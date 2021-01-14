<?php

namespace App\Models;

use App\Entities\ResponseEntities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    use HasFactory;

    public static function addProduct($payload): ResponseEntities
    {
        $response = new ResponseEntities();

        $rules = [
            'product_name' => 'required',
            'image' => '',
            'description' => '',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];

        $validator = Validator::make($payload, $rules);

        if ($validator->fails()) {
            $response->message = 'Bad request!';
            $response->data = $validator->errors();
            return $response;
        }

        $product = self::create([
            'product_name' => Arr::get($payload, 'product_name'),
            'image' => Arr::get($payload, 'product_name'),
            'description' => Arr::get($payload, 'product_name'),
            'price' => Arr::get($payload, 'product_name'),
            'stock' => Arr::get($payload, 'product_name'),
        ]);

        $response->success = true;
        $response->message = 'Add product success';
        $response->data = $product;

        return $response;
    }

    public static function editProduct($productId, $payload): ResponseEntities
    {
        $response = new ResponseEntities();

        $rules = [
            'product_name' => '',
            'image' => '',
            'description' => '',
            'price' => 'numeric',
            'stock' => 'numeric'
        ];

        $validator = Validator::make($payload, $rules);

        if ($validator->fails()) {
            $response->message = 'Bad request!';
            $response->data = $validator->errors();
            return $response;
        }

        $product = self::where('id', $productId)->first();

        if ($product === null){
            $response->message = 'Product not found';

            return $response;
        }

        $product = self::where('id', $productId)->update([
            'product_name' => Arr::get($payload, 'product_name'),
            'image' => Arr::get($payload, 'product_name'),
            'description' => Arr::get($payload, 'product_name'),
            'price' => Arr::get($payload, 'product_name'),
            'stock' => Arr::get($payload, 'product_name'),
        ]);

        $response->success = true;
        $response->message = 'Edit product success';
        $response->data = $product;

        return $response;
    }

    public static function getProductList($queryString): ResponseEntities
    {
        $response = new ResponseEntities();

        $product = self::get();//TODO: add filter and sort

        $response->success = true;
        $response->message = 'Get product list success';
        $response->data = $product;

        return $response;
    }

    public static function getProduct($productId): ResponseEntities
    {
        $response = new ResponseEntities();

        $product = self::where('id', $productId)->first();

        if ($product === null){
            $response->message = 'Product not found';

            return $response;
        }

        $response->success = true;
        $response->message = 'Get product success';
        $response->data = $product;

        return $response;
    }

    public static function deleteProduct($productId): ResponseEntities
    {
        $response = new ResponseEntities();

        $product = self::where('id', $productId)->delete();

        if ($product === null){
            $response->message = 'Product not found';

            return $response;
        }

        $response->success = true;
        $response->message = 'Delete product success';
        $response->data = $product;

        return $response;
    }
}
