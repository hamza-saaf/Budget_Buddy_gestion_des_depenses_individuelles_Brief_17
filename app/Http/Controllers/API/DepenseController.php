<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Depense;
use App\Models\Tag;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Depense::all();
        // $depenses=Depense::all();
        // return response()->json($depenses);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $form = $request->all();
        // return Depense::create($form);
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);
        $depense = Depense::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return response()->json($depense, 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function show(Depense $depense)
    {
        return $depense;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depense $depense)
    {
        // $form=$request->all();
        // $depense->fill($form)->save();
        // return $depense;
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);
        $depense->update($validatedData);
        return response()->json([
            'message' => 'Update avec succes',
            'depense' => $depense
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depense  $depense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();
        return response()->jsonn([
            'message' => 'la Depense a ete supprime',
            'id' => $depense->id,
        ]);
    }

    public function attachTags(Request $request, $id)
    {
        $depense = Depense::findOrFail($id);
        $tag = array_filter($request->input('tags', []));
        // $tagIds = Tag::whereIn('id', $request->tags)->pluck('id')->toArray();

        // if (!is_array($tagIds) || empty($tagIds)) {
        //     return response()->json(['message' => 'No valid tags provided'], 400);
        // }
        if (!empty($tagIds) || !is_array($tag)) {
            $tags = Tag::whereIn('id', $tag)->get();
        } else {
            $tags = collect();
        }
        $depense->tags()->sync( $tags);
        return response()->json([
            'message' => 'Tags attached successfully',
            'Depense' => $depense->load('tags')
        ]);
    }
}
