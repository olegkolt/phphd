<?php

namespace PHPHD;

use PHPHD\DataSource\Memory;
use PHPHD\DataSource\Serialize;
use PHPHD\Data\File;

class SearchUnusedCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testInMemory()
    {
        $dataSrc = new Memory();
        $collector = new Collect($dataSrc);
        $collector->startCollection();
        
        $sampleFilePath = __DIR__ . '/sample.php';
        
        require($sampleFilePath);
        
        $collector->save();
        
        $report = new Report($dataSrc);
        $unused = $report->generateReport()[$sampleFilePath];
       
        $this->assertEquals(File::UNUSED_LINE, $unused[13][1]);
        $this->assertEquals(File::UNUSED_LINE, $unused[14][1]);
    }
    
    public function testSerialize()
    {
        $dumpFilePath = __DIR__ . '/data/data.dump';
        
        if (file_exists($dumpFilePath)) {
            unlink($dumpFilePath);
        }
        
        $dataSrc = new Serialize($dumpFilePath);
        $collector = new Collect($dataSrc);
        $collector->startCollection();
        
        $sampleFilePath = __DIR__ . '/sample2.php';
        
        require($sampleFilePath);
        
        $collector->save();
        
        $report = new Report(
            new Serialize($dumpFilePath)
        );
        $unused = $report->generateReport()[$sampleFilePath];
        
        $this->assertEquals(File::UNUSED_LINE, $unused[13][1]);
        $this->assertEquals(File::UNUSED_LINE, $unused[14][1]);
    }
    
    public function testDirInMemory()
    {
        $dataSrc = new Memory();
        $collector = new Collect($dataSrc);
        $collector->startCollection();
        
        $dir = __DIR__ . '/sampleDir';
        
        require($dir . '/used.php');
        
        $collector->save();
        
        $report = new Report($dataSrc);
        $unusedFiles = $report->generateReportForDirectory($dir);
        
        $this->assertCount(1, $unusedFiles);
        $this->assertEquals($dir . '/decedent.php', $unusedFiles[0]);
    }
}
