<?php

namespace App\Observers;

use App\Models\Token;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TokenObserver
{
    /**
     * Automatically set the expiration date and password for new instances.
     *
     * @param Token $instance
     */
    public function creating(Token $instance)
    {
        $this->deleteUserTokens($instance->user_id);

        $instance->expires_at = Carbon::now()
            ->addMinutes(config('token.lifetime'));

        $instance->password = Uuid::uuid4()->toString();
    }

    /**
     * Delete any tokens associated with the given user ID.
     *
     * @param $userId
     */
    private function deleteUserTokens($userId)
    {
        Token::where('user_id', $userId)->delete();
    }

    /**
     * Prevent a token from being updated.
     *
     * @return false
     */
    public function updating()
    {
        return false;
    }
}
