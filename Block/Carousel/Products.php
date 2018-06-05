<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Block\Carousel;
class Products extends \Magento\Framework\View\Element\Template {
	public $_template = 'SY_Carousel::carousel/products.phtml';
	protected $_collectionFactory;
	protected $imageHelper;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_collectionFactory,
		\Magento\Catalog\Helper\Image $imageHelper,
		array $data = []
	){
		$this->imageHelper = $imageHelper;
		$this->_collectionFactory = $_collectionFactory;
		parent::__construct($context, $data);
	}
	public function getCollection(){
		$collection = $this->_collectionFactory->create()->addAttributeToSelect('*');
		$collection->addFieldToFilter('entity_id', ['in'=>$this->getData('ids')]);
		return $collection;
	}
	public function getImageUrl($_product){
		return $this->imageHelper->init($_product, 'product_base_image')
				->setImageFile($_product->getSmallImage())
				// ->resize(380)
				->getUrl();
	}
}