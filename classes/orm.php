<?php

/**
 * @author Roman Chvanikoff <chvanikoff@gmail.com>
 * @copyright 2011
 */

class ORM extends Kohana_ORM {

	/**
	 * Alias of and_where()
	 *
	 * For columns that keep only 0/1 values you can write
	 * conditions like
	 * ->where('allowed')
	 * that will be exactly the same as
	 * ->where('allowed', '=', '1')
	 * Also you can write negative conditions with "!":
	 * ->where(' ! allowed')
	 * instead of
	 * ->where('allowed', '=', '0')
	 *
	 *
	 * @param   mixed   column name or array($column, $alias) or object
	 * @param   string  logic operator
	 * @param   mixed   column value
	 * @return  $this
	 *
	 */
	public function where($column, $op = NULL, $value = NULL)
	{
		if ($op === NULL AND $value === NULL)
		{
			$op = '=';
			$value = (int) (strpos($column, '!') === FALSE);
			$column = str_replace(array('!', ' '), '', $column);
		}

		return parent::where($column, $op, $value);
	}

	/**
	 * Creates a new "AND WHERE" condition for the query.
	 *
	 * For columns that keep only 0/1 values you can write
	 * conditions like
	 * ->where('allowed')
	 * that will be exactly the same as
	 * ->where('allowed', '=', '1')
	 * Also you can write negative conditions with "!":
	 * ->where(' ! allowed')
	 * instead of
	 * ->where('allowed', '=', '0')
	 *
	 * @param   mixed   column name or array($column, $alias) or object
	 * @param   string  logic operator
	 * @param   mixed   column value
	 * @return  $this
	 */
	public function and_where($column, $op = NULL, $value = NULL)
	{
		if ($op === NULL AND $value === NULL)
		{
			$op = '=';
			$value = (int) (strpos($column, '!') === FALSE);
			$column = str_replace(array('!', ' '), '', $column);
		}

		return parent::and_where($column, $op, $value);
	}

	/**
	 * Make sure you are working with loaded object.
	 * If not - Exception will be thrown.
	 *
	 * @throws Kohana_Exception
	 * @return void
	 */
	public function check_loaded()
	{
		if ( ! $this->loaded())
		{
			throw new Kohana_Exception('model :model not loaded', array(
				':model' => __CLASS__,
			));
		}
	}

	/**
	 * If you have fields that keep only 0/1 values
	 * and that named "is_" + property_name
	 * then you can use this method to compare the field with 1
	 * $object->is('author')
	 * equals to
	 * (bool) ($object->is_author === 1)
	 *
	 * @param $field
	 * @return bool
	 */
	public function is($field)
	{
		$this->check_loaded();
		$key = 'is_'.$field;

		return ((int) $this->$key === 1);
	}

	/**
	 * This magic method allows you to add custom logic to any property by creating methods "get_" + property_name
	 * For example, you have a "title" in your model. But when you read it - you always have to convert it
	 * To format properly. In this case you can just create method get_title() at your model and format title there
	 * Other point for using this method is to create virtual fields:
	 * If you will call $object->virtual_property the $object->get_virtual_property() method will be called
	 *
	 * @param $column
	 * @return mixed
	 */
	public function __get($column)
	{
		return (method_exists($this, 'get_'.$column))
			? call_user_func(array($this, 'get_'.$column))
			: parent::__get($column);
	}

	/**
	 * Native Kohana_ORM add() method will throw an exception if empty array of far_keys will be passed
	 * This wrapper just checks if far_keys is not empty array
	 *
	 * @param $alias
	 * @param $far_keys
	 * @return ORM
	 */
	public function add($alias, $far_keys)
	{
		return (is_array($far_keys) AND empty($far_keys))
			? $this
			: parent::add($alias, $far_keys);
	}
}