<?php 
/**
 * Tests_CityModel
 *
 * Unit test case for city Table
 * Insert,Update,Delete,listing City
 *
 * @package    zendcommon
 * @subpackage phpunit
 * @author     Bhaskar Joshi
 */
class Tests_CityTable extends PHPUnit_Framework_TestCase
{
	/**
	* City Id for listing,update 
    *
	* @var number
	* @access private
	*/	
	private $snCityId = 1;
	
	/**
	* City Id for Delete 
    *
	* @var number
	* @access private
	*/	
	private $snDeleteCityId = 3;
	
	/**
	* StringParameter for add,update,delete,listing 
    *
	* @var string
	* @access private
	*/	
	private $ssStringParameter = 'test';
	
	/**
	* Blank Array for add,update,delete,listing
    *
	* @var array
	* @access private
	*/	
	private $asBlankArray = array();	
	
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
	* For store Searh Field value
    *
	* @var string
	* @access private
	*/
	private $ssSearchField = 'name';

    /**
	* For store Search Keyword value
    *
	* @var string
	* @access private
	*/
	private $ssSearchKeyword = 'ahmedabad';
	
	/**
	* For store language in listing 
    *
	* @var string
	* @access private
	*/
	private $ssLang = 'fi';

	/**
	* For Insert
    *
	* @var string
	* @access private
	*/
	private $amInsertArray = array();	
	
	/**
	* For change active language
    *
	* @var string
	* @access private
	*/
	private $bIsActive = 1;
	
	/**
	* For Insert City Record
    * countryId is wrong field
	* @var Array
	* @access private
	*/
	private $amWrongInsertFieldData = array('countryId' => "1", 'name_en' => "test_en", 'name_fi' => "test_fi", 'is_active' => "1");
	
	/**
	* For Insert City Record
    *
	* @var Array
	* @access private
	*/
	private $amInsertCityData = array('country_id' => "1", 'name_en' => "test_en", 'name_fi' => "test_fi", 'is_active' => "1");
	
	/**
	* For Update City Record
    * countryId is wrong field
	* @var Array
	* @access private
	*/
	private $amWrongUpdateFieldData = array('id'=> '1', 'countryId' => "2", 'name_en' => "Update_test_en", 'name_fi' => "Update_test_fi", 'is_active' => "0");
	
	/**
	* For Update City Record
    *
	* @var Array
	* @access private
	*/
	private $amUpdateCityData = array('id'=> '1', 'country_id' => "2", 'name_en' => "Update_test_en", 'name_fi' => "Update_test_fi", 'is_active' => "0");
	
	
	/**
	* For Fetch All City List
	* when pass nothing as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityList()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityList();
      	$this->assertInternalType('array', $bResult);      	
    }
    
    /**
	* For Fetch All City List
	* when pass parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityListWithParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityList($this->ssSortOn, $this->ssSortBy, $this->ssSearchField , $this->ssSearchKeyword ,$this->ssLang);
      	$this->assertInternalType('array', $bResult);
    }
    
    /**
	* For Fetch City by id
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityByIdWhenEmptyAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityById('');
      	$this->assertFalse($bResult, "Pass Blank As Parameter");
    }
    
    /**
	* For Fetch City by id
	* when pass String as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityByIdWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityById($this->ssStringParameter);
      	$this->assertFalse($bResult, "pass String insted of number As Parameter");
    }
    
    /**
	* For Fetch City by id
	* when pass Blank array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityByIdWhenArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityById($this->asBlankArray);
      	$this->assertFalse($bResult, "pass Array insted of number As Parameter");
    }
    
    /**
	* For Fetch City by id
	* when pass Appropriate id as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetCityById()
    {
    	$bResult = Doctrine::getTable('Model_City')->getCityById($this->snCityId);
    	
      	$this->assertInternalType('array', $bResult);
    }
    
    /**
	* For Insert City Record
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertCityWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->InsertCity('');
      	$this->assertFalse($bResult, "City Not Insert Because Pass Blank As Parameter");
    }
    
    /**
	* For Insert City Record
	* when pass blank array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertCityWhenBlankArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->InsertCity($this->asBlankArray);
      	$this->assertFalse($bResult, "City Not Insert Because Pass Blank Array As Parameter");
    }
    
    /**
	* For Insert City Record
	* when pass string as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertCityWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->InsertCity($this->ssStringParameter);
      	$this->assertFalse($bResult, "City Not Insert Because Pass String As Parameter");
    }
    
    /**
	* For Insert City Record 
	* when pass Wrong Field Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertCityWhenWrongFieldArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->InsertCity($this->amWrongInsertFieldData);
        $this->assertEquals(0,false, count($bResult));
    }
    
    /**
	* For Insert City Record
	* when pass Appropriate Parameter Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertCity()
    {
    	$bResult = Doctrine::getTable('Model_City')->InsertCity($this->amInsertCityData);
        $this->assertTrue($bResult, "City Not Inserted");
    }   
    
    /**
	* For Update City Record
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testUpdateCityWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->UpdateCity('');
      	$this->assertFalse($bResult, "City Not Update Because Pass Blank As Parameter");
    } 
    
    /**
	* For Update City Record
	* when pass blank array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testUpdateCityWhenBlankArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->UpdateCity($this->asBlankArray);
      	$this->assertFalse($bResult, "City Not Updated Because Pass Blank Array As Parameter");
    }
    
    /**
	* For Update City Record
	* when pass string as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testUpdateCityWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->UpdateCity($this->ssStringParameter);
      	$this->assertFalse($bResult, "City Not Updated Because Pass String As Parameter");
    }
    
    /**
	* For Update City Record
	* when pass Wrong Field Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testUpdateCityWhenWrongFieldArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->UpdateCity($this->amWrongUpdateFieldData);
        $this->assertEquals(0,false, count($bResult));
    }
    
    /**
	* For Update City Record
	* when pass Appropriate Parameter Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testUpdateCity()
    {
    	$bResult = Doctrine::getTable('Model_City')->UpdateCity($this->amUpdateCityData);
        $this->assertTrue($bResult, "City Not Updated");
    }  
    
    /**
	* For Delete City Record
	* when pass blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteCityWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->deleteCity('');
      	$this->assertFalse($bResult, "City Not Delete Because Pass Blank As Id Parameter");
    }
    
    /**
	* For Delete City Record
	* when pass String as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteCityWhenPassStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->deleteCity($this->ssStringParameter);
      	$this->assertFalse($bResult, "City Not Delete Because Pass String As Id Parameter");
    }
    
    /**
	* For Delete City Record
	* when pass array as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteCityWhenPassArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->deleteCity($this->asBlankArray);
      	$this->assertFalse($bResult, "City Not Delete Because Pass Array As Id Parameter");
    }
    
    /**
	* For Delete City Record
	* when pass Appropriate Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteCity()
    {
    	$bResult = Doctrine::getTable('Model_City')->deleteCity($this->snDeleteCityId);
      	$this->assertTrue($bResult, "City Deleted");
    } 
    
    /**
	* For change Enable-disable City
	* when pass blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeEnableDisableWhenPassBlankAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->changeEnableDisable('',$this->bIsActive);
      	$this->assertFalse($bResult, "City Enable/Disable Because Pass Blank As Id Parameter");
    }
    
    /**
	* For change Enable-disable City
	* when pass both parameter as blank 
	*  
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeEnableDisableWhenPassBothParameterAsBlank()
    {
    	$bResult = Doctrine::getTable('Model_City')->changeEnableDisable('','');
      	$this->assertFalse($bResult, "City Enable/Disable Because Pass Both parameter Blank");
    }
    
    /**
	* For change Enable-disable City
	* when pass String As Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeEnableDisableWhenPassStringAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_City')->changeEnableDisable($this->ssStringParameter,$this->bIsActive);
      	$this->assertFalse($bResult, "City Enable/Disable Because Pass String As Id Parameter");
    }
    
    /**
	* For change Enable-disable City
	* when pass Appropreate parameters
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeEnableDisable()
    {
    	$bResult = Doctrine::getTable('Model_City')->changeEnableDisable($this->snCityId,$this->bIsActive);
      	$this->assertTrue($bResult, "City Not Enable/Disable on Some Problem");
    }	
}