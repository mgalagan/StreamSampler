<?php

use Symfony\Component\Console\Application;
use Sampler\Command\StreamSamplerCommand;
use StreamSampler\Reader\ReaderManager;
use StreamSampler\Reader\StreamReaderInterface;
use StreamSampler\Source\StreamSourceInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;


class StreamSamplerCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StreamSamplerCommand
     */
    protected $command;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $readerManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $reader;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $source;

    protected function setUp()
    {
        $app =  new Application('Stream Sampler Test App', '1.0');
        $this->readerManager = $this->createMock(ReaderManager::class);
        $this->readerManager->expects($this->once())
            ->method('getTypes')
            ->willReturn(['url' => 'DumpClass']);

        $this->reader = $this->createMock(StreamReaderInterface::class);
        $this->source = $this->createMock(StreamSourceInterface::class);

        $this->command = new StreamSamplerCommand($this->readerManager);
        $this->command->setApplication($app);
    }

    public function testExecute()
    {
        $this->readerManager->expects($this->once())
            ->method('getReaderByType')
            ->with($this->equalTo($inputType = 'url'))
            ->willReturn($this->reader);

        $this->reader->expects($this->once())
            ->method('read')
            ->with($this->callback(function ($params) {
                $this->assertEquals($params['size'], 5);
                $this->assertEquals($params['url'], 'test');
                return true;
            }))
            ->willReturn($this->source);

        $this->source->expects($this->once())
            ->method('getContent')
            ->willReturn(['asdasdasdasdalksldajsdkald', 'asdasdasdasdalksldajsdkald']);

        $input = new ArrayInput([
            'command' => $this->command->getName(),
            '--type' => $inputType,
            '--size' => 5,
            '--url' => 'test',
        ]);
        $output = new BufferedOutput();

        $this->command->run($input, $output);
        $this->assertEquals(5, mb_strlen($output->fetch())-1);
    }
}