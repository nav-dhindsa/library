<?php

namespace App\Http\Controllers;

use App\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store() 
    {
      Book::create($this->validateRequest());
    }

    public function update(Book $book)
    {
      $book->update($this->validateRequest());
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
