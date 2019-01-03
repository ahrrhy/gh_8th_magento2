<?php

namespace Stanislavz\PhpOop\Block;

class LearnViewModels extends \Magento\Framework\View\Element\Template
{
    /**
     * @param $fileList
     */
    public function printFileList($fileList)
    {
        if (!\is_array($fileList)) {
            echo $fileList, ' ';
            return;
        }

        foreach ($fileList as $arr => $value) {
            if ($arr < 10) {
                $this->printFileList($arr);
                $this->printFileList($value);
            }
        }
    }
}
