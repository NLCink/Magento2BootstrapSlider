<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Model;

use Stepzerosolutions\Tbslider\Api\Data\SliderInterface;
use Magento\Store\Model\StoreManagerInterface;
/**
 * @stepzerosolutions
 */
class Slider extends \Magento\Framework\Model\AbstractModel
implements SliderInterface
{
	const XMLSLIDERSTATUS = 'sztbslider/general/active';
	const XMLMDDEVICEWIDTH = "sztbslider/responsiveness/mddevices";
	const XMLSMDEVICEWIDTH = "sztbslider/responsiveness/smdevices";
	const XMLXSDEVICEWIDTH = "sztbslider/responsiveness/xsdevices";

    /**
     * Store Manager
     *
     * @var StoreManagerInterface $storeManager
     */
    private $_storeManager;
	
    /**
     * Config
     *
     * @var  \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $_scopeConfig;
	
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
       	StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_scopeConfig = $scopeConfig;
		$this->_storeManager = $storeManager;
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }
	
 /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Stepzerosolutions\Tbslider\Model\ResourceModel\Slider');
    }
	
	public function getResponsiveWidth(){
		$deviceWidth = array('md' => 1024,'sm' => 922,'xs' => 768);
		$store = $this->_storeManager->getStore()->getId();
		$options = array();
        $options['md'] = $this->_scopeConfig->getValue(
		self::XMLMDDEVICEWIDTH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store ) ;
        $options['sm'] = $this->_scopeConfig->getValue(
		self::XMLMDDEVICEWIDTH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store ) ;
        $options['xs'] = $this->_scopeConfig->getValue(
		self::XMLMDDEVICEWIDTH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store ) ;
		return array_merge($options,$deviceWidth );
	}
	
	
	public function getId(){
		return $this->getData(self::ID);
	}
    public function getSliderTitle(){
		return $this->getData(self::SLIDER_TITLE);
	}
    public function getSliderDescription(){
		return $this->getData(self::SLIDER_DESCRIPTION);
	}
    public function getSliderWidth(){
		return $this->getData(self::SLIDER_WIDTH);
	}
    public function getSliderHeight(){
		return $this->getData(self::SLIDER_HEIGHT);
	}
    public function getSliderWidthxs(){
		return $this->getData(self::SLIDER_WIDTHXS);
	}
    public function getSliderHeightxs(){
		return $this->getData(self::SLIDER_HEIGHTXS);
	}
    public function getSliderWidthsm(){
		return $this->getData(self::SLIDER_WIDTHSM);
	}
    public function getSliderHeightsm(){
		return $this->getData(self::SLIDER_HEIGHTSM);
	}
    public function getSliderWidthmd(){
		return $this->getData(self::SLIDER_WIDTHMD);
	}
    public function getSliderHeightmd(){
		return $this->getData(self::SLIDER_HEIGHTMD);
	}
    public function getSliderClass(){
		return $this->getData(self::SLIDER_CLASS);
	}
    public function getSliderBgcolor(){
		return $this->getData(self::SLIDER_BGCOLOR);
	}
    public function getSliderAutoresponsive(){
		return $this->getData(self::SLIDER_AUTORESPONSIVE);
	}
    public function getSliderType(){
		return $this->getData(self::SLIDER_TYPE);
	}
    public function getPauseonhover(){
		return $this->getData(self::PAUSEONHOVER);
	}
    public function getWrap(){
		return $this->getData(self::WRAP);
	}
    public function getKeyboard(){
		return $this->getData(self::KEYBOARD);
	}
    public function getSlidermeta(){
		return $this->getData(self::SLIDERMETA);
	}
    public function getSliderHidexs(){
		return $this->getData(self::SLIDER_HIDEXS);
	}
    public function getSliderDuration(){
		return $this->getData(self::SLIDER_DURATION);
	}
    public function getDate(){
		return $this->getData(self::DATE);
	}
    public function getStatus(){
		return $this->getData(self::STATUS);
	}
    public function getTimestamp(){
		return $this->getData(self::TIMESTAMP);
	}
	
    public function getStores(){
		return explode(",", $this->getData( self::STORES ) );
	}
	
	// set items
	public function setId($id){
		return $this->setData( self::ID, $id );
	}
    public function setSliderTitle($title){
		return $this->setData( self::SLIDER_TITLE,$title );
	}
    public function setSliderDescription( $description ){
		return $this->setData( self::SLIDER_DESCRIPTION,$description );
	}
    public function setSliderWidth( $width ){
		return $this->setData( self::SLIDER_WIDTH,$width );
	}
    public function setSliderHeight( $height ){
		return $this->setData( self::SLIDER_HEIGHT,$height );
	}
    public function setSliderWidthxs( $widthxs ){
		return $this->setData( self::SLIDER_WIDTHXS,$widthxs );
	}
    public function setSliderHeightxs( $heightxs ){
		return $this->setData( self::SLIDER_HEIGHTXS,$heightxs );
	}
    public function setSliderWidthsm( $widthsm ){
		return $this->setData( self::SLIDER_WIDTHSM,$widthsm );
	}
    public function setSliderHeightsm( $heightsm ){
		return $this->setData( self::SLIDER_HEIGHTSM,$heightsm );
	}
    public function setSliderWidthmd( $widthmd ){
		return $this->setData( self::SLIDER_WIDTHMD,$widthmd );
	}
    public function setSliderHeightmd( $heightmd ){
		return $this->setData( self::SLIDER_HEIGHTMD,$heightmd );
	}
    public function setSliderClass( $sliderclass ){
		return $this->setData( self::SLIDER_CLASS,$sliderclass );
	}
    public function setSliderBgcolor( $bgcolor ){
		return $this->setData( self::SLIDER_BGCOLOR,$bgcolor );
	}
    public function setSliderAutoresponsive( $autoresponsive ){
		return $this->setData( self::SLIDER_AUTORESPONSIVE,$autoresponsive );
	}
    public function setSliderType( $slidertype ){
		return $this->setData( self::SLIDER_TYPE,$slidertype );
	}
    public function setPauseonhover( $pauseonhover ){
		return $this->setData( self::PAUSEONHOVER,$pauseonhover );
	}
    public function setWrap( $wrap ){
		return $this->setData( self::WRAP,$wrap );
	}
    public function setKeyboard( $keyboard ){
		return $this->setData( self::KEYBOARD,$keyboard );
	}
    public function setSlidermeta( $slidermeta ){
		return $this->setData( self::SLIDERMETA,$slidermeta );
	}
    public function setSliderHidexs( $sliderhidexs ){
		return $this->setData( self::SLIDER_HIDEXS,$sliderhidexs );
	}
    public function setSliderDuration( $sliderduration ){
		return $this->setData( self::SLIDER_DURATION,$sliderduration );
	}
    public function setDate( $date ){
		return $this->setData( self::DATE,$date );
	}
    public function setStatus( $status ){
		return $this->setData( self::STATUS,$status );
	}
    public function setTimestamp( $timestamp ){
		return $this->setData( self::TIMESTAMP,$timestamp );
	}
    public function setStores( $stores ){
		return $this->setData( self::STORES, implode(",", $stores) ."," );
	}


	public function getSliderChilditems(){
        if ($this->getId()) {
            return $this->getCollection()
			->addFieldToFilter( 'slider_id', ['eq' => $this->getId()] )
			->addItemsList();
		}
		return false;
	}

}
