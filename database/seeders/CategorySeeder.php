<?php

namespace Database\Seeders;

use App\Models\Catalog\Category as CatalogCategory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{

    public  $cates = [
        [
            'name' => 'category 1',
            'slug' => 'category-1',
            'active' => true,

        ],
        [
            'name' => 'category 2',
            'slug' => 'category-2',
            'active' => false,

        ]
    ];

    public function run()
    {
        if (Category::count() <= 0) {

            foreach ($this->cates as $category) {

                CatalogCategory::create($category);
            }
        }
    }
}
