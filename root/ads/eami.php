<?php
/**
* EAMI (Easy Automatic Module Insertion)
*
* Created By: EXreaction
* http://www.lithiumstudios.org
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

class eami
{
	// Will hold all of the modules
	var $ucp = array();
	var $mcp = array();
	var $acp = array();

	/**
	* Constructor
	*/
	function eami()
	{
		global $db;

		//  Get all of the modules and put them in the data arrays
		$sql = 'SELECT * FROM ' . MODULES_TABLE;
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$this->{$row['module_class']}[$row['module_id']] = $row;
		}
	}

	/**
	* Add a new module
	*
	* @param string $class The module class, ucp, mcp, acp
	* @param string|int $parent The parent name or parent ID of the module you want to insert
	* @param array $data The data on the module you want to send, like basename/langname/mode/auth/etc.
	*/
	function add_module($class, $parent, $data)
	{
		global $cache, $db;

		if ($class != 'ucp' && $class != 'mcp' && $class != 'acp')
		{
			return false;
		}

		// Here we try to find the parent ID.
		$parent_id = (($parent == '') ? 0 : $parent); // Also accept a blank parent name as the same thing as 0.
		$parent_id = false;
		if (is_numeric($parent) && (intval($parent) == 0 || isset($this->{$class}[intval($parent)])))
		{
			$parent_id = intval($parent);
		}
		else
		{
			foreach ($this->{$class} as $id => $row)
			{
				if (in_array($parent, $row))
				{
					$parent_id = $id;
					break;
				}
			}
		}

		// If we could not find the requested parent, return false
		if ($parent_id === false)
		{
			return false;
		}

		// The left and right ID for the new module
		if ($parent_id != 0)
		{
			$left_id = (int) $this->{$class}[$parent_id]['right_id'];
		}
		else
		{
			$left_id = 0;
			foreach ($this->{$class} as $row)
			{
				if ($row['right_id'] >= $left_id)
				{
					$left_id = $row['right_id'] + 1;
				}
			}
		}
		$right_id = $left_id + 1;

		// Build the module data array which will be inserted into the DB.
		$data = array_merge(array(
			'module_enabled'	=> 1,
			'module_display'	=> 1,
			'module_basename'	=> '',
			'module_class'		=> $class,
			'parent_id'			=> $parent_id,
			'left_id'			=> $left_id,
			'right_id'			=> $right_id,
			'module_langname'	=> '',
			'module_mode'		=> '',
			'module_auth'		=> '',
		), $data);

		// Update the left and right ID's in this classes data
		foreach ($this->{$class} as $id => $row)
		{
			if ($row['left_id'] >= $left_id)
			{
				$this->{$class}[$id]['left_id'] += 2;
			}
			if ($row['right_id'] >= $left_id)
			{
				$this->{$class}[$id]['right_id'] += 2;
			}
		}

		// Update the left and right ID's in the database
		$db->sql_query('UPDATE ' . MODULES_TABLE . ' SET left_id = left_id + 2 WHERE left_id >= ' . $left_id . ' AND module_class = \'' . $class . '\'');
		$db->sql_query('UPDATE ' . MODULES_TABLE . ' SET right_id = right_id + 2 WHERE right_id >= ' . $left_id . ' AND module_class = \'' . $class . '\'');

		// Insert the new module into the DB
		$sql = 'INSERT INTO ' . MODULES_TABLE . ' ' . $db->sql_build_array('INSERT', $data);
		$db->sql_query($sql);
		$module_id = $db->sql_nextid();

		// Make sure to put the new modules' data in this classes data
		$this->{$class}[$module_id] = $data;

		// Clear the Modules Cache
		$cache->destroy("_modules_{$class}");

		return true;
	}
}
?>