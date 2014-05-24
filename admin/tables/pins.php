<?php
/*------------------------------------------------------------------------

# TZ Pinboard Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

// Import JTableCategory
//jimport('joomla.application.component.model');
class TableTz_Pins extends JTable
{
	/**
	 * Method to delete a node and, optionally, its child nodes from the table.
	 *
	 * @param   integer  $pk        The primary key of the node to delete.
	 * @param   boolean  $children  True to delete child nodes, false to move them up a level.
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     http://docs.joomla.org/JTableNested/delete
	 * @since   2.5
	 */
        var $id = null;
       var $asset_id= null;
       var $title= null;
       var $alias= null;
       var $introtext = null;
       var $fulltext = null;
       var $state = null;
       var $catid = null;
       var $created = null;
       var $created_by = null;
       var $created_by_alias = null;
       var $modified = null;
       var $modified_by = null;
       var $checked_out = null;
       var $checked_out_time = null;
       var $publish_up = null;
       var $publish_down = null;
       var $images = null;
       var $urls = null;
       var $attribs = null;
       var $version = null;
       var $ordering = null;
       var $metakey= null;
       var $metadesc = null;
       var $access = null;
       var $hits = null;
       var $metadata =null;
      var $featured =null;
      var $language = null;
        var $xreference = null;

       function __construct(&$db) {
             parent::__construct('#__tz_pinboard_pins','id',$db);

       }

        /**
    	 * Override check function
    	 *
    	 * @return  boolean
    	 *
    	 * @see     JTable::check
    	 * @since   11.1
    	 */


    /**
    	 * Overridden JTable::store to set created/modified and user id.
    	 *
    	 * @param   boolean  $updateNulls  True to update fields even if they are null.
    	 *
    	 * @return  boolean  True on success.
    	 *
    	 * @since   11.1
    	 */

    public function load($keys = null, $reset = true)
    	{

    		if (empty($keys))
    		{
    			// If empty, use the value of the current key
    			$keyName = $this->_tbl_key;
    			$keyValue = $this->$keyName;

    			// If empty primary key there's is no need to load anything
    			if (empty($keyValue))
    			{
    				return true;
    			}

    			$keys = array($keyName => $keyValue);

    		}
    		elseif (!is_array($keys))
    		{
    			// Load by primary key.
    			$keys = array($this->_tbl_key => $keys);
    		}

    		if ($reset)
    		{
    			$this->reset();
    		}

    		// Initialise the query.
    		$query = $this->_db->getQuery(true);
    		$query->select('*');
    		$query->from($this->_tbl);
    		$fields = array_keys($this->getProperties());

    		foreach ($keys as $field => $value)
    		{
    			// Check that $field is in the table.
    			if (!in_array($field, $fields))
    			{
    				throw new UnexpectedValueException(sprintf('Missing field in database: %s &#160; %s.', get_class($this), $field));
    			}
    			// Add the search tuple to the query.
    			$query->where($this->_db->quoteName($field) . ' = ' . $this->_db->quote($value));
    		}

    		$this->_db->setQuery($query);

    		$row = $this->_db->loadAssoc();

    		// Check that we have a result.
    		if (empty($row))
    		{
    			return false;
    		}

    		// Bind the object with the row and return.
    		return $this->bind($row);
    	}
        protected function _getAssetName()
    	{
    		$k = $this->_tbl_key;
    		return 'com_tz_pinboard.article.' . (int) $this->$k;
    	}

    	/**
    	 * Method to return the title to use for the asset table.
    	 *
    	 * @return  string
    	 *
    	 * @since   11.1
    	 */
    	protected function _getAssetTitle()
    	{
    		return $this->title;
    	}

    	/**
    	 * Method to get the parent asset id for the record
    	 *
    	 * @param   JTable   $table  A JTable object (optional) for the asset parent
    	 * @param   integer  $id     The id (optional) of the content.
    	 *
    	 * @return  integer
    	 *
    	 * @since   11.1
    	 */
//    	protected function _getAssetParentId($table = null, $id = null)
//    	{
//    		$assetId = null;
//
//    		// This is a article under a category.
//    		if ($this->catid)
//    		{
//    			// Build the query to get the asset id for the parent category.
//    			$query = $this->_db->getQuery(true);
//    			$query->select($this->_db->quoteName('asset_id'));
//    			$query->from($this->_db->quoteName('#__tz_pinboard_category'));
//    			$query->where($this->_db->quoteName('id') . ' = ' . (int) $this->catid);
//
//    			// Get the asset id from the database.
//    			$this->_db->setQuery($query);
//    			if ($result = $this->_db->loadResult())
//    			{
//    				$assetId = (int) $result;
//    			}
//    		}
//
//    		// Return the asset id.
//    		if ($assetId)
//    		{
//    			return $assetId;
//    		}
//    		else
//    		{
//    			return parent::_getAssetParentId($table, $id);
//    		}
//    	}

    	/**
    	 * Overloaded bind function
    	 *
    	 * @param   array  $array   Named array
    	 * @param   mixed  $ignore  An optional array or space separated list of properties
    	 * to ignore while binding.
    	 *
    	 * @return  mixed  Null if operation was satisfactory, otherwise returns an error string
    	 *
    	 * @see     JTable::bind
    	 * @since   11.1
    	 */
    	public function bind($array, $ignore = '')
    	{

    		// Search for the {readmore} tag and split the text up accordingly.
    		if (isset($array['articletext']))
    		{
    			$pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
    			$tagPos = preg_match($pattern, $array['articletext']);

    			if ($tagPos == 0)
    			{
    				$this->introtext = $array['articletext'];
    				$this->fulltext = '';
    			}
    			else
    			{
    				list ($this->introtext, $this->fulltext) = preg_split($pattern, $array['articletext'], 2);
    			}
    		}

    		if (isset($array['attribs']) && is_array($array['attribs']))
    		{
    			$registry = new JRegistry;
    			$registry->loadArray($array['attribs']);
    			$array['attribs'] = (string) $registry;
    		}

    		if (isset($array['metadata']) && is_array($array['metadata']))
    		{
    			$registry = new JRegistry;
    			$registry->loadArray($array['metadata']);
    			$array['metadata'] = (string) $registry;
    		}

    		// Bind the rules.
    		if (isset($array['rules']) && is_array($array['rules']))
    		{
    			$rules = new JAccessRules($array['rules']);
    			$this->setRules($rules);
    		}

    		return parent::bind($array, $ignore);
    	}

    	/**
    	 * Overloaded check function
    	 *
    	 * @return  boolean  True on success, false on failure
    	 *
    	 * @see     JTable::check
    	 * @since   11.1
    	 */
    	public function check()
    	{
    		if (trim($this->title) == '')
    		{
    			$this->setError(JText::_('COM_CONTENT_WARNING_PROVIDE_VALID_NAME'));
    			return false;
    		}

    		if (trim($this->alias) == '')
    		{
    			$this->alias = $this->title;
    		}

    		$this->alias = JApplication::stringURLSafe($this->alias);

    		if (trim(str_replace('-', '', $this->alias)) == '')
    		{
    			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
    		}

    		if (trim(str_replace('&nbsp;', '', $this->fulltext)) == '')
    		{
    			$this->fulltext = '';
    		}

    		// Check the publish down date is not earlier than publish up.
    		if ($this->publish_down > $this->_db->getNullDate() && $this->publish_down < $this->publish_up)
    		{
    			// Swap the dates.
    			$temp = $this->publish_up;
    			$this->publish_up = $this->publish_down;
    			$this->publish_down = $temp;
    		}

    		// Clean up keywords -- eliminate extra spaces between phrases
    		// and cr (\r) and lf (\n) characters from string
    		if (!empty($this->metakey))
    		{
    			// Only process if not empty

    			// Array of characters to remove
    			$bad_characters = array("\n", "\r", "\"", "<", ">");

    			// Remove bad characters
    			$after_clean = JString::str_ireplace($bad_characters, "", $this->metakey);

    			// Create array using commas as delimiter
    			$keys = explode(',', $after_clean);

    			$clean_keys = array();

    			foreach ($keys as $key)
    			{
    				if (trim($key))
    				{
    					// Ignore blank keywords
    					$clean_keys[] = trim($key);
    				}
    			}
    			// Put array back together delimited by ", "
    			$this->metakey = implode(", ", $clean_keys);
    		}

    		return true;
    	}

    	/**
    	 * Overrides JTable::store to set modified data and user id.
    	 *
    	 * @param   boolean  $updateNulls  True to update fields even if they are null.
    	 *
    	 * @return  boolean  True on success.
    	 *
    	 * @since   11.1
    	 */
    	public function store($updateNulls = false)
    	{

    		$date = JFactory::getDate();
    		$user = JFactory::getUser();

    		if ($this->id)
    		{
    			// Existing item
    			$this->modified = $date->toSql();
    			$this->modified_by = $user->get('id');

    		}
    		else
    		{

    			// New article. An article created and created_by field can be set by the user,
    			// so we don't touch either of these if they are set.
    			if (!(int) $this->created)
    			{

    				$this->created = $date->toSql();

    			}

    			if (empty($this->created_by))
    			{
    				$this->created_by = $user->get('id');

    			}
    		}

    		// Verify that the alias is unique
    		$table = JTable::getInstance('Tz_Pins', 'Table', array('dbo' => $this->getDbo()));

    		if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
    		{
    			$this->setError(JText::_('JLIB_DATABASE_ERROR_ARTICLE_UNIQUE_ALIAS'));
    			return false;
    		}

    		return parent::store($updateNulls);
    	}

    	/**
    	 * Method to set the publishing state for a row or list of rows in the database
    	 * table. The method respects checked out rows by other users and will attempt
    	 * to checkin rows that it can after adjustments are made.
    	 *
    	 * @param   mixed    $pks     An optional array of primary key values to update.  If not set the instance property value is used.
    	 * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published]
    	 * @param   integer  $userId  The user id of the user performing the operation.
    	 *
    	 * @return  boolean  True on success.
    	 *
    	 * @since   11.1
    	 */
    	public function publish($pks = null, $state = 1, $userId = 0)
    	{
    		$k = $this->_tbl_key;

    		// Sanitize input.
    		JArrayHelper::toInteger($pks);
    		$userId = (int) $userId;
    		$state = (int) $state;

    		// If there are no primary keys set check to see if the instance key is set.
    		if (empty($pks))
    		{
    			if ($this->$k)
    			{
    				$pks = array($this->$k);
    			}
    			// Nothing to set publishing state on, return false.
    			else
    			{
    				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
    				return false;
    			}
    		}

    		// Build the WHERE clause for the primary keys.
    		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

    		// Determine if there is checkin support for the table.
    		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
    		{
    			$checkin = '';
    		}
    		else
    		{
    			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
    		}

    		// Get the JDatabaseQuery object
    		$query = $this->_db->getQuery(true);

    		// Update the publishing state for rows with the given primary keys.
    		$query->update($this->_db->quoteName($this->_tbl));
    		$query->set($this->_db->quoteName('state') . ' = ' . (int) $state);
    		$query->where('(' . $where . ')' . $checkin);
    		$this->_db->setQuery($query);

    		try
    		{
    			$this->_db->execute();
    		}
    		catch (RuntimeException $e)
    		{
    			$this->setError($e->getMessage());
    			return false;
    		}

    		// If checkin is supported and all rows were adjusted, check them in.
    		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
    		{
    			// Checkin the rows.
    			foreach ($pks as $pk)
    			{
    				$this->checkin($pk);
    			}
    		}

    		// If the JTable instance value is in the list of primary keys that were set, set the instance.
    		if (in_array($this->$k, $pks))
    		{
    			$this->state = $state;
    		}

    		$this->setError('');

    		return true;
    	}
//    public function getKeyName()
//    {
//        return $this->_tbl_key;
//    }
}
