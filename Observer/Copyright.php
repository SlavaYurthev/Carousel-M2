<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Observer;
class Copyright implements \Magento\Framework\Event\ObserverInterface {
	public function execute(\Magento\Framework\Event\Observer $observer){
		$observer->getLayout()->addBlock(
			'Magento\Framework\View\Element\Text', 
			'sy.copyright.carousel', 
			'sy.copyright'
		)->setData(
			'text',
			'<a href="https://slavayurthev.github.io/magento-2/extensions/carousel/">Magento 2 Carousel Extension</a>'
		);
		return $this;
	}
}