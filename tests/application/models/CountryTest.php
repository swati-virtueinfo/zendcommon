<?php 

 /**
 * Tests_CountryTable
 *
 * Unit test case for CategoryTable 
 * Listing, insert, edit, update, delete country.
 *
 * @package zendcommom
 * @subpackage phpunit
 * @author Suresh Chikani
 */
class Tests_CountryTable extends PHPUnit_Framework_TestCase
{
	/**
	* For store sort on value
    *
	* @var string
	* @access private
	*/
	private $ssSortOn = 'id';

   /**
	* For store sort by value
    *
	* @var string
	* @access private
	*/
	private $ssSortBy = 'ASC';
	
	/**
	* For country listing 
    *
	* @var string
	* @access private
	*/
	private $ssLang = 'en';
	
	/**
	* For insert, listing, edit, update country detail.  
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
	private $asBlankArray = array();
	
	/**
	* For insert, listing, edit, update country detail.
	* @author Suresh Chikani
	* @var string
	* @access private
	*/
	private $ssStringValue = 'country';
	
	/**
	* For edit category id. 
    * @author Suresh Chikani 
	* @var numaric
	* @access private
	*/
	private $snCountryId = 1;
	
	/**
	* For delete category id. 
    * @author Suresh Chikani 
	* @var numaric
	* @access private
	*/
	private $snCountryDeleteId = 12;
	
	/**
	* For edit category id, delete category id. 
    * @author Suresh Chikani 
	* @var numaric
	* @access private
	*/
	private $snWrongCountryId = 111;
	
	/**
	* For insert country detail.
    * @author Suresh Chikani    
	* @var array
	* @access private
	*/
	private $asCountry = Array ('name_en' => 'india_en', 'name_fi' => 'india_fi', 'is_active' => 1 );
	
	/**
	* For insert category detail with not exits field. 
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
 	private $asCountryNotExistsField = Array ('name_en' => 'india_en', 'name_fi' => 'india_fi', 'isactive' => 1 );
 	
 	/**
	* For update contry record.
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
 	private $asCountryUpdate = Array ( 'id' => 4, 'name_en' => 'update_country_en', 'name_fi' => 'update_country_fi', 'is_active' => 1 );
	
 	/**
	* For updtae contry is_active status.
    * @author Suresh Chikani
	* @var numaric
	* @access private
	*/
 	private $snCountryStatus = 1;
	
	/**
	* For Fetch All country List
	* When pass null parameter
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryList()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryList();
      	$this->assertInternalType('array',$bResult);      	
    }
    
    /**
	* For Fetch All country List
	* when pass optinal parameter 
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryListWithOptionalParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryList($this->ssSortOn, $this->ssSortBy, $this->ssLang);
      	$this->assertInternalType('array',$bResult);
    }

	/**
	* For get country detail by id
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryByIdWhenBlankValueAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryById('');
      	$this->assertFalse($bResult,"Records not found because pass blank value as a parameter");
    }
    
	/**
	* For get country detail by id
	* when pass null parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryByIdWhenNullParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryById();
      	$this->assertFalse($bResult,"Records not found because pass null parameter");
    }
    
    /**
	* or get country detail by id
	* when pass String as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryByIdWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryById($this->ssStringValue);
      	$this->assertFalse($bResult,"Records not found because you pass string as a parameter");
    }
    
    /**
	* or get country detail by id
	* when pass blank array as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryByIdWhenBlankArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryById($this->asBlankArray);
      	$this->assertFalse($bResult,"Records not found because pass blank array as parameter");
    }
    
    /**
	* or get country detail by id
	* when pass Proper id as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetCountryById()
    {
    	$bResult = Doctrine::getTable('Model_Country')->getCountryById($this->snCountryId);
      	$this->assertInternalType('array',$bResult);
    }
    
    
	/**
	* For insert country details
	* When user pass blank array as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassBlankArrayParameter()
	{
		$bResult = Doctrine::getTable('Model_Country')->InsertCountry($this->asBlankArray);
		$this->assertFalse($bResult, "Record do not add successfully because pass blank array as a parameter");
	}

	/**
	* For insert country details
	* When user pass string as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassStringParameter()
    { 
       	$bResult = Doctrine::getTable('Model_Country')->InsertCountry($this->ssStringValue);
	 	$this->assertFalse($bResult, "Record do not add successfully  because pass string value as a parameter");
	}

	/**
	* For insert country details
	* When user pass blank value as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->InsertCountry('');
		$this->assertFalse($bResult, "Record do not add successfully because pass blank value as a parameter");
	}
	
	/**
	* For insert country details
	* When user pass null parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassNullParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->InsertCountry();
		$this->assertFalse($bResult, "Record do not add successfully because pass null value as a parameter");
	}

	/**
	* For insert country details
	* When user pass array parameter with not exists field in table.
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassArrayWithNotExistsField()
    {
		
		$bResult = Doctrine::getTable('Model_Country')->InsertCountry($this->asCountryNotExistsField);
		$this->assertFalse($bResult, "Record do not add successfully  because pass array with not exists field in table");
    }

	/**
	* For insert country details
	* When user pass proper array parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testInsertCountryWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->InsertCountry($this->asCountry);
		$this->assertTrue($bResult, "Record add successfully");
    }
    
    
	/**
	* For update country detail
	* When user pass blank  array as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateCountryWhenPassBlankArrayParameter()
    {
        $bResult = Doctrine::getTable('Model_Country')->UpdateCountry($this->asBlankArray);
		$this->assertFalse($bResult, "Record do not update successfully because pass blank array");
    }

	/**
	* For update country detail
	* When user pass string as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateCountryWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->UpdateCountry($this->ssStringValue);
		$this->assertFalse($bResult, "Record do not update successfully because pass string value as a parameter");
	}

	/**
	* For update country detail
	* When user pass blank value as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateCountryWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->UpdateCountry('');
		$this->assertFalse($bResult, "Record do not update successfully because pass blank value as a parameter");
    }

    /**
	* For update country detail
	* When user pass appropriate array as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateCountryWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->UpdateCountry($this->asCountryUpdate);
		$this->assertTrue($bResult, "Record update successfully");
    }
    
    
	/**
	* For delete country by id.
	* when user pass null parameter.
    *
    * @author suresh chikani
	* @access public
	*/
    public function testdeleteCountryWhenNullAsParameter()
    {
       $bResult = Doctrine::getTable('Model_Country')->deleteCountry();
       $this->assertFalse($bResult, 'Record not delete successfully because pass null parameter');
    }
    
	/**
	* For delete country by id.
    * When user pass blank value as parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCountryWhenBlankValuesAsParameter()
	{
		$bResult = Doctrine::getTable('Model_Country')->deleteCountry('');
		$this->assertFalse($bResult, 'Records not delete successfully because pass balnk as parameter');	
	}

   /**
	* For delete country by id.
    * When user pass string as parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCountryWhenStringAsParameter()
	{
		$bResult = Doctrine::getTable('Model_Country')->deleteCountry($this->ssStringValue);
		$this->assertFalse($bResult, 'Records not delete because you pass string as a parameter');	
	}
	
	/**
	* For delete country by id.
    * When user pass blank array as parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCountryWhenBlankArrayAsParameter()
	{
		$bResult = Doctrine::getTable('Model_Country')->deleteCountry($this->asBlankArray);
		$this->assertFalse($bResult, 'Records not delete because you pass blank array as a parameter');	
	}

    /**
	* For delete country by id.
    * When user pass  wrong id as parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCountryWithWrongId()
	{
		$asResult = Doctrine::getTable('Model_Country')->deleteCountry($this->snWrongCountryId);
		$this->assertEquals(0, false, count( $asResult));
	}

   /**
	* For delete country by id.
    * When user pass country exits id
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCountryWithCategoryId()
	{
		$asResult = Doctrine::getTable('Model_Country')->deleteCountry($this->snCountryDeleteId);
		$this->assertTrue($asResult,"record deleted sucessfully");
	}
	
	/**
	* For change country status
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeEnableDisableWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable('');
      	$this->assertFalse($bResult,"country status Not Changed Because Pass Blank vlaue as Parameter");
    }
    
	/**
	* FFor change country status
	* when pass null parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeEnableDisableWhenPassNullAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable();
      	$this->assertFalse($bResult,"country status Not Changed Because Pass Null Parameter");
    }
	/**
	* For change country status
	* when pass blank array as parameter 
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeEnableDisableWhenPassBlankArrayParameter()
    {
    	$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable($this->asBlankArray);
      	$this->assertFalse($bResult,"country status not Changed Because Pass Blank Array As Parameter");
    }
    
	/**
	* For change country status
	* When user pass string as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeEnableDisableWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable($this->ssStringValue);
		$this->assertFalse($bResult ,"country status not Changed because pass string value as a parameter");
	}
	
	/**
	* For change country status
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeEnableDisable()
    {
		$bResult = Doctrine::getTable('Model_Country')->changeEnableDisable($this->snCountryId, $this->snCountryStatus);
		$this->assertTrue($bResult ,"country status changed sucessfully");
	}
}