<?php
/**
 * Sitepages_IndexController supports features like 
 * list of Site Pages,
 * Add Site Pages with Exists Languges Value,
 * Edit Site Pages with Exists Languages value
 * Change Site Pages Order 
 * Delete Site Pages & also Enable/Disable it.
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 *
 */
class Sitepages_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

	//For Listing Site Pages
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
		
		//Fetch All Data From site_pages Table
		$amSitePagesList = Doctrine::getTable('Model_SitePages')->getSitePagesList($ssSortOn, $ssSortBy, $ssSearchField, $ssSearchKeyword , $ssCurrentLocale );
		
		// Get list
		$this->view->asHeading = array("Pages Title", "Pages Menu Name", "Pages Order", "Enable or Disable", "Action");
		$this->view->asFieldName = $asFieldList = array("title", "menu_name", "ord", "is_active", "");
		$this->view->asColumnSort = array(false, false, false, false, false);
		$this->view->asColumnWidth = array("30%", "30%", "15%", "15%", "10%");
		$this->view->asColumnAlign = array("left", "center", "center", "center", "center");
		$this->view->asSearchOption = array('title' => 'Title','menu_name' => 'Menu Name');
		
		//For Edit/Delete Link In Listing
		foreach($amSitePagesList as $snKey => $asCity)
		{
			$amSitePagesList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$asCity['id']."' title='Edit'><img src="."'"."/images/".(isset($asCity['is_active']) && $asCity['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			$amSitePagesList[$snKey]['name'] = $amSitePagesList[$snKey]['Translation'][$ssCurrentLocale]['name'];
			$amSitePagesList[$snKey][2] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asCity['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>" .
			"&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asCity['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
		}
	
		// Get paging
		$this->view->user = $oCommon->paginate($amSitePagesList);   
    }
}