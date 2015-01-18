<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Fields
{
	public static function addField($label, $name, $prefix = null, $class = '', $lang = false)
	{
		$field = array(
			'label' => $label,
			'name' => $name,
			'required' => true,
			'type' => 'text',
			'prefix' => $prefix,
			'class' => $class,
			'lang' => $lang
		);

		return $field;
	}

	public static function addHiddenField($name)
	{
		$field = array(
			'type' => 'hidden',
			'name' => $name
		);

		return $field;
	}

	public static function addTextField($label, $name, $prefix = null, $class = '', $lang = false)
	{
		$field = array(
			'label' => $label,
			'name' => $name,
			'required' => true,
			'type' => 'textarea',
			'autoload_rte' => true,
			'prefix' => $prefix,
			'class' => $class,
			'lang' => $lang
		);

		return $field;
	}

	public static function addColorField($label, $name, $suffix = null)
	{
		return array(
			'label' => $label,
			'name' => $name,
			'required' => true,
			'type' => 'color'
		);
	}

	public static function addSwitchField($label, $name, $suffix = null)
	{
		return array(
			'label' => $label,
			'name' => $name,
			'required' => true,
			'type' => 'switch',
			'is_bool' => true,
			'values' => array(
				array(
					'id' => 'active_on',
					'value' => 1
				),
				array(
					'id' => 'active_off',
					'value' => 0
				)
			),
		);
	}

	public static function addFreeField($label, $name, $suffix = null)
	{
		return array(
			'label' => $label,
			'name' => $name,
			'required' => true,
			'type' => 'free',
			'suffix' => $suffix,
		);
	}
}