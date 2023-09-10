<?php

namespace App\Support;

use App\Events\AfterSessionRegenerate;
use Closure;

class SessionRegenerateRunner
{
    public static function run(Closure $callback = null): void
    {
        $old = session()->getId();

        session()->invalidate();

        session()->regenerateToken();

        if (!is_null($callback)) {
            $callback();
        }

        event(new AfterSessionRegenerate(
            $old,
            session()->getId()
        ));
    }
}
