<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $fillable = ['email'];

    protected $hidden = [];

    /**
     * A user has a maximum of one active "password" token.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token()
    {
        return $this->hasOne(Token::class);
    }

    /**
     * Convenience method for accessing the user's active "password" token.
     *
     * @return string
     */
    public function getPasswordAttribute()
    {
        return (string)$this->token;
    }
}
