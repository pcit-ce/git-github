<?php

declare(strict_types=1);

namespace PCIT\GitHub\Service\OAuth;

use Curl\Curl;

interface OAuthInterface
{
    public function __construct($config, Curl $curl);

    public function getLoginUrl(?string $state): string;

    public function getAccessToken(string $code, ?string $state, bool $raw = false): array;
}
