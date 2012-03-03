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
	* @param array $amCatId To store category detail
	* @return boolean
	*/
	public function insertCategory($asCategory = array())
	{
		if( (!is_array( $asCategory ) || empty( $asCategory ))) return false;
		
		//print_r($asCategory);exit;
		try
		{
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			
			if( $asCategory['parentid'] > 0 ) {
				$amCatLevel = Doctrine::getTable('Model_Category')->find($asCategory['parentid'])->toArray();
				$snCurrentLevel = $amCatLevel['level'];
				$snInsertLevel = $snCurrentLevel + 1;
			}
			
			$oCategory = new Model_Category();
			
			foreach($asLanguageList as $snKey => $amValues) {
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
	* For get category record
	*
	* @author suresh chikani
	* @access public
	* @param  array $amCategories To store category detail
	* @param  $snParentid To store category parentid
	* @return array
	*/
	public function getCatList($snParentid = 0, $amCategories = array())
	{
		$oSelectQuery = Doctrine_Query::create();
		$oSelectQuery->select('C.id, C.is_active, C.level, C.parentid, T.*');
		$oSelectQuery->from("Model_Category C " );
		$oSelectQuery->leftjoin("C.Translation T");
		$oSelectQuery->where("C.parentid = ? ", $snParentid );
		$oSelectQuery->andwhere("T.lang = ?", Zend_Registry::get('Zend_Locale'));
		$oSelectQuery->orderBy('parentid, level');
		
		$oCategories = $oSelectQuery->fetchArray();
		
		if ( $oCategories ) {
			foreach ($oCategories as $amCategory){
				$amNewCategory = $amCategories[$amCategory['id']] = $amCategory;
				$amCategories[$amCategory['id']] = $this->getCatList($amCategory['id'], $amNewCategory);
			}
		}
		return $amCategories;
	}
	/**
	* For get category record by editid
	*
	* @author suresh chikani
	* @access public
	* @param  $snEditId To store category id 
	* @return array
	*/
	public function getCategoryById($snEditId = 0)
	{
		$oSelectQuery = Doctrine_Query::create();
		$oSelectQuery->select('C.*, T.*');
		$oSelectQuery->from("Model_Category C " );
		$oSelectQuery->leftjoin("C.Translation T");
		$oSelectQuery->where("C.id = ? ", $snEditId );
		
		return $oCategories = $oSelectQuery->fetchArray();
		
	}
	/**
	* For delete category record
	*
	* @author suresh chikani
	* @access public
	* @param  $snId To store category id 
	* @return boolean
	*/
	public function deletecat($snId = 0)
	{
		if( $snId == "" || !is_numeric($snId) ) return false;
		
		//delete category from category and translatetable table
		Doctrine_Query::create()
				->delete("Model_Category C")
				->where("C.id = ?", $snId)
				->execute();
		return true;
	}
	/**
	* For change category isactive status
	*
	* @author suresh chikani
	* @access public
	* @param  array $amUpdateData To store category data  
	* @return boolean
	*/	
	public function updateStatus($amUpdateData = array())
	{
		if( !is_array( $amUpdateData ) || empty( $amUpdateData ) ) return false;
		
		try
		{
			//update isactive in category table
			$oUserInfo = Doctrine_Query::create()
				->update("Model_Category C")
				->set("C.is_active", "?", $amUpdateData['is_active'])
				->set("C.updated_at", "?", date('Y-m-d H:i:s'));
				
			$oUserInfo->where("C.id = ?", $amUpdateData['id']);
			$oUserInfo->execute();
						
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
	* @param array $amPostUpdateData To store update category detail
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
			
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $snKey => $amValues) {
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
