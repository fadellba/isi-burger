<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    /** @use HasFactory<\Database\Factories\BurgerFactory> */
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'description', 'image', 'stock', 'category_id', 'is_active'];

    public function category() {
        /* belongsTo (relation un a un)
        un burger est associer a un seul category*/
        return $this->belongsTo(Category::class);
    }

    public function orders() {
        /*belongsToMany (relation un a plusieur)
        un burger peut se trouver dans plusieur commande*/
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'unit_price');
    }
}
