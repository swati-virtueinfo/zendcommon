<?php

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
						->addValidator('NotEmpty', true, array('messages' => 'Email Address Field Required'))
          				->addValidator('EmailAddress', true, array('messages' => 'Invalid Email Address'))
						->setAttrib('maxlength', '50');
	
        // Set password textbox
        $oPasswordTextbox = new Zend_Form_Element_Password("password");
        $oPasswordTextbox->setLabel("Password")
			            ->setRequired(true)
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->setErrorMessages(array('password' => 'Password Field Requiered'));
           
        $this->addElements(array($oUserNameTextbox, $oPasswordTextbox));
    }

}

