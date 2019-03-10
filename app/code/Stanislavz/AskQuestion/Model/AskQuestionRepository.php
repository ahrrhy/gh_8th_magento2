<?php

namespace Stanislavz\AskQuestion\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion as ResourceAskQuestion;
use Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory as AskQuestionCollectionFactory;
use Stanislavz\AskQuestion\Api\AskQuestionRepositoryInterface;
use Stanislavz\AskQuestion\Api\Data\AskQuestionInterface;
use Stanislavz\AskQuestion\Api\Data\AskQuestionInterfaceFactory;
use Stanislavz\AskQuestion\Api\Data\AskQuestionSearchResultsInterfaceFactory;
use Stanislavz\AskQuestion\Api\Data\AskQuestionSearchResultsInterface;
use Stanislavz\AskQuestion\Model\AskQuestionFactory as AskQuestionFactory;
use Stanislavz\AskQuestion\Model\AskQuestion;

class AskQuestionRepository implements AskQuestionRepositoryInterface
{
    /**
     * @var ResourceAskQuestion
     */
    protected $resource;

    /**
     * @var AskQuestionFactory
     */
    protected $askQuestionFactory;

    /**
     * @var AskQuestionCollectionFactory
     */
    protected $askQuestionCollectionFactory;

    /**
     * @var AskQuestionInterfaceFactory
     */
    protected $dataAskQuestionFactory;

    /**
     * @var AskQuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    public function __construct(
        AskQuestionSearchResultsInterfaceFactory $searchResultsFactory,
        AskQuestionFactory $askQuestionFactory,
        AskQuestionCollectionFactory $askQuestionCollectionFactory,
        AskQuestionInterfaceFactory $dataAskQuestionFactory,
        ResourceAskQuestion $resource,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->askQuestionCollectionFactory = $askQuestionCollectionFactory;
        $this->dataAskQuestionFactory = $dataAskQuestionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->askQuestionFactory   = $askQuestionFactory;
        $this->dataObjectHelper     = $dataObjectHelper;
        $this->dataObjectProcessor  = $dataObjectProcessor;
    }

    /**
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(AskQuestionInterface $askQuestion)
    {
        try {
            $this->resource->save($askQuestion);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $askQuestion;
    }

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId): AskQuestionInterface
    {
        /** @var AskQuestion $askQuestion */
        $askQuestion = $this->askQuestionFactory->create();
        $this->resource->load($askQuestion, $questionId);
        if (!$askQuestion->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
        }
        return $askQuestion;
    }

    /**
     * Retrieve question matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AskQuestionSearchResultsInterface
    {
        /** @var AskQuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\Collection $collection */
        $collection = $this->askQuestionCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() === SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $askQuestion = [];
        /** @var AskQuestion $askQuestionModel */
        foreach ($collection as $askQuestionModel) {
            /** @var AskQuestionInterface $askQuestionData */
            $askQuestionData = $this->dataAskQuestionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $askQuestionData,
                $askQuestionModel->getData(),
                'Stanislavz\AskQuestion\Api\Data\AskQuestionInterface'
            );
            $askQuestion[] = $this->dataObjectProcessor->buildOutputDataArray(
                $askQuestionData,
                'Stanislavz\AskQuestion\Api\Data\AskQuestionInterface'
            );
        }
        $searchResults->setItems($askQuestion);
        return $searchResults;
    }

    /**
     * Delete question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion): bool
    {
        try {
            $this->resource->delete($askQuestion);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete request sample by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($questionId): bool
    {
        return $this->delete($this->getById($questionId));
    }
}
