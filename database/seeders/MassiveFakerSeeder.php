<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Author,Category,Book,Rating};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class MassiveFakerSeeder extends Seeder
{
    public function run(): void {
        $faker = Faker::create();

        // Matikan event untuk speed-up
        Model::unsetEventDispatcher();

        // 1) Authors (1,000)
        $authors = [];
        for ($i=0; $i<1000; $i++) {
            $authors[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        foreach (array_chunk($authors, 1000) as $chunk) {
            DB::table('authors')->insert($chunk);
        }
        $authorIds = DB::table('authors')->pluck('id')->all();

        // 2) Categories (3,000)
        $categories = [];
        for ($i=0; $i<3000; $i++) {
            $categories[] = [
                'name' => $faker->unique()->words(3, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        foreach (array_chunk($categories, 1000) as $chunk) {
            DB::table('categories')->insert($chunk);
        }
        $categoryIds = DB::table('categories')->pluck('id')->all();

        // 3) Books (100,000) — batch 5,000
        $booksBatchSize = 5000;
        $booksToCreate = 100000;
        for ($done = 0; $done < $booksToCreate; $done += $booksBatchSize) {
            $batch = [];
            for ($i=0; $i<$booksBatchSize && ($done+$i)<$booksToCreate; $i++) {
                $batch[] = [
                    'title' => $faker->sentence(4),
                    'author_id' => $authorIds[array_rand($authorIds)],
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'published_year' => $faker->numberBetween(1970, (int)date('Y')),
                    'price' => $faker->randomFloat(2, 5, 200),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('books')->insert($batch);
        }
        $bookIds = DB::table('books')->pluck('id')->all();

        // 4) Ratings (500,000) — batch 10,000
        $ratingsBatchSize = 10000;
        $ratingsToCreate = 500000;
        for ($done = 0; $done < $ratingsToCreate; $done += $ratingsBatchSize) {
            $batch = [];
            for ($i=0; $i<$ratingsBatchSize && ($done+$i)<$ratingsToCreate; $i++) {
                $batch[] = [
                    'book_id' => $bookIds[array_rand($bookIds)],
                    'score' => $faker->numberBetween(1,5),
                    'comment' => $faker->boolean(30) ? $faker->sentence(12) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('ratings')->insert($batch);
        }
    }
};
