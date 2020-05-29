<?php

use App\Post;
use App\User;

beforeEach(function () {
    $this->hey = 'artisan';
});

it('loads the main page correctly', function () {
    $response = get(route('posts.index'));

    $response->assertSuccessful();
    $response->assertSee('Posts');
    assertEquals('artisan', $this->hey);
});

it('loads the main page correctly chained')
    ->get('/')
    ->assertSuccessful()
    ->assertSee('Posts');

it('shows that there are no posts when there are no posts', function () {
    $posts = Post::all();

    $response = get(route('posts.index'));

    $response->assertSuccessful();
    $response->assertSee('No posts yet');
    assertCount(0, $posts);
});

test('users can see the posts on the index page', function () {
    $postA = factory(Post::class)->create([
        'title' => 'My first post',
    ]);

    $postB = factory(Post::class)->create([
        'title' => 'My second post',
    ]);

    $response = get(route('posts.index'));

    $response->assertSuccessful();
    $response->assertSee('My first post');
    $response->assertSee('My second post');
    assertCount(2, Post::all());
});

test('guests cannot see create post button', function () {
    $response = get(route('posts.index'));

    $response->assertSuccessful();
    $response->assertDontSee('Create Post');
});

test('logged in users can see create post button', function () {
    $user = factory(User::class)->create();

    $response = actingAs($user)->get(route('posts.index'));

    $response->assertSuccessful();
    $response->assertSee('Create Post');
});

test('guests cannot create a post', function () {
    $response = get(route('posts.create'));

    $response->assertRedirect(route('login'));
});

test('logged in users can view the create post page', function () {
    $user = factory(User::class)->create();

    $response = actingAs($user)->get(route('posts.create'));

    $response->assertSuccessful();
    $response->assertSee('Create Post');
});

test('logged in users can create a post', function () {
    $user = factory(User::class)->create();

    $response = actingAs($user)
        ->followingRedirects()
        ->post(route('posts.store'), [
            'title' => 'My first post',
            'body' => 'Body for first post',
        ]);

    $response->assertSuccessful();
    $response->assertSee('Post created successfully');
    $response->assertSee('My first post');

    assertDatabaseHas('posts', [
        'title' => 'My first post',
    ]);
});

test('users can view a post', function () {
    $postA = factory(Post::class)->create([
        'title' => 'My first post',
        'body' => 'Body for my first post'
    ]);

    $response = get(route('posts.show', $postA));

    $response->assertSuccessful();
    $response->assertSee('My first post');
    $response->assertSee('Body for my first post');
});
