<?php

namespace Strict\Property\Tests\Intermediate;

use Closure;


class ZZVirtualPropertyClassMock
{
    private $x = 3;

    public function getGetter(): Closure {
        return function() {
            return $this->x;
        };
    }

    public function getGetterHook(): Closure {
        return function(Closure $next) {
            return $next() * $this->x;
        };
    }
}