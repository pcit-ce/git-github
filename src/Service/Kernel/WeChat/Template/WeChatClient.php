<?php

declare(strict_types=1);

namespace PCIT\GitHub\Service\Kernel\WeChat\Template;

use PCIT\PCIT;

class WeChatClient
{
    private $template_id;

    private $template_message;

    private $openId;

    public function __construct(PCIT $app)
    {
        $this->template_id = $app['config']['wechat']['template_id'];

        $this->template_message = $app->wechat->template_message;

        $this->openId = $app['config']['wechat']['open_id'];
    }

    /**
     * @return mixed
     */
    public function sendTemplateMessage(
        string $code,
        string $time,
        string $event_type,
        string $repo_name,
        string $branch,
        string $commit_message,
        string $committer_username,
        string $info,
        string $url,
        string $openId = null
    ) {
        $openId || $openId = $this->openId;

        /**
         * 结果：{{code.DATA}} 时间：{{time.DATA}} 类型：{{event_type.DATA}} 仓库：{{repo_name.DATA}} 提交信息：{{commit_message.DATA}} 推送：{{committer.DATA}} 信息：{{info.DATA}}.
         */
        $result = [
            'touser' => $openId,
            'template_id' => $this->template_id,
            'url' => $url,
            'data' => [
                'code' => [
                    'value' => $code,
                    'color' => '#173177',
                ],
                'time' => [
                    'value' => $time,
                ],
                'event_type' => [
                    'value' => $event_type,
                ],
                'repo_name' => [
                    'value' => $repo_name.':'.$branch,
                ],
                'commit_message' => [
                    'value' => $commit_message,
                ],
                'committer' => [
                    'value' => $committer_username,
                ],
                'info' => [
                    'value' => $info,
                ],
            ],
        ];

        return $this->template_message->send($result);
    }
}
