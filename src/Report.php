<?php

namespace PHPHD;

use PHPHD\DataSource\SourceInterface;

class Report
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

    /**
     * Array:
     * - keys: file names
     * - values: array:
     *      - keys: line number
     *      - values: line content
     * 
     * @return array<string, array<integer, string>>
     */
    public function generateReport()
    {
        $files = $this->src->getData();
        $result = array();
        foreach ($files->getFiles() as $file) {
            $result[$file->getFileName()] = $file->findUnusedLines();
        }
        return $result;
    }

    /**
     * @param string $dirPath Absolute directory path
     * @return string[]
     */
    public function generateReportForDirectory($dirPath)
    {
        $dir = new \RecursiveDirectoryIterator($dirPath);
        $iterator = new \RecursiveIteratorIterator($dir);
        $phpFiles = new \RegexIterator($iterator, '/^.+\.(php|phtml)$/i', \RecursiveRegexIterator::GET_MATCH);
        
        $files = $this->src->getData();
        $unusedFiles = array();
        foreach ($phpFiles as $phpFile) {
            if (!$files->isFileUsed($phpFile[0])) {
                $unusedFiles[] = $phpFile[0];
            }
        }
        
        return $unusedFiles;
    }
}
