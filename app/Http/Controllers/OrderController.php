<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use JWTAuth;

class OrderController extends Controller
{

    public static function checkout(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $payload = $request->input();
        $payload['order_by'] = $user->id;
        return Order::checkout($payload);
    }

    public static function getOrderList(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return Order::getOrderList($request->query(), $user);
    }

    public static function getOrder(Request $request, $orderId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return Order::getOrder($orderId, $user);
    }

    public static function deleteOrder(Request $request, $orderId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return Order::deleteOrder($orderId, $user);
    }
}
