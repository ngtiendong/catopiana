<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $index = 0;
        for($i = 1; $i < 41 ; $i++)
        {
        		$index++;
        		if($index == 7) $index = 1;
	        	 DB::table('questions')->insert([
	        	'curriculum_id' => 1,
	        	'index' => $index,
	        	'question' => 'afterInit/1.png',
	        	'correct_answer' => 'afterInit/1.png',
	        	'wrong_answer' => json_encode(['afteInit/1a.png','afteInit/1b.png','afteInit/1c.png']),
	        ]);
        }
       
    }
}
