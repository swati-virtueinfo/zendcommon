<?php
/**
 * Pages_Form_Addedit
 * Pages Add/Edit Form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Pages_Form_Addedit extends Zend_Form
{
    public function init()
    {
        //Get Page Id 
        $oRequest = Zend_Controller_Front::getInstance()->getRequest();
		$snPageId = $oRequest->getParam('id');
		
		$asElementArray=array();
		
		//Fetch Zend_Locale to used in fetch Record 
		$ssCurrentLocale = Zend_Registry::get('Zend_Locale')->toString(); 
		
		//set id hidden field at Edit
		if ($snPageId > 0) {
			$oPageId = new Zend_Form_Element_Hidden("id");
			$oPageId->setRequired(false);
			array_push($asElementArray, $oPageId);
		}
		//$this->getTranslator();
		$amPagesList = $this->getPageTreeCombo($ssCurrentLocale, $snPageId);
		$ssParentId = $this->createElement('select','parent_id',array('label' => 'Parent * '));
		$ssParentId->setRequired(true);
		$ssParentId->addMultiOptions($amPagesList);
		array_push($asElementArray,$ssParentId);
	
		//Get Languages list for Creating Textbox As Per language
		$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();	
		
		$oTitle = $this->createElement('text','cn_title',array('label' =>  $this->getTranslator()->_('lbl_title')));
		$oMenuName = $this->createElement('text','menu_name',array('label' => $this->getTranslator()->_('lbl_menu_name')));
		$oMetatitle = $this->createElement('text','meta_title',array('label' => $this->getTranslator()->_('lbl_meta_title')));
		$oMetaKeyword = $this->createElement('text','meta_keyword',array('label' => $this->getTranslator()->_('lbl_meta_keyword')));
		$oContent = $this->createElement('text','content',array('label' => $this->getTranslator()->_('lbl_content')));
		$oMetaDescription = $this->createElement('text','meta_description',array('label' => $this->getTranslator()->_('lbl_meta_description')));
		
		foreach($asLanguageList as $key => $amLanguage)
		{
			//Set Title textbox
    		$oPagesTitleLang[$amLanguage['lang']] = $this->createElement('text','pages_title_' . $amLanguage['lang']);
			$oPagesTitleLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_pages_title_required')));
			$oPagesTitleLang[$amLanguage['lang']]->setRequired(true);
			
			//Set Menu Name textbox
			$oPagesMenuNameLang[$amLanguage['lang']] = $this->createElement('text','pages_menu_name_' . $amLanguage['lang']);
			$oPagesMenuNameLang[$amLanguage['lang']]->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'msg_pages_menu_name_required')));
			$oPagesMenuNameLang[$amLanguage['lang']]->setRequired(true);
			
			//Set Meta Title textbox
			$oPagesMetaTitleLang[$amLanguage['lang']] = $this->createElement('text','pages_meta_title_' . $amLanguage['lang']);
			$oPagesMetaTitleLang[$amLanguage['lang']]->setRequired(false);
			
			//Set Meta keyword textbox
			$oPagesMetaKeywordLang[$amLanguage['lang']] = $this->createElement('text','pages_meta_keyword_' . $amLanguage['lang']);
			$oPagesMetaKeywordLang[$amLanguage['lang']]->setRequired(false);
			
			//Set Content textarea
			$oPagesContent[$amLanguage['lang']] = $this->createElement('textarea','pages_content_' . $amLanguage['lang'], array('rows' => '3', 'cols' => '20' ));
			$oPagesContent[$amLanguage['lang']]->setRequired(false);
			
			//Set Meta Description textarea
			$oPagesMetaDescription[$amLanguage['lang']] = $this->createElement('textarea','pages_meta_description_' . $amLanguage['lang'], array('rows' => '3', 'cols' => '20'));
			$oPagesMetaDescription[$amLanguage['lang']]->setRequired(false);
			
			array_push($asElementArray, $oPagesTitleLang[$amLanguage['lang']],$oPagesMenuNameLang[$amLanguage['lang']],$oPagesMetaTitleLang[$amLanguage['lang']],$oPagesMetaKeywordLang[$amLanguage['lang']],$oPagesContent[$amLanguage['lang']],$oPagesMetaDescription[$amLanguage['lang']]);
    	}
    	//Set Url textBox
    	$oSitePageUrl = $this->createElement('text','url', array('label' => $this->getTranslator()->_('lbl_Url')));
		$oSitePageUrl->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => $this->getTranslator()->_('msg_pages_url_required'))));
		$oSitePageUrl->addValidator('regex', false, array('pattern' => '/^[öäåÖÄÅA-Z-a-z_0-9\s]+$/i',
		 							'messages' => array('regexNotMatch'   => "Invalid type given, value should be string, integer or float")));					
		$oSitePageUrl->setRequired(true);			
		array_push($asElementArray,$oSitePageUrl);
		
		//Set isactive check box				
		$ochkIsActive = new Zend_Form_Element_Checkbox("is_active");
      	$ochkIsActive->setLabel($this->getTranslator()->_("lbl_active"))
					 ->setChecked(true);		
		array_push($asElementArray,$ochkIsActive, $oTitle, $oMenuName, $oMetatitle, $oMetaKeyword, $oContent, $oMetaDescription);
						
		$this->addElements($asElementArray);
    }
    
    /**
	* For getPageTreeCombo for fill parent combo 
	*
	* @author Bhaskar joshi
	* @param  string $ssCulture for language culture
	* @param  number $snPageId for Page Id
	* @access public
	* @return array 
	*/
    public function getPageTreeCombo($ssCulture, $snPageId = 0)
	{
		$amSitePageList = $amSitePages = array();
	    $snLastIdRef = false;
	    
	    $amSitePages = Doctrine::getTable('Model_Pages')->getPageMenu($ssCulture, $snPageId);
		$iteriter = new RecursiveIteratorIterator(new RecursiveArrayIterator($amSitePages), RecursiveIteratorIterator::SELF_FIRST);
		
		$amSitePageList[0] = 'set_root'; 
		foreach ($iteriter as $snKey => $saValue) {
			if (is_numeric($snKey)) {
		  		$snLastIdRef = $snKey;
		    } else if ($snKey == 'menu_name') {
				$amSitePageList[$snLastIdRef] = html_entity_decode(str_repeat("&nbsp;", $iteriter->getDepth() - 1), ENT_COMPAT, 'UTF-8') . $saValue;
			}
		}
	    return $amSitePageList;
	}
}