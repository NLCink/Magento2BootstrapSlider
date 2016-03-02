<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Model;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Image as MagentoImage;


class Image
{
	const SLIDERMEDIAPATH = "/slider";
	const SLIDERIMAGEMDPATH = "/md";
	const SLIDERIMAGESMPATH = "/sm";
	const SLIDERIMAGEXSPATH = "/xs";
	const SLIDERTHUMBPATH = "/thumb";
   /**
     * @var int
     */
    protected $_width;

    /**
     * @var int
     */
    protected $_height;

    /**
     * Default quality value (for JPEG images only).
     *
     * @var int
     */
    protected $_quality = 80;
	
   /**
     * @var string
     */
    protected $_baseFile;

    /**
     * @var bool
     */
    protected $_isBaseFilePlaceholder;

    /**
     * @var string|bool
     */
    protected $_newFile;

    /**
     * @var MagentoImage
     */
    protected $_processor;

    /**
     * @var string
     */
    protected $_destinationSubdir;
	
   protected $_mediaDirectory;

    /**
     * @var \Magento\Framework\Image\Factory
     */
    protected $_imageFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $_objectManager;
	
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Image\Factory $imageFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function __construct(
		\Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\Factory $imageFactory,
		\Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_imageFactory = $imageFactory;
		$this->_storeManager = $storeManager;
		$this->_objectManager = $objectManager;
    }
	
	public function getSliderMediaPath($size=''){
		switch($size){
			case 'md':
				return self::SLIDERMEDIAPATH . self::SLIDERIMAGEMDPATH;
				break;
			case 'sm':
				return self::SLIDERMEDIAPATH . self::SLIDERIMAGESMPATH;
				break;
			case 'xs':
				return self::SLIDERMEDIAPATH . self::SLIDERIMAGEXSPATH;
				break;
			case 'thumb':
				return self::SLIDERMEDIAPATH . self::SLIDERTHUMBPATH;
				break;
			default:
				return self::SLIDERMEDIAPATH;
				break;
		}
	}
	
	public function deleteImage($path){
		if( is_file( $path ) ){
			unlink($path);
		}
	}
	
    /**
     * @param int $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->_width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->_height = $height;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }
	
    /**
     * @see \Magento\Framework\Image\Adapter\AbstractAdapter
     * @return $this
     */
    public function resize()
    {
        if ($this->getWidth() === null && $this->getHeight() === null) {
            return $this;
        }
        $this->getImageProcessor()->resize($this->_width, $this->_height);
        return $this;
    }
	
    /**
     * Set image quality, values in percentage from 0 to 100
     *
     * @param int $quality
     * @return $this
     */
    public function setQuality($quality)
    {
        $this->_quality = $quality;
        return $this;
    }

    /**
     * Get image quality
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->_quality;
    }
	

 	public function setBaseFile($filepath){
		$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
					->getDirectoryRead(DirectoryList::MEDIA);
		if( file_exists( $mediaDirectory->getAbsolutePath($filepath) ) ){
			$this->_baseFile = $mediaDirectory->getAbsolutePath($filepath);
		}
	}

    /**
     * @return string
     */
    public function getBaseFile()
    {
        return $this->_baseFile;
    }

    /**
     * @return bool|string
     */
    public function getNewFile()
    {
        return $this->_newFile;
    }
	
    /**
     * First check this file on FS
     * If it doesn't exist - try to download it from DB
     *
     * @param string $filename
     * @return bool
     */
    protected function _fileExists($filename)
    {
        if ($this->_mediaDirectory->isFile($filename)) {
            return true;
        } else {
            return $this->_coreFileStorageDatabase->saveFileToFilesystem(
                $this->_mediaDirectory->getAbsolutePath($filename)
            );
        }
    }
    /**
     * @param string|null $file
     * @return bool
     */
    protected function _checkMemory($file = null)
    {
        return $this->_getMemoryLimit() > $this->_getMemoryUsage() + $this->_getNeedMemoryForFile(
            $file
        )
        || $this->_getMemoryLimit() == -1;
    }

    /**
     * @return string
     */
    protected function _getMemoryLimit()
    {
        $memoryLimit = trim(strtoupper(ini_get('memory_limit')));

        if (!isset($memoryLimit[0])) {
            $memoryLimit = "128M";
        }

        if (substr($memoryLimit, -1) == 'K') {
            return substr($memoryLimit, 0, -1) * 1024;
        }
        if (substr($memoryLimit, -1) == 'M') {
            return substr($memoryLimit, 0, -1) * 1024 * 1024;
        }
        if (substr($memoryLimit, -1) == 'G') {
            return substr($memoryLimit, 0, -1) * 1024 * 1024 * 1024;
        }
        return $memoryLimit;
    }

    /**
     * @return int
     */
    protected function _getMemoryUsage()
    {
        if (function_exists('memory_get_usage')) {
            return memory_get_usage();
        }
        return 0;
    }

    /**
     * @param string|null $file
     * @return float|int
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _getNeedMemoryForFile($file = null)
    {
        $file = $file === null ? $this->getBaseFile() : $file;
        if (!$file) {
            return 0;
        }

        if (!$this->_mediaDirectory->isExist($file)) {
            return 0;
        }

        $imageInfo = getimagesize($this->_mediaDirectory->getAbsolutePath($file));

        if (!isset($imageInfo[0]) || !isset($imageInfo[1])) {
            return 0;
        }
        if (!isset($imageInfo['channels'])) {
            // if there is no info about this parameter lets set it for maximum
            $imageInfo['channels'] = 4;
        }
        if (!isset($imageInfo['bits'])) {
            // if there is no info about this parameter lets set it for maximum
            $imageInfo['bits'] = 8;
        }
        return round(
            ($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65
        );
    }
	
    /**
     * Create destination folder
     *
     * @param string $destinationFolder
     * @return \Magento\Framework\File\Uploader
     * @throws \Exception
     */
    private function _createDestinationFolder($destinationFolder)
    {
        if (!$destinationFolder) {
            return $this;
        }

        if (substr($destinationFolder, -1) == '/') {
            $destinationFolder = substr($destinationFolder, 0, -1);
        }

        if (!(@is_dir($destinationFolder)
            || @mkdir($destinationFolder, DriverInterface::WRITEABLE_DIRECTORY_MODE, true)
        )) {
            throw new \Exception("Unable to create directory '{$destinationFolder}'.");
        }
        return $this;
    }
	
	
	public function saveSliderItem($destinationFolder, $fileData , $width=150 ){
		$this->_createDestinationFolder($destinationFolder);
		if( is_dir($destinationFolder) ){
			$image = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
			$image->open( $fileData['path'] . $fileData['file']);
			$imgData = getimagesize($fileData['path'] . $fileData['file']);
			$newsize = $this->getImageData($imgData, $width);
			$image->resize($newsize["width"],$newsize["height"] );
			$pathinfo = pathinfo( $fileData['file'] );
			$image->save($destinationFolder, $pathinfo['basename']);
		}
	}
	
	public function saveSliderResponsiveImages($source, $destinationFolder, $fileData , $width=150 ){
		$this->_createDestinationFolder($destinationFolder);
		if( is_dir($destinationFolder) ){
			$image = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
			$image->open( $source );
			$imgData = getimagesize( $source );
			$newsize = $this->getImageData($imgData, $width);
			$image->resize($newsize["width"],$newsize["height"] );
			$image->save($destinationFolder, $fileData['name']);
		}
		
	}
	
	public function getImageData($data, $width){
      // calculate thumbnail size
		$newdata["width"] = $width;
		$newdata["height"] = floor(  ( $data[1] * $newdata["width"] ) / $data[0] );
		return $newdata;
	}
	
	public function deleteSliderImage($image){
	}
}
