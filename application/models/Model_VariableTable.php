<?php
/**
 */
class Model_VariableTable extends Doctrine_Table
{
	/**
	* For Fetch All Record From Variable Table
	*
	* @author Bhaskar joshi
	* @access public
	* @return array of Variable table records 
	*/
	public function getVariableList($ssSortOn = '', $ssSortBy = '', $ssSearchField = '', $ssSearchKeyword = '',$ssLang = 'en')
	{
		
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('v.id, v.name,v.is_active, T.*');
			$oSelectQuery->from("Model_Variable v " );
			$oSelectQuery->leftjoin("v.Translation T");
			$oSelectQuery->andwhere("T.lang = ?", $ssLang);
			if( !empty($ssSearchField) && !empty($ssSearchKeyword) )
				$oSelectQuery->where($ssSearchField . " LIKE '" . $ssSearchKeyword . "%'" );
		
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
	* For Fetch All Record From Variable Table
	*
	* @author suresh chikani
	* @access public
	* @return boolean | array of Variable table records 
	*/
	public function getAllVariableList($ssLang = '')
	{
		
		if(empty($ssLang) || is_numeric($ssLang) || is_array($ssLang) ) return false;
		
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('v.id, v.name,v.is_active, T.*');
			$oSelectQuery->from("Model_Variable v " );
			$oSelectQuery->leftjoin("v.Translation T");
			$oSelectQuery->andwhere("T.lang = ?", $ssLang);
			$oSelectQuery->orderBy('v.name ASC');
			
			return $oSelectQuery->fetchArray();


		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}	
	}
	
	/**
	* For Fetch Record of Given Variable Id From Variable Table
	*
	* @author Bhaskar joshi
	* @param  number $snVariableId for Variable Id
	* @access public
	* @return array of Variable table records 
	*/
	public function getVariableById($snVariableId = '')
	{
		if( $snVariableId == "" || !is_numeric($snVariableId) || $snVariableId == 0 ) return false;
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('v.*, T.*');
			$oSelectQuery->from("Model_Variable v " );
			$oSelectQuery->leftjoin("v.Translation T");
			$oSelectQuery->where("v.id = ?", $snVariableId);
	
			return $oSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Insert Variable data
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $asVariableData is form Data array
	* @return boolean
	*/
	public function InsertVariable($asVariableData = array())
	{
		if(!is_array($asVariableData) || empty($asVariableData)) return false;
		
		try
		{
			//Inserting Variable into table
			$oVariable = new Model_Variable();
			$oVariable->name = $asVariableData['name'];
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $snKey => $amValues) 
			{
				 $oVariable->Translation[$amValues['lang']]->value = $asVariableData['value_' . $amValues['lang']];
			}
			$oVariable->is_active = $asVariableData['is_active'];
			$oVariable->created_at =  date('Y-m-d H:i:s');
			$oVariable->updated_at =  date('Y-m-d H:i:s');
			$oVariable->save();
			
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Update Variable data
	*
	* @author Bhaskar joshi
	* @access public
	* @param  array $asVariableData is form Data array
	* @return boolean
	*/
	public function UpdateVariable($asVariableData = array())
	{
		if( !is_array( $asVariableData ) || empty( $asVariableData ) ) return false;
		
		try
		{   
			//Update Model Variable Table
			$oUpdateVariable = Doctrine::getTable('Model_Variable')->find($asVariableData['id']);			
			$oUpdateVariable->set("name",$asVariableData['name']);		
			$oUpdateVariable->set("is_active", $asVariableData['is_active']);
			$oUpdateVariable->set("updated_at", date('Y-m-d H:i:s'));
			
			//Updateing Transaction Table 
			$asLanguageList = Doctrine::getTable('Model_Language')->getLanguageList();
			foreach($asLanguageList as $snKey => $amValues) {
				$oUpdateVariable->Translation[$amValues['lang']]->value = $asVariableData['value_' . $amValues['lang']];
			}			
			$oUpdateVariable->save();
			return true;
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Delete Variable
	*
	* @author Bhaskar joshi
	* @access public
	* @param  $snVariableId for Which Variable Id is Delete
	* @return boolean
	*/
	public function deleteVariable($snVariableId = 0)
	{
		if( $snVariableId == "" || !is_numeric($snVariableId) || $snVariableId == 0 ) return false;
		try
		{
			//delete data from Varible table
			Doctrine_Query::create()
						->delete("Model_Variable V")
						->where("V.id = ?", $snVariableId)
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
	* For change Active Variable Or Not
	*
	* @author Bhaskar joshi
	* @access public
	* @param  number  $snVariableId is id of Variable to set active
	* @param  boolean $b__isActive for check the value of is_active on click
	* @return boolean
	*/
	public function changeActiveVariable($snVariableId = 0, $bIsActive)
	{
		if((empty($snVariableId) && empty($bIsActive)) || !is_numeric($snVariableId) || $snVariableId == 0 ) return false;
		
		try
		{
			//change the value of is_active of Given Row Id
			$bIsActive = ($bIsActive) ? 0 : 1;
			
			//Update Language table
			$asLanguageUpdate = Doctrine_Query::create()
					->update("Model_Variable V")
					->set("V.is_active", "?", $bIsActive)
					->set("updated_at", "?", date('Y-m-d H:i:s'))
					->where("V.id = ?", $snVariableId)
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
