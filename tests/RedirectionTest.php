<?php

namespace SiroDiaz\Redirection\Tests;

use SiroDiaz\Redirection\Exceptions\RedirectionException;
use SiroDiaz\Redirection\Models\Redirection;

class RedirectionTest extends TestCase
{
    /** @test */
    public function it_redirects_a_request(): void
    {
        Redirection::create([
            'old_url' => 'old-url',
            'new_url' => 'new/url',
        ]);

        $response = $this->get('old-url');
        $response->assertRedirect('new/url');
    }

    /** @test */
    public function it_redirects_nested_requests(): void
    {
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
        $this->expectException(RedirectionException::class);

        Redirection::create([
            'old_url' => 'same-url',
            'new_url' => 'same-url',
        ]);
    }
}
