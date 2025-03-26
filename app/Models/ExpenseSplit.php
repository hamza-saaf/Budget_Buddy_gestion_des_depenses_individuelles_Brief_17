<?php

// app/Models/ExpenseSplit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSplit extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'user_id',
        'amount',
        'percentage',
    ];

    protected $casts = [
        'amount' => 'float',
        'percentage' => 'float',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
