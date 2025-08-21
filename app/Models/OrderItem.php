<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'production_status',
    ];

    // 制作ステータス定義
    public const PRODUCTION_STATUSES = [
        'not_started' => '着手不可',
        'waiting' => '制作待ち',
        'in_production' => '制作中',
        'completed' => '制作完了',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductionStatusLabelAttribute()
    {
        return self::PRODUCTION_STATUSES[$this->production_status] ?? '不明';
    }
}
