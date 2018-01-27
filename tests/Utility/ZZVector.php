<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Intermediate\PropertyRegister;
use Strict\Property\Utility\StrictPropertyContainer;
use Closure;


/**
 * @property-read float $r
 * @property float      $x
 * @property float      $y
 */
class ZZVector
    extends StrictPropertyContainer
{
    protected function registerProperty(PropertyRegister $propertyRegister): void
    {
        $propertyRegister
            ->newProperty('x', true, true)
            ->newProperty('y', true, true);

        $validator = function (float $value, Closure $next) {
            $next($value);
        };

        $propertyRegister
            ->addSetterHook('x', $validator)
            ->addSetterHook('y', $validator);

        $propertyRegister
            ->newVirtualProperty('r', function (): float {
                return ($this->x ** 2 + $this->y ** 2) ** 0.5;
            }, null);
    }

    public function __construct(float $x = 0.0, float $y = 0.0)
    {
        parent::__construct();
        $this->x = $x;
        $this->y = $y;
    }
}