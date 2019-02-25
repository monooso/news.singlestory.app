<?php

namespace App\Models;

trait SaneRefresh
{
    /**
     * Override the Model::refresh method to fix global scopes issue.
     *
     * @see https://github.com/laravel/framework/issues/21809
     *
     * @return $this
     */
    public function refresh()
    {
        if (! $this->exists) {
            return $this;
        }

        $this->setRawAttributes(static::newQueryWithoutScopes()
            ->findOrFail($this->getKey())
            ->attributes);

        $this->load(collect($this->relations)
            ->except('pivot')
            ->keys()
            ->toArray());

        return $this;
    }
}
