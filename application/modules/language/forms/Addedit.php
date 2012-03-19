<?php
/**
 * Language_Form_Addedit
 * Add/Edit Language Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Language_Form_Addedit extends Zend_Form
{
    public function init()
    {
    	$oTranslator = $this->getTranslator();
    	
    	$oRequest = Zend_Controller_Front::getInstance()->getRequest();
		$snIdLanguage = $oRequest->getParam('id'); 
		
		//set id hidden field at Edit
		$oId = new Zend_Form_Element_Hidden("id");
		$oId->setRequired(false);
		
        //Set name textbox
        $oTextBoxName = new Zend_Form_Element_Text("name");
        $oTextBoxName->setLabel($oTranslator->translate("lbl_name"))
					 ->setRequired(true)
					 ->addFilter('StripTags')
					 ->addFilter('StringTrim')
					 ->addValidator('NotEmpty', true, array('messages' => $oTranslator->translate('err_language_name_required')))
					 ->setAttrib('maxlength', '50');
						
     	//Set language textbox
       	$oTextBoxLanguage = new Zend_Form_Element_Text("lang");
       	$oTextBoxLanguage->setLabel($oTranslator->translate("lbl_language"))
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => $oTranslator->translate('err_language_culture_required')))
						->setAttrib('maxlength', '2');	
		
    	//Set isdefualt Radio Button  
    	$oChkIsDefault = new Zend_Form_Element_Checkbox("is_default");
      	$oChkIsDefault->setLabel($oTranslator->translate("lbl_default_language"))
						->setChecked(true);
		
		//Set isactive check box				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel($oTranslator->translate("lbl_active_language"))
						->setChecked(true);
		
		//Set flag file control 
		$oFlagImage = new Zend_Form_Element_File("flag");
       	$oFlagImage->setLabel($oTranslator->translate("lbl_flag"))
       			   ->setDestination(UPLOAD_DIR_PATH.'/language/');
	   	$oFlagImage->addValidator('Extension', false, array('jpg', 'png', 'gif', 'jpeg','messages' => 'err_select only .jpg .png .gif .jpeg file'));
	   	$oFlagImage->addValidator('Size', false, 10240000);
	   	if(isset($snIdLanguage) ? $oFlagImage->setRequired(false) : $oFlagImage->setRequired(true));

		//Add element At Add & Edit 
		if(isset($snIdLanguage)){
			$this->addElements(array($oId,$oTextBoxName, $oTextBoxLanguage, $ochkIsActive,$oFlagImage));
		}else{
			$this->addElements(array($oTextBoxName, $oTextBoxLanguage, $oChkIsDefault,$ochkIsActive,$oFlagImage));
		}
    }
}