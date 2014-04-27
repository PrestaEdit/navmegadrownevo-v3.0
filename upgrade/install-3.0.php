<?php
/**
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
if (!defined('_PS_VERSION_'))
  exit;

function upgrade_module_3_0($object)
{
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `GeneralColor`  VARCHAR(7) DEFAULT \'#383838\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontMenu`  VARCHAR(7) DEFAULT \'#ffffff\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontSubMenu`  VARCHAR(7) DEFAULT \'#ffffff\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontSubSubMenu`  VARCHAR(7) DEFAULT \'#ffffff\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontMenuHover`  VARCHAR(7) DEFAULT \'#c7c7c7\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontSubMenuHover`  VARCHAR(7) DEFAULT \'#c7c7c7\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `ColorFontSubSubMenuHover`  VARCHAR(7) DEFAULT \'#c7c7c7\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `backgroundTR1`  VARCHAR(7) DEFAULT \'\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `backgroundTD1`  VARCHAR(7) DEFAULT \'\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `backgroundTD2`  VARCHAR(7) DEFAULT \'\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_parameters` MODIFY COLUMN `backgroundTD3`  VARCHAR(7) DEFAULT \'\'';

	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_button` MODIFY COLUMN `buttonColor`  VARCHAR(7) DEFAULT \'#383838\'';
	$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'admevo_button` ADD COLUMN `link`  VARCHAR(255) NULL';

	//$sql[] = 'UPDATE `'._DB_PREFIX_.'admevo_parameters` SET `stateTD1`=\'1\'';

	foreach ($sql as $s)
		Db::getInstance()->execute($s);
}