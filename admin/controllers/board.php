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
class TZ_PinboardControllerBoard extends JControllerForm
{
    function display($cachable = false, $urlparams = array())
    {
        $task = JRequest::getCmd('task');
        $doc = JFactory::getDocument();
        $type = $doc->getType();
        $view = $this->getView('board', $type);
        $model = $this->getModel('board');
        $view->setModel($model, true);

        switch ($task) {
            case'more':
            case'edit':
                $view->setLayout('more');
                break;
            case'publish':
            case'boards.publish':
                $model->publish();
                break;
            case'unpublish':
            case'boards.unpublish':
                $model->unpulich();
                break;
            case'remove':
                $model->delete();
                break;
            default:
                $view->setLayout('default');
                break;
        }

        $view->display();
    }

}

?>