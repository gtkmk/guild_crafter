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
            'name' => Str::limit($this->faker->name, 50),
            'class' => $this->faker->randomElement(['warrior', 'mage', 'archer', 'cleric']),
            'xp' => $this->faker->numberBetween(0, 100),
        ];
    }
}
