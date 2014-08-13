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
     * @param \PHPHD\DataSource\SourceInterface $src
     */
    public function __construct(SourceInterface $src)
    {
        $this->src = $src;
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
            $file = $files->find($fileName);
            foreach ($lines as $lineNo => $isUsed) {
                $file->addUsedLine($lineNo - 1);
            }
        }
        
        $this->src->saveData($files);
    }

    /**
     * @param \PHPHD\DataSource\SourceInterface $src
     */
    public static function register(SourceInterface $src)
    {
        $collector = new self($src);
        $collector->startCollection();
        
        register_shutdown_function(array($collector, 'save'));
    }
}
