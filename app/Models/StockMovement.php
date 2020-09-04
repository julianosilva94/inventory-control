<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property bool $in
 * @property int $quantity
 * @property string $system
 * @property Carbon $created_at
 */
class StockMovement extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'product_id',
        'in',
        'quantity',
        'system',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
