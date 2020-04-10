<?php

declare(strict_types=1);

namespace PCIT\GitHub\Service\Issue;

use Curl\Curl;
use Exception;

class CommentsClient
{
    /**
     * @var Curl
     */
    private $curl;

    private $api_url;

    /**
     * @var \TencentAI\TencentAI
     */
    private $tencent_ai;

    public function __construct(Curl $curl, string $api_url, \TencentAI\TencentAI $tencent_ai)
    {
        $this->curl = $curl;

        $this->api_url = $api_url;

        $this->tencent_ai = $tencent_ai;
    }

    /**
     * Create a comment.
     *
     * 201
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $repo_full_name,
                           int $issue_number,
                           string $body)
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/'.$issue_number.'/comments';

        $output = $this->curl->post($url, json_encode(compact('body')));

        $http_return_code = $this->curl->getCode();

        if (201 !== $http_return_code) {
            \Log::debug('Http Return Code is not 201 '.$http_return_code);
        }

        return $output;
    }

    /**
     * List comments on an issue.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(string $repo_full_name, int $issue_number)
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/'.$issue_number.'/comments';

        return $this->curl->get($url);
    }

    /**
     * List comments in a repository.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function listInRepository(string $repo_full_name)
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/comments';

        return $this->curl->get($url);
    }

    /**
     * Get a single comment.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getSingle(string $repo_full_name, int $comment_id)
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/comments/'.$comment_id;

        return $this->curl->get($url);
    }

    /**
     * Edit a comment.
     *
     * @throws \Exception
     */
    public function edit(string $repo_full_name, int $comment_id, string $body): void
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/comments/'.$comment_id;

        $this->curl->patch($url, json_encode(compact('body')));

        $http_return_code = $this->curl->getCode();

        if (200 !== $http_return_code) {
            \Log::debug('Http Return Code is not 200 '.$http_return_code);

            throw new Exception('Edit Issue comment Error', $http_return_code);
        }
    }

    /**
     * Delete a comment.
     *
     * 204.
     *
     * @throws \Exception
     */
    public function delete(string $repo_full_name, int $comment_id): void
    {
        $url = $this->api_url.'/repos/'.$repo_full_name.'/issues/comments/'.$comment_id;

        $this->curl->delete($url);

        $http_return_code = $this->curl->getCode();

        if (204 !== $http_return_code) {
            \Log::debug('Http Return Code Is Not 204 '.$http_return_code);

            throw new Exception('Delete Issue comment Error', $http_return_code);
        }
    }
}
