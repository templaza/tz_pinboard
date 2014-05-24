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

jimport('joomla.application.component.view');

class TZ_PinboardViewUsers extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        require_once(JPATH_COMPONENT . '/helpers/users.php');
        JFactory::getLanguage()->load('com_users');

        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        TZ_PinboardHelper::addSubmenu('users');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        // Include the component HTML helpers.
        JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since    1.6
     */
    protected function addToolbar()
    {
        $canDo = TZ_PinboardHelperUsers::getActions();

        JToolBarHelper::title(JText::_('COM_USERS_VIEW_USERS_TITLE'), 'user');

        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('user.add');
        }
        if ($canDo->get('core.edit')) {
            JToolBarHelper::editList('user.edit');
        }
        if ($canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'users.delete');
            JToolBarHelper::divider();
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_tz_pinboard');
            JToolBarHelper::divider();
        }

        JToolBarHelper::help('JHELP_USERS_USER_MANAGER');
        JHtmlSidebar::setAction('index.php?option=com_users&view=users');

        JHtmlSidebar::addFilter(
            JText::_('COM_USERS_FILTER_STATE'),
            'filter_state',
            JHtml::_('select.options', TZ_PinboardHelperUsers::getStateOptions(), 'value', 'text', $this->state->get('filter.state'))
        );
    }
}
