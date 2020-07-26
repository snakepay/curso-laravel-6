<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Factory criam dados fake para nossa aplicação para testes */
        factory(User::class, 10)->create();

        
        /*
        User::create([
            'name' => 'Lucas Delfim',
            'email' => 'snakepay@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        */
    }
}
