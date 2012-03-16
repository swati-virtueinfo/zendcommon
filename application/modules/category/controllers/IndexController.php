<?php

class Category_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->oTranslate = Zend_Registry::get('Zend_Translate');
    }

    public function indexAction()
    {
        $this->_redirect('/category/index/listcategory');
    }

    public function addcategoryAction()
    {
    	//Get languages list
    	$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
    	$this->view->asLanguageList = $asLanguageList;

    	// Add category form
    	$this->view->oAddCateFrom = $oAddCateFrom = new Category_Form_Addcategory();
    	
    	$snEditId = $this->getRequest()->getParam('editid');
    	
    	if($snEditId > 0 ) {
    		$amCatEdit = Doctrine::getTable('Model_Category')->getCategoryById($snEditId);
    		
    		//$this->view->snParentId = $snParentId = $amCatEdit[0]['parentid'];
    		if ($this->getRequest()->isPost()) {
    			$amPostData = $this->getRequest()->getPost();
    			if( $oAddCateFrom->isValid($amPostData) ) {
    				$amFormData = $oAddCateFrom->getValues();
    				//$amFormData['parentid'] = $amPostData['parentid'];
    				$bUpdateCat = Doctrine::getTable('Model_Category')->updateCategory($amFormData);
    				$this->_helper->flashMessenger->addMessage(array('Record update successfully'));
    				$this->_redirect('/category/index/listcategory');		
    			}
    		}
    		foreach ( $asLanguageList as $asLanguage) {
    			$amCatEdit['name_' . $asLanguage['lang']] = $amCatEdit[0]['Translation'][$asLanguage['lang']]['name'];
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
					$this->_helper->flashMessenger->addMessage(array('Record insert successfully'));
					$this->_redirect('/category/index/listcategory');
            	} else {
            		$oAddCateFrom->populate($amPostData);
            	}
     		}
    	}
    	
    }
    
    public function listcategoryAction()
    {
	   	$amCatList = Doctrine::getTable('Model_Category')->getCatList(Zend_Registry::get('Zend_Locale'));
	   	ksort($amCatList);
    	$this->view->amCatListing = $amCatList;
    }
    
	public function deletecategoryAction()
    {
    	$this->getRequest()->getParam('id');
    	// For deleting category detail of given id_category
      	if( $this->getRequest()->getParam('id') != '' )
			Doctrine::getTable('Model_Category')->deleteCatById( $this->getRequest()->getParam('id') );
		
		$this->_helper->flashMessenger->addMessage(array('Record delete successfully'));	
		// Redirectes to category list
		$this->_redirect('/category/index/listcategory');
    }
 	public function isactiveAction()
    {
    	$snIdCategory = $this->getRequest()->getParam('id');
    	
    	$snChangeStatus = ( $this->getRequest()->getParam('status') == 1 ) ?  0 : 1;
      	$amUpdateData = array ('id' => $snIdCategory , 'is_active' => $snChangeStatus);
    	
    	Doctrine::getTable('Model_Category')->updateStatus($amUpdateData);
    	$this->view->amCatById = $amCatById = Doctrine::getTable('Model_Category')->find($snIdCategory)->toArray();
    	$this->_helper->flashMessenger->addMessage(array('Category status change successfully'));
    }
}