<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Pour la table d'authentification
        $this->call(UserTableSeeder::class);
    

        $this->call(AuthorTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(BookTableSeeder::class);
        //appel des autres seeders ici;
        $this->call(ScoreTableSeeder::class);
    }
}
