<?php
namespace StreamSampler\Reader;

class InputStreamReader extends AbstractStreamReader
{
    /**
     * @inheritdoc
     */
    protected function readContent(array $params)
    {
        while (!feof(STDIN)) {
            $this->writeBuffer(fgets(STDIN));
        }
    }
}