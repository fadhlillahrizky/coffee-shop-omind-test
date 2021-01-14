<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public static function checkout(Request $request)
    {
        return Order::checkout($request->input());
    }

    public static function getOrderList(Request $request)
    {
        return Order::getOrderList($request->query());
    }

    public static function getOrder(Request $request, $orderId)
    {
        return Order::getOrder($orderId);
    }

    public static function deleteOrder(Request $request, $orderId)
    {
        return Order::deleteOrder($orderId);
    }
}
