<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->search;
        $book = Book::where('title', 'LIKE', "%{$key}%")
            ->orWhere('author', 'LIKE', "%{$key}%")
            ->orWhere('published', 'LIKE', "%{$key}%")
            ->orWhere('isbn', 'LIKE', "%{$key}%")
            ->orWhere('genre', 'LIKE', "%{$key}%")
            ->paginate(10)->toArray();

        return array_reverse($book);
    }

    public function filterBook(Request $key)
    {
        $book = Book::query();
        if ($key->title) {
            $book->where('title', 'LIKE', "%{$key->title}%");
        }
        if ($key->author) {
            $book->where('author', 'LIKE', "%{$key->author}%");
        }
        if ($key->published) {
            $book->where('published', 'LIKE', "%{$key->published}%");
        }
        if ($key->isbn) {
            $book->where('isbn', 'LIKE', "%{$key->isbn}%");
        }
        if ($key->genre) {
            $book->where('genre', 'LIKE', "%{$key->genre}%");
        }
        return $book->paginate(10)->toArray();
    }

    public function add(Request $request)
    {
        $request->validate([
            "title" => 'required',
            "author" => 'required',
            "genre" => 'required',
            "description" => 'required',
            "isbn" => 'required',
            "published" => 'required',
            "publisher" => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }

        Book::create($input);

        return response()->json(['success' => 'Book created successfully']);

    }

    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function update($id, Request $request)
    {
        $book = Book::find($id);
        $request->validate([
            "title" => 'required',
            "author" => 'required',
            "genre" => 'required',
            "description" => 'required',
            "isbn" => 'required',
            "published" => 'required',
            "publisher" => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
            unlink('img/' . $book->image);
        }

        $book->update($input);

        return response()->json(['success' => 'Book update successfully']);
    }

    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();
        unlink('img/' . $book->image);
        return response()->json(['success' => 'Book deleted successfully']);

    }
}
