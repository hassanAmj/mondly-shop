<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{

        use RefreshDatabase;

        public function test_category_can_have_childern():void{
            $parent = Category::create([
                'name' => 'Kitchen',
                'slug' => 'kitchen',
            ]);

            $child = Category::create([
                'name' => 'Air Fryer',
                'slug' => 'air-fryer',
                'parent_id' => $parent->id,
            ]);

            $this->assertTrue(
                $parent->children->contains($child)
            );

        }

        public function test_category_can_have_parent():void{
            $parent = Category::create([
                'name' => 'Kitchen',
                'slug' => 'kitchen',
            ]);

            $child = Category::create([
                'name' => 'Air Fryer',
                'slug' => 'air-fryer',
                'parent_id' => $parent->id,
            ]);

            $this->assertTrue(
                $child->parent->is($parent)
            );


        }

}
