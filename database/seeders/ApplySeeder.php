<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apply;
use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->state([
            'name' => 'test2',
            'password' => 'password',
            'email' => 'example2@mail.com',
        ])->create();
    }
}
