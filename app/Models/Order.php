<?php

namespace App\Models;

use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Observers\OrderObserver;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;

    private readonly UserRepositoryInterface $userRepository;
    private readonly OrderRepositoryInterface $orderRepository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->userRepository = new UserRepository();
        $this->orderRepository = new OrderRepository();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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

    public function hasAccess(): bool
    {
        $user = auth()->user();
        return $user->is_admin || $this->users()->where("users.id", "=", $user->id)->exists();
    }

    public function getUsersAvatarsForOrder(): array
    {
        return $this->userRepository->getUsersAvatarsForOrder($this);
    }

    public function getOrderUsers(): Collection
    {
        return $this->orderRepository->getOrderUsers($this);
    }

    public function getTotalCostWithVatAttribute(): float
    {
        $cost = 0.0;
        foreach($this->order_items as $item) {
            $cost += $item->cost_with_vat;
        }
        return $cost;
    }
}
