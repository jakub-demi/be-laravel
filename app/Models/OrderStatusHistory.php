<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderStatusHistoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(OrderStatusHistoryObserver::class)]
class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "user_id",
        "status",
    ];

    protected $casts = [
        "status" => OrderStatus::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
