<?php

class Model_LanguageTable extends Doctrine_Table
{
	/**
	* For Fetch All Record From Language Table
	*
	* @author Bhaskar joshi
	* @access public
	* @return array of Language table records 
	*/
	public function getLanguageList($ssSortOn = '', $ssSortBy = '', $ssSearchField = '', $ssSearchKeyword = '')
	{  
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('*');
			$oSelectQuery->from("Model_Language");
			if( !empty($ssSearchField) && !empty($ssSearchKeyword) )
				$oSelectQuery->where($ssSearchField . " LIKE '%" . $ssSearchKeyword . "%'" );
		
			if( !empty($ssSortOn) && !empty($ssSortBy) )
				 $oSelectQuery->orderBy( $ssSortOn . ' ' . $ssSortBy );

			return $oSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Get Default Language 
	*
	* @author Bhaskar joshi
	* @access public
	* @return array  
	*/
	public function getDefaultLanguage()
	{
		try
		{
			$amLanguageData = Doctrine_Query::create();
			$amLanguageData->select('id,name,lang');
			$amLanguageData->from("Model_Language");
			$amLanguageData->where('is_default = ? ', 1);
			
			return $amLanguageData->fetchOne()->toArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Get Active Languages
	*
	* @author Bhaskar joshi
	* @access public
	* @return array 
	*/
	public function getActiveLanguageList()
	{
		try
		{
			$amLanguageData = Doctrine_Query::create();
			$amLanguageData->select('*');
			$amLanguageData->from("Model_Language");
			$amLanguageData->where('is_active = ? ', 1);
			
			return $amLanguageData->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Insert Language detail
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $asLanguageData is form Data array
	* @return boolean
	*/
	public function InsertLanguage($asLanguageData = array())
	{
		if(!is_array($asLanguageData) || empty($asLanguageData)) return false;

		try
		{
			//Inserting Language into table
			$oLanguage = new Model_Language();
			$oLanguage->name = $asLanguageData['name'];
			$oLanguage->lang = $asLanguageData['lang'];
			$oLanguage->is_default = $asLanguageData['is_default'];
			$oLanguage->is_active = $asLanguageData['is_active'];
			$oLanguage->flag = $asLanguageData['flag'];
			$oLanguage->created_at =  date('Y-m-d H:i:s');
			$oLanguage->updated_at =  date('Y-m-d H:i:s');
			$oLanguage->save();
			
			//Getting Last Insert Record Id & is_default Value
			$snLastInsertId = $oLanguage['id'];
			$IsDefaultValue = $oLanguage['is_default'];
			
			//check if last insert Record is_default value is true 
			if($IsDefaultValue == 1)
			{
				//Update Other Record is_default value false 
				$asLanguageUpdate = Doctrine_Query::create();
				$asLanguageUpdate->update("Model_Language L");
				$asLanguageUpdate->set("L.is_default", "?", 0);
				$asLanguageUpdate->where("L.id != ?", $snLastInsertId);
				$asLanguageUpdate->execute();
			}
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Update Language
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $asLanguageUpdateData is Form Data to Update
	* @return boolean
	*/
	public function UpdateLanguage($asLanguageUpdateData = array())
	{
		if( !is_array( $asLanguageUpdateData ) || empty( $asLanguageUpdateData ) ) return false;
		
		try
		{
			//Update Language table
			$asLanguageUpdate = Doctrine_Query::create();
			$asLanguageUpdate->update("Model_Language L");
			$asLanguageUpdate->set("L.name", "?", $asLanguageUpdateData['name']);
			$asLanguageUpdate->set("L.lang", "?", $asLanguageUpdateData['lang']);
			$asLanguageUpdate->set("L.is_active", "?", $asLanguageUpdateData['is_active']);
						
			if(!empty($asLanguageUpdateData['flag']))
			{
				$asLanguageUpdate->set("L.flag", "?" , $asLanguageUpdateData['flag']);
			}
			$asLanguageUpdate->set("updated_at", "?" , date('Y-m-d H:i:s'));	
			$asLanguageUpdate->where("L.id = ?", $asLanguageUpdateData['id']);
			$asLanguageUpdate->execute();
			
			if($asLanguageUpdateData['is_default'] == 1)
			{
				$asLanguageUpdate = Doctrine_Query::create();
				$asLanguageUpdate->update("Model_Language L");
				$asLanguageUpdate->set("L.is_default", "?", 0);
				$asLanguageUpdate->set("updated_at", "?" , date('Y-m-d H:i:s'));
				$asLanguageUpdate->where("L.id != ?", $asLanguageUpdateData['id']);
				$asLanguageUpdate->execute();
			}
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}	
	
	/**
	* For Delete Language
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number $snLanguageId for Which language Id is Delete
	* @return boolean
	*/
	public function deleteLanguage($snLanguageId = '')
	{
		if( $snLanguageId == "" || !is_numeric($snLanguageId) ) return false;
		
		try
		{
			$oDeleteQuery = Doctrine_Query::create();
			$oDeleteQuery->delete("Model_Language L");
			$oDeleteQuery->where("L.id = ?", $snLanguageId);
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
	* For change Default Language 
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number $snLanguageId is Language set as default
	* @return boolean
	*/
	public function changeDefaultLanguage($snLanguageId = '')
	{
		if( $snLanguageId == "" || !is_numeric($snLanguageId)) return false;
		
		try
		{
			$asLanguageUpdate = Doctrine_Query::create();
			$asLanguageUpdate->update("Model_Language L");
			$asLanguageUpdate->set("L.is_default", "?", 1);
			$asLanguageUpdate->set("updated_at", "?", date('Y-m-d H:i:s'));
			$asLanguageUpdate->where("L.id = ?", $snLanguageId);
			$asLanguageUpdate->execute();
				
			$asLanguageUpdateOther = Doctrine_Query::create();
			$asLanguageUpdateOther->update("Model_Language L");
			$asLanguageUpdateOther->set("L.is_default", "?", 0);
			$asLanguageUpdateOther->where("L.id != ?", $snLanguageId);
			$asLanguageUpdateOther->execute();
			
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}		
	}
	
	/**
	* For change Active Language Or Not
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array  $snLanguageId is id of language to set active
	* @return boolean
	*/
	public function changeIsActive($amUpdateData = array())
	{
		if( !is_array( $amUpdateData ) || empty( $amUpdateData ) ) return false;
		
		try
		{
			$oLanguageUpdate = Doctrine_Query::create();
		    $oLanguageUpdate->update("Model_Language L");
			$oLanguageUpdate->set("L.is_active", "?", $amUpdateData['is_active']);
			$oLanguageUpdate->set("updated_at", "?", date('Y-m-d H:i:s'));
			$oLanguageUpdate->where("L.id = ?", $amUpdateData['id']);
			$oLanguageUpdate->execute();
			
			return ($oLanguageUpdate) ? true : false;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}		
	}
	
}