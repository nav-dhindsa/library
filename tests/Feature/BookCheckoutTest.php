<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\User;
use App\UserActionLog;
use Illuminate\Support\Facades\Auth;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;   
    
    /**
     * @test
     */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $book = factory(Book::class)->create();
        $this->actingAs($user = factory(User::class)->create())->post('/checkout/' . $book->id);

        $this->assertCount(1, UserActionLog::all());
        $this->assertEquals($user->id, UserActionLog::first()->user_id);
        $this->assertEquals($book->id, UserActionLog::first()->book_id);
        $this->assertEquals('CHECKOUT', UserActionLog::first()->action);
        $this->assertEquals('CHECKED_OUT', $book->fresh()->status);
    }

     /**
     * @test
     */
    public function only_signed_in_users_can_check_out_a_book()
    {
        $book = factory(Book::class)->create();
        $this->post('/checkout/' . $book->id)->assertRedirect('/login');

        $this->assertCount(0, UserActionLog::all());
    }

    /**
     * @test
     */
    public function only_real_books_can_be_checked_out()
    {
        $this->actingAs($user = factory(User::class)->create())->post('/checkout/12')->assertStatus(404);

        $this->assertCount(0, UserActionLog::all());
    }

    /**
     * @test
     */
    public function a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/checkout/' . $book->id);
        $this->actingAs($user)->post('/checkin/' . $book->id);

        $this->assertCount(2, UserActionLog::all());
        $this->assertEquals($user->id, UserActionLog::all()->last()->user_id);
        $this->assertEquals($book->id, UserActionLog::all()->last()->book_id);
        $this->assertEquals('CHECKIN', UserActionLog::all()->last()->action);
        $this->assertEquals('AVAILABLE', $book->fresh()->status);
    }

    /**
     * @test
     */
    public function only_signed_in_users_can_check_in_a_book()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/checkout/' . $book->id);

        Auth::logout();

        $this->post('/checkin/' . $book->id)->assertRedirect('/login');

        $this->assertCount(1, UserActionLog::all());
        $this->assertEquals('CHECKED_OUT', $book->fresh()->status);

    }

     /** 
      * @test 
      */
     public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
     {
         $book = factory(Book::class)->create();
         $user = factory(User::class)->create();
 
         $this->assertCount(0, UserActionLog::all());
     }
}
