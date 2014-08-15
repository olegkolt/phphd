<?php

namespace PHPHD;

use PHPHD\DataSource\SourceInterface;

class Collect
{
    /**
     * @var \PHPHD\DataSource\SourceInterface
     */
    protected $src;

    /**
     * @var string|null
     */
    protected $dir;

    /**
     * @param \PHPHD\DataSource\SourceInterface $src
     * @param string|null $dir
     */
    public function __construct(SourceInterface $src, $dir = null)
    {
        $this->src = $src;
        if (!is_null($dir)) {
            $this->dir = realpath($dir);
        }
    }
    
    public function startCollection()
    {
        xdebug_start_code_coverage();
    }
    
    public function save()
    {
        $data = xdebug_get_code_coverage();
        
        $files = $this->src->getData();
        
        foreach ($data as $fileName => $lines) {
            if (!$this->isFileInDir($fileName)) {
                continue;
            }
            $file = $files->find($fileName);
            foreach ($lines as $lineNo => $isUsed) {
                $file->addUsedLine($lineNo - 1);
            }
        }
        
        $this->src->saveData($files);
    }

    /**
     * @param string $filePath
     * @return boolean
     */
    protected function isFileInDir($filePath)
    {
        if (is_null($this->dir)) {
            return true;
        }
        return strpos($filePath, $this->dir) === 0;
    }

    /**
     * @param \PHPHD\DataSource\SourceInterface $src
     * @param string|null $dir
     */
    public static function register(SourceInterface $src, $dir = null)
    {
        $collector = new self($src, $dir);
        $collector->startCollection();
        
        register_shutdown_function(array($collector, 'save'));
    }
}
