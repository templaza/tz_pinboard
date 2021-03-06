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

jimport('joomla.application.component.controlleradmin');

/**
 * The Categories List Controller.
 */
class TZ_PinboardControllerCategories extends JControllerAdmin
{
    function __construct($config = array())
    {
        JFactory::getLanguage()->load('com_categories');
        parent::__construct($config);
    }

    /**
     * Proxy for getModel
     *
     * @param    string $name The model name. Optional.
     * @param    string $prefix The class prefix. Optional.
     *
     * @return    object    The model.
     * @since    1.6
     */
    function getModel($name = 'Category', $prefix = 'TZ_PinboardModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }

    /**
     * Rebuild the nested set tree.
     *
     * @return    bool    False on failure or error, true on success.
     * @since    1.6
     */
    public function rebuild()
    {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $extension = JRequest::getCmd('extension');
        $this->setRedirect(JRoute::_('index.php?option=com_tz_pinboard&view=categories&extension=' . $extension, false));

        // Initialise variables.
        $model = $this->getModel();

        if ($model->rebuild()) {
            // Rebuild succeeded.
            $this->setMessage(JText::_('COM_CATEGORIES_REBUILD_SUCCESS'));
            return true;
        } else {
            // Rebuild failed.
            $this->setMessage(JText::_('COM_CATEGORIES_REBUILD_FAILURE'));
            return false;
        }
    }

    /**
     * Save the manual order inputs from the categories list page.
     *
     * @return    void
     * @since    1.6
     */
    public function saveorder()
    {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get the arrays from the Request
        $order = JRequest::getVar('order', null, 'post', 'array');
        $originalOrder = explode(',', JRequest::getString('original_order_values'));

        // Make sure something has changed
        if (!($order === $originalOrder)) {
            parent::saveorder();
        } else {
            // Nothing to reorder
            $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
            return true;
        }
    }

    /**
     * Method to save the submitted ordering values for records via AJAX.
     *
     * @return    void
     *
     * @since   3.0
     */
    public function saveOrderAjax()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get the arrays from the Request
        $pks = $this->input->post->get('cid', null, 'array');
        $order = $this->input->post->get('order', null, 'array');
        $originalOrder = explode(',', $this->input->getString('original_order_values'));

        // Make sure something has changed
        if (!($order === $originalOrder)) {
            // Get the model
            $model = $this->getModel();
            // Save the ordering
            $return = $model->saveorder($pks, $order);
            if ($return) {
                echo "1";
            }
        }
        // Close the application
        JFactory::getApplication()->close();

    }
}
