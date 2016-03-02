<?php
/**
 *
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Api\Data;


use Magento\Framework\Api\ExtensibleDataInterface;
/**
 * Slider interface.
 */
interface TemplatesInterface extends ExtensibleDataInterface
{
	public function getSliderData();
	public function getSlideritems();
	public function setSliderData($sliderdata);
	public function setSlideritems($firstitem);
	public function renderSlider();
}
