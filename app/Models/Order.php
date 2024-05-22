<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "category_id",
        "order_number",
        "due_date",
        "payment_date",
        "customer_name",
        "customer_address",
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status_histories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function hasAccess(): bool
    {
        $user = auth()->user();
        return $user->is_admin || $this->users()->where("users.id", "=", $user->id)->exists();
    }

    public function getTotalCostWithVatAttribute(): float
    {
        $cost = 0.0;
        foreach($this->order_items as $item) {
            $cost += $item->cost_with_vat;
        }
        return $cost;
    }

    public function getStatusAttribute(): ?OrderStatus
    {
        return $this->status_histories()->latest()->first()?->status;
    }
}
