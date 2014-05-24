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
defined("_JEXEC") or die;
jimport('joomla.application.component.view');
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tz_pinboard.php');
class TZ_PinboardViewBoard extends JViewLegacy
{

    function display($tpl = null)
    {
        $state = $this->get('State');
        $listOrder = $state->get('lab1');
        $listDirn = $state->get('lab2');
        $this->assign('state1', $listOrder);
        $this->assign('state2', $listDirn);
        $status = $state->get('status');
        $search = $state->get('search');
        $this->assign('search', $search);

        $this->assign('star', $status);
        $this->assign('More', $this->get('More'));
        $this->assign('board', $this->get('Board'));
        $this->assign('pagination', $this->get('Pagination'));
        $this->assign('authors', $this->get('Authors'));
        $task = JRequest::getCmd('task');

        switch ($task) {
            case'more':
            case'edit':
                $this->addMoreTookBar();
                break;
            default:
                $this->addTookBar();
                TZ_PinboardHelper::addSubmenu('board');
                $this->sidebar = JHtmlSidebar::render();
                break;
        }
        parent::display($tpl);
    }

    function addTookBar()
    {
        JToolbarHelper::title(JText::_('Pin Board'), 'article.png');
        JToolbarHelper::editList();
        JToolbarHelper::publishList();
        JToolbarHelper::unpublishList();
        JToolbarHelper::deleteList('COM_TZ_PINBOARD_QUESTION_DELETE');
        JToolBarHelper::preferences('com_tz_pinboard');
        JToolbarHelper::cancel();
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_AUTHOR'),
            'filter_author_id',
            JHtml::_('select.options', $this->authors, 'value', 'text', $this->get('State')->get('autho'), true)
        );
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published',
            JHtml::_('select.options', $this->publicc(), 'value', 'text', $this->get('State')->get('status'), true)

        );
    }

    function addMoreTookBar()
    {
        JToolbarHelper::title(JText::_('Pin Board'), 'article.png');
        JToolBarHelper::preferences('com_tz_pinboard');
        JToolbarHelper::cancel();
    }

    protected function getSortFields()
    {
        return array(

            'tz.title' => JText::_('Title'),
            'tz.author' => JText::_('Author'),
            'tz.date' => JText::_('Date'),
            'tz.state' => JText::_('Status'),
            'tz.id' => JText::_('JGRID_HEADING_ID')
        );
    }

    function publicc()
    {
        return array(
            '1' => JText::_('Public'),
            '0' => JText::_('unpublish'),
        );

    }


}

?>