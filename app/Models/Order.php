<?php

namespace App\Models;

use App\Entities\ResponseEntities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_by',
        'table_no',
        'total_price'
    ];


    /**
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public static function checkout($payload): ResponseEntities
    {
        $response = new ResponseEntities();

        $orderItems = collect($payload['items']);

        $productIds = $orderItems->pluck('product_id');

        $products = Product::whereIn('id', $productIds)
            ->get()
            ->pluck('price', 'id');

        $total =  0;

        foreach ($orderItems as $orderItem) {
            $total += $orderItem['qty'] * $products[$orderItem['product_id']];
        }

        $order = self::create([
            'order_by' => Arr::get($payload, 'order_by'),
            'table_no' => Arr::get($payload, 'table_no'),
            'total_price' => $total
        ]);

        //TODO: try to combine with previous foreach
        foreach ($orderItems as $orderItem) {
            OrderDetail::create([
               'order_id' => $order->id,
               'product_id' => $orderItem['product_id'],
               'qty' => $orderItem['qty']
            ]);
        }

        $response->success = true;
        $response->message = 'Checkout order success';
        $response->data = $order;

        return $response;
    }

    public static function getOrderList(array $queryString, $userInfo): ResponseEntities
    {
        $response = new ResponseEntities();

        $orders = self::with('orderItems')
            ->where('order_by', $userInfo->id)
            ->get();//TODO: add filter and sort

        $response->success = true;
        $response->message = 'Get Order list success';
        $response->data = $orders;

        return $response;
    }

    public static function getOrder($orderId, $userInfo): ResponseEntities
    {
        $response = new ResponseEntities();

        $order = self::with('orderItems')
            ->where('order_by', $userInfo->id)
            ->where('id', $orderId)
            ->first();

        if ($order === null){
            $response->message = 'Order not found';

            return $response;
        }

        $response->success = true;
        $response->message = 'Get Order success';
        $response->data = $order;

        return $response;
    }

    public static function deleteOrder($orderId, $userInfo): ResponseEntities
    {
        $response = new ResponseEntities();

        $order = self::where('id', $orderId)->delete();

        if ($order === 0){
            $response->message = 'Order not found';

            return $response;
        }

        $response->success = true;
        $response->message = 'Delete product success';

        return $response;
    }
}
