<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    public mixed $user;
    protected $fillable = ['user_id', 'status', 'total_price'];

    public function burgers(): BelongsToMany
    {
        return $this->belongsToMany(Burger::class)->withPivot('quantity', 'unit_price')->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
}
