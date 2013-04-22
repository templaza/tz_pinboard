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


class TZ_PinboardControllerPinboard extends JControllerAdmin{


    private $model;

    function display($cachable=false,$urlparams=array()){
        $doc    = JFactory::getDocument();
        $type   = $doc->getType();
        $view   = $this->getView('pinboard',$type);
        $this   -> model = $this->getModel('pinboard');
        $view   -> setModel($this->model,true);
        $task   = JRequest::getCmd('task');

        switch($task){
            case'tz.pin.like':
                echo $this->model->inserLike();
                die();
                break;

            case'tz.pin.unlike':
                echo $this->model->insertUnlike();
                die();
                break;

            case'add_ajax':
                echo $this->model->PinAjax();
                die();
                break;

            case'tz_repin':
                echo  $this->model->ajaxRepins();
                die();
                break;

            case'tz_repin_insert':
                echo  $this->model->insertRepinAll();
                die();
                break;

            case'tz.insert.comment_cm':
                echo json_encode($this->model->ajaxcomment_cm());
                die();
                break;
            case'tz.pt.cm':
                echo $this->model->ajaxPTComment();
                die();
                break;
            case'ActiviAjax':
                echo $this->model->AjaxActive();
                die();
                break;
            case'TzApprover':
                echo $this->model->ApprovePin();
                die();
                break;
            default:
                $view->setLayout('default');
                break;
        }

        $view->display($tpl=null);
    }


}
?>