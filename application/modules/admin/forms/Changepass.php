<?php
/**
 * Admin_Form_Changepass
 * Admin Change Password Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Admin_Form_Changepass extends Zend_Form
{
    public function init()
    {
    	$oId = new Zend_Form_Element_Hidden("id");
    	$oId->setRequired(false);
					
        // Set old password textbox
        $oOldPasswordTextbox = new Zend_Form_Element_Password("oldpassword");
        $oOldPasswordTextbox->setLabel("Old Password *")
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'Old password requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'Passwprd must less than 6 characters long'));
	
        // Set new password textbox
        $oNewPasswordTextbox = new Zend_Form_Element_Password("newpassword");
        $oNewPasswordTextbox->setLabel("New Password *")
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'New password requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'Passwprd must less than 6 characters long'));
		
		// Set Confirm password textbox
        $oConfirmPasswordTextbox = new Zend_Form_Element_Password("confirmpassword");
        $oConfirmPasswordTextbox->setLabel("Confirm Password *")
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'Confirm password requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'Passwprd must less than 6 characters long'));
			            
        $this->addElements(array($oId,$oOldPasswordTextbox, $oNewPasswordTextbox,$oConfirmPasswordTextbox));
    }
}