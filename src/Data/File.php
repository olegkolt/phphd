<?php

namespace PHPHD\Data;

/**
 * Used file with used lines
 */
class File
{
    const NOCODE_LINE = 0;
    const USED_LINE   = 1;
    const UNUSED_LINE = 2;
    
    protected $noCodePatterns = array(
        '/^$/', // Empty strings
        '/^\s*$/', // Empty strings
        '/^\<\?*/', // <?php or <?
        '|^ *//|', // Comments //
        '/^ *\*/', // Comments *
        '|^ */\*|', // Comments /*
        '/^ *\} *$/', // }
        '/^ *\{ *$/', // {
        '/^namespace .+$/'
    );
    
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var integer[]
     */
    protected $usedLines = array();

    /**
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param integer $lineNo
     */
    public function addUsedLine($lineNo)
    {
        $lineNo = intval($lineNo);
        if (in_array($lineNo, $this->usedLines)) {
            return;
        }
        $this->usedLines[] = $lineNo;
    }

    /**
     * Line numbers starts from 0
     * 
     * @return array<integer, array>
     */
    public function reportUnusedLines()
    {
        $lines = file($this->fileName, FILE_IGNORE_NEW_LINES);
        $amount = count($lines);
        
        $result = new \SplFixedArray($amount);
        
        for ($i = 0; $i < $amount; $i++) {
            
            $line = $lines[$i];
            if ($this->isLineUsed($i)) {
                $status = self::USED_LINE;
            } elseif ($this->isNoCodeLine($line)) {
                $status = self::NOCODE_LINE;
            } else {
                $status = self::UNUSED_LINE;
            }
            $result[$i] = array(
                $line,
                $status
            );
        }

        return $result;
    }

    /**
     * @param integer $lineNo
     * @return boolean
     */
    protected function isLineUsed($lineNo)
    {
        return in_array($lineNo, $this->usedLines);
    }

    /**
     * @param string $line
     * @return boolean
     */
    protected function isNoCodeLine($line)
    {
        foreach ($this->noCodePatterns as $pattern) {
            if (preg_match($pattern, $line) > 0) {
                return true;
            }
        }
        return false;
    }
}
