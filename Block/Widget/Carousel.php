<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Block\Widget;
class Carousel extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {
	protected function _toHtml(){
		return $this->getLayout()->createBlock(
			$this->getBlockClass(),
			'',
			[
				'data' => [
					'ids' => explode(",", $this->getData('ids')),
					'items' => $this->getData('items'),
					'nav' => $this->getData('nav'),
					'dots' => $this->getData('dots'),
					'loop' => $this->getData('loop'),
					'autoplay' => $this->getData('autoplay')
				]
			]
		)->toHtml();
	}
}