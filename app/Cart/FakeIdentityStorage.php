<?php

namespace App\Cart;

class FakeIdentityStorage implements IdentityStorageContract
{

    public function get(): string
    {
        return 'tests';
    }
}
