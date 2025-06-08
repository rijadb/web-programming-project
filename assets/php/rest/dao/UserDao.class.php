<?php

//zbog pull requesta

require_once __DIR__ . '/BaseDao.class.php';

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('user');
    }

    public function count_users_paginated($search)
    {
        $query = "SELECT COUNT(*) AS count
                  FROM user 
                  WHERE LOWER(firstName) LIKE CONCAT('%', :search, '%')
                  OR LOWER(lastName) LIKE CONCAT('%', :search, '%');";

        return $this->query_unique($query, ["search" => $search]);
    }

    public function get_users_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $query = "SELECT * 
                  FROM user 
                  WHERE LOWER(firstName) LIKE CONCAT('%', :search, '%')
                  OR LOWER(lastName) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit};
                  ";

        return $this->query($query, ["search" => $search]);
    }

    public function delete_user($id)
    {
        $query = "DELETE FROM user WHERE id = :id";
        $this->execute($query, ["id" => $id]);
    }

    public function add_user($user)
    {
        if (empty($user["firstName"]) || empty($user["lastName"]) || empty($user["email"]) || empty($user["pwd"])) {
            throw new Exception("All fields are required.");
        }

        if (!filter_var($user["email"], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        if ($this->get_user_by_email($user["email"])) {
            throw new Exception("Email already registered.");
        }

        $hashedPwd = password_hash($user["pwd"], PASSWORD_DEFAULT);

        $query = "INSERT INTO user(firstName, lastName, email, pwd) VALUES(:firstName, :lastName, :email, :pwd);";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            "firstName" => $user["firstName"],
            "lastName" => $user["lastName"],
            "email" => $user["email"],
            "pwd" => $hashedPwd
        ]);

        $userId = $this->connection->lastInsertId();

        $cart_query = "INSERT INTO cart(userId) VALUES(:userId)";
        $cart_stmt = $this->connection->prepare($cart_query);
        $cart_stmt->execute(["userId" => $userId]);

        return $user;
    }


    public function get_all_users()
    {
        $query = "SELECT * FROM user;";
        return $this->query($query, []);
    }

    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM user WHERE id = :id";
        return $this->query_unique($query, ["id" => $id]);
    }
    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        return $this->query_unique($query, ["email" => $email]);
    }
}
