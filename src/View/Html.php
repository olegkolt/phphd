<?php

namespace PHPHD\View;

use PHPHD\DataSource\SourceInterface;
use PHPHD\Report;

class Html
{
    /**
     * @var \PHPHD\DataSource\SourceInterface
     */
    protected $src;
    
    public static $data = array();

    /**
     * @param \PHPHD\DataSource\SourceInterface $src
     */
    public function __construct(SourceInterface $src)
    {
        $this->src = $src;
    }

    /**
     * Output html
     * 
     * @param string|null $dirPath For unused files search
     */
    public function output($dirPath = null)
    {
        $report = new Report($this->src);
        self::$data['unusedCode'] = $report->generateReport();
        if (!is_null($dirPath)) {
            self::$data['dir'] = $dirPath;
            self::$data['unusedFiles'] = $report->generateReportForDirectory($dirPath);
        }
        require __DIR__ . '/template.html.php';
    }
}
