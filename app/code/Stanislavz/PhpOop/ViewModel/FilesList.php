<?php

namespace Stanislavz\PhpOop\ViewModel;

class FilesList implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $_dir;

    private $recursiveIteratorConst = \RecursiveIteratorIterator::CHILD_FIRST;

    /**
     * FilesList constructor.
     * @param $recursiveIteratorConst
     * @param \Magento\Framework\Filesystem\DirectoryList $dir
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
        $this->_dir = $dir;
    }

    /**
     * @param $startDirPath
     * @return \RecursiveIteratorIterator
     */
    private function getRecursiveIterator($startDirPath): \RecursiveIteratorIterator
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->buildPath($startDirPath)),
            $this->recursiveIteratorConst
        );
    }

    /**
     * @param $startDirPath
     * @return array
     */
    public function getFileList($startDirPath): array
    {
        $fileList = [];
        $recursiveIterator = $this->getRecursiveIterator($startDirPath);
        foreach ($recursiveIterator as $fileItem) {
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
                    'created_at' => date('F d Y H:i:s.', filectime($fileItem->getPathname()))
                ]];

            for ($depth = $recursiveIterator->getDepth() - 1; $depth >= 0; $depth--) {
                $name = [
                    $recursiveIterator->getSubIterator($depth)->current()->getFilename() => $name
                ];
            }

            $fileList = array_merge_recursive($fileList, $name);
        }

        return $fileList;
    }

    /**
     * @param $startDirPath
     * @return string
     */
    protected function buildPath($startDirPath): string
    {
        return $this->_dir->getRoot() . '/' . $startDirPath;
    }
}
