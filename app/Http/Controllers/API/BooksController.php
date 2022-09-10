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
        $book = Book::where('title', 'LIKE', "%{$key}%")
            ->orWhere('author', 'LIKE', "%{$key}%")
            ->orWhere('published', 'LIKE', "%{$key}%")
            ->orWhere('isbn', 'LIKE', "%{$key}%")
            ->orWhere('genre', 'LIKE', "%{$key}%")
            ->paginate(10)->toArray();
        return $this->sendResponse(array_reverse($book), 'Books retrieved successfully.');
    }

    public function filterBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required|string',
            "author" => 'string',
            "genre" => 'string',
            "isbn" => 'integer',
            "published" => 'date',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $key = $request;
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

        return $this->sendResponse(array_reverse($book->paginate(10)->toArray()), 'Books retrieved successfully.');

    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required',
            "author" => 'required',
            "genre" => 'required',
            "description" => 'required',
            "isbn" => 'required',
            "published" => 'required',
            "publisher" => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->all());
        }
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
        $validator = Validator::make($request->all(), [
            "title" => 'required',
            "author" => 'required',
            "genre" => 'required',
            "description" => 'required',
            "isbn" => 'required',
            "published" => 'required',
            "publisher" => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->all());
        }

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
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
