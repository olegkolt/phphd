<?php

namespace PHPHD;

use PHPHD\View\Html;
use PHPHD\DataSource\Memory;

class HtmlOutputTest extends \PHPUnit_Framework_TestCase
{
    public function testInMemory()
    {
        $dataSrc = new Memory();
        $collector = new Collect($dataSrc);
        $collector->startCollection();
        
        $sampleFilePath = __DIR__ . '/sample3.php';
        
        require($sampleFilePath);
        
        $collector->save();
        
        $this->expectOutputRegex('/.+/'); // No empty
        
        $html = new Html($dataSrc);
        $html->output();
    }
}
 