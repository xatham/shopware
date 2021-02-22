<?php

declare(strict_types=1);

namespace LiveShopping\Components;

class LiveShoppingPrinter
{
    public function getSlogan(): string
    {
        $slogans = [
            'An apple a day keeps the doctor away',
            'Let’s get ready to rumble',
            'A rolling stone gathers no moss',
        ];

        return array_rand(array_flip($slogans));
    }
}
