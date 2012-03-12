<?php

class Language_Form_Addedit extends Zend_Form
{

    public function init()
    {
    	 $oRequest = Zend_Controller_Front::getInstance()->getRequest();
		 $snIdLanguage = $oRequest->getParam('id'); 
		
		//set id hidden field at Edit
		$oId = new Zend_Form_Element_Hidden("id");
		$oId->setRequired(false);
		
        //Set name textbox
        $oTextBoxName = new Zend_Form_Element_Text("name");
        $oTextBoxName->setLabel("Name * ")
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => 'Language name is required'))
						->setAttrib('maxlength', '50');
						
     	//Set language textbox
       	$oTextBoxLanguage = new Zend_Form_Element_Text("lang");
       	$oTextBoxLanguage->setLabel("Language * ")
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => 'Language culture is required'))
						->setAttrib('maxlength', '2');	
    	
    	//Set isdefualt Radio Button  
    	$oChkIsDefault = new Zend_Form_Element_Checkbox("is_default");
      	$oChkIsDefault->setLabel("Default Language ")
						->setChecked(true);
		
		//Set isactive check box				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel("Active Language ")
						->setChecked(true);
		
		//Set flag file control 
		$oFlagImage = new Zend_Form_Element_File("flag");
       	$oFlagImage->setLabel("Flag * ")
       			->setDestination(UPLOAD_DIR_PATH.'/language/');

       	//put condition for validation set required
       	if(isset($snIdLanguage) ? $oFlagImage->setRequired(false) : $oFlagImage->setRequired(true));
	   	$oFlagImage->addValidator('Extension', false, 'jpg,jpeg,png,gif');
	   	$oFlagImage->addValidator('Size', false, 10240000);

		//Add element At Add & Edit 
		if(isset($snIdLanguage)){
			$this->addElements(array($oId,$oTextBoxName, $oTextBoxLanguage,$ochkIsActive,$oFlagImage));
		}else{
			$this->addElements(array($oTextBoxName, $oTextBoxLanguage,$oChkIsDefault,$ochkIsActive,$oFlagImage));
		}
    }
}