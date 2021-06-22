<?php

namespace Database\Factories;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invitation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(rand(5,10)),
            "date" => $this->faker->date(),
            "image" => 'https://firebasestorage.googleapis.com/v0/b/recipe-images-9a9cc.appspot.com/o/no-image.jpg?alt=media&token=c23fdbfa-0680-4125-bfe6-d41d5290ce62',
            "location" => $this->faker->address,
            "description" => $this->faker->text(rand(10, 25)),
            "user_id" => rand(1, 25),
        ];
    }
}
