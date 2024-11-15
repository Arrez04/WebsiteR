<?php

namespace Controller;

include "Traits/ApiResponseFormatter.php";
include "Models/Product.php";

use Models\Product;
use Traits\ApiResponseFormatter;

class ProductController
{
    use \app\Traits\ApiResponseFormatter;

    public function index()
    {
        // Definisi objek model Product yang sudah dibuat
        $productModel = new Product();
        $response = $productModel->findAll();
        // Return response dengan pelacakan formatting terlebih dahulu menggunakan trait yang sudah dipanggil
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($id)
    {
        $productModel = new Product();
        $response = $productModel->findById($id);

        return $this->apiResponse(200, "success", $response);
    }

    public function insert()
    {
        // Tangkap input JSON
        $jsonInput = file_get_contents("php://input");
        $inputData = json_decode($jsonInput, true);

        // Validasi input valid atau tidak
        if (json_last_error()) {
            return $this->apiResponse(400, "Error: Invalid input", null);
        }

        $productModel = new Product();
        $response = $productModel->create([
            "product_name" => $inputData["product_name"]
        ]);

        return $this->apiResponse(200, "success", $response);
    }

    public function update($id)
    {
        $jsonInput = file_get_contents("php://input");
        $inputData = json_decode($jsonInput, true);

        if (json_last_error()) {
            return $this->apiResponse(400, "Error: Invalid input", null);
        }

        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData["product_name"]
        ], $id);

        return $this->apiResponse(200, "success", $response);
    }

    public function delete($id)
    {
        $productModel = new Product();
        $response = $productModel->delete($id);

        return $this->apiResponse(200, "success", $response);
    }
}