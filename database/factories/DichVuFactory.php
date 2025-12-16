<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DichVuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
	{
		$name = fake()->unique()->sentence(3); 
		return [
			'danhmuc_id' => \App\Models\DanhMuc::inRandomOrder()->first()->id,
			'tendichvu' => $name,
			'tendichvu_slug' => \Illuminate\Support\Str::slug($name),
			'motadichvu' => fake()->paragraph(),
			'dongia' => fake()->numberBetween(50000, 200000),
			'donvitinh' => fake()->randomElement(['kg', 'cái', 'bộ']),
			'hinhanh' => fake()->imageUrl(640, 480, 'laundry', true),
		];
	}
}
