<?php
/**
 * Admin_IndexController supports features like 
 * displaying home Page
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 */
class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	/*
	 * @Description : For Listing 
	 */
    public function indexAction()
    {
    	//Create Session Namespace object & check if Session is Created or not
        $oNamespace = new Zend_Session_Namespace('sess_admin');        
       	$ss__adminname = $oNamespace->__get('admin_name');
       	$ss__adminid = $oNamespace->__get('aid');
       	
       	//If Sessesion Not Created then Redirect to Login
       	if(empty($ss__adminname))
            $this->_redirect('admin/login');
 		
 		//For Display Admin Name in View     
        $this->view->admin_name = $ss__adminname;
        $this->view->aid = $ss__adminid;
    }


}

