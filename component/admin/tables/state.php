<?php
/**
 * @package     RedSHOP.Backend
 * @subpackage  Table
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * State table
 *
 * @package     RedSHOP.Backend
 * @subpackage  Table.State
 * @since       2.0.0.4
 */
class RedshopTableState extends RedshopTable
{
	/**
	 * The table name without the prefix. Ex: cursos_courses
	 *
	 * @var  string
	 */

	protected $_tableName = 'redshop_state';

	/**
	 * Function check
	 * 
	 * @return boolean
	 */
	public function check()
	{
		if (!parent::check())
		{
			return false;
		}

		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select([$db->qn('id'), $db->qn('state_3_code')])
			->from($db->qn('#__redshop_state'))
			->where(
				$db->qn('state_3_code') . ' = ' . $db->q($this->state_3_code)
				. ' AND ' . $db->qn('id') . ' != ' . $db->q($this->id)
				. ' AND ' . $db->qn('country_id') . ' = ' . $db->q($this->country_id)
				);

		$db->setQuery($query);

		$xid = intval($db->loadResult());

		if ($xid)
		{
			$this->_error = JText::_('COM_REDSHOP_STATE_CODE3_ALREADY_EXISTS');
			JError::raiseWarning('', $this->_error);

			return false;
		}
		else
		{
			$query = $db->getQuery(true);

			$query->select([$db->qn('id'), $db->qn('state_3_code'), $db->qn('state_2_code')])
			->from($db->qn('#__redshop_state'))
			->where(
				$db->qn('state_2_code') . ' = ' . $db->q($this->state_2_code)
				. ' AND ' . $db->qn('id') . ' != ' . $db->q($this->id)
				. ' AND ' . $db->qn('country_id') . ' = ' . $db->q($this->country_id)
				);

			$db->setQuery($query);
			$xid = intval($db->loadResult());

			if ($xid)
			{
				$this->_error = JText::_('COM_REDSHOP_STATE_CODE2_ALREADY_EXISTS');
				JError::raiseWarning('', $this->_error);

				return false;
			}
		}

		return true;
	}
}
