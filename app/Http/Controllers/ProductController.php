<?php

namespace App\Http\Controllers;

use App\Entities\ResponseEntities;
use App\Models\Product;
use Illuminate\Http\Request;
use JWTAuth;

class ProductController extends Controller
{
    public static function addProduct(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::addProduct($request->input());
        }
        return self::cannotAccess();
    }

    public static function editProduct(Request $request, $productId)
    {

        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::editProduct($request->input(), $productId);
        }
        return self::cannotAccess();
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
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::deleteProduct($productId);
        }
        return self::cannotAccess();
    }

    private static function cannotAccess()
    {
        $response = new ResponseEntities();

        $response->message = 'Cannot access';
        return $response;
    }
}
