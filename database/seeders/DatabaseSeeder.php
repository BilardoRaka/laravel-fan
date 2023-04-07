<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Epresence;
use App\Models\User;
use Carbon\Carbon;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'nama' => 'Ananda Bayu',
            'email' => 'bayu@gmail.com',
            'npp' => '12345',
            'npp_supervisor' => '11111',
            'password' => bcrypt('password')
        ]);

        User::create([
            'nama' => 'Raka Pamungkas',
            'email' => 'brpamungkas@gmail.com',
            'npp' => '12346',
            'npp_supervisor' => '11111',
            'password' => bcrypt('password')
        ]);

        User::create([
            'nama' => 'Winoto',
            'email' => 'win@gmail.com',
            'npp' => '12347',
            'npp_supervisor' => '-',
            'password' => bcrypt('password')
        ]);

        User::create([
            'nama' => 'Supervisor',
            'email' => 'spv@gmail.com',
            'npp' => '11111',
            'npp_supervisor' => '-',
            'password' => bcrypt('password')
        ]);

        Epresence::create([
            'user_id' => 1,
            'type' => 'IN',
            'is_approve' => false,
            'waktu' => Carbon::now()
        ]);

        Epresence::create([
            'user_id' => 1,
            'type' => 'OUT',
            'is_approve' => false,
            'waktu' => Carbon::now()
        ]);

        Epresence::create([
            'user_id' => 2,
            'type' => 'IN',
            'is_approve' => false,
            'waktu' => Carbon::now()
        ]);

        Epresence::create([
            'user_id' => 2,
            'type' => 'OUT',
            'is_approve' => false,
            'waktu' => Carbon::now()
        ]);

        Epresence::create([
            'user_id' => 3,
            'type' => 'IN',
            'is_approve' => false,
            'waktu' => Carbon::now()
        ]);

    }
}
