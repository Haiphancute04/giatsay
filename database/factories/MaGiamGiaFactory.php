<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaGiamGiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
	{
		return [
			'ma_code' => fake()->unique()->regexify('[A-Z0-9]{8}'), 
			'loai_giamgia' => fake()->randomElement(['fixed', 'percent']),
			'giatri' => fake()->randomElement([10000, 20000, 10, 15]), 
			'dieukien_toithieu' => 100000,
			'soluong_phathanh' => 100,
			'ngay_batdau' => now(),
			'ngay_ketthuc' => now()->addDays(30),
			'trangthai' => true,
		];
	}
}
