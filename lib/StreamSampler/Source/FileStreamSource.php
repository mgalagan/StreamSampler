<?php
namespace StreamSampler\Source;

class FileStreamSource implements StreamSourceInterface
{
    /**
     * Path to source file
     * @var string
     */
    protected $path;

    /**
     * open file resource
     * @var resource
     */
    protected $readResource;

    /**
     * @inheritdoc
     */
    public function __construct($source)
    {
        if (!is_string($source) || !file_exists($source)) {
            throw new \LogicException('Wrong input source');
        }
        $this->path = $source;
        $this->readResource = fopen($this->path, 'r');
    }

    /**
     * clear after script ends
     */
    public function __destruct()
    {
        if (is_resource($this->readResource)) {
            fclose($this->readResource);
            unlink($this->path);
        }
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        while ($buffer = fread($this->readResource, 1024)) {
            yield $buffer;
        }
    }
}