<?php
/**
 * Module MeGa DrOwN mEnU Evolution - Main file
 *
 * @category   	Module / front_office_features
 * @author     	PrestaEdit <j.danse@prestaedit.com> (since 2.0)
 * @author     	DevForEver (special thanks to him)
 * @copyright  	2015 PrestaEdit
 * @version   	3.0
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

// Security
if (!defined('_PS_VERSION_'))
	exit;

// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
	define('_MYSQL_ENGINE_', 'MyISAM');

include(dirname(__FILE__).'/models/megadrownevo.php');
include(dirname(__FILE__).'/models/button.php');

class NavMegaDrownEvo extends Module
{
	private $_css = '';
	private $_menu = '';
	private $_menu_tpl = array();
	private $_searchBar = 0;
	private $_html = '';

	private $eol = "\r\n";

	public function __construct()
	{
		$this->name = 'navmegadrownevo';
	 	$this->tab = 'front_office_features';
	 	$this->version = '3.0';
		$this->author = 'PrestaEdit';
		$this->ps_versions_compliancy['min'] = '1.6.0.1';
		$this->need_instance = 0;

		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('MeGa DrOwN mEnU Evolution');
		$this->description = $this->l('Add a MeGa DrOwN mEnU Evolution.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
		$this->allow = (int)Configuration::get('PS_REWRITING_SETTINGS');
	}

	public function install()
	{
		// Install SQL
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;

		// Install Module
   		return 	parent::install()
				&& $this->registerHook('displayTop')
				&& $this->registerHook('displayHeader');
	}

	public function uninstall()
	{
		// Uninstall SQL
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;

		Configuration::deleteByName('MOD_MEGADROWN_ITEMS');

		// Uninstall Module
		if (!parent::uninstall())
			return false;

		return true;
	}

	public function getContent()
	{
		$warning = $this->displayName.$this->l(' is in test for PrestaShop 1.6. If you need, contact me at: ').' j.danse@prestaedit.com';
		$this->adminDisplayWarning($warning);

		$languages = Language::getLanguages();
		$iso = Language::getIsoById((int)Configuration::get('PS_LANG_DEFAULT'));
		$output = "";
		$errors = array();
		$errorsNb = 0;

		$update_cache = false;

		if (Tools::isSubmit('submitAddButton'))
		{
			$order_button = MegaDrownEvo::getMaxPosition() + 1;

			$button = new Button();
			$button->order_button = (int)$order_button;
			$button = $this->processSubmitButton($button);

			if (!$button->add())
				$errorsNb++;

			if ($errorsNb)
				$output .= $this->displayError($this->l('Unable to add this button'));
			else
				$output .= $this->displayConfirmation($this->l('Button added'));

			Tools::redirectAdmin('index.php?controller=AdminModules&configure='.$this->name.'&tab_module=&tab_active=menu&module_name='.$this->name.'&token='.Tools::getValue('token'));
		}
		else if (Tools::isSubmit('submitUpdateButton'))
		{
			$button = new Button((int)Tools::getValue('id_button'));
			$button = $this->processSubmitButton($button);

			if (!$button->update())
				$errorsNb++;

			if ($errorsNb)
				$output .= $this->displayError($this->l('Unable to update this button'));
			else
				$output .= $this->displayConfirmation($this->l('Button updated'));

			Tools::redirectAdmin('index.php?controller=AdminModules&configure='.$this->name.'&tab_module=&tab_active=menu&module_name='.$this->name.'&token='.Tools::getValue('token'));
		}
		else if(Tools::isSubmit('submitConfigure'))
		{
			$tabDesign = array();
			$tabDesign["MenuWidth"] 				= Tools::getValue('MenuWidth');
			$tabDesign["MenuHeight"] 				= Tools::getValue('MenuHeight');
			$tabDesign["MinButtonWidth"] 			= Tools::getValue('MinButtonWidth');
			$tabDesign["MaxButtonWidth"] 			= Tools::getValue('MaxButtonWidth');
			$tabDesign["columnSize"] 				= Tools::getValue('ColumnSize');
			$tabDesign["paddingLeft"] 				= Tools::getValue('paddingLeft');
			$tabDesign["marginTop"] 				= Tools::getValue('marginTop');
			$tabDesign["marginBottom"] 				= Tools::getValue('marginBottom');
			$tabDesign["GeneralColor"] 				= Tools::getValue('GeneralColor');
			$tabDesign["FontSizeMenu"] 				= Tools::getValue('FontSizeMenu');
			$tabDesign["FontSizeSubMenu"] 			= Tools::getValue('FontSizeSubMenu');
			$tabDesign["FontSizeSubSubMenu"] 		= Tools::getValue('FontSizeSubSubMenu');
			$tabDesign["ColorFontMenu"] 			= Tools::getValue('ColorFontMenu');
			$tabDesign["ColorFontSubMenu"] 			= Tools::getValue('ColorFontSubMenu');
			$tabDesign["ColorFontSubSubMenu"] 		= Tools::getValue('ColorFontSubSubMenu');
			$tabDesign["ColorFontMenuHover"] 		= Tools::getValue('ColorFontMenuHover');
			$tabDesign["ColorFontSubMenuHover"] 	= Tools::getValue('ColorFontSubMenuHover');
			$tabDesign["ColorFontSubSubMenuHover"] 	= Tools::getValue('ColorFontSubSubMenuHover');
			$tabDesign["VerticalPadding"] 			= Tools::getValue('VerticalPadding');
			Tools::getValue('noColorTR1')=="1" 		? $tabDesign["backgroundTR1"] 	= "" 		: $tabDesign["backgroundTR1"] 	= Tools::getValue('backgroundTR1');
			Tools::getValue('noColorTD1')=="1" 		? $tabDesign["backgroundTD1"] 	= "" 		: $tabDesign["backgroundTD1"] 	= Tools::getValue('backgroundTD1');
			Tools::getValue('noColorTD2')=="1" 		? $tabDesign["backgroundTD2"] 	= "" 		: $tabDesign["backgroundTD2"] 	= Tools::getValue('backgroundTD2');
			Tools::getValue('noColorTD3')=="1" 		? $tabDesign["backgroundTD3"] 	= "" 		: $tabDesign["backgroundTD3"] 	= Tools::getValue('backgroundTD3');
			$tabDesign["heightTR1"] 				= Tools::getValue('heightTR1');
			$tabDesign["widthTD1"] 					= Tools::getValue('widthTD1');
			$tabDesign["widthTD3"] 					= Tools::getValue('widthTD3');
			$tabDesign["stateTR1"] 					= Tools::getValue('stateTR1');
			$tabDesign["stateTD1"] 					= Tools::getValue('stateTD1');
			$tabDesign["stateTD3"] 					= Tools::getValue('stateTD3');
			$tabDesign["SearchBar"]					= Tools::getValue('SearchBar');

			$result = Db::getInstance()->autoExecuteWithNullValues(
				_DB_PREFIX_.'admevo_parameters',
				$tabDesign,
				'UPDATE'
			);

			$output .= $this->displayConfirmation($this->l('Settings saved'));

			$this->_clearCache('cssnavmegadrownevo.tpl', $this->getCacheId());

			Tools::redirectAdmin('index.php?controller=AdminModules&configure='.$this->name.'&tab_active=configure&module_name='.$this->name.'&token='.Tools::getValue('token'));
		}
		else if (Tools::getIsset('deletenavmegadrownevo'))
		{
			$id_button = (int)Tools::getValue('id_button');

			Db::getInstance()->delete('admevo_button', 'id_button = '.(int)$id_button);
			Db::getInstance()->delete('admevo_button_lang', 'id_button = '.(int)$id_button);
			Db::getInstance()->delete('admevo_button_link', 'id_button = '.(int)$id_button);
			Db::getInstance()->delete('admevo_button_link_cat', 'id_button = '.(int)$id_button);
			Db::getInstance()->delete('admevo_custom_menu', 'id_button = '.(int)$id_button);
			Db::getInstance()->delete('admevo_custom_menu_lang', 'id_button = '.(int)$id_button);

			Tools::redirectAdmin('index.php?controller=AdminModules&configure='.$this->name.'&tab_module=&tab_active=menu&module_name='.$this->name.'&token='.Tools::getValue('token'));
		}
		else if (Tools::isSubmit('submitHelpNeeded'))
		{
			$datas = array(
				'method' => 'help_needed',
				'message' => Tools::getValue('HELP_MESSAGE'),
				'email' => Tools::getValue('HELP_EMAIL')
			);

			if (Tools::getValue('HELP_SEND_INFORMATIONS'))
			{
				$datas['sending_informations'] = 1;
				$datas['module_name'] = $this->displayName;
				$datas['module_version'] = $this->version;
				$datas['ps_version'] = _PS_VERSION_;
			}
			else
				$datas['sending_informations'] = 0;

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, 'http://api.prestaedit.com');
			curl_setopt($curl, CURLOPT_COOKIESESSION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);

			$return = curl_exec($curl);
			curl_close($curl);

			Tools::redirectAdmin('index.php?controller=AdminModules&configure='.$this->name.'&tab_active=help&module_name='.$this->name.'&token='.Tools::getValue('token'));
		}
		else
			$output .= $this->displayForm();

		$this->_clearCache('cssnavmegadrownevo.tpl', $this->getCacheId());

		return $output;
	}

	public function processSubmitButton($button)
	{
		$button->buttonColor = (Tools::getValue('use_color') ? pSQL(Tools::getValue('button_color')) : '');

		$languages = Language::getLanguages();
		foreach ($languages as $language)
		{
			$button->name_button[(int)$language['id_lang']] = pSQL(Tools::getValue('button_name_'.(int)$language['id_lang']));
			$button->detailSubLeft[(int)$language['id_lang']] = pSQL(Tools::getValue('sub_left_'.(int)$language['id_lang']));
			$button->detailSubTR[(int)$language['id_lang']] = pSQL(Tools::getValue('sub_tr_'.(int)$language['id_lang']));
			$button->detailSub[(int)$language['id_lang']] = pSQL(Tools::getValue('sub_'.(int)$language['id_lang']));
			$button->link[(int)$language['id_lang']] = pSQL(Tools::getValue('link_'.(int)$language['id_lang']));
		}

		return $button;
	}

	public function displayForm()
	{
		include(dirname(__FILE__).'/models/fields.php');

		$output = '';

		$languages = Language::getLanguages(false);
		foreach ($languages as $k => $language)
			$languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitConfigure';

		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		$this->fields_form[1]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Line top'),
				'icon' => 'icon-cogs'
			),
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		$this->fields_form[2]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Left column'),
				'icon' => 'icon-cogs'
			),
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		$this->fields_form[3]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Center column - Links detail'),
				'icon' => 'icon-cogs'
			),
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		$this->fields_form[4]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Right column'),
				'icon' => 'icon-cogs'
			),
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Menu width'), 'MenuWidth', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Menu height'), 'MenuHeight', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Min width button'), 'MinButtonWidth', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Max width button'), 'MaxButtonWidth', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Padding left'), 'paddingLeft', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Margin top'), 'marginTop', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Margin bottom'), 'marginBottom', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Width column'), 'columnSize', 'px', 'fixed-width-xs');

		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('General color'), 'GeneralColor');

		/*
		$this->fields_form[0]['form']['input'][] = Fields::addFreeField($this->l('Picture Menu'), 'PictureMenu', 'px');
		$this->fields_form[0]['form']['input'][] = Fields::addFreeField($this->l('Picture Button'), 'PictureButton', 'px');
		$this->fields_form[0]['form']['input'][] = Fields::addFreeField($this->l('Picture List arrow'), 'PictureListArrow', 'px');
		$this->fields_form[0]['form']['input'][] = Fields::addFreeField($this->l('Picture background submenu'), 'PicturebackSubMenu', 'px');
		*/

		$this->fields_form[0]['form']['input'][] = Fields::addSwitchField($this->l('Search'), 'SearchBar', 'px');

		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Font size Menu'), 'FontSizeMenu', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Font size Sub-menu'), 'FontSizeSubMenu', 'px', 'fixed-width-xs');
		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Font size Sub-sub-menu'), 'FontSizeSubSubMenu', 'px', 'fixed-width-xs');

		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Menu color'), 'ColorFontMenu');
		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Menu color').'('.$this->l('Hover').')', 'ColorFontMenuHover');
		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Sub-menu color'), 'ColorFontSubMenu');
		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Sub-menu color').'('.$this->l('Hover').')', 'ColorFontSubMenuHover');
		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Sub-sub-menu color'), 'ColorFontSubSubMenu');
		$this->fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Sub-sub-menu color').'('.$this->l('Hover').')', 'ColorFontSubSubMenuHover');

		$this->fields_form[0]['form']['input'][] = Fields::addField($this->l('Vertical padding'), 'VerticalPadding', 'px', 'fixed-width-xs');

		$this->fields_form[1]['form']['input'][] = Fields::addSwitchField($this->l('Active'), 'stateTR1');
		$this->fields_form[1]['form']['input'][] = Fields::addSwitchField($this->l('No color'), 'noColorTR1');
		$this->fields_form[1]['form']['input'][] = Fields::addColorField($this->l('Background Color'), 'backgroundTR1');
		$this->fields_form[1]['form']['input'][] = Fields::addField($this->l('Height line'), 'heightTR1', 'px', 'fixed-width-xs');

		$this->fields_form[2]['form']['input'][] = Fields::addSwitchField($this->l('Active'), 'stateTD1');
		$this->fields_form[2]['form']['input'][] = Fields::addSwitchField($this->l('No color'), 'noColorTD1');
		$this->fields_form[2]['form']['input'][] = Fields::addColorField($this->l('Background Color'), 'backgroundTD1');
		$this->fields_form[2]['form']['input'][] = Fields::addField($this->l('Width column'), 'widthTD1', 'px', 'fixed-width-xs');

		$this->fields_form[3]['form']['input'][] = Fields::addSwitchField($this->l('No color'), 'noColorTD2');
		$this->fields_form[3]['form']['input'][] = Fields::addColorField($this->l('Background Color'), 'backgroundTD2');

		$this->fields_form[4]['form']['input'][] = Fields::addSwitchField($this->l('Active'), 'stateTD3');
		$this->fields_form[4]['form']['input'][] = Fields::addSwitchField($this->l('No color'), 'noColorTD3');
		$this->fields_form[4]['form']['input'][] = Fields::addColorField($this->l('Background Color'), 'backgroundTD3');
		$this->fields_form[4]['form']['input'][] = Fields::addField($this->l('Width column'), 'widthTD3', 'px', 'fixed-width-xs');

		$helper->fields_value = $this->getFieldsValue();

		$tab_active = Tools::getValue('tab_active', 'menu');

		$output .= '<div class="tabbable">
						<ul class="nav nav-tabs">
							<li '.($tab_active == 'configure' ? 'class="active"' : '').'><a href="#pane1" data-toggle="tab"><i class="icon-cogs"></i> '.$this->l('Settings').'</a></li>
					    	<li '.($tab_active == 'menu' ? 'class="active"' : '').'><a href="#pane2" data-toggle="tab"><i class="icon-list-alt"></i> '.$this->l('Menu').'</a></li>
					    	<li '.($tab_active == 'help' ? 'class="active"' : '').'><a href="#panel_help" data-toggle="tab"><i class="icon-question"></i> '.$this->l('Help').'</a></li>
						</ul>
						<div class="tab-content">
						    <div id="pane1" class="tab-pane '.($tab_active == 'configure' ? 'in active' : '').'">
						    	'.$helper->generateForm($this->fields_form).'
						    </div>

						    <div id="pane2" class="tab-pane '.($tab_active == 'menu' ? 'in active' : '').'">
						    	'.$this->renderTabPane().'
						    </div>

						    <div id="panel_help" class="tab-pane '.($tab_active == 'help' ? 'in active' : '').'">
						    	'.$this->renderAssistanceForm().'
						    </div>
						</div>
					</div>';

		return $output;
	}

	public function renderTabPane()
	{
		$output = '';
		if (Tools::getIsset('addbutton'))
			$output .= $this->initForm('add');
		else if (Tools::getIsset('updatenavmegadrownevo'))
			$output .= $this->initForm('update');
		else
			$output .= '<p>'.$this->renderList().'</p>';

		return $output;
	}

	public function renderList()
	{
		$fields_list = array(
			'name_button' => array(
				'title' => $this->l('Name'),
				'type' => 'text',
			),
			'order_button' => array(
				'title' => $this->l('Position'),
				'position' => 'position',
				'align' => 'center',
				'class' => 'fixed-width-xs'
			),
		);

		$helper = new HelperList();
		$helper->shopLinkType = '';
		$helper->identifier = 'id_button';
		$helper->position_identifier = 'order_button';
		$helper->orderBy = 'position';
		$helper->orderWay = 'ASC';
		$helper->actions = array('edit', 'delete');
		$helper->show_toolbar = false;
		$helper->toolbar_btn['new'] =  array(
			'href' => AdminController::$currentIndex.'&configure='.$this->name.'&addbutton=1&token='.Tools::getAdminTokenLite('AdminModules'),
			'desc' => $this->l('Add new')
		);
		$helper->title = $this->l('Buttons');
		$helper->table = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$buttons = MegaDrownEvo::getConfigurations((int)$this->context->language->id);
		$helper->listTotal = count($buttons);

		return $helper->generateList($buttons, $fields_list);
	}

	private function initForm($type)
	{
		$fields_form = array();

		$languages = Language::getLanguages(false);
		foreach ($languages as $k => $language)
			$languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'submit'.Tools::ucfirst($type).'Button';

		$fields_form[0]['form'] = array(
			'tinymce' => true,
			'submit' => array(
				'name' => $helper->submit_action,
				'title' => $this->l('Save')
			),
			'input' => array()
		);

		//
		$fields_form[0]['form']['input'][] = Fields::addField($this->l('Name'), 'button_name', null, '', true);
		// Colors
		$fields_form[0]['form']['input'][] = Fields::addSwitchField($this->l('Use color'), 'use_color');
		$fields_form[0]['form']['input'][] = Fields::addColorField($this->l('Button Color & background sub-menu'), 'button_color');
		//
		$fields_form[0]['form']['input'][] = Fields::addTextField($this->l('Line top'), 'sub_tr', null, '', true);
		$fields_form[0]['form']['input'][] = Fields::addTextField($this->l('Left column'), 'sub_left', null, '', true);
		$fields_form[0]['form']['input'][] = Fields::addTextField($this->l('Right column'), 'sub', null, '', true);
		// Link
		$fields_form[0]['form']['input'][] = Fields::addField($this->l('Link'), 'link', null, '', true);

		if ($type == 'update')
			$fields_form[0]['form']['input'][] = Fields::addHiddenField('id_button');

		if ($type == 'add')
		{
			$helper->fields_value['button_color'] = '';
			$helper->fields_value['use_color'] = false;
			foreach ($languages as $language)
			{
				$helper->fields_value['button_name'][$language['id_lang']] = '';
				$helper->fields_value['sub_left'][$language['id_lang']] = '';
				$helper->fields_value['sub_tr'][$language['id_lang']] = '';
				$helper->fields_value['sub'][$language['id_lang']] = '';
				$helper->fields_value['link'][$language['id_lang']] = '';
			}
		}
		else if ($type == 'update')
		{
			$button = new Button((int)Tools::getValue('id_button'));

			$helper->fields_value['id_button'] = (int)Tools::getValue('id_button');

			$helper->fields_value['button_color'] = $button->buttonColor;
			if ($button->buttonColor != '')
				$helper->fields_value['use_color'] = true;
			else
				$helper->fields_value['use_color'] = false;

			// Lang Fields
			$helper->fields_value['button_name'] = $button->name_button;
			$helper->fields_value['sub_left'] = $button->detailSubLeft;
			$helper->fields_value['sub_tr'] = $button->detailSubTR;
			$helper->fields_value['sub'] = $button->detailSub;
			$helper->fields_value['link'] = $button->link;
		}

		return $helper->generateForm($fields_form);
	}

	public function processPosition()
	{
		$object = new Button((int)Tools::getValue('id_button'));

		if (!Validate::isLoadedObject($object))
		{
			$this->errors[] = Tools::displayError('An error occurred while updating the status for an object.').
				' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
		}
		elseif (!$object->updatePosition((int)Tools::getValue('way'), (int)Tools::getValue('position')))
			$this->errors[] = Tools::displayError('Failed to update the position.');
		else
		{
			$id_identifier_str = ($id_identifier = (int)Tools::getValue($this->identifier)) ? '&'.$this->identifier.'='.$id_identifier : '';
			$redirect = self::$currentIndex.'&'.$this->table.'Orderby=position&'.$this->table.'Orderway=asc&conf=5'.$id_identifier_str.'&token='.$this->token;
			$this->redirect_after = $redirect;
		}
		return $object;
	}

	public function getFieldsValue()
	{
		$fields_value = array();

		$MDParameters = MegaDrownEvo::getParameters();
		foreach ($MDParameters as $param => $value)
			$fields_value[$param] = $value;

		$fields_value['PictureMenu'] = '';
		$fields_value['PictureButton'] = '';
		$fields_value['PictureListArrow'] = '';
		$fields_value['PicturebackSubMenu'] = '';

		$fields_value['noColorTR1'] = false;
		$fields_value['noColorTD1'] = false;
		$fields_value['noColorTD2'] = false;
		$fields_value['noColorTD3'] = false;

		return $fields_value;
	}

	private function makeMegaDrown()
	{
		$id_lang = (int)$this->context->language->id;

		/* BEGIN: ACTIVE CATEGORY */
		$active_category = null;
		if (Tools::getIsset('id_category'))
			$active_category = (int)Tools::getValue('id_category');
		else if (Tools::getIsset('id_product'))
		{
			if (!isset($this->context->cookie->last_visited_category)
				|| !Product::idIsOnCategoryId((int)Tools::getValue('id_product'), array('0' => array('id_category' => $this->context->cookie->last_visited_category))))
			{
				$product = new Product((int)Tools::getValue('id_product'));
				if (Validate::isLoadedObject($product))
					$active_category = (int)$product->id_category_default;
			}
			else
				$active_category = (int)$this->context->cookie->last_visited_category;
		}

		if ($active_category !== null)
			$resultCat = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'admevo_button_link_cat WHERE id_link_cat='.(int)$active_category);
		/* END: ACTIVE CATEGORY */

		$MDParameters = MegaDrownEvo::getParameters();
		$this->_menu_tpl['parameters'] = $MDParameters;
		$this->_menu_tpl['search_bar'] = (int)$MDParameters['SearchBar'];

		$MDConfiguration = MegaDrownEvo::getConfigurations((int)$this->context->language->id);
		if (count($MDConfiguration))
		{
			foreach ($MDConfiguration as $kButton => $ValButton)
			{
				$id_button = (int)$ValButton['id_button'];

				$tabIdLinkCat[$id_button] = array();
				$tabLinkCustom[$id_button] = array();

				$CatMenu 	= array();
				$CatMenu 	= MegaDrownEvo::getButtonLinksCat($id_button);
				if (count($CatMenu))
				{
					foreach ($CatMenu as $kMenu => $ValCat)
					{
						$tabIdLinkCat[$id_button][$ValCat['id_link_cat']] = $ValCat['id_link_cat'];
						$DescendantCateogries = Db::getInstance()->ExecuteS('
							SELECT *
							FROM '._DB_PREFIX_.'category
							WHERE id_parent='.$ValCat['id_link_cat']);

						if (count($DescendantCateogries))
							foreach ($DescendantCateogries as $kDescCat => $ValDescCat)
								$tabIdLinkCat[$ValButton['id_button']][$ValDescCat['id_category']] = $ValDescCat['id_category'];
					}
				}

				$CustomMenu = array();
				$CustomMenu = MegaDrownEvo::getButtonLinksCustom($id_button, (int)$this->context->language->id);
				if (count($CustomMenu))
				{
					foreach ($CustomMenu as $kMenu=>$ValMenu)
					{
						$tabLinkCustom[$id_button][$ValMenu['id_custom']] = basename($ValMenu['link']);
						$CustomMenuUnder = array();
						$CustomMenuUnder = MegaDrownEvo::getButtonLinksCustomUnder($id_button, $ValMenu['id_custom'], (int)$this->context->language->id);
						if (count($CustomMenuUnder))
							foreach ($CustomMenuUnder as $kDescCustom => $ValDescCustom)
								$tabLinkCustom[$id_button][$ValDescCustom['id_custom']] = basename($ValDescCustom['link']);
					}
				}
			}
		}

		if (count($MDConfiguration))
		{
			$b = 0;
			foreach ($MDConfiguration as $kButton => $ValButton)
			{
				$this->_menu_tpl['li'][$b] = array();

				$id_button = (int)$ValButton['id_button'];

				$this->_menu_tpl['li'][$b]['id_button'] = (int)$id_button;
				$this->_menu_tpl['li'][$b]['name'] = $ValButton['name_button'];

				strpos(strtolower($this->_menu_tpl['li'][$b]['name']), "<br />") ? $this->_menu_tpl['li'][$b]['decal'] = "margin-top : -5px;" : $this->_menu_tpl['li'][$b]['decal'] = "";

				if ($ValButton['link'] != '')
					$this->_menu_tpl['li'][$b]['link_button'] = $ValButton['link'];
				else
					$this->_menu_tpl['li'][$b]['link_button'] = "#";

				($this->_menu_tpl['li'][$b]['link_button'] == "#" ? $this->_menu_tpl['li'][$b]['onclick'] = 1 : $this->_menu_tpl['li'][$b]['onclick'] = 0);
				((in_array($active_category, $tabIdLinkCat[$ValButton['id_button']]) || basename($_SERVER['REQUEST_URI']) == $this->_menu_tpl['li'][$b]['link_button']) ? $this->_menu_tpl['li'][$b]['style'] = 'background-position : 0 -'.$MDParameters['MenuHeight'].'px; color: #'.$MDParameters['ColorFontMenuHover'] : $this->_menu_tpl['li'][$b]['style'] = '');

				if($ValButton['buttonColor'] != '')
						$this->_css .= '.liBouton'.$b.' { background-color: '.$ValButton['buttonColor'].' }'.$this->eol;

				$CatMenu 	= MegaDrownEvo::getButtonLinksCat((int)$id_button);
				$CustomMenu = MegaDrownEvo::getButtonLinksCustom((int)$id_button, (int)$this->context->language->id);
				$NbColsMax 	= MegaDrownEvo::getMaxColumns((int)$id_button);;
				$MaxCols	= 0;
				$MaxLines	= 0;
				$tabLines	= array();
				$m=0;

				if (count($CatMenu))
				{
					foreach($CatMenu as $kMenu => $ValCat)
					{
						$tabLines[$kButton][$ValCat['num_ligne']] 									= $ValCat['num_ligne'];
						$tabColumnDatas[$kButton][$ValCat['num_column']][$ValCat['num_ligne']][$m]	= $ValCat;
						$tabColumnType[$kButton][$ValCat['num_column']][$ValCat['num_ligne']][$m]	= 'category';
						$m++;
						$MaxCols <($ValCat['num_column']*1) ? $MaxCols = $ValCat['num_column'] : false;
						$MaxLines <($ValCat['num_ligne']*1) ? $MaxLines = $ValCat['num_ligne'] : false;
					}
				}

				if (count($CustomMenu))
				{
					foreach($CustomMenu as $kCustom => $ValCustom)
					{
						$tabLines[$kButton][$ValCustom['num_ligne']] 										= $ValCustom['num_ligne'];
						$tabColumnDatas[$kButton][$ValCustom['num_column']][$ValCustom['num_ligne']][$m]	= $ValCustom;
						$tabColumnType[$kButton][$ValCustom['num_column']][$ValCustom['num_ligne']][$m]		= 'custom';
						$m++;
						$MaxCols <($ValCustom['num_column']*1) ? $MaxCols = $ValCustom['num_column'] : false;
						$MaxLines <($ValCustom['num_ligne']*1) ? $MaxLines = $ValCustom['num_ligne'] : false;
					}
				}

				if (array_key_exists($kButton, $tabLines))
				{
					if (count($tabLines[$kButton]))
					{
						$this->_menu_tpl['li'][$b]['sub'] = 1;
						$this->_menu_tpl['li'][$b]['sub']['bg_color'] = $ValButton['buttonColor'];

						if ($MDParameters['stateTR1'])
						{
							$this->_menu_tpl['li'][$b]['tr1'] = 1;
							$this->_menu_tpl['li'][$b]['tr1']['details']['sub_tr'] = html_entity_decode($ValButton['detailSubTR']);
							$this->_menu_tpl['li'][$b]['tr1']['details']['sub'] = html_entity_decode($ValButton['detailSub']);
						}

						if ($MDParameters['stateTD1'])
						{
							$this->_menu_tpl['li'][$b]['td1'] = 1;
							if ($ValButton['img_name'] != '')
							{
								$this->_menu_tpl['li'][$b]['td1']['img'] = 1;
								$this->_menu_tpl['li'][$b]['td1']['img']['link'] = urldecode($ValButton['img_link']);
								$this->_menu_tpl['li'][$b]['td1']['img']['name'] = $ValButton['img_name'];
							}
							$this->_menu_tpl['li'][$b]['td1']['details'] = html_entity_decode($ValButton['detailSubLeft']);
						}

						$this->_menu_tpl['li'][$b]['td2'] = array();
						for ($c=1; $c <= $MaxCols; $c++)
						{
							$this->_menu_tpl['li'][$b]['td2'][$c] = array();
							$this->_menu .= '<td valign="top">'.$this->eol;
							for ($l=1; $l <= $MaxLines; $l++)
							{
								if (array_key_exists($c, $tabColumnDatas[$kButton]))
									if (array_key_exists($l, $tabColumnDatas[$kButton][$c]))
										if (count(@$tabColumnDatas[$kButton][$c][$l]))
										{
											$this->_menu .= '<table border="0" style="width:'.$MDParameters['columnSize'].'px">'.$this->eol;
											foreach ($tabColumnDatas[$kButton][$c][$l] as $keyMenu=>$ValMenu)
											{
												$this->_menu .= '<tr>'.$this->eol;
												$this->_menu .= '<td style="width:'.$MDParameters['columnSize'].'px">'.$this->eol;
												switch ($tabColumnType[$kButton][$c][$l][$keyMenu])
												{
													case 'category':
														$category = new Category((int)$ValMenu['id_link_cat']);

														if (!$category->checkAccess((int)$this->context->customer->id))
															break;
														else
														{
															$this->_menu .= '<ul>'.$this->eol;
															$NameCategory = $this->getNameCategory($ValMenu['id_link_cat'], (int)$this->context->language->id, $ValButton['id_button']);
															$NameSubstitute = $this->getNameSubstitute($ValMenu['id_link_cat'], (int)$this->context->language->id, $ValButton['id_button']);
															$Category = new Category((int)$ValMenu['id_link_cat'], (int)$this->context->language->id);
															$rewrited_url = $this->context->link->getCategoryLink($ValMenu['id_link_cat']);
															$this->_menu .= '	<li class="stitle">
																					<a href="'.$rewrited_url.'" style="text-align:left">'.(trim($NameSubstitute[0]['name_substitute']) != '' ? $NameSubstitute[0]['name_substitute'] : $NameCategory[0]['name']).'</a>
																				</li>'.$this->eol;

															if($ValMenu['view_products'] != 'on')
															{
																$NameCategoryUnder = array();
																$NameCategoryUnder = $this->getNameCategoryUnder($ValMenu['id_link_cat'], $ValButton['id_button']);
																if (count($NameCategoryUnder))
																{
																	foreach ($NameCategoryUnder as $KUnderCat=>$ValUnderCat)
																	{
																		$Category = new Category(intval($ValUnderCat['id_category']), (int)$this->context->language->id);
																		if ($Category->checkAccess($context->customer->id))
																		{
																			$rewrited_url = $this->context->link->getCategoryLink($ValUnderCat['id_category']);
																			$NameCategoryUnder = $this->getNameCategory($ValUnderCat['id_category'], (int)$this->context->language->id, $ValButton['id_button']);
																			$NameSubstitute = $this->getNameSubstitute($ValUnderCat['id_category'], (int)$this->context->language->id, $ValButton['id_button']);
																			$this->_menu .= '	<li>
																									<a href="'.$rewrited_url.'" style="text-align:left">'.(trim($NameSubstitute[0]['name_substitute']) != '' ? $NameSubstitute[0]['name_substitute'] : $NameCategoryUnder[0]['name']).'</a>
																								</li>'.$this->eol;
																		}
																	}
																}
															}
															else
															{
																$NameProductsUnder = array();
																$NameProductsUnder = $this->getProductsUnder($ValMenu['id_link_cat'], (int)$this->context->language->id, $this->context->shop->id);
																if (count($NameProductsUnder))
																{
																	foreach ($NameProductsUnder as $KUnderProd=>$ValUnderProd)
																	{
																		$Products = new Product(intval($ValUnderProd['id_product']), true, (int)$this->context->language->id);
																		$rewrited_url = $Products->getLink();
																		$NameProduct = $Products->name;
																		$this->_menu .= '<li><a href="'.$rewrited_url.'" style="text-align:left">'.(strlen($NameProduct)>20 ? substr(($NameProduct), 0, 40)."..." : ($NameProduct)).'</a></li>'.$this->eol;
																	}
																}
															}
															$this->_menu .= '</ul>'.$this->eol;
														}

														break;

													case 'custom':
														$this->_menu .= '<ul>'.$this->eol;
														$this->_menu .= '<li class="stitle"><a href="'.$ValMenu['link'].'" '.($ValMenu['link']=="#" || $ValMenu['link']=="" ? "onclick='return false'" : false).' style="text-align:left">'.$ValMenu['name_menu'].'</a></li>'.$this->eol;
														$NameLinkUnder = array();
														$NameLinkUnder = $this->getButtonLinksCustomUnder($ValButton['id_button'], $ValMenu['id_custom'], (int)$this->context->language->id);
														if (count($NameLinkUnder))
														{
															foreach ($NameLinkUnder as $KUnderLink => $ValUnderLink)
																$this->_menu .= '<li><a href="'.$ValUnderLink['link'].'" '.($ValUnderLink['link']=="#" || $ValUnderLink['link']=="" ? "onclick='return false'" : false).' style="text-align:left">'.$ValUnderLink['name_menu'].'</a></li>'.$this->eol;
														}
														$this->_menu .= '</ul>'.$this->eol;
													break;
												}

												$this->_menu .= '</td>'.$this->eol;
												$this->_menu .= '</tr>'.$this->eol;
											}

											$this->_menu .= '</table>'.$this->eol;
										}
							}

							$this->_menu .= '</td>'.$this->eol;
						}

						//Colonne droite;
						if ($MDParameters['stateTD3'] && !$MDParameters['stateTR1'])
						{
							$this->_menu_tpl['li'][$b]['td3'] = 1;
							$this->_menu_tpl['li'][$b]['td3']['details'] = html_entity_decode($ValButton['detailSub']);
						}
					}
				}

				$b++;
			}
		}
	}

	public function getCacheId($name = null)
	{
		//$this->page_name = Dispatcher::getInstance()->getController();
		//$smarty_cache_id = 'navmegadrownevo-'.$this->page_name.'-'.(int)$this->context->shop->id.'-'.(int)$this->context->language->id.'-'.(int)Tools::getValue('id_category').'-'.(int)Tools::getValue('id_manufacturer').'-'.(int)Tools::getValue('id_supplier').'-'.(int)Tools::getValue('id_cms').'-'.(int)Tools::getValue('id_product');

		//return $smarty_cache_id;

		return 'navmegadrownevo.tpl';
	}

	/*
	public function hookDisplayTop($param)
	{
		$this->context->smarty->cache_lifetime = 31536000;
		Tools::enableCache();
		if (!$this->isCached('views/templates/front/navmegadrownevo.tpl', $this->getCacheId()))
		{
			$this->makeMegaDrown();

			$this->context->smarty->assign('menuMDEvo', $this->_menu);
		}

		$html = $this->display(__FILE__, 'views/templates/front/navmegadrownevo.tpl', $this->getCacheId());
		Tools::restoreCacheSettings();
		return $html;
	}
	*/

	public function hookDisplayTop($param)
	{
		$this->makeMegaDrown();
		$this->context->smarty->assign('css_megadrownevo', $this->_css);
		$this->context->smarty->assign('menuMDEvo', $this->_menu);
		$this->context->smarty->assign('search_bar', $this->_searchBar);

		$this->context->smarty->assign('menu', $this->_menu_tpl);

		return $this->display(__FILE__, 'views/templates/front/navmegadrownevo_wip.tpl');
	}

  	public function hookDisplayHeader($params)
  	{
  		$this->context->smarty->cache_lifetime = 0;
		Tools::enableCache();
		if (!$this->isCached('views/templates/front/cssnavmegadrownevo.tpl', $this->getCacheId()))
		{
			$MDParameters = MegaDrownEvo::getParameters();

			/*
			$MDParameters['bg_menu'] 			= $this->checkIfImageExist('bg_menu', $MDParameters['extensionMenu']);
			$MDParameters['bg_bout'] 			= $this->checkIfImageExist('bg_bout', $MDParameters['extensionBout']);
			$MDParameters['navlist_arrow'] 		= $this->checkIfImageExist('navlist_arrow', $MDParameters['extensionArro']);
			$MDParameters['sub_bg'] 			= $this->checkIfImageExist('sub_bg', $MDParameters['extensionBack']);
			*/

			$this->context->smarty->assign('MDParameters', $MDParameters);
			$this->context->smarty->assign('pathMDEvo', $this->_path);
		}

		$this->context->controller->addJS(($this->_path).'/views/js/jquery.hoverIntent.minified.js', 'all');

		$this->context->controller->addCSS(($this->_path).'/views/css/navmegadrownEvo.css', 'all');

		$this->context->controller->addJS(($this->_path).'/views/js/navmegadrownEvo.js');

		$html = $this->display(__FILE__, 'views/templates/front/cssnavmegadrownevo.tpl', $this->getCacheId());
		Tools::restoreCacheSettings();
		return $html;
  	}

  	private function renderAssistanceForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Help'),
					'icon' => 'icon-question'
				),
				'description' => $this->l('Do you need help ? Fill the form and submit your ask to us !'),
				'input' => array(
					array(
		                'type' => 'text',
		                'label' => $this->l('Email'),
		                'name' => 'HELP_EMAIL',
		                'size' => 20,
		                'required' => true
            		),
            		array(
		                'type' => 'textarea',
		                'label' => $this->l('Message'),
		                'name' => 'HELP_MESSAGE',
		                'required' => true
            		),
            		array(
						'type' => 'switch',
						'label' => $this->l('Send informations:'),
						'name' => 'HELP_SEND_INFORMATIONS',
						'required' => true,
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'HELP_SEND_INFORMATIONS',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'HELP_SEND_INFORMATIONS',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						)
					),
				),
				'desc' => '<b>'.$this->l('Will be send').'</b>: <br /><ul><li>'.$this->l('Module name').'</li><li>'.$this->l('Module version').'</li><li>'.$this->l('PrestaShop version').'</li></ul>',
				'submit' => array(
					'title' => $this->l('Submit')
				),
			)
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitHelpNeeded';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => array(
				'HELP_EMAIL' => $this->context->employee->email,
				'HELP_MESSAGE' => '',
				'HELP_SEND_INFORMATIONS' => false,
			),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => (int)$this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}
}