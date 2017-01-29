<?php

namespace StreamSampler\Source;

interface StreamSourceInterface
{
    /**
     * StreamSourceInterface constructor.
     * @param $source
     */
    public function __construct($source);

    /**
     * return content
     * @return \Generator
     */
    public function getContent();
}