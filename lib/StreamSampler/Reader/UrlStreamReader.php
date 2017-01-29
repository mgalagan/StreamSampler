<?php
namespace StreamSampler\Reader;

use GuzzleHttp\Client;

class UrlStreamReader extends AbstractStreamReader
{
    /**
     * @inheritdoc
     */
    protected function readContent(array $params)
    {
        if (empty($params['url'])) {
            throw new \LogicException('URL cant be empty');
        }

        $client = new Client();
        $response = $client->get($params['url']);
        $body = $response->getBody();
        while ($buffer = $body->read(1024)) {
            $this->writeBuffer($buffer);
        }
    }
}