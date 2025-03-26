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
        // Récupérer toutes les dépenses du groupe
        $expenses = $this->expenses;

        if ($expenses->isEmpty()) {
            return false;
        }

        // Calculer les soldes
        $balances = [];

        foreach ($expenses as $expense) {
            foreach ($expense->splits as $split) {
                $payerId = $expense->payer_id;
                $userId = $split->user_id;
                $amount = $split->amount;

                if ($payerId == $userId) continue;

                if (!isset($balances[$payerId])) {
                    $balances[$payerId] = [];
                }

                if (!isset($balances[$payerId][$userId])) {
                    $balances[$payerId][$userId] = 0;
                }

                $balances[$payerId][$userId] += $amount;
            }
        }

        // Vérifier si au moins un solde est non nul
        foreach ($balances as $payer => $userBalances) {
            foreach ($userBalances as $user => $amount) {
                if ($amount > 0) {
                    return true;
                }
            }
        }

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
