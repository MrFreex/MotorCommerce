<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MongoController extends Controller
{
    private static $endpoint = "http://localhost:3000/";
    private static $token = "yDDxw9mTdYM!cEWDK2@yuXdSJH3-Xt2?";

    public static function editProduct(string $_id, $update)
    {
        return Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/edit", [
            'update' => $update,
            '_id' => $_id
        ])->json();
    }

    public static function newCategory($name)
    {
        return Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "categories/add", [
            'label' => $name
        ])->json();
    }

    public static function delCategory($id)
    {
        return Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "categories/del", [ "_id" => $id ])->json();
    }

    public static function editCategory($id, array $array)
    {
        return Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "categories/edit", [
            "_id" => $id,
            "update" => $array
        ])->json();
    }

    public static function getOneProduct($id) {
        $response = Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/get", [
            '_id' => $id
        ]);

        return $response->json();
    }

    public static function addProduct($data) {

        $response = Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/add", $data);

        return $response->json();
    }

    public function getAllProducts() {
        $response = Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/getAll", []);

        return $response->json();
    }

    public function findProduct($field, $value) {
        $response = Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/find", [
            'field' => $field,
            'value' => $value
        ]);

        return $response->json();
    }

    public function deleteProduct($id) {
        $response = Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "products/delete", [
            '_id' => $id
        ]);

        $data = [
            "type" => "success",
            "message" => "Product deleted successfully"
        ];

        if (!$response->ok()) {
            $data = [
                "type" => "error",
                "message" => "Error deleting product"
            ];
        }

        return redirect()->back()->with($data['type'], $data['message']);
    }

    /* Categories */

    public function addCategory(Array $data) {
        return Http::withHeaders([
            'auth-key' => self::$token
        ])->post(self::$endpoint . "categories/add", $data)->json();
    }

    public function listCategories() {
        return Http::withHeaders([
            'auth-key' => self::$token,
        ])->post(self::$endpoint . "categories/list", [])->json();
    }
}
