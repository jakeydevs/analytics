<?php

namespace Jakeydevs\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Jakeydevs\Analytics\Models\Pageview;

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
            'session_id' => Str::random(3),

            //-- Fake data should not have this data
            'user_agent' => '',
            'referrer' => '',
            'ip' => '',

            'path' => $this->faker->randomElement([
                'index',
                'path/one',
                'path/two',
            ]),

            'method' => 'GET',
            'code' => "200",
            'time_spent' => random_int(0, 100),

            //-- "parsed" data
            'parsed' => true,
            'device' => $this->faker->randomElement([
                'desktop',
                'mobile',
                'tablet',
            ]),
            'browser' => $this->faker->randomElement([
                'chrome',
                'edge',
                'firefox',
            ]),
            'location' => $this->faker->countryCode,
            'os' => $this->faker->randomElement([
                'Windows',
                'Ubuntu',
                'MacOS',
            ]),

            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
