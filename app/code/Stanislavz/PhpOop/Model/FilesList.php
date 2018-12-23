<?php

namespace Stanislavz\PhpOop\Model;

class FilesList
{
    protected $_dir;

    private $startDirPath;
    private $recursiveIteratorConst;
    private $recursiveIterator;
    private $fileList = [];

    /**
     * FilesList constructor.
     * @param $startDirPath
     * @param $recursiveIteratorConst
     * @param \Magento\Framework\Filesystem\DirectoryList $dir
     */
    public function __construct(
        $startDirPath,
        $recursiveIteratorConst,
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
        $this->startDirPath           = $startDirPath;
        $this->recursiveIteratorConst = $recursiveIteratorConst;
        $this->_dir                   = $dir;
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    private function getRecursiveIterator(): \RecursiveIteratorIterator
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->buildPath()),
            $this->recursiveIteratorConst
        );
    }

    /**
     * Returns array with info about files and directories. Files are nested into directories arrays
     * Each file is an array with fields : 'name', 'pathname', 'modified_at'
     * @return array
     */
    public function getFileList(): array
    {
        $this->recursiveIterator = $this->getRecursiveIterator();
        foreach ($this->recursiveIterator as $fileItem) {
            /**
             * Skip ./ and ../
             */
            if ($fileItem->getFilename() === '.' || $fileItem->getFilename() === '..') {
                continue;
            }

            $name = $fileItem->isDir()
                ? [$fileItem->getFilename() => []]
                : [$fileItem->getFilename() => [
                    'name'        => $fileItem->getFilename(),
                    'pathname'    => $fileItem->getPathname(),
                    'modified_at' =>date('F d Y H:i:s.', filemtime($fileItem->getPathname()))
                ]];

            for ($depth = $this->recursiveIterator->getDepth() - 1; $depth >= 0; $depth--) {
                $name = [
                    $this->recursiveIterator->getSubIterator($depth)->current()->getFilename()
                    . ' ' . date('F d Y H:i:s.', filemtime($fileItem->getPathname())) => $name
                ];
            }

            $this->fileList = array_merge_recursive($this->fileList, $name);
        }

        return $this->fileList;
    }

    /**
     * @return string
     */
    public function getStartDirPath(): string
    {
        return $this->startDirPath;
    }

    /**
     * @return string
     */
    protected function buildPath(): string
    {
        return $this->_dir->getRoot() . '/' . $this->startDirPath;
    }

    /**
     * @param string $newDirPath
     */
    public function setDirPath($newDirPath)
    {
        $this->startDirPath = $newDirPath;
    }
}
