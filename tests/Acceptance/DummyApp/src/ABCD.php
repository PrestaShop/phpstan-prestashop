<?php

namespace PHPStanForPrestaShopTests\Acceptance\DummyApp\src;

class ABCD
{
    /**
     * @return int
     */
    public function getName()
    {
        return self::class;
    }

    public function toggle($state)
    {
        if ($state) {
            echo "A";
        } else {
            echo "B";
        }
    }
}
