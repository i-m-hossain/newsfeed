<?php

namespace Database\Factories;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chirp = Chirp::inRandomOrder()->first();
        $chirpId = $chirp ? $chirp->id : null;
        $userId = User::inRandomOrder()->first();

        return [
            'body' => fake()->sentence(),
            'chirp_id' => $chirpId,
            'user_id' => $userId
        ];
    }
}
