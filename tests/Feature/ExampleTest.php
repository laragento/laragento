<?php

namespace Tests\Feature;

use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('product/frappe-erdbeer');

          $this->browse(function ($browser) {
                $browser->visit('product/frappe-erdbeer')
                      //->type('email', $user->email)
                      //->type('password', 'secret')
                      //->press('Login')
                      //->assertPathIs('/home');
                      ->assertSee('Fra ppé');
          });

        $response->assertStatus(200);
    }
}
