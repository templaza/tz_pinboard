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


class TZ_PinboardControllerDetail  extends JControllerAdmin{

    function display($cachable=false,$urlparams=array()){
        $type   = JFactory::getDocument();
        $html   = $type->getType();
        $view   = $this->getView('detail',$html);
        $model  = $this->getModel('detail');
        $view   -> setModel($model,true);
        $task   = JRequest::getCmd('task');

        switch($task){
            case'tz.insert.comment':
                echo json_encode($model->ajaxcomment());
                die();
                break;

            case'tz.delete.comment':
                echo json_encode($model->ajaxdeletecomment());
                die();
                break;

            case'tz.ajax.pt.cm':
                echo $model->ajaxphantrangcomment();
                die();
                break;

            case'tz.detail.pins':
                echo $model->ajaxDetail();
                die();
                break;

            case'tz.pin.follow':
                $model->inserFollow();
                die();
                break;

            case'tz.pin.unfollow':
                $model->insertUnfollow();
                die();
                break;

            default:
                $view->setLayout('default');
                break;
        }

        $view->display();
    }
}

?>