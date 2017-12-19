<?php

namespace Tests\Feature;

use App\Constants\EmailSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailPreferencesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cannot_submit_the_email_preferences_form()
    {
        $response = $this->post(route('account'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function a_confirmation_message_is_displayed_when_the_email_preferences_are_saved(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
        ]);

        $response->assertRedirect(route('account'));
        $response->assertSessionHas('status', trans('account.updated'));
    }

    /** @test */
    public function an_authenticated_user_can_choose_to_receive_daily_emails()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::DAILY,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_can_choose_to_receive_weekly_emails()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::WEEKLY,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::WEEKLY,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_can_choose_to_receive_no_emails()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::NEVER,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::NEVER,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_error_is_returned_when_the_schedule_is_missing()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function an_error_is_returned_when_attempting_to_set_an_invalid_schedule(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), ['schedule' => 'yearly']);

        $this->assertDatabaseMissing('users', [
            'id'       => $user->id,
            'schedule' => 'yearly',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function the_account_view_receives_the_currently_authenticated_user()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('account'));

        $response->assertViewIs('account.show');
        $response->assertViewHas('user', $user);
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
