<?php

namespace NotificationChannels\JetSms\Test;

use Illuminate\Container\ContextualBindingBuilder;
use Illuminate\Contracts\Foundation\Application;
use Mockery as M;
use NotificationChannels\JetSms\JetSmsServiceProvider;
use PHPUnit\Framework\TestCase;

class JetSmsServiceProviderTest extends TestCase
{
    private $app;
    private $contextualBindingBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->app = M::mock(Application::class);
        $this->contextualBindingBuilder = M::mock(ContextualBindingBuilder::class);
    }

    public function tearDown(): void
    {
        M::close();

        parent::tearDown();
    }

    /** @test */
    public function it_should_provide_services_on_boot()
    {
        $this->app->shouldReceive('bind')
                  ->once();

        $this->app->shouldReceive('singleton')
            ->once();

        $provider = new JetSmsServiceProvider($this->app);

        $this->assertNull($provider->boot());
    }
}
