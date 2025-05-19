<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Borrow;
 
class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = Borrow::get();

        if ($borrows->isEmpty()) {
            return response()->json(['message' => 'No borrows found'], 404);
        }

        return response()->json($borrows);
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $borrow = new borrow();
        $borrow->name = $request->name;
        $borrow->description = $request->description;
        $borrow->save();
        return response()->json($borrow);
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrow = Borrow::find($id);
        return response()->json($borrow);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $borrow = Borrow::find($id);
        $borrow->name = $request->name;
        $borrow->description = $request->description;
        $borrow->save();
        return response()->json($borrow);
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Borrow::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}