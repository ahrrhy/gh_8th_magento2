<?php

namespace Stanislavz\AskQuestion\Controller\Submit;

use Stanislavz\AskQuestion\Model\Notification\EmailSender;
use Stanislavz\AskQuestion\Model\AskQuestion;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Index
 * @package Stanislavz\AskQuestion\Controller\Submit
 */
class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESS = 'Success';

    /**
     * @var \Stanislavz\AskQuestion\Model\AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /** @var EmailSender */
    private $emailSender;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\App\Action\Context $context
     * @param EmailSender $emailSender
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\App\Action\Context $context,
        EmailSender $emailSender
    ) {
        parent::__construct($context);
        $this->formKeyValidator   = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->emailSender = $emailSender;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong.
                 Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }
            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }
            // @TODO: #111 Backend form validation
            // Here we must also process backend validation or all form fields.
            // Otherwise attackers can just copy our page, remove fields validation and send anything they want
            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => $request->getParams()
            ];

            /** @var AskQuestion $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();
            $askQuestion->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setQuestion($request->getParam('question'));
            $askQuestion->save();

            $this->sendEmailNotification();

        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }

    private function sendEmailNotification(): void
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $postData = $request->getPostValue();

        // send admin notification
        $this->sendEmail(
            $postData,
            EmailSender::ADMIN_ASKQUESTION_EMAIL_TEMPLATE,
            $this->emailSender->getAdminEmailAddress()
        );
        // send customer notification
        $this->sendEmail($postData, EmailSender::CUSTOMER_ASKQUESTION_EMAIL_TEMPLATE);
    }

    /**
     * @param $postData
     * @param $emailTemplateId
     * @param null $adminEmailAddress
     */
    private function sendEmail($postData, $emailTemplateId, $adminEmailAddress = null): void
    {
        $this->emailSender->sendNotification($postData, $emailTemplateId, $adminEmailAddress);
    }
}
