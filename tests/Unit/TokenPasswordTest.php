<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatingANewInstanceSetsThePassword()
    {
        $user = factory(User::class)->create();
        $password = Token::create(['user_id' => $user->id]);

        $this->assertNotNull($password->password);
    }

    public function testPasswordsAreUnique()
    {
        $passwords = [];

        for ($count = 0; $count < 100; $count++) {
            $user = factory(User::class)->create();
            $password = Token::create(['user_id' => $user->id]);

            $this->assertFalse(in_array($password->password, $passwords));

            $passwords[] = $password->password;
        }
    }

    public function testSavingANewInstanceSetsThePassword()
    {
        $user = factory(User::class)->create();

        $password = new Token(['user_id' => $user->id]);
        $password->save();

        $this->assertNotNull($password->password);
    }

    public function testThePasswordMayNotBeModified()
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
