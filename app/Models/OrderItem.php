<?php

namespace App\Models;

use App\Observers\OrderItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(OrderItemObserver::class)]
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "count",
        "cost",
        "vat",
        "cost_with_vat"
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
