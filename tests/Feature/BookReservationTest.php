<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Book 1',
            'isbn' => '123456789',
            'publication_date' => '2012-02-15',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }
}
