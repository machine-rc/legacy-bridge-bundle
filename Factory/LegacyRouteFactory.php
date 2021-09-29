<?php


namespace Machine\LegacyBridgeBundle\Factory;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouteCollection;

class LegacyRouteFactory implements LegacyRouteGeneratorInterface
{
    private $routeGeneratorList = [];

    public function addGenerator(LegacyRouteGeneratorInterface $generator): void
    {
        $this->routeGeneratorList[] = $generator;
    }

    public function generateRoutes(SplFileInfo $file, RouteCollection $routeCollection): void
    {
        array_walk($this->routeGeneratorList, function (LegacyRouteGeneratorInterface $generator) use ($file, $routeCollection) {
            $generator->generateRoutes($file, $routeCollection);
        });
    }
}
