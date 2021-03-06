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
     *      - values: array:
     *          - values: [0] - line string, [1] - status
     * 
     * @return array<string, array<integer, array>>
     */
    public function generateReport()
    {
        $files = $this->src->getData();
        $result = array();
        foreach ($files->getFiles() as $file) {
            $result[$file->getFileName()] = $file->reportUnusedLines();
        }
        ksort($result);
        return $result;
    }

    /**
     * @param string $dirPath Directory path
     * @return string[]
     */
    public function generateReportForDirectory($dirPath)
    {
        $dir = new \RecursiveDirectoryIterator(realpath($dirPath));
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
