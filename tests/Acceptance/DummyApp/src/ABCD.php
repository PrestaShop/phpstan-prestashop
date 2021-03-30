<?php

namespace DummyApp;

class ABCD
{
    use BadTrait;

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

        echo $this->whatCouldGoWrong('C');
    }
}
