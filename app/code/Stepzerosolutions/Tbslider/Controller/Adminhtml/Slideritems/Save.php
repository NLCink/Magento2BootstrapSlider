<?php
/**
 *
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems;

use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory;
use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface;
use Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface;
use Magento\Framework\App\Filesystem\DirectoryList;


class Save extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems
{
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;


	protected $_imageprocessor;
    /**
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param SlideritemsRepositoryInterface $slideritemsRepository
	 * @param SlideritemsInterfaceFactory $slideritemsDataFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
	 * @param \Stepzerosolutions\Tbslider\Model\Image $imageprocessor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        SlideritemsRepositoryInterface $slideritemsRepository,
		SlideritemsInterfaceFactory $slideritemsDataFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
		\Stepzerosolutions\Tbslider\Model\Image $imageprocessor,
		\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
    	\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    ) {
        $this->dataObjectProcessor = $dataObjectProcessor;
		$this->_imageprocessor = $imageprocessor;
        parent::__construct(
            $context,
            $coreRegistry,
            $slideritemsRepository,
			$slideritemsDataFactory,
            $resultForwardFactory,
            $resultPageFactory
        );
    	$this->_cacheTypeList = $cacheTypeList;
	    $this->_cacheFrontendPool = $cacheFrontendPool;
    }

    /**
     * Store Variation types Data to session
     *
     * @param array $slideritemsData
     * @return void
     */
    protected function storeSlideritemsDataToSession($slideritemsData)
    {
        if (array_key_exists('title', $slideritemsData)) {
            $slideritemsData['slideritem_title'] = $slideritemsData['title'];
            unset($slideritemsData['title']);
        }
        $this->_getSession()->setSlideritemsData($slideritemsData);
    }

    /**
     * Create or save Variation type.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {

        /** @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slideritems */
        $slideritems = null;
            $id = $this->getRequest()->getParam('id');
			$data = $this->getRequest()->getPost();
            $resultRedirect = $this->resultRedirectFactory->create();
            try {
                if ($id !== null) {
                    $slideritems = $this->slideritemsRepository->getById( (int)$id );
                } else {
                    $slideritems = $this->slideritemsDataFactory->create();
                }
                $slideritemsTitle = (string)$this->getRequest()->getParam('slideritem_title');
                if (empty($slideritemsTitle)) {
                    $slideritemsTitle = null;
                }
                $slideritems->setSlideritemTitle($slideritemsTitle);
                $slideritemsDescription = (string)$this->getRequest()->getParam('slideritem_description');
                if (empty($slideritemsDescription)) {
                    $slideritemsDescription = null;
                }
                $slideritems->setSlideritemDescription($slideritemsDescription);
                $slideritemSlider = (int)$this->getRequest()->getParam('slideritem_slider');
                if (empty($slideritemSlider)) {
                    $slideritemSlider = null;
                }
                $slideritems->setSlideritemSlider($slideritemSlider);
                $is_active = (int)$this->getRequest()->getParam('is_active');
                if (empty($is_active)) {
                    $is_active = null;
                }
                $slideritems->setIsActive($is_active);
                $slider_sort = (int)$this->getRequest()->getParam('slider_sort');
                if (empty($slider_sort)) {
                    $slider_sort = null;
                }
				$slideritems->setSliderSort($slider_sort);
				/** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
				$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
					->getDirectoryRead(DirectoryList::MEDIA);
				if (isset($_FILES['filename']) && isset($_FILES['filename']['name']) && strlen($_FILES['filename']['name'])) {
						/*
						 * Save image upload
						 */
						try {
							$uploader = $this->_objectManager->create(
								'Magento\MediaStorage\Model\File\Uploader',
								['fileId' => 'filename']
							);
							$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
		
							/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
							$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
		
							$uploader->addValidateCallback('banner_image', $imageAdapter, 'validateUploadFile');
							$uploader->setAllowRenameFiles(true);
							$uploader->setFilesDispersion(true);
		
							$result = $uploader->save(
								$mediaDirectory->getAbsolutePath( $this->_imageprocessor->getSliderMediaPath() )
							);
							
							$sliderimagepath = $slideritems->getSliderImagePath();
							if( !empty($sliderimagepath) )	{
								$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $sliderimagepath ));
								$slideritems->setSliderImagePath('');
								$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
									$this->_imageprocessor->getSliderMediaPath('thumb'), 
									$sliderimagepath
								);
								$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $thumbDirtmp ));
							}

							//create slider item thumb
							$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
								$this->_imageprocessor->getSliderMediaPath('thumb'), 
								$this->_imageprocessor->getSliderMediaPath().$result['file']
							);
							$pathinfo = pathinfo( $thumbDirtmp );
							$this->_imageprocessor->saveSliderItem($mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ."/" ), $result);
							$slideritems->setSliderImagePath( $this->_imageprocessor->getSliderMediaPath().$result['file'] );
						} catch (\Exception $e) {
							if ($e->getCode() == 0) {
								$this->messageManager->addError($e->getMessage());
							}
						}
					} else {
						if (isset($data['filename']) ) {
							if (isset($data['filename']['delete'])) {
								$data['filename'] = null;
								$data['delete_image'] = true;
								$sliderimagepath = $slideritems->getSliderImagePath();
								if( !empty($sliderimagepath) )	{
									$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $sliderimagepath ));
									$slideritems->setSliderImagePath('');
									$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
										$this->_imageprocessor->getSliderMediaPath('thumb'), 
										$sliderimagepath
									);
									$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $thumbDirtmp ));
								}
							} elseif (isset($data['filename']['value'])) {
								$data['filename'] = $data['filename']['value'];
							} else {
								$data['filename'] = null;
							}
						}
					}
				if (isset($_FILES['filenamemd']) && isset($_FILES['filenamemd']['name']) && strlen($_FILES['filenamemd']['name'])) {
						/*
						 * Save image upload
						 */
						try {
							$uploader = $this->_objectManager->create(
								'Magento\MediaStorage\Model\File\Uploader',
								['fileId' => 'filenamemd']
							);
							$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
		
							/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
							$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
		
							$uploader->addValidateCallback('banner_image', $imageAdapter, 'validateUploadFile');
							$uploader->setAllowRenameFiles(true);
							$uploader->setFilesDispersion(true);
		
							$result = $uploader->save(
								$mediaDirectory->getAbsolutePath( $this->_imageprocessor->getSliderMediaPath('md') )
							);
							$slideritems->setSliderImageMdPath( $this->_imageprocessor->getSliderMediaPath('md').$result['file'] );
						} catch (\Exception $e) {
							if ($e->getCode() == 0) {
								$this->messageManager->addError($e->getMessage());
							}
						}
					} else {
						if (isset($data['filenamemd']) ) {
							if (isset($data['filenamemd']['delete'])) {
								$data['filenamemd'] = null;
								$data['delete_image'] = true;
								$sliderimagemdpath = $slideritems->getSliderImageMdPath();
								if( !empty($sliderimagemdpath) )	{
									$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $sliderimagemdpath ));
									$slideritems->setSliderImageMdPath('');
								}
							} elseif (isset($data['filenamemd']['value'])) {
								$data['filenamemd'] = $data['filenamemd']['value'];
							} else {
								$data['filenamemd'] = null;
							}
						}
						
						if( empty($slideritems->getSliderImageMdPath() ) && !empty( $slideritems->getSliderImagePath() ) ){
							//create MD slider from Main Image
							$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
								$this->_imageprocessor->getSliderMediaPath('md'), 
								$slideritems->getSliderImagePath()
							);
							$pathinfo = pathinfo( $thumbDirtmp );
							$result = array('name' => $pathinfo['basename'], 'file' => $thumbDirtmp, 'path' => $mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ) );
							$this->_imageprocessor->saveSliderResponsiveImages( 
										$mediaDirectory->getAbsolutePath( $slideritems->getSliderImagePath() ),
										$mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ), 
										$result,
										1024
										);
							$slideritems->setSliderImageMdPath($thumbDirtmp);
						}
				}
				if (isset($_FILES['filenamesm']) && isset($_FILES['filenamesm']['name']) && strlen($_FILES['filenamesm']['name'])) {
						/*
						 * Save image upload
						 */
						try {
							$uploader = $this->_objectManager->create(
								'Magento\MediaStorage\Model\File\Uploader',
								['fileId' => 'filenamesm']
							);
							$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
		
							/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
							$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
		
							$uploader->addValidateCallback('banner_image', $imageAdapter, 'validateUploadFile');
							$uploader->setAllowRenameFiles(true);
							$uploader->setFilesDispersion(true);
		
							$result = $uploader->save(
								$mediaDirectory->getAbsolutePath( $this->_imageprocessor->getSliderMediaPath() )
							);
							$slideritems->setSliderImageSmPath( $this->_imageprocessor->getSliderMediaPath().$result['file'] );
						} catch (\Exception $e) {
							if ($e->getCode() == 0) {
								$this->messageManager->addError($e->getMessage());
							}
						}
					} else {
						if (isset($data['filenamesm']) ) {
							if (isset($data['filenamesm']['delete'])) {
								$data['filenamesm'] = null;
								$data['delete_image'] = true;
								$sliderimagesmpath = $slideritems->getSliderImageSmPath();
								if( !empty($sliderimagesmpath) )	{
									$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $sliderimagesmpath ));
									$slideritems->setSliderImageSmPath('');
								}
							} elseif (isset($data['filenamesm']['value'])) {
								$data['filenamesm'] = $data['filenamesm']['value'];
							} else {
								$data['filenamesm'] = null;
							}
						}
						if( empty($slideritems->getSliderImageSmPath() ) && !empty( $slideritems->getSliderImagePath() ) ){
							//create MD slider from Main Image
							$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
								$this->_imageprocessor->getSliderMediaPath('sm'), 
								$slideritems->getSliderImagePath()
							);
							$pathinfo = pathinfo( $thumbDirtmp );
							$result = array('name' => $pathinfo['basename'], 'file' => $thumbDirtmp, 'path' => $mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ) );
							$this->_imageprocessor->saveSliderResponsiveImages( 
										$mediaDirectory->getAbsolutePath( $slideritems->getSliderImagePath() ),
										$mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ), 
										$result,
										922
										);
							$slideritems->setSliderImageSmPath($thumbDirtmp);
						}
				}
				if (isset($_FILES['filenamexs']) && isset($_FILES['filenamexs']['name']) && strlen($_FILES['filenamexs']['name'])) {
						/*
						 * Save image upload
						 */
						try {
							$uploader = $this->_objectManager->create(
								'Magento\MediaStorage\Model\File\Uploader',
								['fileId' => 'filenamexs']
							);
							$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
		
							/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
							$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
		
							$uploader->addValidateCallback('banner_image', $imageAdapter, 'validateUploadFile');
							$uploader->setAllowRenameFiles(true);
							$uploader->setFilesDispersion(true);
		
							$result = $uploader->save(
								$mediaDirectory->getAbsolutePath( $this->_imageprocessor->getSliderMediaPath() )
							);
							$slideritems->setSliderImageXsPath( $this->_imageprocessor->getSliderMediaPath().$result['file'] );
						} catch (\Exception $e) {
							if ($e->getCode() == 0) {
								$this->messageManager->addError($e->getMessage());
							}
						}
					} else {
						if (isset($data['filenamexs']) && isset($data['filenamexs']['value'])) {
							if (isset($data['filenamexs']['delete'])) {
								$data['filenamexs'] = null;
								$data['delete_image'] = true;
								$sliderimagexspath = $slideritems->getSliderImageXsPath();
								if( !empty($sliderimagexspath) )	{
									$this->_imageprocessor->deleteImage($mediaDirectory->getAbsolutePath( $sliderimagexspath ));
									$slideritems->setSliderImageXsPath('');
								}
							} elseif (isset($data['filenamexs']['value'])) {
								$data['filenamexs'] = $data['filenamexs']['value'];
							} else {
								$data['filenamexs'] = null;
							}
						}
						if( empty($slideritems->getSliderImageXsPath() ) && !empty( $slideritems->getSliderImagePath() ) ){
							//create MD slider from Main Image
							$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
								$this->_imageprocessor->getSliderMediaPath('xs'), 
								$slideritems->getSliderImagePath()
							);
							$pathinfo = pathinfo( $thumbDirtmp );
							$result = array('name' => $pathinfo['basename'], 'file' => $thumbDirtmp, 'path' => $mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ) );
							$this->_imageprocessor->saveSliderResponsiveImages( 
										$mediaDirectory->getAbsolutePath( $slideritems->getSliderImagePath() ),
										$mediaDirectory->getAbsolutePath( $pathinfo['dirname'] ), 
										$result,
										768
										);
							$slideritems->setSliderImageXsPath($thumbDirtmp);
						}
				}

                $slider = $this->slideritemsRepository->save($slideritems);
				$this->cleanCache();
                $this->messageManager->addSuccess(__('You saved the Slider item.'));
                $resultRedirect->setPath('tbslider/slideritems');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                if ($slideritems != null) {
                    $this->storeSlideritemsDataToSession(
                        $this->dataObjectProcessor->buildOutputDataArray(
                            $slideritems,
                            '\Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface'
                        )
                    );
                }
                $resultRedirect->setPath('tbslider/slideritems');
            }
            return $resultRedirect;
    }
	
	
	protected function cleanCache(){
		$types = array('block_html','collections','full_page');
		foreach ($types as $type) {
			$this->_cacheTypeList->cleanType($type);
		}
		foreach ($this->_cacheFrontendPool as $cacheFrontend) {
			$cacheFrontend->getBackend()->clean();
		}
	}
}
