<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hey = 'artisan';
    }

    /** @test */
    public function the_main_page_loads_correctly()
    {
        $response = $this->get(route('posts.index'));

        $response->assertSuccessful();
        $response->assertSee('Posts');
        $this->assertEquals('artisan', $this->hey);
    }

    /** @test */
    public function shows_that_there_are_no_posts_when_there_are_no_posts()
    {
        $posts = Post::all();

        $response = $this->get(route('posts.index'));

        $response->assertSuccessful();
        $response->assertSee('No posts yet');
        $this->assertCount(0, $posts);
    }

    /** @test */
    public function users_can_see_the_posts_on_index_page()
    {
        $postA = factory(Post::class)->create([
            'title' => 'My first post',
        ]);

        $postB = factory(Post::class)->create([
            'title' => 'My second post',
        ]);

        $response = $this->get(route('posts.index'));

        $response->assertSuccessful();
        $response->assertSee('My first post');
        $response->assertSee('My second post');
        $this->assertCount(2, Post::all());
    }

    /** @test */
    public function guests_cannot_see_create_post_button()
    {
        $response = $this->get(route('posts.index'));

        $response->assertSuccessful();
        $response->assertDontSee('Create Post');
    }

    /** @test */
    public function logged_in_users_can_see_create_post_button()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertSuccessful();
        $response->assertSee('Create Post');
    }

    /** @test */
    public function guests_cannot_create_a_post()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_users_can_view_create_post_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertSuccessful();
        $response->assertSee('Create Post');
    }

    /** @test */
    public function logged_in_users_can_create_a_post()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post(route('posts.store'), [
                'title' => 'My first post',
                'body' => 'Body for first post',
            ]);

        $response->assertSuccessful();
        $response->assertSee('Post created successfully');
        $response->assertSee('My first post');

        $this->assertDatabaseHas('posts', [
            'title' => 'My first post',
        ]);
    }

    /** @test */
    public function users_can_view_a_post()
    {
        $postA = factory(Post::class)->create([
            'title' => 'My first post',
            'body' => 'Body for my first post'
        ]);

        $response = $this->get(route('posts.show', $postA));

        $response->assertSuccessful();
        $response->assertSee('My first post');
        $response->assertSee('Body for my first post');
    }
}
