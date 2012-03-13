<?php
/**
 * Countrycity_Form_Addeditcity
 * City Add/Edit Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Countrycity_Form_Addeditcity extends Zend_Form
{
    public function init()
    {
        //Get Variable Id 
        $oRequest = Zend_Controller_Front::getInstance()->getRequest();
		$oEditId = $oRequest->getParam('id'); 
		$asElementArray=array();
		
		//Add Id as hidden field
		$oEditId = new Zend_Form_Element_Hidden("id");
		$oEditId->setRequired(false);		
		if(isset($oEditId) ? array_push($asElementArray, $oEditId) : "");		
		
		//Add country_id as select field
		$oCountry = new Zend_Form_Element_Select('country_id');
        $oCountry->setLabel('Country');
        $oCountry->setRequired(true);
   		$oCountry->addValidator('NotEmpty',true, array('messages' => array('isEmpty' => 'msg_country_name_required')));
        $oCountry->setRegisterInArrayValidator(false); 
        $this->addElement($oCountry);
        
		//Get Languages list for Creating Textbox for City Language wise
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();	
		
		//Add lang as text field
		foreach($asLanguageList as $key => $amLanguage)
		{
    		$oVariableNameLang[$amLanguage['lang']] = $this->createElement('text','name_' . $amLanguage['lang'], array('label' => 'Name : '));
			$oVariableNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_city_name_required')));
			$oVariableNameLang[$amLanguage['lang']]->setRequired(true);
			array_push($asElementArray, $oVariableNameLang[$amLanguage['lang']]);
    	}		
						
		//Add is_active as check box Field				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel("Active ")
					 ->setChecked(true);		
		array_push($asElementArray,$ochkIsActive);
						
		$this->addElements($asElementArray);
    }
}