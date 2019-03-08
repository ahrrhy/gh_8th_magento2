<?php

namespace Stanislavz\AskQuestion\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Stanislavz\AskQuestion\Api\Data\AskQuestionInterface;
use Stanislavz\AskQuestion\Api\Data\AskQuestionSearchResultInterface;

/**
 * Interface AskQuestionRepositoryInterface
 * @package Stanislavz\AskQuestion\Api
 * @api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(AskQuestionInterface $askQuestion): AskQuestionInterface;

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId): AskQuestionInterface;

    /**
     * Retrieve question matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AskQuestionSearchResultInterface;

    /**
     * Delete question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion): bool;

    /**
     * Delete request sample by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($questionId): bool;
}
