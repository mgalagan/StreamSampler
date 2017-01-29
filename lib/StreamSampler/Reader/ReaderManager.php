<?php
namespace StreamSampler\Reader;

class ReaderManager
{
    /**
     * readers definitions
     * @var array
     */
    protected $definitions = [];

    /**
     * path ro cache dir
     * @var string
     */
    protected $cacheDir;

    /**
     * stream source class
     * @var string
     */
    protected $streamSourceClass;

    /**
     * ReaderManager constructor.
     * @param array $readerDefinitions
     * @param string $streamSourceClass
     * @param string $cacheDir
     */
    public function __construct(array $readerDefinitions, $streamSourceClass, $cacheDir)
    {
        if (empty($readerDefinitions)) {
            throw new \LogicException('reader definitions cannot be empty');
        }

        if (empty($cacheDir)) {
            throw new \LogicException('cache dir cannot be empty');
        }

        if (empty($streamSourceClass)) {
            throw new \LogicException('stream source cannot be empty');
        }

        $this->definitions = $readerDefinitions;
        $this->cacheDir = $cacheDir;
        $this->streamSourceClass = $streamSourceClass;
    }

    /**
     * return list of available types
     * @return array
     */
    public function getTypes()
    {
        return array_keys($this->definitions);
    }

    /**
     * init reader and return by type
     * @param string $type
     * @return InputStreamReader
     */
    public function getReaderByType($type)
    {
        if (!array_key_exists($type, $this->definitions)) {
            throw new \LogicException('Cant find requested type');
        }
        return new $this->definitions[$type]($this->streamSourceClass, $this->cacheDir);
    }
}