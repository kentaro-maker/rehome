<?php

namespace Database\Factories;

use App\Models\Apply;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Apply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => Event::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'approved' => null,
        ];
    }
}
