<?php
namespace StreamSampler\Reader;

class RandomStreamReader extends AbstractStreamReader
{
    CONST MAX_REPEAT = 100;

    /**
     * @inheritdoc
     */
    protected function readContent(array $params)
    {
        $multiplier = $params['size'] ?: 1;

        for ($i = 0; $i<=static::MAX_REPEAT*$multiplier; $i++) {
            $this->writeBuffer(md5(uniqid()));
        }
    }
}