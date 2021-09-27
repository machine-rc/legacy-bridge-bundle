<?php

namespace Basster\LegacyBridgeBundle\Tests\DependencyInjection;

use Basster\LegacyBridgeBundle\DependencyInjection\BassterLegacyBridgeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class BassterLegacyBridgeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideConfigs
     */
    public function setLegacyPath(
      array $config,
      $path,
      $prepend = null,
      $append = null
    ) {
        $bag = new ParameterBag();

        $extension = new BassterLegacyBridgeExtension();
        $extension->load($config, new ContainerBuilder($bag));

        self::assertEquals($path,
                           $bag->get('machine_legacy_bridge.legacy_path'));
        self::assertEquals($prepend,
                           $bag->get('machine_legacy_bridge.prepend_script'));
        self::assertEquals($append,
                           $bag->get('machine_legacy_bridge.append_script'));
    }

    public function provideConfigs()
    {
        $pathOnly = array(
          'machine_legacy_bridge' => array(
            'legacy_path' => __DIR__,
          ),
        );

        $prependOnly                                            = $pathOnly;
        $prependOnly['machine_legacy_bridge']['prepend_script'] = __FILE__;

        $appendOnly                                           = $pathOnly;
        $appendOnly['machine_legacy_bridge']['append_script'] = __FILE__;

        $all                                            = $pathOnly;
        $all['machine_legacy_bridge']['append_script']  = __FILE__;
        $all['machine_legacy_bridge']['prepend_script'] = __FILE__;

        return array(
          'path-only'         => array($pathOnly, __DIR__, null, null),
          'with-prepend-only' => array($prependOnly, __DIR__, __FILE__, null),
          'with-append-only'  => array($appendOnly, __DIR__, null, __FILE__),
          'all'               => array($all, __DIR__, __FILE__, __FILE__),
        );
    }
}
