<?php
/**
 */
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
	* @return object of doctrine query 
	*/
	public function getDefaultLanguage()
	{
		try
		{
			$amLanguageData = Doctrine_Query::create()
						->select('id,name,lang')
						->from("Model_Language")
						->where('is_default = ? ', 1);
			
			return  $amLanguageData;
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
	* @return object of doctrine query 
	*/
	public function getActiveLanguageList()
	{
		try
		{
			$amLanguageData = Doctrine_Query::create()
						->select('*')
						->from("Model_Language")
						->where('is_active = ? ', 1);
			
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
	public function InsertUser($asLanguageData = array())
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
			$b__isDefaultValue = $oLanguage['is_default'];
			
			//check if last insert Record is_default value is true 
			if($b__isDefaultValue == 1)
			{
				//Update Other Record is_default value false 
				$asLanguageUpdate = Doctrine_Query::create()
						->update("Model_Language L")
						->set("L.is_default", "?", 0)
						->where("L.id != ?", $snLastInsertId)
						->execute();
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
			$asLanguageUpdate = Doctrine_Query::create()
						->update("Model_Language L")
						->set("L.name", "?", $asLanguageUpdateData['name'])
						->set("L.lang", "?", $asLanguageUpdateData['lang'])
						->set("L.is_active", "?", $asLanguageUpdateData['is_active']);
						
			if(!empty($asLanguageUpdateData['flag']))
			$asLanguageUpdate->set("L.flag", "?" , $asLanguageUpdateData['flag']);
			$asLanguageUpdate->set("updated_at", "?" , date('Y-m-d H:i:s'));	
			$asLanguageUpdate->where("L.id = ?", $asLanguageUpdateData['id']);
			$asLanguageUpdate->execute();
			
			if($asLanguageUpdateData['is_default'] == 1)
			{
				$asLanguageUpdate = Doctrine_Query::create()
						->update("Model_Language L")
						->set("L.is_default", "?", 0)
						->set("updated_at", "?" , date('Y-m-d H:i:s'))
						->where("L.id != ?", $asLanguageUpdateData['id'])
						->execute();
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
	* @param  $snLanguageId for Which language Id is Delete
	* @return boolean
	*/
	public function deleteLanguage($snLanguageId = '')
	{
		if( $snLanguageId == "" || !is_numeric($snLanguageId) ) return false;
		try
		{
			//delete data from Language table
			Doctrine_Query::create()
						->delete("Model_Language L")
						->where("L.id = ?", $snLanguageId)
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
	* For change Default Language 
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number $snLanguageId is Language set as default
	* @return boolean
	*/
	public function changeDefaultLanguage($snLanguageId = '')
	{
		if( $snLanguageId == "" || !is_numeric($snLanguageId) ) return false;
		try
		{
			//Update Language table
			$asLanguageUpdate = Doctrine_Query::create()
					->update("Model_Language L")
					->set("L.is_default", "?", 1)
					->set("updated_at", "?", date('Y-m-d H:i:s'))
					->where("L.id = ?", $snLanguageId)
					->execute();
				
			$asLanguageUpdateOther = Doctrine_Query::create()
					->update("Model_Language L")
					->set("L.is_default", "?", 0)
					->where("L.id != ?", $snLanguageId)
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
	* For change Active Language Or Not
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number  $snLanguageId is id of language to set active
	* @param  boolean $b__isActive for check the value of is_active on clicked id
	* @return boolean
	*/
	public function changeActiveLanguage($snLanguageId = '',$b__isActive)
	{
		
		if( $snLanguageId == "" || !is_numeric($snLanguageId)) return false;
		try
		{
			//change the value of is_active of Given Row Id
			$bIsActive = ($b__isActive) ? 0 : 1;
			
			//Update Language table
			$asLanguageUpdate = Doctrine_Query::create()
					->update("Model_Language L")
					->set("L.is_active", "?", $bIsActive)
					->set("updated_at", "?", date('Y-m-d H:i:s'))
					->where("L.id = ?", $snLanguageId)
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