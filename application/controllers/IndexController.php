<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //Create Session Namespace object & check if Session is Created or not
        $oNamespace = new Zend_Session_Namespace('sess_admin');        
       	$this->view->ssLoginUserName = $ssLoginUserName = $oNamespace->__get('admin_name');
    }



}



