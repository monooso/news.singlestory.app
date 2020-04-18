<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cannot_access_the_delete_account_page()
    {
        $response = $this->get(route('account.delete'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_access_the_delete_account_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('account.delete'));

        $response->assertViewIs('account.delete');
    }

    /** @test */
    public function deleting_the_account_removes_the_user_from_the_database()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->delete(route('account.destroy'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('status', trans('account.deleted'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
