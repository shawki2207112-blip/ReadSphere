<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * Attributes that may be assigned using create(), update(), or fill().
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'issue_date',
        'due_date',
        'returned_at',
        'status',
    ];

    /**
     * Convert database date values into Carbon date objects.
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'returned_at' => 'date',
        ];
    }

    /**
     * Get the member who borrowed the book.
     *
     * withTrashed() allows old borrowing records to still display
     * the user even when the user has been soft deleted.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the book associated with this borrowing record.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     * Determine whether the borrowed book is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'borrowed'
            && $this->due_date->isPast();
    }
}