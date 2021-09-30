<?php

namespace Machine\LegacyBridgeBundle\Controller;

use Machine\LegacyBridgeBundle\Factory\LegacyRouteFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class LegacyScriptController
 *
 * @package Machine\LegacyBridgeBundle\Controller
 */
class LegacyScriptController implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function runLegacyScript(string $requestPath, string $filePath): StreamedResponse
    {
        $legacyRouteFactory = $this->container->get(LegacyRouteFactory::class);

        $requireLegacyScript = static function () {};
        if ($legacyRouteFactory instanceof LegacyRouteFactory) {
            $requireLegacyScript = $legacyRouteFactory->createRouteProcessor($requestPath, $filePath);
        }

        return new StreamedResponse($requireLegacyScript);
    }

    /**
     * @param string|null $script
     */
    public function setPrependScript($script = null)
    {
        $this->prependScript = $script;
    }

    /**
     * @param string|null $script
     */
    public function setAppendScript($script = null)
    {
        $this->appendScript = $script;
    }

    /** {@inheritdoc} */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
