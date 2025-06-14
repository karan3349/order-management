<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'grand_total',
    ];

    /**
     * Get the customer that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    /**
     * Get the order items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}