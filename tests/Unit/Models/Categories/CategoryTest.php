<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_many_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->children()->first());
    }

    public function test_it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertEquals(1, $category->parents()->count());
    }

    public function test_category_can_be_orderable()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->assertEquals($categoryTwo->name, Category::ordered()->first()->name);
    }
}
