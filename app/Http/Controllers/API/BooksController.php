<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class BooksController extends BaseController
{
    public function index(Request $request)
    {
        $key = $request->search;
        $book = Book::search($key)->paginate(10);
        return $this->sendResponse($book, 'Books retrieved successfully.');
    }

    public function filterBook(Request $request)
    {
        $request->validate([
            "title" => 'required|string',
            "author" => 'nullable|string',
            "genre" => 'nullable|string',
            "isbn" => 'nullable|integer',
            "publish_date" => 'nullable|date',
        ]);

        $key = $request;
        $book = Book::query();
        if ($key->title) {
            $book->filter('title', $key->title);
        }
        if ($key->author) {
            $book->filter('author', $key->author);
        }
        if ($key->publish_date) {
            $book->filter('published', $key->publish_date);
        }
        if ($key->isbn) {
            $book->filter('isbn', $key->isbn);
        }
        if ($key->genre) {
            $book->filter('genre', $key->genre);
        }

        return $this->sendResponse($book->paginate(10), 'Books retrieved successfully.');

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
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }

        $book = Book::create($input);
        return $this->sendResponse($book, 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        return $this->sendResponse($book, 'Book created successfully.');
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
        ]);

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
            $request->validate([
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
            if (File::exists('img/' . $book->image)) {
                unlink('img/' . $book->image);
            }
        }

        $book->update($input);

        return $this->sendResponse(null, 'Book updated successfully.');
    }

    public function delete(Book $book)
    {
        $book->delete();
        if (File::exists('img/' . $book->image)) {
            unlink('img/' . $book->image);
        }
        return $this->sendResponse(null, 'Book deleted successfully.');

    }
}
