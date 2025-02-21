<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['В процессе', 'Завершено', 'Не завершено'];
        return [
            'title' => $this->faker->realText(mt_rand(10, 15)),
            'description' => $this->faker->realText(mt_rand(10, 100)),
            'deadline' => $this->faker->dateTimeBetween('2024-01-01', 'now'),
            'status' => $this->faker->randomElement($status),
            'user_id' => mt_rand(1, 5),
        ];
    }
}
