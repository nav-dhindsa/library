<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}
