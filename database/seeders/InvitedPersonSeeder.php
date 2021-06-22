<?php

namespace Database\Seeders;

use App\Models\InvitationPerson;
use Illuminate\Database\Seeder;

class InvitedPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvitationPerson::factory()->times(25)->create();
    }
}
