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

/**
 * View to edit an article.
 *
 */
class TZ_PinboardViewArticle extends JViewLegacy
{
    protected $form;
    protected $item;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $params = JComponentHelper::getParams('com_tz_pinboard');
        $img_size = $params->get('portfolio_image_size');
        $this->assign('img_size', $img_size);

        if (JRequest::getCmd('task') != 'lists') {
            JFactory::getLanguage()->load('com_content');
            if ($this->getLayout() == 'pagebreak') {
                // TODO: This is really dogy - should change this one day.
                $eName = JRequest::getVar('e_name');
                $eName = preg_replace('#[^A-Z0-9\-\_\[\]]#i', '', $eName);
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('COM_CONTENT_PAGEBREAK_DOC_TITLE'));
                $this->assignRef('eName', $eName);
                parent::display($tpl);
                return;
            }

            // Initialiase variables.
            $this->form = $this->get('Form');
            $this->item = $this->get('Item');
            $this->state = $this->get('State');

            $this->canDo = TZ_PinboardHelper::getActions($this->state->get('filter.category_id'));

            // Check for errors.
            if (count($errors = $this->get('Errors'))) {
                JError::raiseError(500, implode("\n", $errors));
                return false;
            }
            $this->assign('listsGroup', $this->get('FieldsGroup'));
            $this->assign('listsTags', $this->get('Tags'));
            $this->assign('listAttach', $this->get('Attachment'));
            $this->assign('listEdit', $this->get('FieldsContent'));


            $this->addToolbar();
        }
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since    1.6
     */
    protected function addToolbar()
    {
        JRequest::setVar('hidemainmenu', true);
        $user = JFactory::getUser();
        $userId = $user->get('id');
        $isNew = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
        $canDo = TZ_PinboardHelper::getActions($this->state->get('filter.category_id'), $this->item->id);
        JToolBarHelper::title(JText::_('COM_CONTENT_PAGE_' . ($checkedOut ? 'VIEW_ARTICLE' : ($isNew ? 'ADD_ARTICLE' : 'EDIT_ARTICLE'))), 'article-add.png');

        // Built the actions for new and existing records.

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_content', 'core.create')) > 0)) {
            JToolBarHelper::save('article.save');
            JToolBarHelper::cancel('article.cancel');
        } else {
            // Can't save the record if it's checked out.
            if (!$checkedOut) {
                // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
                if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
                    // We can save this record, but check the create permission to see if we can return to make a new one.
                    if ($canDo->get('core.create')) {
                    }
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
            }

            JToolBarHelper::cancel('article.cancel', 'JTOOLBAR_CLOSE');
        }

        JToolBarHelper::divider();
    }
}
