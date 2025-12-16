<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DanhMucFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $name = fake()->unique()->word();
    return [
        'tendanhmuc' => $name,
        'tendanhmuc_slug' => \Illuminate\Support\Str::slug($name),
    ];
}
}
