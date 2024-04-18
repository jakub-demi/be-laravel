<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = static::generateOrderNumber();
        });
    }

    protected static function generateOrderNumber(): int
    {
        $currentYear = date('Y');
        $lastOrder = static::whereYear('created_at', $currentYear)->orderByDesc('id')->first();

        if (!$lastOrder) {
            $nextOrderNumber = 1;
        } else {
            $lastOrderNumber = (int)substr($lastOrder->order_number, -6);
            $nextOrderNumber = $lastOrderNumber + 1;
        }

        return (int)($currentYear . str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "order_number",
        "due_date",
        "payment_date"
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
