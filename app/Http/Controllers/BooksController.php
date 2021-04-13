<?php

namespace App\Http\Controllers;

use App\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response the list view from the index.blade.php
   */
  public function index()
  {
      $books=Book::Paginate(5);

      return view('books.index', ['books' => $books]);
  }

  public function store() 
  {
    $book = Book::create($this->validateRequest());
    return redirect($book->path());
  }

  public function update(Book $book)
  {
    $book->update($this->validateRequest());
    return redirect($book->path());

  }

  public function destroy(Book $book)
  {
    $book->delete();

    return redirect('/books');
  }

  /**
   * @return mixed
   */
  protected function validateRequest()
  {
    return request()->validate([
      'title' => 'required',
      'isbn' => 'required',
      'publication_date' => 'required',
    ]);
  }
}
