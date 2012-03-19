<?php

class Pages_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->oTranslate = Zend_Registry::get('Zend_Translate');
    }

    public function indexAction()
    {
    	//Fetch Zend_Locale to used in fetch Record 
		$ssCurrentLocale = Zend_Registry::get('Zend_Locale')->toString();
		
		//Get only parent record
    	$amParentSitePages = Doctrine::getTable('Model_Pages')->getPageMenu($ssCurrentLocale, '', false);
    	if ($amParentSitePages) {
		    foreach ($amParentSitePages['parents'] as $snKey => $amPatentPages) {
		    	$anParentPages[$snKey] = count($amPatentPages);
		    }
	    }
	    
        $oCommon = new ZendX_Common();

		$this->view->ssSortOn = $ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$this->view->ssSortBy = $ssSortBy = $this->_getParam('sortBy', 'ASC');

		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 14;
		/********** Optional Part End FOR paginate()************/
		
		// Assigning search field
		$this->view->ssSearchField = $ssSearchField = $this->_getParam('searchSelect');

		// Assigning search keyword
		$this->view->ssSearchKeyword =  $ssSearchKeyword = $this->_getParam('searchKeyword');
		
		$amPagesList = $this->getPageTree($ssCurrentLocale);
		//print_r($amPagesList);
		
		// Get list
		$this->view->asHeading = array("Pages Title", "Pages Menu Name", "Pages Order", "Enable or Disable", "Action");
		$this->view->asFieldName = $asFieldList = array("title", "menu_name", "ord", "is_active", "");
		$this->view->asColumnSort = array(false, false, false, false, false);
		$this->view->asColumnWidth = array("30%", "30%", "15%", "15%", "10%");
		$this->view->asColumnAlign = array("left", "center", "center", "center", "center");
		$this->view->asSearchOption = array('title' => 'Title','menu_name' => 'Menu Name');
		
		//For Edit/Delete Link In Listing
		foreach($amPagesList as $snKey => $asPages)
		{
			if ($anParentPages[$asPages['parent_id']] > 1) {
				if($asPages['ord'] == 1){
					$amPagesList[$snKey]['ord'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/pagesorder/id/".$asPages['id']."/dir/Down' title='Edit'><img src=/images/down.gif /></a>";
				} elseif ($asPages['ord'] == $anParentPages[$asPages['parent_id']]) {
					$amPagesList[$snKey]['ord'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/pagesorder/id/".$asPages['id']."/dir/Up' title='Edit'><img src=/images/up.gif /></a>";
				} else {
					$amPagesList[$snKey]['ord'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/pagesorder/id/".$asPages['id']."/dir/Up' title='Edit'><img src=/images/up.gif /></a>&nbsp;&nbsp;&nbsp;" . 
					"<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/pagesorder/id/".$asPages['id']."/dir/Down' title='Edit'><img src=/images/down.gif /></a>";
				}
			} else {
				$amPagesList[$snKey]['ord'] = '';
			}
			
			$amPagesList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$asPages['id']."' title='Edit'><img src="."'"."/images/".(isset($asPages['is_active']) && $asPages['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			//$amPagesList[$snKey]['name'] = $amPagesList[$snKey]['Translation'][$ssCurrentLocale]['name'];
			$amPagesList[$snKey][4] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asPages['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>" .
			"&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asPages['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
		}
		// Get paging
		$this->view->user = $oCommon->paginate($amPagesList); 
    }

    public function addeditAction()
    {
    	
    	//Fetch Zend_Locale to used in fetch Record 
		$ssCurrentLocale = Zend_Registry::get('Zend_Locale')->toString(); 
		
         //Create Form View Object
        $oForm = new Pages_Form_Addedit();
        
		//Create Object Of Request Variable
        $oRequest = $this->getRequest();
      	
		// Checking request method is post
		if($oRequest->isPost())
		{
			// Checking post values are valid
			if( $oForm->isValid($oRequest->getPost()))
			{
				//If Id variable is get in request then Edit Record else Add Record
				if ($oRequest->getParam('id') > 0 )
				{
					// For updating Page detail
					Doctrine::getTable('Model_Pages')->UpdatePage($oForm->getValues());

					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Page updated successfully');
					
					//Redirect to Page
					$this->_redirect('/pages/index');
				}
				else
				{
					//for Store Form Values	
					$amAddCityData = $oForm->getValues();
					
					// Insert Page Detail
					Doctrine::getTable('Model_Pages')->InsertPage($amAddCityData);
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Page added successfully.');
					
					//Redirect to Countrycity-City Page
					$this->_redirect('/pages/index');	
				}			
			}
		}
		
		//For Populate Page Edit Form Data
		if($this->getRequest()->getParam('id') != '' )
		{
			
			//fetch Record by id from pages table 	
			$amPagesFormData = Doctrine::getTable('Model_Pages')->getPagesById($this->getRequest()->getParam('id'));
			$amPagesFormData = $amPagesFormData->toArray();
			// Populate Languag wise Textboxes
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $asLanguage){
				$amPagesFormData['site_pages_title_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['title'];
				$amPagesFormData['site_pages_menu_name_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['menu_name'];
				$amPagesFormData['site_pages_meta_title_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['meta_title'];
				$amPagesFormData['site_pages_meta_keyword_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['meta_title'];
				$amPagesFormData['site_pages_content_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['content'];
				$amPagesFormData['site_pages_meta_description_' . $asLanguage['lang']] = $amPagesFormData['Translation'][$asLanguage['lang']]['meta_description'];
			}
			//set Url Textbox value
			$amPagesFormData['url'] = $amPagesFormData['url'];
			
			//set Active checkbox value
			$amPagesFormData['is_active'] = $amPagesFormData['is_active'];
			
			//Poupulate Country Form Data
    		$oForm->populate($amPagesFormData);
		}
		
		//Assign Form to View
		$this->view->form = $oForm;
    }

    public function getPageTree($ssCulture)
    {
		$amSitePageList = $amSitePages = array();
	    $snLastIdRef = false;
	    
	    $amSitePages = Doctrine::getTable('Model_Pages')->getPageMenu($ssCulture, '', true);
		$iteriter = new RecursiveIteratorIterator(new RecursiveArrayIterator($amSitePages), RecursiveIteratorIterator::SELF_FIRST);
		
		foreach ($iteriter as $snKey => $saValue) {
		  if (is_numeric($snKey)) {
		  	$snLastIdRef = $snKey;
		  } else if ($snKey == 'title') {
		  	$amSitePageList[$snLastIdRef]['depth'] = $iteriter->getDepth() - 1;
		  	$amSitePageList[$snLastIdRef]['title'] = html_entity_decode(str_repeat("&nbsp;", ($iteriter->getDepth() - 1) * 3), ENT_COMPAT, 'UTF-8') . $saValue;
		  } else if ($snKey == 'menu_name') {
		  	$amSitePageList[$snLastIdRef]['menu_name'] = $saValue;
		  } else if ($snKey == 'is_active') {
		  	$amSitePageList[$snLastIdRef]['is_active'] = $saValue;
		  } else if ($snKey == 'id') {
		  	$amSitePageList[$snLastIdRef]['id'] = $saValue;
		  } else if ($snKey == 'parent_id') {
		  	$amSitePageList[$snLastIdRef]['parent_id'] = $saValue;
		  } else if ($snKey == 'ord') {
		  	$amSitePageList[$snLastIdRef]['ord'] = $saValue;
		  } 
		}
	    return $amSitePageList;
    }

    public function changeactiveAction()
    {
       if($this->getRequest()->getParam('id') != '')
		{
			$amPageData = Doctrine::getTable('Model_Pages')->find($this->getRequest()->getParam('id'));
		
			$bIsActive=$amPageData['is_active'];

			// For Change Default Page as given id
			$bResult = Doctrine::getTable('Model_Pages')->enalbleDisablePage($this->getRequest()->getParam('id'),$bIsActive);

			// On Success assigning success massage to flashMessenger
			if($bResult)
				$this->_helper->flashMessenger->addMessage(array('Record Edited'));
			
			// Redirectes to Page listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}	
		
    }

    public function deleteAction()
    {
       if( $this->getRequest()->getParam('id') != '' )
		{
			// For deleting Page detail of given id
			Doctrine::getTable('Model_Pages')->deletePage( $this->getRequest()->getParam('id') );

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage(array('Page deleted successfully'));
			
			// Redirectes to Page listing Page
			$this->_redirect('/pages/index');
		}
    }

    public function pagesorderAction()
    {
        $snId = $this->getRequest()->getParam('id');
    	$ssOrderDir = $this->getRequest()->getParam('dir');
    	//Fetch record by page id
    	$asPagesList = Doctrine::getTable('Model_Pages')->getPagesById($snId);
    	
	  	$snPageOrd = $asPagesList->ord; //Get page ord
	    $snPageParentId = $asPagesList->parent_id; // Get parent id
	    $snUpdateOredrId = ($ssOrderDir == "Up") ? $snPageOrd -1 : $snPageOrd + 1; //Change page ord for change ord
	    // Fetch record by parent id and page ord	
	    $asParentPagesList = Doctrine::getTable('Model_Pages')->getPagesByParentId($snPageParentId, $snUpdateOredrId);
	    $asPagesList->ord = $snUpdateOredrId; // Update new page ord
	    $asPagesList->save(); // Save new page ord
	    	
	    $asParentPagesList->ord = $snPageOrd; // Update old page ord
	    $asParentPagesList->save(); // Save old page ord
	    	
	    $this->_redirect('/pages/index/index');
    }
}