<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(), // Crée un ticket ou associe un ticket existant
            'user_id' => User::factory(),     // Crée un utilisateur ou associe un utilisateur existant
            'content' => $this->faker->text(200), // Génère un contenu aléatoire pour le message
        ];
    }
}
