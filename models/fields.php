<?php

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