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


class TZ_PinboardControllerTags extends JControllerAdmin{


    private $model;


    function display(){

        $doc            =   &JFactory::getDocument();
        $type           =   $doc->getType();
        $view           =   &$this->getView('tags',$type);
        $this->model    =   &$this->getModel('tags');
        $view->setModel($this->model,true);
        $task           = JRequest::getCmd('task');
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

            case'tz_more_repins':
                echo $this->model->ajaxChitetiPins();
                die();
                break;

            case'tz.insert.commnet_cm':
                echo json_encode($this->model->ajaxcommnet_cm());
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