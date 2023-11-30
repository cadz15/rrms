<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Support\Arr;
use App\Enums\RequestItemEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestItem>
 */
class RequestItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $request = Request::inRandomOrder()->first();
        return [
            'request_id' => $request->id,
            'item_name' => $this->faker->name(),
            'quantity' => rand(1, 10),
            'price' => rand(1, 10),
            'status' => Arr::random([
                RequestItemEnum::DECLINED,
                RequestItemEnum::PENDING,
                RequestItemEnum::APPROVED
            ])
        ];
    }
}
