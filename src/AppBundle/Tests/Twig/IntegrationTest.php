<?php

use AppBundle\Twig\Extension\AppBundleExtension;

class Project_Tests_IntegrationTest extends Twig_Test_IntegrationTestCase
{
    public function getExtensions()
    {
        //use Psr\Container\ContainerInterface;
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')->getMock();

        return array(
            new AppBundleExtension($container),
        );
    }

    public function getFixturesDir()
    {
        return dirname(__FILE__).'/Fixtures/';
    }
}
