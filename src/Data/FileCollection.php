<?php

namespace PHPHD\Data;

/**
 * Collection of used files
 */
class FileCollection
{
    /**
     * @var array<string, File>
     */
    protected $files = array();

    /**
     * @param string $fileName
     * @return File
     */
    public function find($fileName)
    {
        if ($this->isFileUsed($fileName)) {
            return $this->files[$fileName];
        }
        $file = new File($fileName);
        $this->files[$fileName] = $file;
        
        return $file;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function isFileUsed($fileName)
    {
        return isset($this->files[$fileName]);
    }

    /**
     * @return array<string, File>
     */
    public function getFiles()
    {
        return $this->files;
    }
}
