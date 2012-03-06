<?php
/**
 */
class Model_AdminTable extends Doctrine_Table
{
	/**
	* For Fetch Record From Table By Given ID
	*
	* @author Bhaskar joshi
	* @param number $snAdminId for Admin Id
	* @access public
	* @return array 
	*/
	public function getAdminRecordById($snAdminId = '')
	{
		if( $snAdminId == "" || !is_numeric($snAdminId) ) return false;
		try
		{
			$asCategoryList = Doctrine_Query::create()
							->select("*")
							->from("Model_Admin A")
							->where("A.id = ?", $snAdminId);
			return $asCategoryList->fetchOne()->toArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
	
	/**
	* For Change Admin Password
	*
	* @author Bhaskar joshi
	* @access public
	* @param  mixed $smPassword To for new Password
	* @param  number $snAdminId for admin Id 
	* @return boolean
	*/
	public function ChangePassword($smPassword = '',$snAdminId = '')
	{
		
		if((empty($smPassword)) && (empty($snAdminId)) || !is_numeric($snAdminId)) return false;
		
		try
		{
			//update Password in admin table
			$as__UserDataList = Doctrine_Query::create()
						->update("Model_Admin A")
						->set("A.password", "?", $smPassword)
						->set("A.updated_at","?", date('Y-m-d H:i:s'))
						->where("A.id = ?", $snAdminId)
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