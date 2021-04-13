<?php

namespace App\Http\Controllers;

use App\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store() 
    {
        Book::create([
            'title' => request('title'),
            'isbn' => request('isbn'),
            'publication_date' => request('publication_date'),
        ]);
    }
}
