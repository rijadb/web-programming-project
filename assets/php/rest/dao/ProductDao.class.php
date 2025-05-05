<?php

require_once __DIR__ . '/BaseDao.class.php';

class ProductDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('product'); // TABLE NAME PRODUCT in database
    }

    public function add_product($product)
    {
        return $this->insert("product", $product);
    }

    public function count_products_paginated($search)
    {
        $query = "SELECT COUNT(*) AS count
                  FROM product 
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%')
                  OR LOWER(brand) LIKE CONCAT('%', :search, '%');";

        // $statement = $this->connection->prepare($query);
        // $statement->execute($params);
        // $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        // return reset($rows);

        return $this->query_unique($query, ["search" => $search]);
    }

    public function get_products_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $query = "SELECT * 
                  FROM product 
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%')
                  OR LOWER(brand) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit};
                  ";

        return $this->query($query, ["search" => $search]);
    }

    public function delete_product($id)
    {
        $query = "DELETE FROM product WHERE id = :id";
        $this->execute($query, ["id" => $id]);
    }

    public function get_product_by_id($product_id)
    {
        return $this->query_unique("SELECT * FROM product WHERE id = :id", ["id" => $product_id]);
    }

    public function edit_product($id, $product)
    {
        $query = "UPDATE product SET
         name = :name,
         brand = :brand,
         description = :description,
         gender = :gender,
         category = :category,
         rating = :rating,
         price = :price
        WHERE id = :id;";

        $result = $this->execute(
            $query,
            [
                "name" => $product["name"],
                "brand" => $product["brand"],
                "description" => $product["description"],
                "gender" => $product["gender"],
                "category" => $product["category"],
                "rating" => $product["rating"],
                "price" => $product["price"],
                "id" => $id
            ]
        );

        return $result;
    }

    public function get_all_products()
    {
        $query = "SELECT * FROM product;";
        return $this->query($query, []);
    }
}
