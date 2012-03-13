<?php
/**
 * Language_IndexController supports features like 
 * list of Languages,Add Languages with creating 
 * Language wise php file ,Edit Languages 
 * Change Default Language,Change Active Language
 * Delete Languages & Language Session Management.
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 */
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
		$this->ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$this->ssSortBy = $this->_getParam('sortBy', 'ASC');
		/********** Optional Part End FOR getList()************/
		
		// Assigning search field
		$this->view->ssSearchField =$this->ssSearchField = $this->_getParam('searchSelect');

		// Assigning search keyword
		$this->view->ssSearchKeyword =$this->ssSearchKeyword = $this->_getParam('searchKeyword');

		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 4;
		/********** Optional Part End FOR paginate()************/
		
		
		//Fetch All Data From Language Table
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList($this->ssSortOn,$this->ssSortBy,$this->ssSearchField,$this->ssSearchKeyword);
		
		// Get list
		$this->view->asHeading = array("Language","Flag","Default","Active","Action");
		$this->view->asFieldName = $asFieldList = array("name", "flag","is_default","is_active","");
		$this->view->asColumnSort = array(true,false,false,false,false,false);
		$this->view->asColumnWidth = array("40%", "15%", "10%", "10%","10%","15%");
		$this->view->asColumnAlign = array("left", "center", "center", "center","center","center");
		$this->view->asSearchOption = array('name' => 'Language');	
		
		//For Edit/Delete Link In Listing
		foreach($asLanguageList  as $snKey => $asLanguage)
		{
			$asLanguageList[$snKey]['flag'] = "<img src="."'"."/upload/language/".$asLanguage['flag']."'"."height='20' width='20'/>";	
			$asLanguageList[$snKey]['is_default'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changedefault/id/".$asLanguage['id']."' title='Change Default Language'><img src="."'"."/images/".(isset($asLanguage['is_default']) && $asLanguage['is_default'] == 1 ? "active_radio.gif" : "deactive_radio.gif")."'"."/></a>";
			$asLanguageList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$asLanguage['id']."' title='Change Active'><img src="."'"."/images/".(isset($asLanguage['is_active']) && $asLanguage['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			$asLanguageList[$snKey]['4'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$asLanguage['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>";
			if($asLanguage["is_default"])
			{
				$asLanguageList[$snKey]['4'] .= "&nbsp;&nbsp;&nbsp;&nbsp;<a><img src='/images/delete_gray.gif'></a>";
			}
			else{
				$asLanguageList[$snKey]['4'] .=  "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$asLanguage['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
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
					//Fetch Record From Database 
					$oLanguage = Doctrine::getTable('Model_Language')->find($this->getRequest()->getParam('id'));
					$amLanguageData = $oLanguage->toArray();
					$ssOldLanguageName = $amLanguageData['lang'];
					
					//Store form Data in Variable 
					$amUpdateLanguageData = $oForm->getValues();
					$ssNewLanguageName = $amUpdateLanguageData['lang'];
					
					// For updating Language detail
					Doctrine::getTable('Model_Language')->UpdateLanguage($oForm->getValues());
					
					//create Language File when changes Lang value at Update
					if($ssOldLanguageName != $ssNewLanguageName)
					{
						//for Store file name with Path
						$ssLogfile = LANGUAGE_PATH.'/'.$ssNewLanguageName.'.php';
						
						if(!is_file($ssLogfile))
						{
							//call function to create Language File in Languages Folder
							$bResult = $this->_createLanguageFile($ssLogfile);
						}
					}	
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('Language updated successfully'));	
					
					//Redirect to Language-Index Page
					$this->_redirect('/language/index');
				}
				else
				{
					$amAddLanguageData = $oForm->getValues();
					// Insert Language Record
					Doctrine::getTable('Model_Language')->InsertLanguage($amAddLanguageData);
					
					//for Store file name with Path
					$ssLogfile = LANGUAGE_PATH.'/'.$amAddLanguageData['lang'].'.php';
					
					if(!is_file($ssLogfile))
					{
						//call function to create Language File in Languages Folder
						$bResult = $this->_createLanguageFile($ssLogfile);
					}
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('Language Add Successfully'));	
					
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
			$oLanguage = Doctrine::getTable('Model_Language')->find($this->getRequest()->getParam('id'));
			$amLanguageData =$oLanguage->toArray();
			
			// For deleting language detail of given id
			$bResultDelete = Doctrine::getTable('Model_Language')->deleteLanguage( $this->getRequest()->getParam('id') );
			
			if($bResultDelete)
			{
				//Delete Language File & Image
				$ssLogfile = LANGUAGE_PATH.'/'.$amLanguageData['lang'].'.php';	
				$ssLanguageImageName =  UPLOAD_DIR_PATH.'/language/'.$amLanguageData['flag'];
				if(!empty($ssLogfile) ? unlink($ssLogfile) : '');
				if(!empty($ssLanguageImageName) ? unlink($ssLanguageImageName) : '');				
			}
			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage(array('Record deleted successfully'));	
			
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
			$this->_helper->flashMessenger->addMessage(array('Record Edited'));
		
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
			$this->_helper->flashMessenger->addMessage(array('Record Edited'));
			
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
    
    //For Create Language File in Language Folder
    public function _createLanguageFile($ssFilenameWithPath = '')
    {
		$ssLogfile = $ssFilenameWithPath;
		//Create File Using fopen
		$handle = fopen($ssLogfile, 'w+') or die("can't open file");
		
		//Put Content In the file
		$ssFileStringData  = '';
		$ssFileStringData .= '<?php' . "\n";
		$ssFileStringData .= 'return array(' . "\n";
		$ssFileStringData .= ');' . "\n";
			
		//Save File 	
		fwrite($handle, $ssFileStringData);
		fclose($handle);
		//Change File Mode 
		chmod($ssLogfile,0777);
		return true;
    }
}