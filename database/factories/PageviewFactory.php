<?php

namespace Database\Factories;

use App\Models\Pageview;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pageview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => Str::random(100),

            'user_agent' => $this->faker->userAgent(),
            'referrer' => '',
            'ip' => $this->faker->ipv4(),

            'path' => $this->faker->randomElement([
                'index',
                'path/one',
                'path/two',
            ]),

            'method' => 'GET',
            'code' => "200",
            'time_spent' => random_int(0, 100),
        ];
    }
}
