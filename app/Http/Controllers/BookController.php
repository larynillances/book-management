<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index() : Response
    {
        $books = Book::with(['author', 'added','category'])
        ->latest()
        ->paginate(5)
        ->through(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'authorName' => $book->author->first_name . ' ' . $book->author->last_name,
                'addedBy' => $book->added->name,
                'category' => $book->category()->get(),
                'author_id' => $book->author_id,
                'added_by' => $book->added_by
            ];
        });
        
        $authors = Author::orderBy('last_name', 'ASC')
                    ->pluck('last_name', 'id');

        $categories = Category::orderBy('category', 'ASC')
                    ->pluck('category', 'id');

        return Inertia::render('Books/List', [
            'books' => $books,
            'authors' => $authors,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author_id' => 'required',
            'category_id' => 'required'
        ]);

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'author_id' => $request->author_id,
            'added_by' => Auth::id(),
            'published_date' => $request->is_published ? Date::now() : NULL
        ]);

        $book->category()->attach([$request->category_id]);

        return to_route('books');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author_id' => 'required',
            'category_id' => 'required'
        ]);

        $book = Book::find($request->id);
        $book->category()->detach([$request->category_id]);
        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'author_id' => $request->author_id,
            'published_date' => $request->is_published ? Date::now() : NULL
        ]);
        $book->category()->attach([$request->category_id]);

        return to_route('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        $book->category()->detach([$request->category_id]);
        $book->delete();

        return to_route('books');
    }
}