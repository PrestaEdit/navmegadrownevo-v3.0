<?php
/*
* 2007-2014 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Button extends ObjectModel
{
	public $id;

	public $order_button;
	public $img_name;
	public $img_link;
	public $buttonColor;
	public $img_name_background;

	public $name_button;
	public $detailSub;
	public $detailSubTR;
	public $detailSubLeft;
	public $link;

	public static $definition = array(
		'table' => 'admevo_button',
		'primary' => 'id_button',
		'multilang' => true,
		'fields' => array(
			'order_button' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'img_name' => 				array('type' => self::TYPE_STRING),
			'img_link' => 				array('type' => self::TYPE_STRING),
			'buttonColor' => 			array('type' => self::TYPE_STRING),
			'img_name_background' =>	array('type' => self::TYPE_STRING),
			// Lang fields
			'name_button' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
			'detailSub' => 				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
			'detailSubTR' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
			'detailSubLeft' => 			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
			'link' => 					array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml'),
		),
	);
}