<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adv>
 */
class AdvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryId = $this->faker->numberBetween(1, 6);
        $subCategoryIds = $this->getSubCategoryIds($categoryId);

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000, 10000),
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryIds ? $this->faker->randomElement($subCategoryIds) : null,
            'user_id' => $this->faker->numberBetween(1, 3),
            'city_id' => $this->faker->numberBetween(1, 10),
            'investment_sum_min' => $this->faker->numberBetween(1000, 10000),
            'investment_sum_max' => $this->faker->numberBetween(1000, 10000),
            'investment_size' => $this->faker->numberBetween(1000, 10000),
            'section_id' => $this->faker->numberBetween(1, 6),
        ];
    }

    private function getSubCategoryIds($categoryId)
    {
        $categoryToSubCategoryIds = [
            1 => [1, 2, 3, 4,5,6,7,8,9,10,11,12], // Replace with your actual sub-category IDs for category 1

        ];

        return $categoryToSubCategoryIds[$categoryId] ?? [];
    }
}
