<?php

namespace Tests\Feature;

use App\Constants\EmailSchedule;
use App\Constants\NewsSource;
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
    public function a_confirmation_message_is_displayed_after_saving()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
            'source'   => NewsSource::REUTERS,
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
            'source'   => NewsSource::REUTERS,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::DAILY,
            'source'   => NewsSource::REUTERS,
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
            'source'   => NewsSource::BBC_NEWS,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::WEEKLY,
            'source'   => NewsSource::BBC_NEWS,
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
            'source'   => NewsSource::BREITBART_NEWS,
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => $user->id,
            'schedule' => EmailSchedule::NEVER,
            'source'   => NewsSource::BREITBART_NEWS,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_error_is_returned_when_the_schedule_is_missing()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post(route('account'), [
            'source' => NewsSource::INDEPENDENT,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function an_error_is_returned_when_the_schedule_is_invalid()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post(route('account'), ['schedule' => 'yearly']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function an_error_is_returned_when_the_source_is_missing()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('source');
    }

    /** @test */
    public function an_error_is_returned_when_the_source_is_invalid()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
            'source'   => 'papur-pawb',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('source');
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

    /** @test */
    public function the_account_view_receives_the_available_news_sources()
    {
        $this->be(factory(User::class)->create());

        $response = $this->get(route('account'));

        $response->assertViewIs('account.show');
        $response->assertViewHas('sources');
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
