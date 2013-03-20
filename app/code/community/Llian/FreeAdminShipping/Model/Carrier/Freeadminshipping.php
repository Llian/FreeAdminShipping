<?php
/**
 * Llian FreeAdminShipping
 *
 * Copyright (C) 2013  Llian
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the 
 * GNU General Public License as published by the Free Software Foundation, either version 3 of the 
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.  If not, 
 * see <http://www.gnu.org/licenses/gpl.html>.
 *
 * @category  Llian
 * @package   Llian_FreeAdminShipping
 * @author    Llian <info@llian.de>
 * @copyright 2013 Llian (http://www.llian.de). All rights served.
 * @license   http://www.gnu.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

/**
 * Free admin shipping model
 *
 * @category  Llian
 * @package   Llian_FreeAdminShipping
 * @author    Llian <info@llian.de>
 */
class Llian_FreeAdminShipping_Model_Carrier_Freeadminshipping
extends Mage_Shipping_Model_Carrier_Abstract
implements Mage_Shipping_Model_Carrier_Interface
{
	/* unique shipping model identifyer */
	protected $_code = 'freeadminshipping';
	protected $_isFixed = true;
	
	/**
	 * Checks if user is logged in as admin 
	 *
	 * @return bool
	 */
	protected function isAdmin()
	{
		/* set admin session */
		Mage::getSingleton('core/session', array('name' => 'adminhtml'))->start();
		$isLoggedIn = Mage::getSingleton('admin/session', array('name' => 'adminhtml'))->isLoggedIn();
		/* set original session */
		Mage::getSingleton('core/session', array('name' => $this->_sessionNamespace))->start();
		return $isLoggedIn;
	}
	
	/**
	 * Returns freeadminshipping shipping rate, if this method is activated and the user is logged in as admin
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 * @return Mage_Shipping_Model_Rate_Result
	 */
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		if (!$this->getConfigFlag('active') || !$this->isAdmin()) {
			return false;
		}
	
		$method = Mage::getModel('shipping/rate_result_method');
		$method->setCarrier('freeadminshipping');
		$method->setCarrierTitle($this->getConfigData('title'));
		$method->setMethod('freeadminshipping');
		$method->setMethodTitle($this->getConfigData('name'));
		$method->setPrice('0.00');
		$method->setCost('0.00');

		$result = Mage::getModel('shipping/rate_result');
		$result->append($method);
		return $result;
	}
		
	public function getAllowedMethods()
	{
		return array('freeadminshipping'=>$this->getConfigData('name'));
	}
	
	
}


?>