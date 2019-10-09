<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    protected function signIn($user = null)
    {
        Passport::actingAs($user ?: factory(User::class)->create());

        return $this;
    }
}
