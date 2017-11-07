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

    public function testAGuestUserCannotSubmitTheEmailPreferencesForm()
    {
        $response = $this->post(route('account'));

        $response->assertRedirect(route('login'));
    }

    public function testAConfirmationMessageIsDisplayedWhenTheEmailPreferencesAreSaved()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), [
            'schedule' => EmailSchedule::DAILY,
        ]);

        $response->assertRedirect(route('account'));
        $response->assertSessionHas('status', trans('account.updated'));
    }

    public function testAnAuthenticatedUserCanChooseToReceiveDailyEmails()
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

    public function testAnAuthenticatedUserCanChooseToReceiveWeeklyEmails()
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

    public function testAnAuthenticatedUserCanChooseToReceiveNoEmails()
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

    public function testAnErrorIsReturnedWhenTheScheduleIsMissing()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('account'), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors('schedule');
    }

    public function testAnErrorIsReturnedWhenAttemptingToSetAnInvalidSchedule()
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

    public function testTheAccountViewReceivesTheCurrentlyAuthenticatedUser()
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
