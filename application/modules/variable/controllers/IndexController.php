<?php
/**
 * Variable_IndexController supports features like 
 * list of Variables with Language value
 * Add Variable with Exists Languges Value,
 * Edit variable with Exists Languages value 
 * Delete Variable, Change Active Variable
 *
 * @category   Zend
 * @package    zendcommon
 * @subpackage admin
 * @author     Bhaskar Joshi
 * @uses       Zend_Controller_Action
 *
 *
 */

class Variable_IndexController extends Zend_Controller_Action
{

    public function init()
    {
         
    }

    public function indexAction()
    {
        $oCommon = new ZendX_Common();

		// Assigning sortOn value

		$this->ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$this->ssSortBy = $this->_getParam('sortBy', 'ASC');

		$this->view->ssSortOn = $ssSortOn = $this->_getParam('sortOn', 'id');

		// Assigning sortBy value
		$this->view->ssSortBy = $ssSortBy = $this->_getParam('sortBy', 'ASC');

		// Assigning search field
		$this->view->ssSearchField = $ssSearchField = $this->_getParam('searchSelect');

		// Assigning search keyword
		$this->view->ssSearchKeyword =  $ssSearchKeyword = strtolower($this->_getParam('searchKeyword'));
		
		/********** Optional Part Start FOR paginate()**********/
		// Assigning current page value
		$oCommon->snPage = $this->_getParam('page', 1);
		$oCommon->snRecordPerPage = 4;
		/********** Optional Part End FOR paginate()************/
		
		// Assigning search field
		$this->view->ssSearchField =$this->ssSearchField = $this->_getParam('searchSelect');

		// Assigning search keyword
		$this->view->ssSearchKeyword =$this->ssSearchKeyword = $this->_getParam('searchKeyword');
		
		//Fetch Zend_Locale to used in fetch Record 
		$ssCurrentLocale = Zend_Registry::get('Zend_Locale')->toString();

		$amVariableList = Doctrine::getTable('Model_Variable')->getVariableList($this->ssSortOn,$this->ssSortBy,$this->ssSearchField,$this->ssSearchKeyword,Zend_Registry::get('Zend_Locale'));

		$amVariableList = Doctrine::getTable('Model_Variable')->getVariableList($ssSortOn, $ssSortBy, $ssSearchField, $ssSearchKeyword,Zend_Registry::get('Zend_Locale'));
		
		// Get list
		$this->view->asHeading = array("lnk_variable_name","lbl_value","lbl_active","lbl_action");
		$this->view->asFieldName = $asFieldList = array("name", "value","is_active","");
		$this->view->asColumnSort = array(true,false,false,false);
		$this->view->asColumnWidth = array("40%", "30%", "10%", "20%");
		$this->view->asColumnAlign = array("left", "center", "center", "center");	
		$this->view->asSearchOption = array('name' => 'Variable','value' => 'Value');	
		
		
		//For Edit/Delete Link In Listing
		foreach($amVariableList  as $snKey => $amVariable)
		{
			$amVariableList[$snKey]['is_active'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/changeactive/id/".$amVariable['id']."/status/".$amVariable['is_active']."' title='Edit'><img src="."'"."/images/".(isset($amVariable['is_active']) && $amVariable['is_active'] == 1 ? "active_check.gif" : "deactive_check.gif")."'"."/></a>";
			$amVariableList[$snKey]['value'] = $amVariableList[$snKey]['Translation'][$ssCurrentLocale]['value'];
			$amVariableList[$snKey]['3'] = "<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/addedit/id/".$amVariable['id']."' title='Edit'><img src='/images/edit_icon.gif' ></a>" .
			"&nbsp;&nbsp;<a href='/".$this->_getParam('module')."/".$this->_getParam('controller')."/delete/id/".$amVariable['id']."' title='Delete' onclick='return deleteMsg()'><img src='/images/delete.gif'></a>";
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
		if($oRequest->isPost()) {
			// Checking post values are valid
			if( $oForm->isValid($oRequest->getPost())) {
				//If Id variable is get in request then Edit Record else Add Record
				if ($oRequest->getParam('id') > 0 ) {
					// For updating Variable detail
					Doctrine::getTable('Model_Variable')->UpdateVariable($oForm->getValues());
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('msg_record_updated_successfully'));	
					//Redirect to Variable-Index Page
					$this->_redirect('/variable/index');
				} else {
					$amAddLanguageData = $oForm->getValues();
					
					// Insert Variable Record
					Doctrine::getTable('Model_Variable')->InsertVariable($oForm->getValues());
					
					// For assigning success massage to flashMessenger
					$this->_helper->flashMessenger->addMessage(array('msg_record_added_successfully'));
					//Redirect to variable-Index Page
					$this->_redirect('/variable/index');	
				}			
			}
		}
		//For Populate Variable Edit Form Data
		if($this->getRequest()->getParam('id') != '' ) {
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
        if( $this->getRequest()->getParam('id') != '' ) {
			// For deleting Variable detail of given id
			Doctrine::getTable('Model_Variable')->deleteVariable( $this->getRequest()->getParam('id') );
			// For assigning success massage to flashMessenger
			$this->_helper->flashMessenger->addMessage(array('msg_record_deleted_successfully'));
			// Redirectes to Variale listing Page
			$this->_redirect('/variable/index');
        }
    }

    public function changeactiveAction()
    {
    	if($this->getRequest()->getParam('id') != '')
		{
			$snPageId = $this->getRequest()->getParam('id');
			$bStatus  = $this->getRequest()->getParam('status');
			$snChangeStatus = ($bStatus) ?  0 : 1;
      		$amUpdateIsActive = array ('id' => $snPageId , 'is_active' => $snChangeStatus);
			
			// For Change Default Variable as given id
			$bResult = Doctrine::getTable('Model_Variable')->changeIsActive($amUpdateIsActive);

			// On Success assigning success massage to flashMessenger
			if($bResult)
				$this->_helper->flashMessenger->addMessage(array('msg_record_edited'));
			
			// Redirectes to Variable listing Page
			$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
		}		
    }

    public function generatefileAction()
    {
   		$ssLanguageDir = LANGUAGE_PATH.'/';
		foreach(glob($ssLanguageDir.'*.*') as $ssLagFile){
    		unlink($ssLagFile);
		}
		
    	$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
    	foreach ($amLanguageList as $snKey => $ssLang) {
    		$ssLogfile = LANGUAGE_PATH.'/'.$amLanguageList[$snKey]['lang'].'.php';
			$handle = fopen($ssLogfile, 'w+') or die("can't open file");
			$ssFileStringData  = '';
			$ssFileStringData .= '<?php' . "\n";
			$ssFileStringData .= 'return array(' . "\n";
			$amLanguageList[$snKey]['lang'];
			$amVariableList = Doctrine::getTable('Model_Variable')->getAllVariableList($amLanguageList[$snKey]['lang']);

			foreach ($amVariableList as $snVarKey => $ssVarValues) {
	    		$ssVarName = $ssVarValues['name'];
    			$ssVarValue = $ssVarValues['Translation'][$amLanguageList[$snKey]['lang']]['value'];
    			$ssFileStringData .= '	'."'$ssVarName'".' => '."'$ssVarValue'".',' . "\n";
	    	}

	    	$ssFileStringData .= ');' . "\n";		
			fwrite($handle, $ssFileStringData);
			fclose($handle);
			chmod($ssLogfile,0777);
			$amLanguageList[$snKey]['lang'];
    	}
    	
    	$this->_helper->flashMessenger->addMessage(array('msg_successfully_generate_languages_files'));
    	$this->_redirect('/variable/index');
    }

    public function exportcsvAction()
    {
        $ssCsvHeader =  $amFieldList = '';
    	$amFieldlist = $amFieldFinalData = $finalData = array();
    	
    	//Fetch Language Table Data 
    	$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();   
    	
    	//Fetch Variable Table Data
        $asExportCsvdata = Doctrine::getTable('Model_Variable')->getAllVariableData();
		
		//Set exported file Name		
        $ssFilename = APPLICATION_PATH . "/tmp/Data-" . date( "m-d-Y-H-i-s" ) . ".csv";
		
        $realPath = realpath( $ssFilename );
		
		//Checking the Real path of file & change file mode
        if ( false === $realPath ){
            touch( $ssFilename );
            chmod( $ssFilename, 0777 );
        }
        
        //Open File for Writing
        $handle = fopen( $ssFilename, "w" );
        
        //........................Writing Heading start........................
        $amFieldList[] .= 'name';
		foreach($amLanguageList as $key => $amLanguage){
			$amFieldList[] .= $amLanguage['lang'];
		}
		
		$amFieldFinalData[] = $amFieldList;
        foreach ( $amFieldFinalData AS $FirstRow ){
            fputcsv( $handle , $FirstRow , ";" );
        }
        //........................Writing Heading End........................
         
        //........................Writing Values Start........................ 
        foreach ($asExportCsvdata  as $key => $row){
	    	 $Data[] = utf8_decode($row["name"]);
	         foreach($amLanguageList as $key => $amLanguage){
	    		$Data[] = utf8_decode($row['Translation'][$amLanguage['lang']]['value']);
	    		}
    		$finalData[]=$Data;
    		unset($Data);
        }

        foreach ( $finalData AS $finalRow ){
            fputcsv( $handle, $finalRow, ";" );
        }
        //........................Writing Values End........................ 

		//Close File
        fclose( $handle );

        $this->getResponse()->setRawHeader( "Content-Type: application/vnd.ms-excel; charset=UTF-8" )
            ->setRawHeader( "Content-Disposition: csv; filename=Data.csv" )
            ->setRawHeader( "Content-Transfer-Encoding: binary" )
            ->setRawHeader( "Expires: 0" )
            ->setRawHeader( "Cache-Control: must-revalidate, post-check=0, pre-check=0" )
            ->setRawHeader( "Pragma: public" )
            ->setRawHeader( "Content-Length: " . filesize( $ssFilename ) )
            ->sendResponse();

        readfile( $ssFilename ); exit();
    }

    public function importcsvAction()
    {
    	$this->view->form = $oForm = new Variable_Form_Importcsv();
    	//Fetch Language Table Data 
    	$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList(); 	
	   
	    $oRequest = $this->getRequest();
      	
		// Checking request method is post
		if( $oRequest->isPost() )
		{
			// Checking post values are valid
			if( $oForm->isValid( $oRequest->getPost() ) )
			{
				$snFileSize = 0;
				$ssFieldValue =  $sm__fieldValue = $sn__countField =  $sn__toalFail = '';
				$data = $ss__fields = $amFieldList = array();
				$sn__totalRowFail =  $sn__totalRowInsert = 1;  
				
				$asFormData = $oForm->getValues();				
			    $filename = APPLICATION_PATH.'/tmp/import/'.$_FILES['importcsv']['name'];
			    
			    $sn__fileSize = filesize($filename);
		        $ssFileOpen = fopen($filename,"r");		        
				$sm__csvContent = fread($ssFileOpen,$sn__fileSize);
				
				$sn__dataLine  = explode("\n",$sm__csvContent); 
				$sn__totalRow = count($sn__dataLine);
				$sn__lastRow = $sn__totalRow-1;
				$inserRow=1;
				$errorInserRow=1;
				
				foreach($sn__dataLine as $sn__key => $ss__value){
					if($sn__key !== $sn__lastRow){
						if($sn__key==0){
							$ss__field = explode(';',$ss__value);
							$sn__countField = count($ss__field);
							$ss__fields[] = $ss__field;
							
							//Create language wise array for check Field Value
							$ssNameField = "name";
							$amFieldList[] = '"'.$ssNameField.'"';
							foreach($amLanguageList as $key => $amLanguage){
								$amFieldList[] .= '"'.$amLanguage['lang'].'"';
							}
							
							//check field value with language array
							$result =($ss__fields[0] === $amFieldList);
							if(!$result){
								$this->_helper->flashMessenger->addMessage(array('msg_field_name_not_proper'));
								$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
								exit;
							}
						} else {
							$sm__fieldvalue = explode(";",$ss__value);
							$sn__countValue =count($sm__fieldvalue);
							$sm__fieldvalues[] =  $sm__fieldvalue;
							
							if($sn__countField == $sn__countValue){
							
							}
							else{
								$sn__toalFail = $sn__totalRowFail++;
							}
						}	
					}		
				}
				
					echo "<pre>";
				/*	print_r($ss__fields);
					print_r($sm__fieldvalues);*/
					
				
				foreach($ss__fields as $keydata => $Fieldvalue)	
				{
					
					foreach($sm__fieldvalues as $keydata => $value)	
					{
						$keydata[$keydata][$Fieldvalue] = $value;
					}	
					
				}
				
				print_r($data);exit;
							//if($sm__fieldvalue[0]!=='' && $sm__fieldvalue[1]!=='' && $sm__fieldvalue[2]!=='' && $sm__fieldvalue[3]!=='' && $sm__fieldvalue[4]!=='' && $sm__fieldvalue[5]!=='' && $sm__fieldvalue[6]!=='' && $sm__fieldvalue[7]!=='' && $sm__fieldvalue[8]!=='' &&  $sm__fieldvalue[9]!==''){
				/*if(($handle = )fopen($filename, 'r')) !== FALSE) {
				            // necessary if a large csv file
				            set_time_limit(0);
				
				            $row = 0;
				
				            while(($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
				                // number of fields in the csv
				                $num = count($data);
				
				                // get the values from the csv
				                $csv[$row]['name'] = $data[0];
				                $csv[$row][] = $data[1];
				
				                // inc the row
				                $row++;
				            }
			            fclose($handle);
	        	}
	        	echo"<pre>";
				print_r($csv);exit;*/
				
			
			}	
		}	
    }

	
}

