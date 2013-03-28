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

class Tz_pinboardControllerAddpinboards extends JControllerForm{

    protected  $model;
    protected  $view;

    function display($cachable=false,$urlparams=array()){
        $doc    = JFactory::getDocument();
        $type   = $doc->getType();
        $this   -> view = $this->getView('addpinboards',$type);
        $this   -> model = $this->getModel('addpinboards');
        $this   -> view->setModel($this->model,true);
        $task   = JRequest::getString("task");

        switch($task){
            case'add_pin_local':
                $this->model->getUpload();
                die();
                break;

            case'add_pin_website':
                echo  json_encode($this->model->ajaxUploadweb());
                die();
                break;

            case'task_upload_pin':
                $this->PinWeb();
                break;

            case'upload.local.pin':
                $this->Pinlocal();
                break;

            case'tz.insert.board':
                $this->InsertCategory_board();
                break;

            default:
                $this->view->setLayout('default');
                break;
        }
        $this->view->display();
    }

    /*
     * method get Pin to web
    */
    function PinWeb(){
        $id_pins  = $this->model->InsertPinHost();
        $url      =   JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($id_pins));
        $red      = JFactory::getApplication();
        $red->redirect($url);
    }

    /*
     * method get Pin to local
     */
    function Pinlocal(){
        $id_pins    =  $this->model->InsertLocal();
        if($id_pins == false || empty($id_pins)){
            $id_pins =   "f";
        }
        $url        =   JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($id_pins));
        $red        = JFactory::getApplication();
        $red->redirect($url);
    }

    /*
     * method insert board
    */
    function InsertCategory_board(){
        $this   ->  model->InsertCategory();
        $url    =   JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute());
        $red    =   JFactory::getApplication();
        $red->redirect($url);
    }
}

?>