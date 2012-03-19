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
        $oOldPasswordTextbox->setLabel($this->getTranslator()->_("lbl_old_password"))
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'msg_old_password_requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'msg_passwprd_must_be_a_6_characters_long'));
	
        // Set new password textbox
        $oNewPasswordTextbox = new Zend_Form_Element_Password("newpassword");
        $oNewPasswordTextbox->setLabel($this->getTranslator()->_("lbl_new_password"))
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'msg_new_password_requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'msg_passwprd_must_be_a_6_characters_long'));
		
		// Set Confirm password textbox
        $oConfirmPasswordTextbox = new Zend_Form_Element_Password("confirmpassword");
        $oConfirmPasswordTextbox->setLabel($this->getTranslator()->_("lbl_confirm_password"))
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->addValidator('NotEmpty', true, array('messages' => 'msg_confirm_password_requiered'))
			            ->addValidator('StringLength', true, array(6, 20,'messages' => 'msg_passwprd_must_be_a_6_characters_long'));
			            
        $this->addElements(array($oId,$oOldPasswordTextbox, $oNewPasswordTextbox,$oConfirmPasswordTextbox));
    }
}