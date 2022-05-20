<?php

namespace ImiApp\ApiServer;

use Imi\Queue\Facade\Queue;
use Imi\Queue\Model\Message;
use Imi\Swoole\Process\Annotation\Process;
use Imi\Swoole\Process\Contract\IProcess;
use function bin2hex;
use function random_bytes;
use function sleep;
use function var_dump;

#[Process(name: "TestProcess")]
class TestProcess implements IProcess
{
    public function run(\Swoole\Process $process): void
    {
        while (true) {
            var_dump("TestProcess: {$process->pid}");
            sleep(5);

            $queue = Queue::getQueue('test');
            $message = new Message();
            $message->setMessage(bin2hex(random_bytes(8)));
            $queue->push($message);
        }
    }
}
