<?php

namespace Stanislavz\RepeatLecture\Ui\Component\Form;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;

/**
 * Class DataProvider
 * @package Stanislavz\RepeatLecture\Ui\Component\Form
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cron\Model\ResourceModel\Schedule\Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blockCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    /**
     * @inheritdoc
     */
    public function getMeta()
    {
        $meta = parent::getMeta();
        $meta['general']['children'] = [
            'custom_field' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => 'field',
                            'formElement'   => 'input',
                            'label'         => __('Custom Field'),
                            'dataType'      => 'text',
                            'sortOrder'     => 45,
                            'dataScope'     => 'custom_field',
                        ]
                    ]
                ]
            ],
            'stanislavz_custom_field' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => 'fieldset',
                            'label'         => __('Stanislavz Fieldset'),
                            'sortOrder'     => 20,
                            'dataScope'     => 'stanislavz_custom_field',
                            'collapsible' => true,
                        ]
                    ]
                ],
                'children' => [
                    'first_field' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'componentType' => 'field',
                                    'formElement'   => 'input',
                                    'label'         => __('Custom Field First'),
                                    'dataType'      => 'text',
                                    'sortOrder'     => 45,
                                    'dataScope'     => 'custom_field_first',
                                ]
                            ]
                        ]
                    ],
                    'second_field' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'componentType' => 'field',
                                    'formElement'   => 'select',
                                    'label'         => __('Custom Field Second'),
                                    'dataType'      => 'text',
                                    'sortOrder'     => 45,
                                    'dataScope'     => 'custom_field_second',
                                    'options' => [
                                        ['value' => '0', 'label' => __('No')],
                                        ['value' => '1', 'label' => __('Yes')]
                                    ],
                                ]
                            ]
                        ]
                    ],
                    'third_field' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'componentType' => 'field',
                                    'formElement'   => 'date',
                                    'label'         => __('Custom Field Third'),
                                    'dataType'      => 'date',
                                    'sortOrder'     => 45,
                                    'dataScope'     => 'custom_field_third',
                                    'options' => [
                                        ['value' => '0', 'label' => __('No')],
                                        ['value' => '1', 'label' => __('Yes')]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $meta;
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cron\Model\Schedule $job */
        foreach ($items as $job) {
            $this->loadedData[$job->getId()] = $job->getData();
        }
        return $this->loadedData;
    }
}
