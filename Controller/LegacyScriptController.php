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
     * @var LegacyRouteFactory
     */
    private $legacyRouteFactory;

    public function __construct(LegacyRouteFactory $legacyRouteFactory)
    {
        $this->legacyRouteFactory = $legacyRouteFactory;
    }

    /**
     * @param $requestPath
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function runLegacyScript($requestPath)
    {
        $requireLegacyScript = $this->legacyRouteFactory->createRouteProcessor($requestPath);

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
