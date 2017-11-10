<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_new_instance_sets_the_password()
    {
        $user = factory(User::class)->create();
        $password = Token::create(['user_id' => $user->id]);

        $this->assertNotNull($password->password);
    }

    /** @test */
    public function passwords_are_unique()
    {
        $passwords = [];

        for ($count = 0; $count < 100; $count++) {
            $user = factory(User::class)->create();
            $password = Token::create(['user_id' => $user->id]);

            $this->assertFalse(in_array($password->password, $passwords));

            $passwords[] = $password->password;
        }
    }

    /** @test */
    public function saving_a_new_instance_sets_the_password()
    {
        $user = factory(User::class)->create();

        $password = new Token(['user_id' => $user->id]);
        $password->save();

        $this->assertNotNull($password->password);
    }

    /** @test */
    public function the_password_may_not_be_modified()
    {
        $user = factory(User::class)->create();

        $password = Token::create(['user_id' => $user->id]);
        $expected = $password->password;

        $password->password = 'very-secure';
        $password->save();
        $password->refresh();

        $this->assertSame($expected, $password->password);
    }
}
