<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    protected $fillable = [
        'category_id',
        'price',
        'label',
        'description',
        'image_id'
    ];
}
