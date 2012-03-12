<?php
/**
 * Variable_Form_Addedit
 * Add/Edit Variable Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Variable_Form_Addedit extends Zend_Form
{
    public function init()
    {
       	$oRequest = Zend_Controller_Front::getInstance()->getRequest();
		$snIdVariable = $oRequest->getParam('id'); 
		$asElementArray=array();
		
		//set id hidden field at Edit
		$oVariableId = new Zend_Form_Element_Hidden("id");
		$oVariableId->setRequired(false);
		
		if(isset($snIdVariable) ? array_push($asElementArray, $oVariableId) : "");		
		
		 //Set name textbox
        $oTextBoxName = new Zend_Form_Element_Text("name");
        $oTextBoxName->setLabel("Name * ")
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_var_name_required')))
						->setAttrib('maxlength', '50');
		array_push($asElementArray,$oTextBoxName);
		
		//Get Languages list for Creating Textbox for language
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();	
		
		//Set Variable value textbox
		foreach($asLanguageList as $key => $amLanguage) {
    		$oVariableNameLang[$amLanguage['lang']] = $this->createElement('text','value_' . $amLanguage['lang'], array('label' => 'Value : '));
			$oVariableNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_var_val_required')));
			$oVariableNameLang[$amLanguage['lang']]->setRequired(true);
			array_push($asElementArray, $oVariableNameLang[$amLanguage['lang']]);
    	}		
						
		//Set isactive check box				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel("Active")
						->setChecked(true);		
		array_push($asElementArray,$ochkIsActive);
						
		$this->addElements($asElementArray);
    }
}