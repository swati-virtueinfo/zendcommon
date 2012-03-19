<?php

class Category_Form_Addcategory extends Zend_Form
{

    public function init()
    {
    	$oTranslator = $this->getTranslator();
    	
    	$oRequest = Zend_Controller_Front::getInstance()->getRequest();
    	$snEditId = $oRequest->getParam('editid');
    	
    	$asElementArray = $oCatNameLang = array();
    	
    	$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();

    	$ssEditHidden = $this->createElement('text','editid');
    	
    	$ssCatName = $this->createElement('select','cat_name',array('label' => $oTranslator->translate('lbl_parent_category')));
    	
	   	$CatName = $this->createElement('text','name',array('label' => $oTranslator->translate('lbl_category_name')));
		
    	foreach($amLanguageList as $key => $amLanguage) {
    		$oCatNameLang[$amLanguage['lang']] = $this->createElement('text','name_' . $amLanguage['lang']);
			$oCatNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'err_category_name_required')))
			                                  ->setRequired(true);
			array_push($asElementArray, $oCatNameLang[$amLanguage['lang']]);
    	}
		
		$ssCatImage = $this->createElement('file','image_name',array('label' => $oTranslator->translate('lbl_category_image')));
		$ssCatImage->addValidator('Extension', false, array('jpg', 'png', 'gif', 'jpeg','messages' => 'err_select only .jpg .png .gif .jpeg file'))
	               ->setDestination(UPLOAD_DIR_PATH.'category/');
    
		$ssCateActive = $this->createElement('checkbox','is_active',array('label' => $oTranslator->translate('lbl_active')));
		$ssCateActive->setValue('1');
		
        if($snEditId) {
        	$ssSubmitButton =  $this->createElement('submit','category_edit',array('label' => $oTranslator->translate('btn_edit_categoty'),'class' => 'but'));
        	$ssSubmitButton->setIgnore(true);
        	array_push($asElementArray, $ssEditHidden, $ssCatName, $CatName,  $ssCatImage, $ssCateActive, $ssSubmitButton);
        } else {
        	$ssSubmitButton =  $this->createElement('submit','category_add',array('label' => $oTranslator->translate('btn_add_category'),'class' => 'but'));
        	$ssSubmitButton->setIgnore(true);
        	array_push($asElementArray, $ssCatName, $CatName,  $ssCatImage, $ssCateActive, $ssSubmitButton);
        }
        
        $this->addElements($asElementArray);
    }
}