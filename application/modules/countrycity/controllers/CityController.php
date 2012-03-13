<?php
/**
 * Countrycity_CityController supports features like 
 * list of City,
 * Add City with Exists Languges Value,
 * Edit City with Exists Languages value 
 * Delete City & also Enable/Disable it.
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 *
 */

class Countrycity_CityController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

	/**
	* For Listing City Detalil
	*
	* @access public
	*/
    public function indexAction()
    {
        $oCommon = new ZendX_Common();

		$this->view->ssSortOn = $ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$this->view->ssSortBy = $ssSortBy = $this->_getParam('sortBy', 'ASC');

		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 4;
		/********** Optional Part End FOR paginate()************/
		
		// Assigning search field
		$this->view->ssSearchField = $ssSearchField = $this->_getParam('searchSelect');

		// Assigning search keyword
		$this->view->ssSearchKeyword =  $ssSearchKeyword = $this->_getParam('searchKeyword');
		
		//Fetch Zend_Locale to used in fetch Record 
		$ssCurrentLocale = Zend_Registry::get('Zend_Locale')->toString(); 
		
		//Fetch All Data From Country Table
		$amCityList = Doctrine::getTable('Model_City')->getCityList($ssSortOn, $ssSortBy, $ssSearchField, $ssSearchKeyword , $ssCurrentLocale );

		// Get list
		$this->view->asHeading = array("City Name", "Enable Or Disable","Action");
		$this->view->asFieldName = $asFieldList = array("name", "is_active", "");
		$this->view->asColumnSort = array(true, false, false);
		$this->view->asColumnWidth = array("65%", "15%", "20%");
		$this->view->asColumnAlign = array("left", "center", "center");
		$this->view->asSearchOption = array('name' => 'City');
		
		//For Edit/Delete Link In Listing
		foreach($amCityList as $snKey => $asCity)
		{
			$amCityList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$asCity['id']."' title='Edit'><img src="."'"."/images/".(isset($asCity['is_active']) && $asCity['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			$amCityList[$snKey]['name'] = $amCityList[$snKey]['Translation'][$ssCurrentLocale]['name'];
			$amCityList[$snKey][2] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asCity['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>" .
			"&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asCity['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
		}
	
		// Get paging
		$this->view->user = $oCommon->paginate($amCityList);
    }

	/**
	* For Add and Edit City Detalil
	*
	* @access public
	*/
    public function addeditAction()
    {
       //Create Form View Object
        $oForm = new Countrycity_Form_Addeditcity();

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
					// For updating City detail
					Doctrine::getTable('Model_City')->UpdateCity($oForm->getValues());

					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('City updated successfully'));
					
					//Redirect to Countrycity-City Page
					$this->_redirect('/countrycity/city');
				}
				else
				{
					//for Store Form Values	
					$amAddCityData = $oForm->getValues();
					
					// Insert City Detail
					Doctrine::getTable('Model_City')->InsertCity($amAddCityData);
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('City added successfully'));
					
					//Redirect to Countrycity-City Page
					$this->_redirect('/countrycity/city');	
				}			
			}
		}
		
		//For Populate City Edit Form Data
		if($this->getRequest()->getParam('id') != '' )
		{
			$amCityFormData = Doctrine::getTable('Model_City')->getCityById($this->getRequest()->getParam('id'));
			
			//set Active checkbox value
			$this->view->country_id = $amCityFormData[0]['country_id'];
					
			// Populate Language wise Textboxes Value
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $asLanguage)
			{
				$amCityFormData['name_' . $asLanguage['lang']] = $amCityFormData[0]['Translation'][$asLanguage['lang']]['name'];
			}
			
			//set Active checkbox value
			$amCityFormData['is_active'] = $amCityFormData[0]['is_active'];
			
			//Poupulate Country Form Data
    		$oForm->populate($amCityFormData);
		}
		//Assign Form to View
		$this->view->form = $oForm;
    }

	/**
	* For Delete City Detalil
	*
	* @access public
	*/
    public function deleteAction()
    {
       if( $this->getRequest()->getParam('id') != '' )
		{
			// For deleting City detail of given id
			Doctrine::getTable('Model_City')->deleteCity( $this->getRequest()->getParam('id') );

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage(array('City deleted successfully'));
			
			// Redirectes to Country listing Page
			$this->_redirect('/countrycity/city');
		}       
    }

	/**
	* For Enable-Disable City Detalil
	*
	* @access public
	*/
    public function changeactiveAction()
    {
        if($this->getRequest()->getParam('id') != '')
		{
			$amCityData = Doctrine::getTable('Model_City')->find($this->getRequest()->getParam('id'));		
			$bIsActive=$amCityData['is_active'];

			// For Change is_active field value as per given id
			$bResult = Doctrine::getTable('Model_City')->changeEnableDisable($this->getRequest()->getParam('id'),$bIsActive);

			// On Success assigning success massage to flashMessenger
			if($bResult)
				$this->_helper->flashMessenger->addMessage(array('Record Edited'));
			
			// Redirectes to City listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }
}