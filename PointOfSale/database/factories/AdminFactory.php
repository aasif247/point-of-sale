<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'admin',
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
