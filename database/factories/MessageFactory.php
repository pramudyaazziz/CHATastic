<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        $id = fake()->numberBetween(1, 2);
        return [
            'conversation_id' => 1,
            'from_id' => $id,
            'to_id' => $id == 1 ? 2 : 1,
            'body' => fake()->text(100),
            'type' => 'text',
            'is_read' => false
        ];
    }
}
