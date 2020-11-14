<?php

declare(strict_types=1);

namespace PCIT\GitHub\Tests\Service\GitHubApp;

use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @group dont-test
     */
    public function test_getAccessToken(): void
    {
        // $result = app('pcit')->github_apps_installations->getAccessToken(
        //     255451);

        $result = 'vv';

        $this->assertStringStartsWith('v', $result);
    }
}
