<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
	public function getConfigValue($field, $storeId = null){
		return $this->scopeConfig->getValue(
			'sy_carousel/'.$field, 
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE, 
			$storeId
		);
	}
}