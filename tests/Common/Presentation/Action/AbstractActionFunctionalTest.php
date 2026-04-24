<?php

declare(strict_types=1);

namespace App\Test\Common\Presentation\Action;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractActionFunctionalTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected UrlGeneratorInterface $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->router = static::getContainer()->get(UrlGeneratorInterface::class);
    }
}
