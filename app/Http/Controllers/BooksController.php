<?php

namespace App\Http\Controllers;

use App\Book;
use Auth;

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

  public function action(Request $request)
  {
    $book = Book::where('isbn', '=', $request['isbn'])->first();
    
    if (empty($book)) {
      return redirect('books')->with(['message' => 'Invalid ISBN number', 'alert' => 'alert-danger']);

    }

    
    if ($request['action'] === 'checkin') {
      if ($book->status === 'AVAILABLE') {
        return redirect('books')->with(['message' => 'Book already checked out!', 'alert' => 'alert-danger']); 
      } else {
        $book->checkin(Auth::user());
    
      return redirect('books')->with(['message' => 'Book checked in successfully', 'alert' => 'alert-success']);
      }
    } else {
      if ($book->status !== 'AVAILABLE') {
        return redirect('books')->with(['message' => 'Book already checked out!', 'alert' => 'alert-danger']); 
      } else {
      $book->checkout(Auth::user());

      return redirect('books')->with(['message' => 'Book checked out successfully', 'alert' => 'alert-success']);
      }
    }


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
