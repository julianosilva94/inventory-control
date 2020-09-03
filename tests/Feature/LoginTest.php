<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function email_field_is_required()
    {
        $credentials = [ 'email' => null ];

        $this->post(route('login.authenticate'), $credentials)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function password_field_is_required()
    {
        $credentials = [ 'password' => null ];

        $this->post(route('login.authenticate'), $credentials)
            ->assertSessionHasErrors();
    }
}
