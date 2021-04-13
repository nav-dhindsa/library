<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\User;
use App\UserActionLog;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function a_book_can_be_checked_out()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkout($user);

        $this->assertCount(1, UserActionLog::all());
        $this->assertEquals($user->id, UserActionLog::first()->user_id);
        $this->assertEquals($book->id, UserActionLog::first()->book_id);
        $this->assertEquals('CHECKOUT', UserActionLog::first()->action);
        $this->assertEquals('CHECKED_OUT', $book->fresh()->status); 
    }

    /**
     * @test
     */
    public function a_book_can_be_checked_in()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(2, UserActionLog::all());
        $this->assertEquals($user->id, UserActionLog::first()->user_id);
        $this->assertEquals($book->id, UserActionLog::first()->book_id);
        $this->assertEquals('CHECKIN', UserActionLog::all()->last()->action);
        $this->assertEquals('AVAILABLE', $book->fresh()->status);
   
    }
}
