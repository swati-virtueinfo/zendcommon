<?php

/**
 * For containing common functions
 *
 * @category   Zend
 * @package    ZendX
 * @author     Shashank Patel
 * @version    $Id: $
 */
class ZendX_Common
{
	/* For paginate() */
	public $ssSearchField = '';
	public $ssSearchKeyword = '';
	public $ssSortOn = '1';
	public $ssSortBy = 'ASC';	
	/* For getList() */
	public $snRecordPerPage = 5;
	public $snPage = 1;

	public function __construct()
	{
		// For getting declared constants
		$oConstants = Zend_Registry::getInstance()->constants;

		// For setting per page count of company
		if ($oConstants->RECORD_PER_PAGE)
		{
			$this->snRecordPerPage = $oConstants->RECORD_PER_PAGE;
		}
	}
	/**
	* For cofiguration of paginator object
	*
	* @uses   Zend_Paginator
	* @access public
	* @param  array   $asRecords 	To store records
	* @param  numeric $snPage 	To store current page no
	* @param  numeric $snRecordPerPage To store count of record per page
	* @return object
	*/
	public function paginate($asRecords = array ())
	{
		// Object creation of Zend_Paginator
		$oPaginator = Zend_Paginator::factory($asRecords);

		// For setting per page record count
		$oPaginator->setItemCountPerPage($this->snRecordPerPage);

		// For setting current page number
		$oPaginator->setCurrentPageNumber($this->snPage);

		// Returns paginator object
		return $oPaginator;
	}

	/**
	* For cofiguration of getList object
	*
	* @uses   Doctrine::getTable
	* @access public
	* @param  object  $oSelectQuery    To store select query object
	* @param  string  $ssSearchField   To store search field name
	* @param  string  $ssSearchKeyword To store searched keyword
	* @param  string  $ssSortOn 	   To store sorting column name - Default=1 take primary key of table
	* @param  string  $ssSortBy 	   To store A				<?php echo $this->searchView(array('asSearchOption'=>$this->asSearchOption)); ?>
SC/DESC value - Default=ASC
	* @return array
	*/
	public function getList($oSelectQuery)
	{
		try
		{
			if( !empty($this->ssSearchField) && !empty($this->ssSearchKeyword) )
				$oSelectQuery->where( $this->ssSearchField . " LIKE '%" . $this->ssSearchKeyword . "%'" );
		
			if( !empty($this->ssSortOn) && !empty($this->ssSortBy) )
				$oSelectQuery->orderBy( $this->ssSortOn . ' ' . $this->ssSortBy );

			return $oSelectQuery->fetchArray();
		}
		catch( Exception $oException )
		{
			echo $oException->getMessage();
			return false;
		}
	}
}