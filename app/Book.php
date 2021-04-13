<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class Book extends Model
{
    protected $guarded = [];

    protected $dates = ['publication_date'];

    public function setPublicationDateAttribute($publication_date)
    {
        $this->attributes['publication_date'] = Carbon::parse($publication_date);
    }

    public function path()
    {
        return '/books' . $this->id;
    }

    public function checkout(User $user) 
    {
        if ($this->status !== 'AVAILABLE') {
            return redirect('books')->with(['message' => 'Book already checked out!', 'alert' => 'alert-danger']);
            
        } else {
            $this->userActionLogs()->create([
                'user_id' => $user->id,
                'action' => 'CHECKOUT',
            ]);

            $this->update([
                'title' => $this->title,
                'isbn' => $this->isbn,
                'publication_date' => $this->publication_date,
                'status' => 'CHECKED_OUT',
            ]);
            
            return redirect('books')->with(['message' => 'Book checked out successfully', 'alert' => 'alert-success']);
        }

        
    }

    public function checkin(User $user) 
    {
        if ($this->status === 'AVAILABLE') {
            return redirect('books')->with(['message' => 'Book should be checked out first!', 'alert' => 'alert-danger']);  
        } else {

        $this->userActionLogs()->create([
            'user_id' => $user->id,
            'action' => 'CHECKIN',
        ]);

        $this->update([
            'title' => $this->title,
            'isbn' => $this->isbn,
            'publication_date' => $this->publication_date,
            'status' => 'AVAILABLE',
        ]);
        }
    }

    public function userActionLogs()
    {
        return $this->hasMany(UserActionLog::class);
    }
}
