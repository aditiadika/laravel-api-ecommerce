<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryIndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_return_collections()
    {
        $categories = factory(Category::class, 2)->create();

        $this->json('GET', 'api/category')
            ->assertJsonFragment([
                'slug' => $categories[0]->slug
            ],[
                'slug' => $categories[1]->slug
            ]);
    }

    public function test_it_only_return_parents_category()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->json('GET', 'api/category')
            ->assertJsonCount(1, 'data');
    }

    public function test_orderable_on_category()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->json('GET', 'api/category')
            ->assertSeeInOrder([$categoryTwo->slug, $category->slug]);
    }
}
