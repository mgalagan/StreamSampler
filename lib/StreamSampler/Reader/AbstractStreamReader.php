<?php
namespace StreamSampler\Reader;

use StreamSampler\Source\FileStreamSource;

abstract class AbstractStreamReader implements StreamReaderInterface
{
    /**
     * local path to buffer
     * @var string
     */
    protected $path;

    /**
     * write resource
     * @var resource
     */
    protected $writeResource;

    /**
     * source class
     * @var string
     */
    protected $sourceClass;

    /**
     * @inheritdoc
     */
    public function __construct($sourceClass, $cacheDir)
    {
        if (empty($cacheDir)) {
            throw new \LogicException('cache dir cannot be empty');
        }
        $this->sourceClass = $sourceClass;
        $this->openFile($cacheDir);
    }

    /**
     * @inheritdoc
     */
    public function read(array $params)
    {
        $this->readContent($params);
        fclose($this->writeResource);

        return new $this->sourceClass($this->path);
    }

    /**
     * read content and write to buffer
     * @param array $params
     * @return void
     */
    abstract protected function readContent(array $params);

    /**
     * open file for write buffer in cache dir
     * @param string $cacheDir
     */
    protected function openFile($cacheDir)
    {
        $this->path = sprintf('%s/tmp%d.txt', $cacheDir, time());
        if (file_exists($this->path)) {
            $this->openFile($cacheDir);
        } else {
            $this->writeResource = fopen($this->path, 'w');
        }
    }

    /**
     * write buffer to file
     * @param $buffer
     */
    protected function writeBuffer($buffer)
    {
        fwrite($this->writeResource, $buffer);
    }
}