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

    /**
     * @test
     */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'isbn' => '123456789',
            'publication_date' => '2012-02-15',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function an_isbn_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Book Title',
            'isbn' => '',
            'publication_date' => '2012-02-15',
        ]);

        $response->assertSessionHasErrors('isbn');
    }

    /**
     * @test
     */
    public function a_publication_date_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Title',
            'isbn' => '123456789',
            'publication_date' => '',
        ]);

        $response->assertSessionHasErrors('publication_date');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Title',
            'isbn' => '123456789',
            'publication_date' => '2012-02-15',
        ]);

        $book = BOOK::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'isbn' => '214521455',
            'publication_date' => '2012-02-15',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('214521455', Book::first()->isbn);
    }
}
