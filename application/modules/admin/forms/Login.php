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
        $oUserNameTextbox->setLabel("Email :")
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => array( Zend_Validate_NotEmpty::IS_EMPTY => ' Email is required' )))
          				->addValidator('EmailAddress', true, array('messages' => array(Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'Please enter valid email address',Zend_Validate_EmailAddress::INVALID_FORMAT =>'Please enter in proper formate')))
          				->setAttrib('maxlength', '50');
	
        // Set password textbox
        $oPasswordTextbox = new Zend_Form_Element_Password("password");
        $oPasswordTextbox->setLabel("Password")
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array( 'messages' => array( Zend_Validate_NotEmpty::IS_EMPTY => ' Password is required' ) ) );
           
        $this->addElements(array($oUserNameTextbox, $oPasswordTextbox));
    }
}
