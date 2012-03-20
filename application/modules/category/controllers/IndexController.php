<?php

class Category_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->_redirect('/category/index/listcategory');
    }

    public function addcategoryAction()
    {
    	//Get languages list
    	$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
    	$this->view->amLanguageList = $amLanguageList;
    	// Add category form
    	$this->view->oAddCateFrom = $oAddCateFrom = new Category_Form_Addcategory();
    	
    	$snEditId = $this->getRequest()->getParam('editid');
    	if($snEditId > 0 ) {
    		$amCatEdit = Doctrine::getTable('Model_Category')->getCategoryById($snEditId);
    		if ($this->getRequest()->isPost()) {
    			$amPostData = $this->getRequest()->getPost();
    			if( $oAddCateFrom->isValid($amPostData) ) {
    				$amFormData = $oAddCateFrom->getValues();
    				$bUpdateCat = Doctrine::getTable('Model_Category')->updateCategory($amFormData);
    				$this->_helper->flashMessenger->addMessage(array('msg_record_updated_successfully'));
    				$this->_redirect('/category/index/listcategory');		
    			}
    		}
    		foreach ( $amLanguageList as $amLanguage) {
    			$amCatEdit['name_' . $amLanguage['lang']] = $amCatEdit[0]['Translation'][$amLanguage['lang']]['name'];
    		}
    		$oAddCateFrom->populate($amCatEdit);	
    	}
    	else {
    		if ($this->getRequest()->isPost()) {
        		$amPostData = $this->getRequest()->getPost();
            	if ($oAddCateFrom->isValid($amPostData)) {
            		$amFormData = $oAddCateFrom->getValues();
            		$amFormData['parentid'] = $amPostData['parentid'];
					$bAddCate = Doctrine::getTable('Model_Category')->insertCategory($amFormData);  // Insert Category
					$this->_helper->flashMessenger->addMessage(array('msg_record_added_successfully'));
					$this->_redirect('/category/index/listcategory');
            	} else {
            		$oAddCateFrom->populate($amPostData);
            	}
     		}
    	}
    }
    
    public function listcategoryAction()
    {
	   	$amCatList = Doctrine::getTable('Model_Category')->getCategoryList(Zend_Registry::get('Zend_Locale'));
	   	ksort($amCatList);
    	$this->view->amCatListing = $amCatList;
    }
    
	public function deletecategoryAction()
    {
    	$this->getRequest()->getParam('id');
      	if( $this->getRequest()->getParam('id') != '' )
			Doctrine::getTable('Model_Category')->deleteCategoryById( $this->getRequest()->getParam('id') );
		
		$this->_helper->flashMessenger->addMessage(array('msg_record_deleted_successfully'));	
		$this->_redirect('/category/index/listcategory');
    }
 	public function isactiveAction()
    {
    	$snIdCategory = $this->getRequest()->getParam('id');
    	
    	$snChangeStatus = ( $this->getRequest()->getParam('status') == 1 ) ?  0 : 1;
      	$amUpdateData = array ('id' => $snIdCategory , 'is_active' => $snChangeStatus);
    	
    	Doctrine::getTable('Model_Category')->changeIsActive($amUpdateData);
    	$this->view->amCatById = $amCatById = Doctrine::getTable('Model_Category')->find($snIdCategory)->toArray();
    	$this->_helper->flashMessenger->addMessage(array('msg_record_edited'));
    }
}