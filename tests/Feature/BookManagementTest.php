<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;
use Carbon\Carbon;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'Book 1',
            'isbn' => '123456789',
            'publication_date' => '2012-02-15',
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $this->assertInstanceOf(Carbon::class, $book->publication_date);
        $this->assertEquals('15/02/2012', $book->publication_date->format('d/m/Y'));
        $response->assertRedirect($book->path());
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
        $response->assertRedirect($book->fresh()->path());
    
    }

    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {
        $this->post('/books', [
            'title' => 'Title',
            'isbn' => '123456789',
            'publication_date' => '2012-02-15',
        ]);

        $book = BOOK::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');

    }
}
