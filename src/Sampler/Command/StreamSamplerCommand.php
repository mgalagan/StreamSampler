<?php

namespace Sampler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use StreamSampler\Reader\ReaderManager;

class StreamSamplerCommand extends Command
{
    /**
     * @var ReaderManager
     */
    protected $readerManager;

    /**
     * StreamSamplerCommand constructor.
     * @param ReaderManager $readerManager
     * @param null $name
     */
    public function __construct(ReaderManager $readerManager, $name = null)
    {
        $this->readerManager = $readerManager;
        parent::__construct($name);
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('stream:sampler');
        $this->setDescription('Stream sampler picks random bites from input sources.');
        $this
            ->addOption('size', 's', InputOption::VALUE_REQUIRED, 'How many bites will be chosen?')
            ->addOption(
                'type',
                't',
                InputOption::VALUE_REQUIRED,
                'Specify input source type: ' . implode(', ', $this->readerManager->getTypes())
            )
            ->addOption('url', '', InputOption::VALUE_OPTIONAL, 'Specify URL for type: url', '');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $return = [];

        $size = ((int) $input->getOption('size')) ?: 1;
        $params = [
            'size' => $size,
            'url' => (string) $input->getOption('url'),
        ];
        $source = $this->readerManager->getReaderByType($input->getOption('type'))->read($params)->getContent();

        foreach ($source as $buffer) {
            $return = array_merge($return, $this->getRandom($buffer, $size));
            if (count($return) > $size) {
                $return = $this->getRandom($return, $size);
            }
        }
        $output->writeln(implode('', $return));
    }

    /**
     * return $size chars from buffer
     * @param string|array $buffer
     * @param $size
     * @return array
     */
    protected function getRandom($buffer, $size)
    {
        $return = [];

        $bufferSize = (is_array($buffer) ? count($buffer) : mb_strlen($buffer)) - 1;
        for ($i = 1; $i <= $size; $i ++) {
            $rand = mt_rand(0, $bufferSize);
            $return[] = $buffer[$rand];
        }

        return $return;
    }
}