<?php

namespace AymardKouakou\OrangeApiPhp\Core;

use NoRewindIterator;
use SplFileObject;

class File
{
    protected SplFileObject $file;

    public function __construct($filename, $mode = "r")
    {
        $splInfo = new \SplFileInfo($filename);
        if (!file_exists($splInfo->getRealPath())) {
            throw new \RuntimeException("File not found");
        }
        $this->file = new SplFileObject($filename, $mode);
    }

    protected function iterateText()
    {
        $count = 0;
        while (!$this->file->eof()) {
            yield $this->file->fgets();
            $count++;
        }
        return $count;
    }

    protected function iterateBinary($bytes): \Generator
    {
        $count = 0;
        while (!$this->file->eof()) {
            yield $this->file->fread($bytes);
            $count++;
        }
    }

    public function iterate(string $type = "Text", $bytes = null): NoRewindIterator
    {
        return
            new NoRewindIterator(($type === "Text") ?
                $this->iterateText() : $this->iterateBinary($bytes));
    }
}
