<?php

namespace StreamSampler\Reader;

use StreamSampler\Source\StreamSourceInterface;

/**
 * Interface StreamReaderInterface
 */
interface StreamReaderInterface
{
    /**
     * StreamReaderInterface constructor.
     * @param string $sourceClass source class
     * @param string $cacheDir local path for cache files
     */
    public function __construct($sourceClass, $cacheDir);

    /**
     * this function must read from content from source
     * @param array $params customize reader
     * @return StreamSourceInterface
     */
    public function read(array $params);
}