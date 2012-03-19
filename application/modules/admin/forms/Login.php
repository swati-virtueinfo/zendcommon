<?php
/**
 * Admin_Form_Login
 * Admin Login Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Admin_Form_Login extends Zend_Form
{
    public function init()
    {
    	//Set username textbox
        $oUserNameTextbox = new Zend_Form_Element_Text("email");
        $oUserNameTextbox->setLabel($this->getTranslator()->_("lbl_email"))
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => array( Zend_Validate_NotEmpty::IS_EMPTY => 'msg_email_is_required' )))
	      				->addValidator('EmailAddress', true, array('allow' => Zend_Validate_Hostname::ALLOW_DNS,'domain' => false,'mx' => true,'deep' => true,'messages' => array(
	                    	Zend_Validate_EmailAddress::INVALID => 'msg_invalid_email',
	                    	Zend_Validate_EmailAddress::INVALID_FORMAT => 'msg_invalid_formate',
	                    	Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'msg_invalid_host_name',
	                    	Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'msg_invalid_email',
	                    	Zend_Validate_EmailAddress::INVALID_SEGMENT => 'msg_invalid_email',
	                    	Zend_Validate_EmailAddress::DOT_ATOM => 'msg_invalid_email',
	                    	Zend_Validate_EmailAddress::QUOTED_STRING => 'msg_invalid_email',
	                    	Zend_Validate_EmailAddress::INVALID_LOCAL_PART => 'msg_invalid_email')))
          				->setAttrib('maxlength', '50');
	
        // Set password textbox
        $oPasswordTextbox = new Zend_Form_Element_Password("password");
        $oPasswordTextbox->setLabel($this->getTranslator()->_("lbl_password"))
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array( 'messages' => array( Zend_Validate_NotEmpty::IS_EMPTY => 'msg_password_is_required' ) ) );
           
        $this->addElements(array($oUserNameTextbox, $oPasswordTextbox));
    }
}
