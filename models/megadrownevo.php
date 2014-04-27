<?php

class MegaDrownEvo
{
	public static function getParameters()
	{
		return Db::getInstance()->getRow('
			SELECT *
			FROM '._DB_PREFIX_.'admevo_parameters
		');
	}

	public static function getConfigurations($id_lang)
	{
		return Db::getInstance()->ExecuteS('
			SELECT *, tb.`order_button` as position
			FROM '._DB_PREFIX_.'admevo_button tb
			LEFT JOIN '._DB_PREFIX_.'admevo_button_lang tbl
			ON (tb.id_button=tbl.id_button)
			WHERE tbl.id_lang='.(int)$id_lang.'
			ORDER BY order_button ASC, name_button ASC
		');
	}

	static public function getButtonLinksCat($id_button)
	{
		return Db::getInstance()->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.'admevo_button_link_cat
			WHERE id_button='.(int)$id_button.' ORDER BY num_ligne ASC, num_column ASC, id_link_cat ASC
		');
	}

	static public function getButtonLinksCustom($id_button, $id_lang)
	{
		return Db::getInstance()->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.'admevo_custom_menu tb
			INNER JOIN '._DB_PREFIX_.'admevo_custom_menu_lang tbl
			ON (tb.id_button=tbl.id_button AND tb.id_custom=tbl.id_custom)
			WHERE tb.id_button='.(int)$id_button.' AND tb.id_parent = 0 AND tbl.id_lang='.(int)$id_lang.'
			ORDER BY tb.num_ligne ASC, tb.num_column ASC
		');
	}

	static public function getButtonOrganization($id_button)
	{
		return Db::getInstance()->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'admevo_button_organization WHERE id_button='.$id_button.'
		');
	}

	static public function getNameCategory($id_category, $id_lang, $id_button)
	{
		return Db::getInstance()->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'category_lang tb INNER JOIN '._DB_PREFIX_.'admevo_button_organization tbl
		ON (tb.id_category=tbl.id_link_cat) WHERE tb.id_category='.$id_category.' AND tb.id_lang='.$id_lang.' and
		tbl.id_button='.$id_button.'
		');
	}

	static public function getNameSubstitute($IdCat, $IdLang, $IdButton) {
		$return[0]['name_substitute'] = "";
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'admevo_button_langcat WHERE id_cat='.(int)$IdCat.' AND id_lang='.(int)$IdLang.' and
		id_button='.(int)$IdButton.'
		' );
		if($result)
			return $result;
		return $return;
	}

	static public function getAllNameSubstitute($IdButton)
	{
		return Db::getInstance()->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'admevo_button_langcat WHERE
		id_button='.(int)$IdButton.'
		');
	}

	static public function getNameCategoryUnder($IdCat, $IdButton)
	{
		return Db::getInstance()->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.'category tb INNER JOIN '._DB_PREFIX_.'admevo_button_organization tbl
			ON (tb.id_category=tbl.id_link_cat)
			WHERE tb.id_parent='.(int)$IdCat.' and tbl.state=1 and tb.active=1 and
			tbl.id_button='.(int)$IdButton.' ORDER BY tbl.num_ligne ASC
		');
	}

	static public function getProductsUnder($id_category, $id_lang, $id_shop = 1) {
		return Db::getInstance()->ExecuteS('
			SELECT *
			FROM ('._DB_PREFIX_.'category_product cp INNER JOIN '._DB_PREFIX_.'product_lang pl
			ON (cp.id_product=pl.id_product)) INNER JOIN '._DB_PREFIX_.'product p on (cp.id_product=p.id_product)
			WHERE cp.id_category='.(int)$id_category.'
			AND p.active=1
			AND pl.id_lang = '.(int)$id_lang.'
			AND pl.id_shop = '.(int)$id_shop.'
			ORDER BY pl.name ASC
		');
	}

	static public function getButtonLinksCustomUnder($IdButton, $IdParent, $idLang)
	{
		return Db::getInstance()->ExecuteS('
			SELECT *
			FROM '._DB_PREFIX_.'admevo_custom_menu tb
			INNER JOIN '._DB_PREFIX_.'admevo_custom_menu_lang tbl
			ON (tb.id_button=tbl.id_button AND tb.id_custom=tbl.id_custom)
			WHERE tb.id_button='.(int)$IdButton.' AND tb.id_parent = '.(int)$IdParent.' AND tbl.id_lang = '.(int)$idLang.'
			ORDER BY tb.num_ligne ASC'
		);
	}

	static public function getMaxColumns($IdButton)
	{
		$maxCols = 0;
		$result = Db::getInstance()->ExecuteS('
		SELECT num_ligne, count(id_link_cat) as nbCat
		FROM '._DB_PREFIX_.'admevo_button_link_cat WHERE id_button='.(int)$IdButton.' GROUP BY num_ligne
		' );
		if(sizeof($result)) {
			foreach($result as $kr=>$ValResult)
				if($maxCols<$ValResult['nbCat'])
					$maxCols = $ValResult['nbCat'];
		}
		return $maxCols;
	}
	static public function getNbColumns($IdButton, $Line)
	{
		return Db::getInstance()->ExecuteS('
			SELECT count(id_link_cat) as nbCols
			FROM '._DB_PREFIX_.'admevo_button_link_cat WHERE id_button='.(int)$IdButton.' AND num_ligne='.(int)$Line
		);
	}

	public static function getMaxPosition()
	{
		return Db::getInstance()->getValue('
			SELECT MAX(tb.`order_button`) as position
			FROM '._DB_PREFIX_.'admevo_button tb
		');
	}
}