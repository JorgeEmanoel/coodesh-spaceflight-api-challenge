<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,
            'imageUrl' => $this->faker->url(),
            'newsSite' => $this->faker->name(),
            'summary' => $this->faker->paragraph,
            'featured' => $this->faker->randomElement([true, false]),
            'launches' => $this->fakeLaunches($this->faker->numberBetween(0, 10)),
            'events' => $this->fakeEvents($this->faker->numberBetween(0, 10)),
        ];
    }

    private function fakeLaunches(int $quantity)
    {
        $launches = [];
        for ($i = 0; $i < $quantity; $i++) {
            $launches[] = [
                'id' => $this->faker->uuid(),
                'provider' => $this->faker->name(),
            ];
        }

        return $launches;
    }

    private function fakeEvents(int $quantity)
    {
        $events = [];
        for ($i = 0; $i < $quantity; $i++) {
            $events[] = [
                'id' => $this->faker->numberBetween(1, 1000),
                'provider' => $this->faker->name(),
            ];
        }

        return $events;
    }
}
