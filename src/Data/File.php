<?php

namespace PHPHD\Data;

/**
 * Used file with used lines
 */
class File
{
    protected $noCodePatterns = array(
        '/^$/', // Empty strings
        '/^\<\?*/', // <?php or <?
        '|^ *//|', // Comments //
        '/^ *\*/', // Comments *
        '|^ */\*|', // Comments /*
        '/^ *\} *$/', // }
        '/^ *\{ *$/', // {
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
     * @return array<integer, string>
     */
    public function findUnusedLines()
    {
        $lines = file($this->fileName, FILE_IGNORE_NEW_LINES);
        $amount = count($lines);
        
        for ($i = 0; $i < $amount; $i++) {
            if (
                $this->isLineUsed($i) ||
                $this->isNoCodeLine($lines[$i])
            ) {
                unset($lines[$i]);
            }
        }

        return $lines;
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
