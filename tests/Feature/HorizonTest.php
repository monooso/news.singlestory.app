<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class HorizonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cannot_access_horizon()
    {
        $response = $this->get('horizon');

        $response->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_access_horizon()
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $response = $this->get('horizon');

        $response->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_access_horizon()
    {
        Config::set('horizon.admins', ['john@doe.com']);

        $user = factory(User::class)->create(['email' => 'john@doe.com']);

        $this->be($user);

        $response = $this->get('horizon');

        $response->assertStatus(200);
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
