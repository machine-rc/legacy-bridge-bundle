<?php

namespace Machine\LegacyBridgeBundle\Routing;

use Machine\LegacyBridgeBundle\Factory\LegacyRouteFactory;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouteCollection;

class LegacyRouteLoader extends Loader
{
    /** @var bool */
    private $loaded = false;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @var string
     */
    private $legacyPath;

    /**
     * @var LegacyRouteFactory
     */
    private $legacyRouteFactory;

    /**
     * LegacyRouteLoader constructor.
     *
     * @param string                                $legacyPath
     * @param \Symfony\Component\Finder\Finder|null $finder
     */
    public function __construct(string $legacyPath, Finder $finder = null, LegacyRouteFactory $legacyRouteFactory)
    {
        parent::__construct();
        $this->finder     = $finder ?: new Finder();
        $this->legacyPath = $legacyPath;
        $this->legacyRouteFactory = $legacyRouteFactory;
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "legacy" loader twice');
        }

        $routes = new RouteCollection();
        $this->initFinder();

        /** @var SplFileInfo $file */
        foreach ($this->finder as $file) {
            $this->legacyRouteFactory->generateRoutes($file, $routes);
        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null): bool
    {
        return 'legacy' === $type;
    }

    private function initFinder(): void
    {
        if (\is_dir($this->legacyPath) && \is_readable($this->legacyPath)) {
            $this->finder->ignoreDotFiles(true)
                ->files()
                ->name('*.php')
                ->in($this->legacyPath);

            return;
        }

        $this->finder->ignoreDotFiles(true)
            ->files()
            ->name('ignoreEverything')
            ->in(__DIR__);
    }
}
