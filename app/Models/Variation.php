<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variation extends Model
{
    protected $fillable = [
        'sku_id',
        'product_id'
    ];

    public function productImages(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
