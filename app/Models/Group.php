<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'currency',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users')
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function hasBalances()
    {
        // Cette méthode vérifiera s'il existe des soldes non réglés
        // Pour l'instant, retournons false
        return false;
    }

    // protected $fillable=[
    //     'name',
    //     'devise'
    // ];
    // public function depense(){
    //     return $this->hasMany(Depense::class);
    // }
    // public function user(){
    //     return $this->belongsToMany(User::class,'members');
    // }
}