<?php

namespace Stanislavz\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface AskQuestionSearchResultsInterface
 * @package Stanislavz\AskQuestion\Api\Data
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
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
