<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Models\Expense;
use App\Models\ExpenseSplit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Ajouter une dépense partagée
     */
    public function store(StoreGroupRequest $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains(Auth::id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n avez pas accès à ce groupe'
            ], 403);
        }

        // Commencer une transaction
        return DB::transaction(function () use ($request, $group) {
            // Créer la dépense
            $expense = Expense::create([
                'group_id' => $group->id,
                'description' => $request->description,
                'amount' => $request->amount,
                'date' => $request->date,
                'split_type' => $request->split_type
            ]);

            // Gérer les payeurs
            $totalPaid = 0;
            foreach ($request->payers as $payer) {
                $totalPaid += $payer['amount'];
            }

            // Vérifier que le total payé correspond au montant de la dépense
            if (abs($totalPaid - $request->amount) > 0.01) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Le montant total payé ne correspond pas au montant de la dépense'
                ], 400);
            }

            // Enregistrer les payeurs
            foreach ($request->payers as $payer) {
                ExpenseSplit::create([
                    'expense_id' => $expense->id,
                    'user_id' => $payer['user_id'],
                    'amount' => $payer['amount'],
                    'is_payer' => true
                ]);
            }

            // Gérer la répartition
            if ($request->split_type == 'equal') {
                // Répartition égale
                $splitAmount = $request->amount / $group->users->count();
                foreach ($group->users as $user) {
                    ExpenseSplit::create([
                        'expense_id' => $expense->id,
                        'user_id' => $user->id,
                        'amount' => $splitAmount,
                        'is_payer' => false
                    ]);
                }
            } else {
                // Répartition personnalisée
                $totalSplit = 0;
                foreach ($request->splits as $split) {
                    ExpenseSplit::create([
                        'expense_id' => $expense->id,
                        'user_id' => $split['user_id'],
                        'amount' => $split['amount'] ?? 0,
                        'percentage' => $split['percentage'] ?? null,
                        'is_payer' => false
                    ]);
                    $totalSplit += $split['amount'] ?? 0;
                }

                // Vérifier que le total réparti correspond au montant de la dépense
                if (abs($totalSplit - $request->amount) > 0.01) {
                    throw new \Exception('Le montant total réparti ne correspond pas au montant de la dépense');
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Dépense ajoutée avec succès',
                'data' => $expense->load(['splits.user', 'group'])
            ], 201);
        });
    }

    /**
     * Lister toutes les dépenses d'un groupe
     */
    public function index($groupId)
    {
        $group = Group::findOrFail($groupId);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains(Auth::id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        $expenses = Expense::with(['splits.user'])
            ->where('group_id', $groupId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $expenses
        ]);
    }

    /**
     * Supprimer une dépense
     */
    public function destroy($groupId, $expenseId)
    {
        $group = Group::findOrFail($groupId);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains(Auth::id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        $expense = Expense::where('group_id', $groupId)->findOrFail($expenseId);

        // Supprimer la dépense et ses répartitions
        $expense->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dépense supprimée avec succès'
        ]);
    }
}
