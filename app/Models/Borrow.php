<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
     use HasFactory;
    // Define table name (optional if conventionally named)
    protected $table = 'borrows';

    // Specify fillable attributes for mass assignment
    protected $fillable = [
        'book_id',
        'borrower_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];

    // Define relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class);
    }

    // Automatically update overdue status
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', 'active');
    }
}