<?php

namespace Database\Factories;

use App\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class PtFactory extends Factory
{
    protected $model = Model::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => app('hash')->make($this->faker->password(8)),
            'plan' => 0
    	];
    }
}
