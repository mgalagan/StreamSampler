<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
$app['cache.dir'] = __DIR__ . '/../var/cache';
$app['stream.sampler.readers'] = [
    'input' => '\StreamSampler\Reader\InputStreamReader',
    'random' => '\StreamSampler\Reader\RandomStreamReader',
    'url' => '\StreamSampler\Reader\UrlStreamReader',
];
$app['stream.sampler.source'] = '\StreamSampler\Source\FileStreamSource';