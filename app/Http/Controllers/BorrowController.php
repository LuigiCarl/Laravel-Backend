<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Validation\Rule;

class BorrowController extends Controller
{
    /**
     * Display a listing of the borrows.
     */
    public function index()
    {
        $borrows = Borrow::with(['book', 'borrower'])->get();

        if ($borrows->isEmpty()) {
            return response()->json(['message' => 'No borrows found'], 404);
        }

        return response()->json($borrows);
    }

    /**
     * Store a newly created borrow.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id'      => 'required|exists:books,id',
            'borrower_id'  => 'required|exists:users,id',
            'borrow_date'  => 'required|date',
            'due_date'     => 'required|date|after_or_equal:borrow_date',
            'status'       => ['required', Rule::in(['active', 'returned'])],
            // return_date is required if status == returned; otherwise must be absent or null
            'return_date'  => [
                'nullable',
                'date',
                'after_or_equal:borrow_date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status === 'returned' && is_null($value)) {
                        $fail('When status is returned, return_date is required.');
                    }
                    if ($request->status === 'active' && !is_null($value)) {
                        $fail('return_date must be null when status is active.');
                    }
                },
            ],
        ]);

        $borrow = Borrow::create($validated);

        return response()->json($borrow, 201);
    }

    /**
     * Display the specified borrow.
     */
    public function show(string $id)
    {
        $borrow = Borrow::with(['book', 'borrower'])->find($id);

        if (!$borrow) {
            return response()->json(['message' => 'Borrow not found'], 404);
        }

        return response()->json($borrow);
    }

    /**
     * Update the specified borrow.
     */
    public function update(Request $request, string $id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            return response()->json(['message' => 'Borrow not found'], 404);
        }

        $validated = $request->validate([
            'book_id'      => 'sometimes|exists:books,id',
            'borrower_id'  => 'sometimes|exists:users,id',
            'borrow_date'  => 'sometimes|date',
            'due_date'     => 'sometimes|date|after_or_equal:borrow_date',
            'status'       => ['sometimes', Rule::in(['active', 'returned'])],
            'return_date'  => [
                'nullable',
                'date',
                'after_or_equal:borrow_date',
                function ($attribute, $value, $fail) use ($request, $borrow) {
                    // Determine effective status (new or existing)
                    $status = $request->get('status', $borrow->status);

                    if ($status === 'returned' && is_null($value)) {
                        $fail('When status is returned, return_date is required.');
                    }
                    if ($status === 'active' && !is_null($value)) {
                        $fail('return_date must be null when status is active.');
                    }
                },
            ],
        ]);

        $borrow->update($validated);

        return response()->json($borrow);
    }

    /**
     * Remove the specified borrow.
     */
    public function destroy(string $id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            return response()->json(['message' => 'Borrow not found'], 404);
        }

        $borrow->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
