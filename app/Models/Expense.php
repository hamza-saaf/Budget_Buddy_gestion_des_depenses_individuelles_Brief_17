<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'payer_id',
        'description',
        'amount',
        'date',
        'split_type', // 'equal' ou 'custom'
    ];
    

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'float',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function splits()
    {
        return $this->hasMany(ExpenseSplit::class);
    }

}