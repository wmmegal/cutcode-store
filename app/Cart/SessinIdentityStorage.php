<?php

namespace App\Cart;

class SessinIdentityStorage implements IdentityStorageContract
{

    public function get(): string
    {
        return session()->getId();
    }
}
