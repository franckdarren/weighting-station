<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les tickets
        $tickets = Ticket::all();

        // Récupérer tous les utilisateurs
        $users = User::all();

        foreach ($tickets as $ticket) {
            // Créer 2 à 5 messages pour chaque ticket existant
            for ($i = 0; $i < rand(2, 5); $i++) {
                Message::factory()->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $users->random()->id // Sélectionner un utilisateur aléatoire existant
                ]);
            }
        }
    }
}
