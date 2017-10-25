<?php

namespace App\Models;

use App\Observers\TokenObserver;
use App\Scopes\ActiveTokenScope;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $dates = ['expires_at'];

    protected $fillable = ['user_id'];

    /**
     * Register the TokenObserver with the model.
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveTokenScope);
        static::observe(new TokenObserver);
    }

    /**
     * Create a new token for the given user.
     *
     * @param User $user
     *
     * @return Token
     */
    public static function createForUser(User $user)
    {
        return static::create(['user_id' => $user->id]);
    }

    /**
     * Override the Model::refresh method to fix global scopes issue.
     * @see https://github.com/laravel/framework/issues/21809
     *
     * @return $this
     */
    public function refresh()
    {
        if (!$this->exists) {
            return $this;
        }

        $this->setRawAttributes(static::newQueryWithoutScopes()
            ->findOrFail($this->getKey())
            ->attributes
        );

        $this->load(collect($this->relations)
            ->except('pivot')
            ->keys()
            ->toArray()
        );

        return $this;
    }

    /**
     * Enable route model binding, using the password field as the key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'password';
    }

    /**
     * Every token belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Use the password field as the string representation of the model.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->password;
    }
}
