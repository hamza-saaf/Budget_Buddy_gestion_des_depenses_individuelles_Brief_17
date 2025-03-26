<?php

// app/Http/Controllers/API/GroupController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Expense;

class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups;

        return response()->json([
            'status' => 'success',
            'data' => $groups
        ]);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'currency' => 'sometimes|string|size:3',
            'description' => 'sometimes|string',
            'members' => 'sometimes|array',
            'members.*' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $group = Group::create([
            'name' => $request->name,
            'currency' => $request->currency ?? 'EUR',
            'description' => $request->description ?? null,
        ]);

        // Ajout de l'utilisateur créateur au groupe
        $group->users()->attach(Auth::id());

        // Ajout des autres membres si spécifiés
        if ($request->has('members')) {
            $group->users()->attach($request->members);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Groupe créé avec succès',
            'data' => $group->load('users')
        ], 201);
    }

    /**
     * Display the specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $group = Group::with(['users', 'expenses'])->findOrFail($id);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        // Calcul des soldes (à implémenter plus tard)
        $balances = []; // À remplacer par l'algorithme de calcul des soldes

        return response()->json([
            'status' => 'success',
            'data' => [
                'group' => $group,
                'balances' => $balances
            ]
        ]);
    }

    /**
     * Remove the specified group from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $group = Group::findOrFail($id);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        // Vérifier s'il reste des soldes non réglés
        if ($group->hasBalances()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Impossible de supprimer ce groupe car il reste des soldes non réglés'
            ], 400);
        }

        $group->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Groupe supprimé avec succès'
        ]);
    }

    /**
     * Add a user to the group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $group = Group::findOrFail($id);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        // Vérifier si l'utilisateur à ajouter n'est pas déjà dans le groupe
        if ($group->users->contains($request->user_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cet utilisateur est déjà membre du groupe'
            ], 400);
        }

        $group->users()->attach($request->user_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Membre ajouté avec succès',
            'data' => $group->load('users')
        ]);
    }

    /**
     * Remove a user from the group.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function removeMember($id, $userId)
    {
        $user = Auth::user();
        $group = Group::findOrFail($id);

        // Vérifier si l'utilisateur appartient au groupe
        if (!$group->users->contains($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'avez pas accès à ce groupe'
            ], 403);
        }

        // Vérifier si l'utilisateur à supprimer est dans le groupe
        if (!$group->users->contains($userId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cet utilisateur n\'est pas membre du groupe'
            ], 400);
        }

        // Vérifier s'il reste des soldes non réglés pour cet utilisateur
        // À implémenter plus tard

        $group->users()->detach($userId);

        return response()->json([
            'status' => 'success',
            'message' => 'Membre retiré avec succès',
            'data' => $group->load('users')
        ]);
    }
    public function storexpensegroupe(Request $request)
    {
        $request->validate([
            'user_id' => Auth::user(),
            'group_id' => 'required|exists:group,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);
        $depense = Expense::create([
            'user_id' => $request->Auth::user(),
            'group_id' => $request->group_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return response()->json($depense, 201);
    }
}
