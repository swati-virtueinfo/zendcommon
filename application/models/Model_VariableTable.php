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
	public function getVariableList($ssSortOn = '', $ssSortBy = '', $ssSearchField = '', $ssSearchKeyword = '')
	{
		try
		{
			$oSelectQuery = Doctrine_Query::create();
			$oSelectQuery->select('v.id, v.name,v.is_active, T.*');
			$oSelectQuery->from("Model_Variable v " );
			$oSelectQuery->leftjoin("v.Translation T");
			$oSelectQuery->andwhere("T.lang = ?", Zend_Registry::get('Zend_Locale'));
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
}