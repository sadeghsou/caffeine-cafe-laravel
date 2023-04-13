<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'espresso', 'label' => 'بر پاسه اسپرسو', 'description' => NULL, 'image' => 'categories/espresso.png'],
            ['name' => 'brew-coffee', 'label' => 'قهوه دمی', 'description' => NULL, 'image' => 'categories/brew-coffee.png'],
            ['name' => 'warm-drink', 'label' => 'نوشیدنی گرم و دمنوش', 'description' => NULL, 'image' => 'categories/warm-drink.png'],
            ['name' => 'ice-coffee', 'label' => 'قهوه سرد', 'description' => NULL, 'image' => 'categories/ice-coffee.png'],
            ['name' => 'frappe-coffee', 'label' => 'فراپه', 'description' => NULL, 'image' => 'categories/frappe-coffee.png'],
            ['name' => 'milkshake', 'label' => 'میلک شیک و اسموتی', 'description' => NULL, 'image' => 'categories/milkshake.png'],
            ['name' => 'cold-drink', 'label' => 'نوشیدنی سرد', 'description' => NULL, 'image' => 'categories/cold-drink.png'],
            ['name' => 'bread', 'label' => 'نان و شیرینی', 'description' => NULL, 'image' => 'categories/bread.png',]
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
