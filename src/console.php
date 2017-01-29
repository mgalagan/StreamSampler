<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use Sampler\Command\StreamSamplerCommand;
use StreamSampler\Reader\ReaderManager;

$console = new Application('Stream Sampler App', '1.0');
$console->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
$console->setDispatcher($app['dispatcher']);
$readerManager = new ReaderManager($app['stream.sampler.readers'], $app['stream.sampler.source'], $app['cache.dir']);
$console->add(new StreamSamplerCommand($readerManager));

return $console;
