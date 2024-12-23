<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name,
            'class' => $this->faker->randomElement(['Guerreiro', 'Mago', 'Arqueiro', 'Clérigo']),
            'xp' => $this->faker->numberBetween(0, 100),
            'is_confirmed' => $this->faker->boolean,
        ];
    }
}
