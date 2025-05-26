<?php

require_once __DIR__ . '/../dao/UserDao.class.php';

class UserService
{

    private $user_dao;

    public function __construct()
    {
        $this->user_dao = new UserDao();
    }


    public function get_users_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $count = $this->user_dao->count_users_paginated($search)["count"];
        $rows = $this->user_dao->get_users_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }

    public function delete_user($user_id)
    {
        $this->user_dao->delete_user($user_id);
    }

    public function add_user($user)
    {
        if (empty($user["firstName"]) || empty($user["lastName"]) || empty($user["email"]) || empty($user["pwd"])) {
            throw new Exception("All fields are required.");
        }

        if (!filter_var($user["email"], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        if ($this->user_dao->get_user_by_email($user["email"])) {
            throw new Exception("Email already in use.");
        }

        $user["pwd"] = password_hash($user["pwd"], PASSWORD_BCRYPT);
        return $this->user_dao->add_user($user);
    }


    public function get_all_users()
    {
        return $this->user_dao->get_all_users();
    }

    public function get_user_by_id($id)
    {
        return $this->user_dao->get_user_by_id($id);
    }
}
