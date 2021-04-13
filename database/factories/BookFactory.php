<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    
    return [
        'title' => $faker->sentence,
        'isbn' => $faker->isbn10,
        'publication_date' => now()->subYears(5),
        'status' => 'AVAILABLE',
    ];
});
