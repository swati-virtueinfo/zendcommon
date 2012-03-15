<?php
/**
*/
class Model_PagesTable extends Doctrine_Table
{
	public function getPageMenu($ssCulture = 'en', $snPageId = '',$bNeedTree = true)
	{
		$ssQuery ='';
		$saPages = array();
		$oPages = '';
		if($ssCulture != ''){
			$ssQuery = Doctrine_Query::create();
			$ssQuery->select('P.*, T.*');
			$ssQuery->from("Model_Pages P " );
			$ssQuery->leftjoin('P.Translation T with T.lang like ?', array($ssCulture));

			if (!empty($snPageId) && $snPageId > 0)
				$ssQuery = $ssQuery->andWhere('P.id != ?', $snPageId);
			
			$oPages = $ssQuery->orderBy('P.ord ', 'ASC')->execute();
			
			if($oPages->count() > 0){
				foreach($oPages as $oPage){
					$saTempPages['items'][$oPage['id']] = $oPage;
					$saTempPages['parents'][$oPage['parent_id']][] = $oPage['id'];
				}
				
				if($bNeedTree)
					$saPages = self::buildTree(0,$saTempPages,$ssCulture);
				else
					$saPages = $saTempPages;
			}
		}
		return $saPages;
	}
	
	public static function buildTree($siParent,$saTempPages,$ssCulture)
	{
		$html = array();
		if (isset($saTempPages['parents'][$siParent]))
		{
			foreach ($saTempPages['parents'][$siParent] as $itemId)
			{
				$menuname = $saTempPages['items'][$itemId];
				$html[$itemId]['id'] = $menuname['id'];
				$html[$itemId]['parent_id'] = $menuname['parent_id'];
				$html[$itemId]['menu_name'] = $menuname['Translation'][$ssCulture]['menu_name'];
				$html[$itemId]['title'] = $menuname['Translation'][$ssCulture]['title'];
				$html[$itemId]['is_active'] = $menuname['is_active'];
				$html[$itemId]['ord'] = $menuname['ord'];
				if(isset($saTempPages['parents'][$itemId]))
				{
					$html[$itemId]['childs'] =  self::buildTree($itemId, $saTempPages,$ssCulture);
				}
			}
		}
		return $html;
	}
	
	/**
	* For Fetch Record of Given Page Id From Pages Table
	*
	* @author Bhaskar joshi
	* @param  number $snPageId for Pages Id field
	* @access public
	* @return array of Pages table records 
	*/
	public function getPagesById($snPageId = '')
	{
		if( $snPageId == "" || !is_numeric($snPageId) || $snPageId == 0 ) return false;
		try
		{
			$oPageSelectQuery = Doctrine_Query::create();
			$oPageSelectQuery->select('P.*, T.*');
			$oPageSelectQuery->from("Model_Pages P " );
			$oPageSelectQuery->leftjoin("P.Translation T");
			$oPageSelectQuery->where("P.id = ?", $snPageId);
			return $oPageSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Insert Page data
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $amPageData is form Data array
	* @return boolean
	*/
	public function InsertPage($amPageData = array())
	{
		if(!is_array($amPageData) || empty($amPageData)) return false;
		
		try
		{
			$oPage = new Model_Pages();		
			$oPage->parent_id = $amPageData['parent_id'];	
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $snKey => $amPageValues) 
			{
				 $oPage->Translation[$amPageValues['lang']]->title = $amPageData['site_pages_title_' . $amPageValues['lang']];
				 $oPage->Translation[$amPageValues['lang']]->menu_name = $amPageData['site_pages_menu_name_' . $amPageValues['lang']];
				 $oPage->Translation[$amPageValues['lang']]->meta_title = $amPageData['site_pages_meta_title_' . $amPageValues['lang']];
				 $oPage->Translation[$amPageValues['lang']]->meta_keyword = $amPageData['site_pages_meta_keyword_' . $amPageValues['lang']];
				 $oPage->Translation[$amPageValues['lang']]->content = $amPageData['site_pages_content_' . $amPageValues['lang']];
				 $oPage->Translation[$amPageValues['lang']]->meta_description = $amPageData['site_pages_meta_description_' . $amPageValues['lang']];
			}
			$oPage->url = $amPageData['url'];
			$oPage->is_active = $amPageData['is_active'];
			$oPage->created_at =  date('Y-m-d H:i:s');
			$oPage->updated_at =  date('Y-m-d H:i:s');
			
			$oPage->save();
			
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Update Page data
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $amPageData is form Data array
	* @return boolean
	*/
	public function UpdatePage($amPageData = array())
	{
		if( !is_array( $amPageData ) || empty( $amPageData ) ) return false;

		try
		{   
			//Updateing Pages Table
			$oUpdatePage = Doctrine::getTable('Model_Pages')->find($amPageData['id']);			
			$oUpdatePage->set("parent_id",$amPageData['parent_id']);	
			$oUpdatePage->set("url",$amPageData['url']);
			$oUpdatePage->set("is_active", $amPageData['is_active']);
			$oUpdatePage->set("updated_at", date('Y-m-d H:i:s'));
			
			//Updateing Pages Transaction Table 
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $snKey => $amPageValues) {
				$oUpdatePage->Translation[$amPageValues['lang']]->title = $amPageData['site_pages_title_' . $amPageValues['lang']];
				$oUpdatePage->Translation[$amPageValues['lang']]->menu_name = $amPageData['site_pages_menu_name_' . $amPageValues['lang']];
				$oUpdatePage->Translation[$amPageValues['lang']]->meta_title = $amPageData['site_pages_meta_title_' . $amPageValues['lang']];
				$oUpdatePage->Translation[$amPageValues['lang']]->meta_keyword = $amPageData['site_pages_meta_keyword_' . $amPageValues['lang']];
				$oUpdatePage->Translation[$amPageValues['lang']]->content = $amPageData['site_pages_content_' . $amPageValues['lang']];
				$oUpdatePage->Translation[$amPageValues['lang']]->meta_description = $amPageData['site_pages_meta_description_' . $amPageValues['lang']];
			}

			$oUpdatePage->save();
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Enable Disable Page
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number  $snPageId is id of Page 
	* @param  boolean $b__isActive for check the value of is_active on click
	* @return boolean
	*/
	public function enalbleDisablePage($snPageId = 0, $bIsActive)
	{
		if((empty($snPageId) && empty($bIsActive)) || !is_numeric($snPageId) || $snPageId == 0 ) return false;
		
		try
		{
			//change the value of is_active of Given Row Id
			$bIsActive = ($bIsActive) ? 0 : 1;
			
			//Update Page table
			$asLanguageUpdate = Doctrine_Query::create()
					->update("Model_Pages P")
					->set("P.is_active", "?", $bIsActive)
					->set("updated_at", "?", date('Y-m-d H:i:s'))
					->where("P.id = ?", $snPageId)
					->execute();
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}		
	}
	
	/**
	* For Delete Page
	*
	* @author Bhaskar joshi
	* @access public
	* @param  $snPageId for Which Page Id is Delete
	* @return boolean
	*/
	public function deletePage($snPageId = 0)
	{
		if( $snPageId == "" || !is_numeric($snPageId) || $snPageId == 0 ) return false;
		try
		{
			//delete data from Varible table
			Doctrine_Query::create()
						->delete("Model_Pages P")
						->where("P.id = ?", $snPageId)
						->execute();
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}		
	}
}