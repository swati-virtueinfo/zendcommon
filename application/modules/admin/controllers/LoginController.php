<?php
/**
 * Admin_LoginController supports features like 
 * displaying Login Page,Check Admin Authentication
 * Admin Logout,Admin Change Password.
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 */
class Admin_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

	//For Display Login Form
    public function indexAction()
    { 
        //Create Form Object & Assign Form to View
        $this->view->form = $oForm = new Admin_Form_Login();
    }

    //For Admin Authentication
    public function logincheckAction()
    {
       //create form Object & assign form to view
       $this->view->form = $oForm = new Admin_Form_Login();
       
       //Assigning a request Object
       $oRequest = $this->getRequest();
       
       //checking method is Post
       if($oRequest->isPost())
       {
			//checking post value is valid
			if($oForm->isValid($oRequest->getPost()))
			{
				//Call _getAuthAdapter() Method for Authenticate form value
				$oAuthAdapter = $this->_getAuthAdapter($oForm->getValues());
				
				//Object Creation of Zend_Auth
				$oAuth = Zend_Auth::getInstance();
				
				//Authenticate Admin
				$oResult = $oAuth->authenticate($oAuthAdapter);
				
				//checking credential is valid
				if($oResult->isValid())
				{
					$oAuthData = $oAuthAdapter->getResultRowObject();
							       		
		       		// For registring session namespace
		          	$oAdminSessionNamespace = new Zend_Session_Namespace('sess_admin');
		          	$oAdminSessionNamespace->setExpirationSeconds(18000);
		          	
		          	// set Session Variable 
		         	$oAdminSessionNamespace->__set('admin_name',$oAuthData->email);
		         	$oAdminSessionNamespace->__set('aid',$oAuthData->id);

		         	if ($oRequest->getParam('module') != 'admin' && $oRequest->getParam('controller') != 'login') {
		         		$ssUrl = $this->getRequest()->getServer('HTTP_REFERER');
		         	} else { 
		         		$ssUrl = $this->_redirect('admin/index');
		         	}
		         	$this->_redirect($ssUrl);		         	          	
				}
				else{
					// For setting error message for invalid username password
					 $this->_helper->flashMessenger->addMessage(array("msg_Invalid_Email_or_password"));
					$this->_redirect('admin/login');
				}
			}
      	}
      	  $this->render('index');
    }

	//for get Auth Adapter
    protected function _getAuthAdapter($asValues = array ())
    {
    	/*
    	 * For Doctrine 
    	 */
    	//Object creation of ZendX_Doctrine_Auth_Adapter
    	$oAuthAdapter = new ZendX_Doctrine_Auth_Adapter();
    	
    	//Assigning encrypted Password In MD5 & SHA1
    	$smEncryptPassword = (SHA1(MD5($asValues['password'])));
    	
    	//setting Auth Adapter parameter for Authentication
    	$oAuthAdapter->setTableName('Model_Admin A')
    				   ->setIdentityColumn('A.email')
    				   ->setCredentialColumn('A.password')
    				   ->setIdentity($asValues['email'])
    				   ->setCredential($smEncryptPassword);
    				   
    	//return Auth Adapter Object
    	return $oAuthAdapter; 
    	
    	/*
    	 * For DB Table 
    	 
		//Object creationof Admin Table    	
	    $oAdminTable  = new Application_Model_DbTable_Admin();
	    
	    //Assigning encrypted Password In MD5 & SHA1
	    $smEncryptPassword = (SHA1(MD5($asValues['password'])));
	    
	    //setting Auth Adapter parameter for Authentication
       	$oAuthAdapter = new Zend_Auth_Adapter_DbTable($oAdminTable->getAdapter());
		$oAuthAdapter->setTableName('admin');
	    $oAuthAdapter->setIdentityColumn('email');
       	$oAuthAdapter->setCredentialColumn('password');      
       	$oAuthAdapter->setIdentity($asValues['email']);
   		$oAuthAdapter->setCredential($smEncryptPassword);
   		
   		//return Auth Adapter Object
    	return $oAuthAdapter; */
    }

	//For Logout
    public function logoutAction()
    {
    	//Create Session Storage Object & Unset Session Namespace 
       	$oStorageSession = new Zend_Auth_Storage_Session('sess_admin');
 		$oStorageSession = Zend_Session:: namespaceUnset('sess_admin');
 		
 		//After Session Namespace Unset Redirect To Admin Login
        $this->_redirect('admin/login');
       
    }

	// For Change password
    public function changepasswordAction()
    {
        $snAid = $this->getRequest()->getParam('id');
        $this->view->id = $snAid;
        //Create Form Object & Assign Form to View
        $this->view->form = $oForm = new Admin_Form_Changepass();
        
    }

	// For Check Change Password
	public function changepasscheckAction()
    {
       //create form Object & assign form to view
       $this->view->form = $oForm = new Admin_Form_Changepass();
       
       //Assigning a request Object
       $oRequest = $this->getRequest();
       
       //checking method is Post
       if($oRequest->isPost())
       {
			//checking post value is valid
			if($oForm->isValid($oRequest->getPost()))
			{
	       		$amFormData = $oRequest->getPost();
	       		$snAdminId = $amFormData['id'];
	       		$smOldPassword = SHA1(MD5($amFormData['oldpassword']));
	       		$smNewPassword = SHA1(MD5($amFormData['newpassword']));
	       		$smConfirmPassword = SHA1(MD5($amFormData['confirmpassword']));
	       		
	       		//If New Password & Confirm Password not Match Redirect to Form Then Give Error
	       		if ($smNewPassword !== $smConfirmPassword) {
	            	$this->_helper->flashMessenger->addMessage(array('msg_Password_and_confirmation_do_not_match.'));
	                $this->_redirect('admin/login/changepassword/id/'.$snAdminId);
	            }
	            else
	            {
	            	$asFetchedOldpassword = Doctrine::getTable('Model_Admin')->getAdminRecordById($snAdminId);
					
	            	if($asFetchedOldpassword['password'] == $smOldPassword)	
	            	{
	            		$bResult = Doctrine::getTable('Model_Admin')->changeAdminPassword($smNewPassword,$snAdminId); 
	            		if($bResult){
	            			$this->_helper->flashMessenger->addMessage(array('msg_Your_password_changed_successfully.'));	
	            		}
	            		else
	            		{
	            			$this->_helper->flashMessenger->addMessage(array('msg_Password_Not_Changed_Pls_Try_Again'));
	            		}
	            		$this->_redirect('admin/login/changepassword/id/'.$snAdminId);
	            	}
	            	else
	            	{
	            		$this->_helper->flashMessenger->addMessage(array('msg_Your_Old_Password_Not_Matched.'));
	                	$this->_redirect('admin/login/changepassword/id/'.$snAdminId);
	            	}
	            }
	   		}
       }
       	$this->render('changepassword');
    }
}