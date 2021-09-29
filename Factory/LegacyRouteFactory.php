<?php

namespace Machine\LegacyBridgeBundle\Factory;

use Closure;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouteCollection;

class LegacyRouteFactory implements LegacyRouteGeneratorInterface, LegacyRouteProcessorInterface
{
    private $routeGeneratorList = [];
    /**
     * @var LegacyRouteProcessorInterface
     */
    private $routeProcessor;

    public function addGenerator(LegacyRouteGeneratorInterface $generator): void
    {
        $this->routeGeneratorList[] = $generator;
    }

    public function generateRoutes(SplFileInfo $file, RouteCollection $routeCollection): void
    {
        array_walk($this->routeGeneratorList, static function (LegacyRouteGeneratorInterface $generator) use ($file, $routeCollection) {
            $generator->generateRoutes($file, $routeCollection);
        });
    }

    public function createRouteProcessor(string $requestPath): Closure
    {
        if (!$this->routeProcessor instanceof LegacyRouteProcessorInterface) {
            return static function () {};
        }

        return $this->routeProcessor->createRouteProcessor($requestPath);
    }

    public function getRouteProcessor(): LegacyRouteProcessorInterface
    {
        return $this->routeProcessor;
    }

    public function setRouteProcessor(LegacyRouteProcessorInterface $routeProcessor): void
    {
        $this->routeProcessor = $routeProcessor;
    }
}
