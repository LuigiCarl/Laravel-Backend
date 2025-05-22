<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Validation\ValidationException;

class BookController extends Controller

{

    public function __construct()
    {
        // Force JSON responses for all methods
        \Illuminate\Support\Facades\Response::macro('jsonResponse', function ($data, $status = 200) {
            return response()->json($data, $status, ['Content-Type' => 'application/json']);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::get();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No books found'], 404);
        }

        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Trim string inputs before validation
        $request->merge([
            'title' => trim($request->input('title')),
            'author' => trim($request->input('author')),
            'isbn' => trim($request->input('isbn')),
            'category' => trim($request->input('category')),
            // Add more fields as needed
        ]);

        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|unique:books,isbn|max:13',
                'category' => 'required|string|max:255',
                'published_year' => 'required|integer|min:1000|max:' . date('Y'),
                'copies' => 'required|integer|min:1',
                'available_copies' => 'required|integer|min:0',
                'description' => 'nullable|string',
                'cover_image' => 'nullable|string',
                
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Require at least one image source
        // if (!$request->hasFile('cover_image') && !$request->input('cover_image_url')) {
        //     return response()->json(['errors' => ['cover_image' => ['Either a cover image or a cover image URL is required.']]], 422);
        // }

        // Additional ISBN check is redundant here; Laravel already checks uniqueness.
        $book = Book::create($validatedData);
        return response()->json(new BookResource($book), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string|max:255',
                'isbn' => 'sometimes|required|string|max:13|unique:books,isbn,' . $book->id,
                'category' => 'sometimes|required|string|max:255',
                'published_year' => 'sometimes|required|integer|min:1000|max:' . date('Y'),
                'copies' => 'sometimes|required|integer|min:1',
                'available_copies' => 'sometimes|required|integer|min:0',
                'description' => 'nullable|string',
                'cover_image' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $book->update($validatedData);

        return response()->json(new BookResource($book));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
