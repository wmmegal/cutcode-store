<?php

namespace App\Cart;

class SessionIdentityStorage implements IdentityStorageContract
{

    public function get(): string
    {
        return session()->getId();
    }
}
