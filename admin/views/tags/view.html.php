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

//no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class TZ_PinboardViewTags extends JViewLegacy
{
    public $_task = null;

    function display($tpl = null)
    {
        $this->_task = JRequest::getCmd('task');

        $this->state = $this->get('State');

        if ($this->getLayout() !== 'modal') {
            TZ_PinboardHelper::addSubmenu('tags');
        }

        $editor = JFactory::getEditor();
        $this->assign('editor', $editor);
        $this->assign('order', $this->state->filter_order);
        $this->assign('order_Dir', $this->state->filter_order_Dir);
        $this->assign('filter_state', $this->state->filter_state);
        $this->assign('lists', $this->get('Lists'));
        $this->assign('listEdit', $this->get('Edit'));
        $this->assign('pagination', $this->get('Pagination'));

        $this->setToolbar();
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    function setToolbar()
    {
        switch ($this->_task) {
            default:
                JToolBarHelper::title(JText::_('Tags Manager'));
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::publishList();
                JToolBarHelper::unpublishList();
                JToolBarHelper::divider();
                JToolBarHelper::deleteList(JText::_('COM_TZ_PINBOARD_QUESTION_DELETE'));
                JToolBarHelper::preferences('com_tz_pinboard');
                break;
            case 'add':
            case 'new':
                JRequest::setVar('hidemainmenu', true);
                JToolBarHelper::title(JText::_('Tags Manager: <small><small>'
                    . JText::_(ucfirst($this->_task)) . '</small></small>'));
                JToolBarHelper::save2new();
                JToolBarHelper::save();
                JToolBarHelper::apply();
                JToolBarHelper::cancel();
                break;
            case 'edit':
                JRequest::setVar('hidemainmenu', true);
                JToolBarHelper::title(JText::_('Tags Manager: <small><small>'
                    . JText::_(ucfirst(JRequest::getCmd('task'))) . '</small></small>'));
                JToolBarHelper::save();
                JToolBarHelper::apply();
                JToolBarHelper::cancel('cancel', JText::_('JTOOLBAR_CLOSE'));
                break;

        }
        $state = array('P' => JText::_('JPUBLISHED'), 'U' => JText::_('JUNPUBLISHED'));
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_state',
            JHtml::_('select.options', $state, 'value', 'text', $this->state->filter_state)
        );

    }

    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields()
    {
        return array(
            'published' => JText::_('JSTATUS'),
            'name' => JText::_('COM_TZ_PINBOARD_TAG_NAME'),
            'id' => JText::_('JGRID_HEADING_ID')
        );
    }
}
 
