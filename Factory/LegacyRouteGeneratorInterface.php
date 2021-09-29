<?php

namespace Machine\LegacyBridgeBundle\Factory;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouteCollection;

interface LegacyRouteGeneratorInterface
{
    public function generateRoutes(SplFileInfo $file, RouteCollection $routeCollection): void;
}
