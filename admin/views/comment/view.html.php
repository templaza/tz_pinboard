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
defined('_JEXEC') or die;
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tz_pinboard.php');
class TZ_PinboardViewComment extends JViewLegacy
{
    function display($tpl = null)
    {
        $state = $this->get('State');
        $states = $state->get('state');
        $search = $state->get('search');
        $this->assign('searchs', $search);
        $aut = $state->get('autho');
        $listOrder = $state->get('lab1');
        $listDirn = $state->get('lab2');
        $this->assign('state1', $listOrder);
        $this->assign('statess', $states);
        $this->assign('state2', $listDirn);
        $this->assign('author', $aut);
        $this->assign('authors', $this->get('Authors'));
        $this->assign('contents', $this->get('Contents'));
        $this->assign('pagination', $this->get('Pagination'));
        $this->assign('More', $this->get('More'));
        $task = JRequest::getCmd('task');
        switch ($task) {
            case'more':
                $this->addMoreTookBar();
                break;
            default:
                $this->addTookBar();
                TZ_PinboardHelper::addSubmenu('comment');
                $this->sidebar = JHtmlSidebar::render();

                break;
        }

        parent::display($tpl);
    }

    function addTookBar()
    {
        JToolbarHelper::title(JText::_('comment'), 'article.png');
        JToolbarHelper::editList();
        JToolbarHelper::publishList();
        JToolbarHelper::unpublishList();
        JToolbarHelper::deleteList('COM_TZ_PINBOARD_COMMENT_MORE_DELETE');
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
            JHtml::_('select.options', $this->publicc(), 'value', 'text', $this->get('State')->get('state'), true)

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

            'tz.content' => JText::_('COM_TZ_PINBOARD_COMMENT_CONTENT'),
            'tz.author' => JText::_('COM_TZ_PINBOARD_COMMENT_AUTHOR'),
            'tz.date' => JText::_('COM_TZ_PINBOARD_COMMENT_DATE'),
            'tz.ip' => JText::_("COM_TZ_PINBOARD_COMMENT_TP"),
            'tz.check' => JText::_('COM_TZ_PINBOARD_COMMENT_MORE_CHECKIP'),
            'tz.contentid' => JText::_('COM_TZ_PINBOARD_COMMENT_CONTENTID'),
            'tz.id' => JText::_('JGRID_HEADING_ID')
        );
    }

    function publicc()
    {
        return array(
            '1' => JText::_('COM_TZ_PINBOARD_COMMENT_PUBLISH'),
            '0' => JText::_('COM_TZ_PINBOARD_COMMENT_UNPUBLISH'),
        );

    }

}

?>