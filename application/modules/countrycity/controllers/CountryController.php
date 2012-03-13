<?php
/**
 * Countrycity_CountryController supports features like 
 * list of Country,
 * Add Country with Exists Languges Value,
 * Edit Country with Exists Languages value 
 * Delete Country & also Enable/Disable it.
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 *
 *
 *
 */

class Countrycity_CountryController extends Zend_Controller_Action
{

    public function init()
    {
        $this->oTranslate = Zend_Registry::get('Zend_Translate');
    }
	
	/**
	* For Listing Country Detalil
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
		$amCountryList = Doctrine::getTable('Model_Country')->getCountryList($ssSortOn, $ssSortBy, Zend_Registry::get('Zend_Locale'));
		
		$amCountryList = Doctrine::getTable('Model_Country')->getCountryList($ssSortOn, $ssSortBy, $ssSearchField, $ssSearchKeyword, $ssCurrentLocale);

		// Get list
		$this->view->asHeading = array("Country Name", "Enable Or Disable","Action");
		$this->view->asFieldName = $asFieldList = array("name", "is_active", "");
		$this->view->asColumnSort = array(true, false, false);
		$this->view->asColumnWidth = array("65%", "15%", "20%");
		$this->view->asColumnAlign = array("left", "center", "center");
		$this->view->asSearchOption = array('name' => 'Country');

		//For Edit/Delete Link In Listing
		foreach($amCountryList  as $snKey => $asCountry)
		{
			$amCountryList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$asCountry['id']."' title='Edit'><img src="."'"."/images/".(isset($asCountry['is_active']) && $asCountry['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			$amCountryList[$snKey]['name'] = $amCountryList[$snKey]['Translation'][$ssCurrentLocale]['name'];
			$amCountryList[$snKey]['2'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asCountry['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>" .
			"&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asCountry['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
		}
	
		// Get paging
		$this->view->user= $oCommon->paginate($amCountryList);
    }
	
	/**
	* For Add and Edit Country Detalil
	*
	* @access public
	*/
    public function addeditAction()
    {
        //Create Form View Object
        $oForm = new Countrycity_Form_Addedit();

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
					// For updating Country detail
					Doctrine::getTable('Model_Country')->UpdateCountry($oForm->getValues());

					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('Country updated successfully'));	
					
					//Redirect to Countrycity-country Page
					$this->_redirect('/countrycity/country');
				}
				else
				{
					//for Store Form Values	
					$amAddCountryData = $oForm->getValues();
					
					// Insert Country Record
					Doctrine::getTable('Model_Country')->InsertCountry($amAddCountryData);
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('Country added successfully'));	
					
					//Redirect to Countrycity-Country Page
					$this->_redirect('/countrycity/country');	
				}			
			}
		}
		
		//For Populate Country Edit Form Data
		if($this->getRequest()->getParam('id') != '' )
		{
			$amCountryFormData = Doctrine::getTable('Model_Country')->getCountryById($this->getRequest()->getParam('id'));
		
			// Populate Language wise Textboxes Value
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $asLanguage)
			{
				$amCountryFormData['name_' . $asLanguage['lang']] = $amCountryFormData[0]['Translation'][$asLanguage['lang']]['name'];
			}
			
			//set Active checkbox value
			$amCountryFormData['is_active'] = $amCountryFormData[0]['is_active'];
			
			//Poupulate Country Form Data
    		$oForm->populate($amCountryFormData);
		}
		//Assign Form to View
		$this->view->form = $oForm;
    }

	/**
	* For Delete Country Detalil
	*
	* @access public
	*/
    public function deleteAction()
    {
    	if( $this->getRequest()->getParam('id') != '' )
		{
			// For deleting country detail of given id
			Doctrine::getTable('Model_Country')->deleteCountry( $this->getRequest()->getParam('id') );

			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage(array('Record deleted successfully'));	
			
			// Redirectes to Country listing Page
			$this->_redirect('/countrycity/country');
		}       
    }

	/**
	* For Change Active City or not 
	*
	* @access public
	*/
    public function changeactiveAction()
    {
        if($this->getRequest()->getParam('id') != '')
		{
			$amCountryData = Doctrine::getTable('Model_Country')->find($this->getRequest()->getParam('id'));
		
			$bIsActive=$amCountryData['is_active'];

			// For Change is_active field value as per given id
			$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable($this->getRequest()->getParam('id'),$bIsActive);

			// On Success assigning success massage to flashMessenger
			if($bResult)
				$this->_helper->flashMessenger->addMessage(array('Record Edited'));
			
			// Redirectes to Country listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }
}