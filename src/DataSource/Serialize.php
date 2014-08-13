<?php

namespace PHPHD\DataSource;

use PHPHD\Data\FileCollection;

class Serialize implements SourceInterface
{
    /**
     * @var string
     */
    protected $filePath = '';
    
    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    
    /**
     * @return \PHPHD\Data\FileCollection
     */
    public function getData()
    {
        if (!file_exists($this->filePath)) {
            return new FileCollection();
        }
        return unserialize(file_get_contents($this->filePath));
    }

    /**
     * @param \PHPHD\Data\FileCollection $filesData
     * @return void
     */
    public function saveData(FileCollection $filesData)
    {
        file_put_contents($this->filePath, serialize($filesData));
    }
}
