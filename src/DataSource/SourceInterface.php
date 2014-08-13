<?php

namespace PHPHD\DataSource;

use PHPHD\Data\FileCollection;

interface SourceInterface
{
    /**
     * @return \PHPHD\Data\FileCollection
     */
    public function getData();

    /**
     * @param \PHPHD\Data\FileCollection $filesData
     * @return void
     */
    public function saveData(FileCollection $filesData);
}
