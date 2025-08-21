<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 注文ステータスの定数定義
    public const ORDER_STATUSES = [
        'pending_payment' => '入金待ち',
        'payment_confirmed' => '入金確認',
        'in_production' => '制作中',
        'preparing_shipment' => '発送準備中',
        'shipped' => '発送済み',
    ];

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_postal_code',
        'shipping_address',
        'shipping_name',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function getStatusLabelAttribute()
    {
        return self::ORDER_STATUSES[$this->status] ?? '不明';
    }

    // 制作ステータスに応じて注文ステータスを自動更新
    public function updateStatusBasedOnItems()
    {
        $statuses = $this->orderItems->pluck('production_status')->toArray();

        if (in_array('in_production', $statuses, true)) {
            $this->status = 'in_production';
        } elseif (!empty($statuses) && count(array_unique($statuses)) === 1 && $statuses[0] === 'completed') {
            $this->status = 'preparing_shipment';
        }

        $this->save();
    }

    public function updateItemStatusesBasedOnOrder()
    {
        foreach ($this->orderItems as $item) {
            // 注文ステータスが「入金確認」の場合 → 制作待ちへ
            if ($this->status === 'payment_confirmed' && $item->production_status === 'not_started') {
                $item->production_status = 'waiting';
                $item->save();
            }
        }
    }
}
