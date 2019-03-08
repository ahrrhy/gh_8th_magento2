<?php

namespace Stanislavz\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface AskQuestionSearchResultInterface
 * @package Stanislavz\AskQuestion\Api\Data
 * @api
 */
interface AskQuestionSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get request samples list.
     *
     * @return \Stanislavz\AskQuestion\Api\Data\AskQuestionInterface[]
     */
    public function getItems(): array;

    /**
     * Set request samples list.
     *
     * @param \Stanislavz\AskQuestion\Api\Data\AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}
