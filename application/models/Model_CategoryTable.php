<?php

class Model_CategoryTable extends Doctrine_Table
{
	
	/**
	* For Fetch All Record From Category Table
	*
	* @author Bhaskar joshi
	* @access public
	* @return array of Category table records 
	*/
	public function getAllCategoryData()
	{
		
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('c.*, T.*');
			$oSelectQuery->from("Model_Category c" );
			return $oSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For inserting category detail
	*
	* @author suresh chikani
	* @access public
	* @param array $asCategory To store category detail
	* @return boolean
	*/
	public function insertCategory($asCategory = array())
	{
		if( (!is_array( $asCategory ) || empty( $asCategory ))) return false;
		
		//print_r($asCategory);exit;
		try
		{
			$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			
			if( $asCategory['parentid'] > 0 ) {
				$amCatLevel = Doctrine::getTable('Model_Category')->find($asCategory['parentid'])->toArray();
				$snCurrentLevel = $amCatLevel['level'];
				$snInsertLevel = $snCurrentLevel + 1;
			}
			
			$oCategory = new Model_Category();
			
			foreach($amLanguageList as $snKey => $amValues) {
				$oCategory->Translation[$amValues['lang']]->name = $asCategory['name_' . $amValues['lang']];
			}
			$oCategory->Translation[$amValues['lang']]->name;
			$asCategory['name_' . $amValues['lang']];
			
			$oCategory->image_name = $asCategory['image_name'];
			$oCategory->parentid = $asCategory['parentid'];
			$oCategory->is_active = $asCategory['is_active'];
			$oCategory->level = $snInsertLevel;
			$oCategory->save();
			
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For get category record by locale
	*
	* @author suresh chikani
	* @access public
	* @param  array $amCategories To store category detail
	* @param  $snParentid To store category parentid
	* @param  $ssLang To store current language
	* @return array
	*/
	public function getCategoryList($ssLang = 'en', $snParentid = 0, $amCategories = array())
	{
		if( !is_numeric($snParentid) || !is_array( $amCategories ) || empty($ssLang) ) return false;
		
		try
		{ 
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('C.id, C.is_active, C.level, C.parentid, T.*');
			$oSelectQuery->from("Model_Category C " );
			$oSelectQuery->leftjoin("C.Translation T");
			$oSelectQuery->where("C.parentid = ? ", $snParentid );
			$oSelectQuery->andwhere("T.lang = ?", $ssLang);
			$oSelectQuery->orderBy('parentid, level');
			
			$oCategories = $oSelectQuery->fetchArray();
			
			if ($oCategories) {
				foreach ($oCategories as $amCategory){
					$amNewCategory = $amCategories[$amCategory['id']] = $amCategory;
					$amCategories[$amCategory['id']] = $this->getCategoryList($ssLang, $amCategory['id'], $amNewCategory);
				}
			}
			return $amCategories;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}	
		
			
	}
	
	/**
	* For get category record by id
	*
	* @author suresh chikani
	* @access public
	* @param  $snEditId To store category id 
	* @return array
	*/
	public function getCategoryById($snEditId = '')
	{
		if( $snEditId == '' || !is_numeric($snEditId) ) return false;
		
		try
		{	
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('C.*, T.*');
			$oSelectQuery->from("Model_Category C " );
			$oSelectQuery->leftjoin("C.Translation T");
			$oSelectQuery->where("C.id = ? ", $snEditId );
			
			return $oCategories = $oSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}	
		
	}
	
	/**
	* For delete category record
	*
	* @author suresh chikani
	* @access public
	* @param  $snId To store category id 
	* @return boolean
	*/
	public function deleteCategoryById($snId = '')
	{
		if( $snId == '' || !is_numeric($snId) ) return false;
		
		try
		{
			$oDeleteQuery = Doctrine_Query::create();
			$oDeleteQuery->delete("Model_Category C");
			$oDeleteQuery->where("C.id = ?", $snId);
			$oDeleteQuery->execute();
				
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
			
	}
	
	/**
	* For change category isactive status
	*
	* @author suresh chikani
	* @access public
	* @param  array $amUpdateData To store category data  
	* @return boolean
	*/	
	public function changeIsActive($amUpdateData = array())
	{
		if( !is_array( $amUpdateData ) || empty( $amUpdateData ) ) return false;
		
		try
		{
			$oChangeActivation = Doctrine_Query::create();
			$oChangeActivation->update("Model_Category C");
			$oChangeActivation->set("C.is_active", "?", $amUpdateData['is_active']);
			$oChangeActivation->set("C.updated_at", "?", date('Y-m-d H:i:s'));
				
			$oChangeActivation->where("C.id = ?", $amUpdateData['id']);
			$oChangeActivation->execute();
						
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For update category detail
	*
	* @author suresh chikani
	* @access public
	* @param array $amFormUpdateData To store update category detail
	* @return boolean
	*/
	public function updateCategory($amFormUpdateData = array())
	{
		if( !is_array( $amFormUpdateData ) || empty( $amFormUpdateData ) ) return false;
			
		try
		{
			$oUpdateCategory = Doctrine::getTable('Model_Category')->find($amFormUpdateData['editid']);
			
			if($amFormUpdateData['image_name'] == '')
				$oUpdateCategory->set("image_name", $oUpdateCategory['image_name']);
			else
				$oUpdateCategory->set("image_name", $amFormUpdateData['image_name']);
			
			$oUpdateCategory->set("is_active", $amFormUpdateData['is_active']);
			$oUpdateCategory->set("updated_at", "?", date('Y-m-d H:i:s'));
			
			$amLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($amLanguageList as $snKey => $amValues) {
				$oUpdateCategory->Translation[$amValues['lang']]->name = $amFormUpdateData['name_' . $amValues['lang']];
			}
			
			$oUpdateCategory->save();
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
		
}
