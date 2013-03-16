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

class Tz_pinboardControllerManageruser extends JControllerForm{


    private $model;


    function display(){
            $doc            = JFactory::getDocument();
            $type           = $doc->getType();
            $view           = $this->getView('manageruser',$type);
            $this->model    = $this->getModel('manageruser');
            $view->setModel($this->model,true);
            $task           = JRequest::getCmd('task');
            switch($task){
                case'tz.edit':
                    $view->setLayout('edit_board');
                    break;

                case'tz.update':
                    $this -> UpDateBoard();
                    $view->setLayout('boars');
                    break;

                case'tz.delete':
                    $this->Tz_deleteboard();
                    $view->setLayout('boars');
                    break;

                case'tz.more.board':
                    $view->setLayout('more_board');
                    break;

                case'tz.edit.pins':
                    $view->setLayout('edit_pins');
                    break;

                case'tz.update.pins':
                    $this->UpdatePinss();
                    break;

                case'tz.delete.pins':
                    $this->deletePinss();
                    break;

                case'tz.more.pins':
                    $view->setLayout('default_more_pins');
                    break;

//                case'tz.pin.like':
//                    echo $this->model->inserLike();
//                    die();
//                    break;
//
//                case'tz.pin.unlike':
//                    echo $this->model->insertUnlike();
//                    die();
//                    break;

                case'tz.pin.follow':
                    echo $this->model->inserFollow();
                    die();
                    break;

                case'tz.pin.unfollow':
                    $this->model->insertUnfollow();
                    die();
                    break;

                case'tz.follow':
                    $view->setLayout('boars');
                    break;

                case'tz.insert.board':
                    $this->model->InsertBoard();
                    $view->setLayout('boars');
                    break;

                case'pins':
                    $view->setLayout('pins');
                    break;

                case'likes':
                    $view->setLayout('likes');
                    break;

                case'followers':
                    $view->setLayout('followers');
                    break;

                case'following':
                    $view->setLayout('following');
                    break;

//                case'tz.insert.commnet':
//                    echo $this->model->ajaxCommnet();
//                    die();
//                    break;
//
//                case'tz.delete.commnet':
//                    echo $this->model->ajaxdeletecommnet();
//                    die();
//                    break;
//
//                case'tz.ajax.pt.cm':
//                    echo $this->model->ajaxphantrangCommnet();
//                    die();
//                    break;
//
//                case'tz.insert.commnet_cm':
//                    echo json_encode($this->model->ajaxcommnet_cm());
//                    die();
//                    break;

                default:
                    $view->setLayout('boars');
                    break;
                }
            $view->display();
    }

    /*
     * method update board
     */
    function UpDateBoard(){
        if($this->model->getUpadateboard()){
            $url =JRoute::_('index.php?option=com_tz_pinboard&view=manageruser');
            $red = JFactory::getApplication();
            $red->redirect($url);
        }
    }

    /*
     * method delete board
    */
    function Tz_deleteboard(){
        $this->model->delteboard();
        $url =JRoute::_('index.php?option=com_tz_pinboard&view=manageruser');
        $red = JFactory::getApplication();
        $red->redirect($url);
    }

    /*
     * method update pins
    */
    function UpdatePinss(){
        $id_board = $this->model->updatePins();
        $url =   JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute());
        $red = JFactory::getApplication();
        $red->redirect($url);
    }

    /*
     * method delete pins
    */
    function deletePinss(){
        $id_board = $this->model->deletePins();
        $url =JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.more.board&id_board='.$id_board);
        $red = JFactory::getApplication();
        $red->redirect($url);
    }



}
?>

