<?php
/**
 * Carousel
 * 
 * @author Slava Yurthev
 */
namespace SY\Carousel\Block\Adminhtml\Widget\StaticBlocks;
class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended {
	protected $_itemFactory;
	protected $_collectionFactory;
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Backend\Helper\Data $backendHelper,
		\Magento\Cms\Model\BlockFactory $itemFactory,
		\Magento\Cms\Model\ResourceModel\Block\CollectionFactory $collectionFactory,
		array $data = []
	) {
		$this->_itemFactory = $itemFactory;
		$this->_collectionFactory = $collectionFactory;
		parent::__construct($context, $backendHelper, $data);
	}
	protected function _construct(){
		parent::_construct();
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setDefaultFilter(['chooser_is_active' => '1']);
	}
	public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element){
		$uniqId = $this->mathRandom->getUniqueHash($element->getId());
		$sourceUrl = $this->getUrl(
			'sy_carousel/chooser/staticblocks', 
			[
				'uniq_id' => $uniqId
			]
		);

		$chooser = $this->getLayout()->createBlock(
			\Magento\Widget\Block\Adminhtml\Widget\Chooser::class
		)->setElement(
			$element
		)->setConfig(
			$this->getConfig()
		)->setFieldsetId(
			$this->getFieldsetId()
		)->setSourceUrl(
			$sourceUrl
		)->setUniqId(
			$uniqId
		);
		if($element->getValue()) {
			$chooser->setLabel($element->getValue());
		}
		else{
			$chooser->setLabel($this->getEmptyLabel());
		}
		$element->setData('after_element_html', $chooser->toHtml());
		return $element;
	}
	private function getEmptyLabel(){
		return __("Please select blocks");
	}
	public function getRowClickCallback(){
		$chooserJsObject = $this->getId();
		$js = '
			function(grid, event){
				var trElement = Event.findElement(event, "tr");
				var idsElement = trElement.down("[name=\'ids[]\']");
				var idsLabel = idsElement.up("label");
				if(event.target != idsElement && event.target != idsLabel){
					idsElement.click();
				}
			}
		';
		return $js;
	}
	protected function _prepareCollection(){
		$collection = $this->_collectionFactory->create();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns(){
		$this->addColumn(
			'identifier',
			[
				'header' => __('Identifier'), 
				'align' => 'left', 
				'index' => 'identifier', 
				'width' => 20
			]
		);
		$this->addColumn(
			'title',
			[
				'header' => __('Title'), 
				'align' => 'left', 
				'index' => 'title'
			]
		);
		$this->addColumn(
			'ids',
			[
				'header' => __('Insert'), 
				'align' => 'center', 
				'type' => 'checkbox',
				'inline_css' => 'checkbox entities',
				'name' => 'ids[]',
				'field_name' => 'ids[]',
				'sortable' => false,
				'filter' => false,
				'index' => 'identifier', 
				'width' => 50,
				'renderer'  => \SY\Carousel\Block\Adminhtml\Widget\StaticBlocks\Chooser\Ids::class,
				'use_index' => true
			]
		);
		return parent::_prepareColumns();
	}
	public function getGridUrl(){
		return $this->getUrl('sy_carousel/chooser/staticblocks', ['_current' => true]);
	}
	public function getRowInitCallback(){
		return '
			function(grid, tr){
				var checkbox = tr.down("[name=\'ids[]\']"), 
					values = '.$this->getId().'.getElementValue().split(",");
				if(checkbox){
					if(values.indexOf(checkbox.value) != -1){
						checkbox.checked = true;
					}
				}
			}
		';
	}
	public function getCheckboxCheckCallback(){
		return '
			function (grid, element) {
				var values = '.$this->getId().'.getElementValue().split(","),
					index = values.indexOf(element.value);
				if(element.checked && index == -1){
					values.push(element.value);
				}
				else{
					if(index != -1){
						values.splice(index, 1);
					}
				}
				function isEligible(value) {
					if(value !== false || value !== null || value !== 0 || value !== "") {
						return value;
					}
				};
				values = values.filter(isEligible);
				if(values.length){
					'.$this->getId().'.setElementValue(values.join(","));
					'.$this->getId().'.setElementLabel(values.join(","));
				}
				else{
					'.$this->getId().'.setElementValue(null);
					'.$this->getId().'.setElementLabel("'.$this->getEmptyLabel().'");
				}
			}
		';
	}
}