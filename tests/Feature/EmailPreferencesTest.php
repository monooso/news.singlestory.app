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
    public function a_confirmation_message_is_displayed_when_the_email_preferences_are_saved(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'news_source' => NewsSource::BBC_NEWS,
            'schedule'    => EmailSchedule::DAILY,
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
            'news_source' => NewsSource::BBC_NEWS,
            'schedule'    => EmailSchedule::DAILY,
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
            'news_source' => NewsSource::BBC_NEWS,
            'schedule'    => EmailSchedule::WEEKLY,
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
            'news_source' => NewsSource::BBC_NEWS,
            'schedule'    => EmailSchedule::NEVER,
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

        $response = $this->post(route('account'), [
            'news_source' => NewsSource::BBC_NEWS,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function an_error_is_returned_when_attempting_to_set_an_invalid_schedule(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'news_source' => NewsSource::BBC_NEWS,
            'schedule'    => 'yearly',
        ]);

        $this->assertDatabaseMissing('users', [
            'id'       => $user->id,
            'schedule' => 'yearly',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    /** @test */
    public function an_authenticated_user_can_choose_to_be_an_informed_member_of_society(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'news_source' => NewsSource::INDEPENDENT,
            'schedule'    => EmailSchedule::DAILY,
        ]);

        $this->assertDatabaseHas('users', [
            'id'          => $user->id,
            'news_source' => NewsSource::INDEPENDENT,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_can_choose_to_be_a_right_wing_dick_hole(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'news_source' => NewsSource::BREITBART_NEWS,
            'schedule'    => EmailSchedule::DAILY,
        ]);

        $this->assertDatabaseHas('users', [
            'id'          => $user->id,
            'news_source' => NewsSource::BREITBART_NEWS,
        ]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_error_is_returned_when_the_news_source_is_missing()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::WEEKLY,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('news_source');
    }

    /** @test */
    public function an_error_is_returned_when_attempting_to_set_an_invalid_news_source(
    )
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'news_source' => 'wibble',
            'schedule'    => EmailSchedule::DAILY,
        ]);

        $this->assertDatabaseMissing('users', [
            'id'          => $user->id,
            'news_source' => 'wibble',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('news_source');
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
        $user = factory(User::class)->create();
        $this->be($user);

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
