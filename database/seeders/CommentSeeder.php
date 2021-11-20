<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         for($i=0 ; $i<10 ; $i++){
             $comments[] = [
                 'company_id' => Company::all()->random()->id,
                 'content' => 'تجربه همکاری با شرکت شما خیلی عالی بود، به امید همکاری های بیشتر',
             ];
         }

         foreach ($comments as $comment){
             Comment::create($comment);
         }
    }
}
