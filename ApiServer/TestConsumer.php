<?php

namespace ImiApp\ApiServer;

use Imi\Bean\Annotation\Bean;
use Imi\Queue\Contract\IMessage;
use Imi\Queue\Driver\IQueueDriver;
use Imi\Queue\Service\BaseQueueConsumer;
use function var_dump;

#[Bean(name: "TestConsumer")]
class TestConsumer extends BaseQueueConsumer
{

    protected function consume(IMessage $message, IQueueDriver $queue): void
    {
        var_dump("consume message: {$message->getMessage()}");

        $queue->success($message);

        throw new \LogicException("未捕获的异常 {$message->getMessage()}");
    }
}
