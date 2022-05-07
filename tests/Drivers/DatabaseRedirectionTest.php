<?php

namespace SiroDiaz\Redirection\Tests\Drivers;

use SiroDiaz\Redirection\Exceptions\RedirectionException;
use SiroDiaz\Redirection\Models\Redirection;
use SiroDiaz\Redirection\Tests\TestCase;

class DatabaseRedirectionTest extends TestCase
{
    /** @test */
    public function it_redirects_a_request(): void
    {
        $this->app['config']->set('redirection.driver', 'database');

        Redirection::create([
            'old_url' => 'old-url',
            'new_url' => 'new/url',
        ]);

        $this->get('old-url')
            ->assertRedirect('new/url');
    }

    /** @test */
    public function it_doesnt_redirect_case_sensitive_requests(): void
    {
        $this->app['config']->set('redirection.driver', 'database');
        $this->app['config']->set('redirection.case-sensitive', true);

        Redirection::create([
            'old_url' => 'old-url',
            'new_url' => 'new/url',
        ]);

        $this->get('old-URL')
            ->assertNotFound();
    }

    /** @test */
    public function it_does_redirect_case_insensitive_requests(): void
    {
        $this->app['config']->set('redirection.driver', 'database');
        $this->app['config']->set('redirection.case-sensitive', false);

        Redirection::create([
            'old_url' => 'old-url',
            'new_url' => 'new/url',
        ]);

        $this->get('OLD-URL')
            ->assertRedirect('new/url');
    }

    /** @test */
    public function it_redirects_nested_requests(): void
    {
        $this->app['config']->set('redirection.driver', 'database');

        Redirection::create([
            'old_url' => '1',
            'new_url' => '2',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('2');

        Redirection::create([
            'old_url' => '2',
            'new_url' => '3',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('3');

        $response = $this->get('2');
        $response->assertRedirect('3');

        Redirection::create([
            'old_url' => '3',
            'new_url' => '4',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('4');

        $response = $this->get('2');
        $response->assertRedirect('4');

        $response = $this->get('3');
        $response->assertRedirect('4');

        Redirection::create([
            'old_url' => '4',
            'new_url' => '1',
        ]);

        $response = $this->get('2');
        $response->assertRedirect('1');

        $response = $this->get('3');
        $response->assertRedirect('1');

        $response = $this->get('4');
        $response->assertRedirect('1');
    }

    /** @test */
    public function it_guards_against_creating_redirect_loops(): void
    {
        $this->app['config']->set('redirection.driver', 'database');

        $this->expectException(RedirectionException::class);

        Redirection::create([
            'old_url' => 'same-url',
            'new_url' => 'same-url',
        ]);
    }
}
