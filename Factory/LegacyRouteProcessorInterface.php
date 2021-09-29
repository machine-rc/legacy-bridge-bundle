<?php

namespace Machine\LegacyBridgeBundle\Factory;

use Closure;

interface LegacyRouteProcessorInterface
{
    public function createRouteProcessor(string $requestPath): Closure;
}
