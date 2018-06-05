<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Block\Carousel;
class StaticBlocks extends \Magento\Framework\View\Element\Template {
	public $_template = 'SY_Carousel::carousel/static_blocks.phtml';
	protected $_collectionFactory;
	protected $filterProvider;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Cms\Model\ResourceModel\Block\CollectionFactory $_collectionFactory,
		\Magento\Cms\Model\Template\FilterProvider $filterProvider,
		array $data = []
	){
		$this->_collectionFactory = $_collectionFactory;
		$this->filterProvider = $filterProvider;
		parent::__construct($context, $data);
	}
	public function getCollection(){
		$collection = $this->_collectionFactory->create();
		$collection->addFieldToFilter('identifier', ['in'=>$this->getData('ids')]);
		return $collection;
	}
	public function filter($content){
		return $this->filterProvider
			->getBlockFilter()
			->filter($content);
	}
}