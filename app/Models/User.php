<?php

namespace App\Models;

use App\Constants\EmailSchedule;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use Notifiable;

    protected $fillable = ['email', 'schedule', 'source'];

    protected $hidden = [];

    /**
     * Return the users who wish to receive a daily email.
     *
     * @return Collection
     */
    public static function daily(): Collection
    {
        return static::where('schedule', EmailSchedule::DAILY)->get();
    }

    /**
     * Return the users who wish to receive a weekly email.
     *
     * @return Collection
     */
    public static function weekly(): Collection
    {
        return static::where('schedule', EmailSchedule::WEEKLY)->get();
    }

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
        return (string) $this->token;
    }

    /**
     * We don't support "remember me" functionality.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }
}
