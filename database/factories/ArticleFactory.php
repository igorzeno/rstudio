<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleTag;
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
            'name' => $this->faker->name(),
            'img' => '',
            'img_preview' => '',
            'user_id' => 1,
        ];

    }
}
