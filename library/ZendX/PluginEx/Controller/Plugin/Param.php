<?php
class ZendX_PluginEx_Controller_Plugin_Param extends Zend_Controller_Plugin_Abstract
{
	
  	protected $_param;
 
    private $_userID;
 
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
		 /*
         * we start session here
         * so we do not need to start it in each action, controller or module
         */
        Zend_Session::start();
 
        /*
         * we create session with namespace 'sess_admin'
         */
        $namespace = new Zend_Session_Namespace('sess_admin'); 
 		
        $this->_userID = $namespace->aid;
        
        if(empty($this->_userID)) 
        {
        	$request->setModuleName('admin')->setControllerName('login');
        }
	}
}
