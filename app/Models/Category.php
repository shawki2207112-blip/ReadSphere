<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Attributes that may be assigned using create(), update(), or fill().
     *
     * Only the category name can be mass assigned.
     */
    protected $fillable = [
        'category_name',
    ];

    /**
     * Get all books that belong to this category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}