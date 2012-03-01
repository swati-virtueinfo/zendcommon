<?php

class Variable_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $oCommon = new ZendX_Common();

		// Assigning sortOn value
		$oCommon->ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$oCommon->ssSortBy = $this->_getParam('sortBy', 'ASC');

		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 10;
		/********** Optional Part End FOR paginate()************/

		//Fetch All Data From Language Table
		$amVariableList = Doctrine::getTable('Model_Variable')->getVariableList();

		// Get list
		$this->view->asHeading = array("Variable Name","Value","Active","Action");
		$this->view->asFieldName = $asFieldList = array("name", "value","is_active","edit","delete");
		$this->view->asColumnSort = array(true,false,false,false,false,false);
		$this->view->asColumnWidth = array("40%", "15%", "10%", "10%","10%","15%");
		$this->view->asColumnAlign = array("left", "center", "center", "center","center","center");	
		
		//For Edit/Delete Link In Listing
		foreach($amVariableList  as $snKey => $asLanguage)
		{
			$amVariableList[$snKey]['edit'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asLanguage['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>";
			$amVariableList[$snKey]['delete'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asLanguage['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
		}
		
		// Get paging
		$this->view->user= $oCommon->paginate($amVariableList); 
    }

    public function addeditAction()
    {
		//Create Form View Object
        $oForm = new Variable_Form_Addedit();

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
					// For updating Variable detail
					Doctrine::getTable('Model_Variable')->UpdateVariable($oForm->getValues());

					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Variable updated successfully');
					
					//Redirect to Variable-Index Page
					$this->_redirect('/variable/index');
				}
				else
				{
					$amAddLanguageData = $oForm->getValues();
					// Insert Variable Record
					Doctrine::getTable('Model_Variable')->InsertVariable($oForm->getValues());
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage('Variable added successfully.');
					
					//Redirect to variable-Index Page
					$this->_redirect('/variable/index');	
				}			
			}
		}
		
		//For Populate Variable Edit Form Data
		if($this->getRequest()->getParam('id') != '' )
		{
			$amVariableFormData = Doctrine::getTable('Model_Variable')->getVariableById($this->getRequest()->getParam('id'));
			
			//set Name Text box value
			$amVariableFormData['name'] = $amVariableFormData[0]['name'];
			
			// Populate Languages Textboxes
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $asLanguage)
			{
				$amVariableFormData['value_' . $asLanguage['lang']] = $amVariableFormData[0]['Translation'][$asLanguage['lang']]['value'];
			}
			
			//set Active checkbox value
			$amVariableFormData['is_active'] = $amVariableFormData[0]['is_active'];
			
			//Poupulate Form Data
    		$oForm->populate($amVariableFormData);
		}
		//Assign Form to View
		$this->view->form = $oForm;
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') != '' )
		{
			// For deleting Variable detail of given id
			Doctrine::getTable('Model_Variable')->deleteVariable( $this->getRequest()->getParam('id') );

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage('Record deleted successfully');
			
			// Redirectes to Variale listing Page
			$this->_redirect('/variable/index');
		}
    }

    public function changeactiveAction()
    {
    	if($this->getRequest()->getParam('id') != '')
		{
			$amVariableData = Doctrine::getTable('Model_Variable')->find($this->getRequest()->getParam('id'));
		
			$bIsActive = $amVariableData['is_active'];

			// For Change Default Variable as given id
			Doctrine::getTable('Model_Variable')->changeActiveVariable($this->getRequest()->getParam('id'),$bIsActive);

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage('Record Edited');
			
			// Redirectes to Variable listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }
}