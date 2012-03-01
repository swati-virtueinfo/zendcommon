<?php

class Language_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->oTranslate = Zend_Registry::get('Zend_Translate');
    }

    public function indexAction()
    {
        $oCommon = new ZendX_Common();

		/********** Optional Part Start FOR getList()**********/			
		// Assigning sortOn value
		$oCommon->ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$oCommon->ssSortBy = $this->_getParam('sortBy', 'ASC');
		/********** Optional Part End FOR getList()************/

		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 4;
		/********** Optional Part End FOR paginate()************/
		
		
		//Fetch All Data From Language Table
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
		
		// Get list
		$this->view->asHeading = array("Language","Flag","Default","Active","Action");
		$this->view->asFieldName = $asFieldList = array("name", "flag","is_default","is_active","edit","delete");
		$this->view->asColumnSort = array(true,false,false,false,false,false);
		$this->view->asColumnWidth = array("40%", "15%", "10%", "10%","10%","15%");
		$this->view->asColumnAlign = array("left", "center", "center", "center","center","center");	
		
		//For Edit/Delete Link In Listing
		foreach($asLanguageList  as $snKey => $asLanguage)
		{
			$asLanguageList[$snKey]['edit'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asLanguage['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>";
			if($asLanguage["is_default"])
			{
				$asLanguageList[$snKey]['delete'] = "<a><img src='/images/delete_gray.gif'></a>";
			}
			else{
				$asLanguageList[$snKey]['delete'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asLanguage['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
			}	
		}
		
		// Get paging
		$this->view->user= $oCommon->paginate($asLanguageList);     	
    }

    public function addeditAction()
    {
        //Create Form View Object
        $oForm = new Language_Form_Addedit();

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
					// For updating Language detail
					Doctrine::getTable('Model_Language')->UpdateLanguage($oForm->getValues());

					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Language updated successfully');
					
					//Redirect to Language-Index Page
					$this->_redirect('/language/index');
				}
				else
				{
					$amAddLanguageData = $oForm->getValues();
					// Insert Language Record
					Doctrine::getTable('Model_Language')->InsertUser($oForm->getValues());
					
					//Create Language file in the Language Folder
					$ssLogfile = LANGUAGE_PATH.'/'.$amAddLanguageData['lang'].'.php';
					$handle = fopen($ssLogfile, 'w+') or die("can't open file");
					$ssFileStringData  = '';
					$ssFileStringData .= '<?php' . "\n";
					$ssFileStringData .= 'array(' . "\n";
					$ssFileStringData .= ');' . "\n";		
					fwrite($handle, $ssFileStringData);
					fclose($handle);
					chmod($ssLogfile,0777);
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Language Add Successfully.');
					
					//Redirect to Language-Index Page
					$this->_redirect('/language/index');
				}
			}
		}
		
		//For Populate Edit Form Data
		if($this->getRequest()->getParam('id') != '' )
		{
			// For getting Language detail of given id
			$oLanguage = Doctrine::getTable('Model_Language')->find($this->getRequest()->getParam('id'));
			
			//For Storage Language Data
			$amLanguageData = $oLanguage->toArray();
			
			//Create View for Image name Display Upon file Tag
			$this->view->ImageName  = $amLanguageData['flag'];
			
			// For filling Language detail to form
			$oForm->populate($amLanguageData);
		}
		//Assign Form to View
		$this->view->form = $oForm;
    }

	//For Delete Language 
	public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') != '' )
		{
			// For deleting language detail of given id
			Doctrine::getTable('Model_Language')->deleteLanguage( $this->getRequest()->getParam('id') );

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage('Record deleted successfully');
			
			// Redirectes to Language listing Page
			$this->_redirect('/language/index');
		}
    }

	//For Change Default Language From Listing
    public function changedefaultAction()
    {
    	if($this->getRequest()->getParam('id') != '')
		{
			// For Change Default Language as given id
			Doctrine::getTable('Model_Language')->changeDefaultLanguage($this->getRequest()->getParam('id'));

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage('Record Edited');
		
			// Redirectes to Language listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }

	//For Change Active Or Not
    public function changeactiveAction()
    {
       if($this->getRequest()->getParam('id') != '')
		{
			$amLanguageData = Doctrine::getTable('Model_Language')->find($this->getRequest()->getParam('id'));
		
			$bIsActive = $amLanguageData['is_active'];

			// For Change Default Language as given id
			Doctrine::getTable('Model_Language')->changeActiveLanguage($this->getRequest()->getParam('id'),$bIsActive);

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage('Record Edited');
			
			// Redirectes to Language listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }

	//For Change Language Session Variable on Language Change
    public function changelanguageAction()
    {
        $ssLanguage = $this->getRequest()->getParam('lang');
        if(!empty($ssLanguage))
        {
        	$session = new Zend_Session_Namespace('language');
        	$session->ssSesLan=$ssLanguage;
        	
        	// Redirectes to Language listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
        }
    }
}












