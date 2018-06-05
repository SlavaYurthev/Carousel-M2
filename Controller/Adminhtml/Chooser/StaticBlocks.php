<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Controller\Adminhtml\Chooser;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Controller\Result\RawFactory;

class StaticBlocks extends \Magento\Backend\App\Action {
	const ADMIN_RESOURCE = 'Magento_Widget::widget_instance';
	protected $layoutFactory;
	protected $resultRawFactory;
	public function __construct(Context $context, LayoutFactory $layoutFactory, RawFactory $resultRawFactory){
		$this->layoutFactory = $layoutFactory;
		$this->resultRawFactory = $resultRawFactory;
		parent::__construct($context);
	}
	public function execute(){
		$layout = $this->layoutFactory->create();
		$chooser = $layout->createBlock(
			\SY\Carousel\Block\Adminhtml\Widget\StaticBlocks\Chooser::class,
			'',
			['data' => ['id' => $this->getRequest()->getParam('uniq_id')]]
		);
		$resultRaw = $this->resultRawFactory->create();
		$resultRaw->setContents($chooser->toHtml());
		return $resultRaw;
	}
}