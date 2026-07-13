<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * These fields contain the main information needed to create
     * or update a book record.
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'total_copies',
        'available_copies',
    ];

    /**
     * Convert selected database values into specific PHP data types.
     */
    protected function casts(): array
    {
        return [
            'total_copies' => 'integer',
            'available_copies' => 'integer',
        ];
    }

    /**
     * Get the category to which this book belongs.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all borrowing records associated with this book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}