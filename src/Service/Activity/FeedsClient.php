<?php

declare(strict_types=1);

namespace PCIT\GitHub\Service\Activity;

use PCIT\GitHub\Service\CICommon;

class FeedsClient
{
    use CICommon;

    /**
     * List feeds.
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @see https://developer.github.com/v3/activity/feeds/#list-feeds
     */
    public function list()
    {
        return $this->curl->get($this->api_url.'/feeds');
    }
}
