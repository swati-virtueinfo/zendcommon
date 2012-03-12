<?php

class Category_Form_Addcategory extends Zend_Form
{

    public function init()
    {
    	$oRequest = Zend_Controller_Front::getInstance()->getRequest();
    	$snEditId = $oRequest->getParam('editid');
    	
    	$asElementArray = $oCatNameLang = array();
    	
    	$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();

    	$ssEditHidden = $this->createElement('text','editid');
    	
    	$ssCatName = $this->createElement('select','cat_name',array('label' => 'Cat Name : '));
    	
	   	$CatName = $this->createElement('text','name',array('label' => 'Cat Name  : '));
		
    	foreach($asLanguageList as $key => $amLanguage) {
    		$oCatNameLang[$amLanguage['lang']] = $this->createElement('text','name_' . $amLanguage['lang'], array('label' => 'Cat Name : '));
			$oCatNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_cat_name_required')))
			     ->setRequired(true);
			array_push($asElementArray, $oCatNameLang[$amLanguage['lang']]);
    	}
		
		$ssCatImage = $this->createElement('file','image_name',array('label' => 'Category Image : '));
		$ssCatImage->addValidator('Extension', false, array('jpg', 'png', 'gif', 'jpeg','messages' => 'Select only .jpg .png .gif .jpeg file'))
	              ->setDestination(UPLOAD_DIR_PATH.'category/');
    
		$ssCateActive = $this->createElement('checkbox','is_active',array('label' => 'Active : '));
		$ssCateActive->setValue('1');
		
        if($snEditId) {
        	$ssSubmitButton =  $this->createElement('submit','category_edit',array('label' => 'Edit Category','class' => 'but'));
        	$ssSubmitButton->setIgnore(true);
        	array_push($asElementArray, $ssEditHidden, $ssCatName, $CatName,  $ssCatImage, $ssCateActive, $ssSubmitButton);
        } else {
        	$ssSubmitButton =  $this->createElement('submit','category_add',array('label' => 'Add Category','class' => 'but'));
        	$ssSubmitButton->setIgnore(true);
        	array_push($asElementArray, $ssCatName, $CatName,  $ssCatImage, $ssCateActive, $ssSubmitButton);
        }
        $this->addElements($asElementArray);
    }
}
