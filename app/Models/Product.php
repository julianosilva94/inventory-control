<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $sku
 * @property string $name
 * @property string $description
 * @property int $quantity
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'quantity',
    ];
}
