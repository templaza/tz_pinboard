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

class TZ_PinboardControllerComment extends JControllerAdmin
{
    function display($cachable = false, $urlparams = array())
    {

        $doc = JFactory::getDocument();
        $type = $doc->getType();
        $view = $this->getView('comment', $type);
        $model = $this->getModel('comment');
        $view->setModel($model, true);
        $task = JRequest::getCmd('task');

        switch ($task) {
            case'remove':
                $model->delete();
                break;
            case'publish':
            case'comment.publish':
                $model->publish();
                break;
            case'unpublish':
            case'comment.unpublish':
                $model->unpulich();
                break;
            case'more':
                $view->setLayout('more');
                break;
            case'check.unpublish':
                $model->unpulichIP();
                break;
            case'check.publish':
                $model->publishIP();
                break;
            default:
                $view->setLayout('default');
                break;
        }

        $view->display();

    }
}

?>