<?php

namespace KnpU\LoremIpsumBundle\Tests\Controller;

use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class IpsumApiControllerTest extends TestCase
{
    public function testIndex()
    {
        $kernel = new KnpULoremIpsumControllerKernel();
        $client = new KernelBrowser($kernel);
        $client->request('GET', '/api/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

class KnpULoremIpsumControllerKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new KnpULoremIpsumBundle(),
            new FrameworkBundle(),
        ];
    }

    protected function configureRoutes(RoutingConfigurator $routes)
    {
        $routes->import(__DIR__.'/../../src/Resources/config/routes.xml')->prefix('/api');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'F00',
            'router' => ['utf8' => true],
        ]);
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/../cache/'.spl_object_hash($this);
    }
}
