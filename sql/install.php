<?php

	// Init
	$sql = array();

	// Create Table in Database
	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_parameters` (
	  `MenuWidth` INT NOT NULL default 980,
	  `MenuHeight` INT NOT NULL default 35,
	  `MinButtonWidth` INT NOT NULL default 98,
	  `MaxButtonWidth` INT NOT NULL default 0,
	  `columnSize` INT NOT NULL default 150,
	  `paddingLeft` INT NOT NULL default 0,
	  `marginTop` INT NOT NULL default 0,
	  `marginBottom` INT NOT NULL default 10,
	  `GeneralColor` VARCHAR(7) NOT NULL default "#f6f6f6",
	  `FontSizeMenu` INT NOT NULL default 11,
	  `FontSizeSubMenu` INT NOT NULL default 11,
	  `FontSizeSubSubMenu` INT NOT NULL default 10,
	  `ColorFontMenu` VARCHAR(7) NOT NULL default "#484848",
	  `ColorFontSubMenu` VARCHAR(7) NOT NULL default "#fffff",
	  `ColorFontSubSubMenu` VARCHAR(7) NOT NULL default "ffffff",
	  `ColorFontMenuHover` VARCHAR(7) NOT NULL default "#c7c7c7",
	  `ColorFontSubMenuHover` VARCHAR(7) NOT NULL default "#c7c7c7",
	  `ColorFontSubSubMenuHover` VARCHAR(7) NOT NULL default "#c7c7c7",
	  `VerticalPadding` INT NOT NULL default 5,
	  `stateTR1` VARCHAR(6) NULL default "on",
	  `stateTD1` VARCHAR(6) NULL default "on",
	  `stateTD3` VARCHAR(6) NULL default "on",
	  `heightTR1` INT NULL default 50,
	  `widthTD1` INT NULL default 150,
	  `widthTD3` INT NULL default 150,
	  `backgroundTR1` VARCHAR(7) NULL default "",
	  `backgroundTD1` VARCHAR(7) NULL default "",
	  `backgroundTD2` VARCHAR(7) NULL default "",
	  `backgroundTD3` VARCHAR(7) NULL default "",
	  `extensionMenu` VARCHAR(7) NULL default "",
	  `extensionBout` VARCHAR(7) NULL default "",
	  `extensionBack` VARCHAR(7) NULL default "",
	  `extensionArro` VARCHAR(7) NULL default "",
	  `SearchBar` VARCHAR(6) NULL default "off"
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';


	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button` (
	  `id_button` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `order_button` INT NOT NULL,
	  `img_name` varchar(255) NULL,
	  `img_link` LONGTEXT NULL,
	  `buttonColor` VARCHAR(7) NULL default "#383838",
	  `img_name_background` VARCHAR(255) NULL
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button_lang` (
	`id_button` INT NOT NULL,
	`id_lang` INT NOT NULL,
	`name_button` VARCHAR(128) NOT NULL,
	`detailSubTR` TEXT NULL,
	`detailSub` TEXT NULL,
	`detailSubLeft` TEXT NULL,
	`link` VARCHAR(255) NOT NULL,
	PRIMARY KEY ( `id_button` , `id_lang` )
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button_langcat` (
	`id_button` INT NOT NULL,
	`id_cat` INT NOT NULL ,
	`id_lang` INT NOT NULL ,
	`name_substitute` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (`id_button`, `id_cat` , `id_lang` )
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button_link_cat` (
	`id_button` INT NOT NULL,
	`id_link_cat` INT NOT NULL,
	`num_column` INT NOT NULL,
	`num_ligne` INT NOT NULL default 1,
	`view_products` VARCHAR( 6 ) NULL
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button_organization` (
	`id_button` INT NOT NULL,
	`id_link_cat` INT NOT NULL,
	`state` INT NOT NULL default 1,
	`num_ligne` INT NOT NULL default 1
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_custom_menu` (
	`id_button` INT NOT NULL,
	`id_custom` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_parent` INT NOT NULL,
	`name_menu` VARCHAR( 255 ) NULL,
	`num_column` INT NOT NULL,
	`num_ligne` INT NOT NULL,
	`link` LONGTEXT NULL,
	 PRIMARY KEY ( `id_custom` )
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_custom_menu_lang` (
	`id_button` INT NOT NULL,
	`id_custom` INT NOT NULL,
	`id_lang` INT NOT NULL,
	`name_menu` VARCHAR( 255 ) NULL,
	 INDEX ( `id_button` , `id_custom`, `id_lang` )
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'admevo_button_shop` (
  `id_admevo_button` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

	// Insert Datas
	$sql[] = '
	INSERT INTO '._DB_PREFIX_.'admevo_parameters
	(MenuWidth, MenuHeight, MinButtonWidth, MaxButtonWidth, GeneralColor,
	FontSizeMenu, FontSizeSubMenu, FontSizeSubSubMenu,
	ColorFontMenu, ColorFontSubMenu, ColorFontSubSubMenu, VerticalPadding)
	VALUES (980, 35, 98, 0, "#383838", 11, 11, 10, "#ffffff", "#ffffff", "#ffffff", 5);';
