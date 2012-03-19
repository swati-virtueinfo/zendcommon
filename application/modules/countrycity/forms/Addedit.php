<?php
/**
 * Countrycity_Form_Addedit
 * Country Add/Edit Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Countrycity_Form_Addedit extends Zend_Form
{
    public function init()
    {
    	//Get Variable Id 
        $oRequest = Zend_Controller_Front::getInstance()->getRequest();
		$snIdVariable = $oRequest->getParam('id'); 
		$asElementArray=array();
		
		//set id hidden field at Edit
		$oVariableId = new Zend_Form_Element_Hidden("id");
		$oVariableId->setRequired(false);
		
		//At Edit time add Hidden text Field
		if(isset($snIdVariable) ? array_push($asElementArray, $oVariableId) : "");		
		
		//Get Languages list for Creating Textbox for language
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();	
		
		//Set Variable value textbox
		foreach($asLanguageList as $key => $amLanguage) {
    		$oVariableNameLang[$amLanguage['lang']] = $this->createElement('text','name_' . $amLanguage['lang'], array('label' => 'Name : '));
			$oVariableNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_country_name_required')))
			     ->setRequired(true);
			array_push($asElementArray, $oVariableNameLang[$amLanguage['lang']]);
    	}		
						
		//Set isactive check box				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel("lbl_active")
						->setChecked(true);		
		array_push($asElementArray,$ochkIsActive);
						
		$this->addElements($asElementArray);
    }
}