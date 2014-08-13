<?php

namespace PHPHD\DataSource;

use PHPHD\Data\FileCollection;

class Memory implements SourceInterface
{
    /**
     * @var \PHPHD\Data\FileCollection
     */
    protected $data;
    
    public function __construct()
    {
        $this->data = new FileCollection();
    }
    
    /**
     * @return \PHPHD\Data\FileCollection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \PHPHD\Data\FileCollection $filesData
     * @return void
     */
    public function saveData(FileCollection $filesData)
    {
        $this->data = $filesData;
    }
}
