<?php

/**
 * @author Roman Chvanikoff <chvanikoff@gmail.com>
 * @copyright 2011
 */

class Request extends Kohana_Request {

	/**
	 * Check if variables in _POST were set
	 * Example:
	 * Request::current()->post_isset('post_var1', 'post_another_var', 'yet_another_var');
	 *
	 * @return bool
	 */
	public function post_isset()
	{
		if ( ! $this->post())
		{
			return FALSE;
		}

		$params = func_get_args();
		foreach ($params as $param)
		{
			if ($this->post($param) === NULL)
			{
				return FALSE;
			}
		}

		return TRUE;
	}
}