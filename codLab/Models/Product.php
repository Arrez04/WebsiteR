<?php

namespace Models;

include "Config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{
    public $conn;

    public function __construct()
    {
        // Connect ke database MySQL
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);

        // Cek koneksi
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Function menampilkan semua data
    public function findAll()
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $data = [];
        
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    // Function menampilkan data dengan id
    public function findById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    // Function untuk membuat sebuah data
    public function create($data)
    {
        $productName = $data['product_name'];
        $query = "INSERT INTO products (product_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
    }

    // Function untuk update data
    public function update($data, $id)
    {
        $productName = $data["product_name"];
        $query = "UPDATE products SET product_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $productName, $id);
        $stmt->execute();
    }

    // Function delete data dengan id
    public function delete($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Destructor untuk menutup koneksi database
    public function __destruct()
    {
        $this->conn->close();
    }
}