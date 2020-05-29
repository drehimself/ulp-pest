<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

/**
 * Set the currently logged in user for the application.
 */
function actingAs(Authenticatable $user, string $driver = null): TestCase
{
    return test()->actingAs($user, $driver);
}

function get(string $url)
{
    return test()->get($url);
}

function assertDatabaseHas(string $table, array $fields)
{
    return test()->assertDatabaseHas($table, $fields);
}
