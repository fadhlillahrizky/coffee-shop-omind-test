<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function addProduct(Request $request)
    {
        return Product::addProduct($request->input());
    }

    public static function editProduct(Request $request, $productId)
    {
        return Product::editProduct($request->input(), $productId);
    }

    public static function getProductList(Request $request)
    {
        return Product::getProductList($request->query());
    }

    public static function getProduct(Request $request, $productId)
    {
        return Product::getProduct($productId);
    }

    public static function deleteProduct(Request $request, $productId)
    {
        return Product::deleteProduct($productId);
    }
}
