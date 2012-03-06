<?php
/**
 * Tests_LanguageModel
 *
 * Unit test case for Language Table
 * Insert,Update,Delete Language
 *
 * @package    zendcommon
 * @subpackage phpunit
 * @author     Bhaskar Joshi
 */
class Tests_LanguageTable extends PHPUnit_Framework_TestCase
{
	/**
	* Language Id for listing,update 
    *
	* @var number
	* @access private
	*/	
	private $snLanguageId = 1;
	
	/**
	* Language Id for Delete 
    *
	* @var number
	* @access private
	*/	
	private $snDeleteLanguageId = 3;
	
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
	* For store search field value
    *
	* @var string
	* @access private
	*/
	private $ssSearchField = 'name';

   /**
	* For store search Keyword
    *
	* @var string
	* @access private
	*/
	private $ssSearchKeyword = 'English';
	
	/**
	* For Insert Language
    * language_name is wrone field
	* @var Array
	* @access private
	*/
	private $amInsertWrongFieldData = array('language_name' => "Gujarati",'lang' => "gu", 'is_default' => "0", 'is_active' => "1", 'flag' => "1329972498_gb.png");
	
	/**
	* For Insert Language
    *
	* @var Array
	* @access private
	*/
	private $amInsertLanguageData = array('name' => "Gujarati",'lang' => "gu", 'is_default' => "0", 'is_active' => "1", 'flag' => "1329972498_gb.png");
	
	/**
	* For Fetch All Language List
	* when pass nothing as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetgetLanguageList()
    {
    	$bResult = Doctrine::getTable('Model_Language')->getLanguageList();
      	$this->assertInternalType('array',$bResult);      	
    }
    
    /**
	* For Fetch All Language List
	* when pass optional parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetgetLanguageListWithOptionalParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->getLanguageList($this->ssSortOn,$this->ssSortBy,$this->ssSearchField,$this->ssSearchKeyword);
      	$this->assertInternalType('array',$bResult);
    }
    
    /**
	* For Get Defualt Language
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetDefaultLanguage()
    {
    	$bResult = Doctrine::getTable('Model_Language')->getDefaultLanguage();
      	$this->assertInternalType('array',$bResult);      	
    }
    
     /**
	* For Get Active Language List
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetActiveLanguageList()
    {
    	$bResult = Doctrine::getTable('Model_Language')->getActiveLanguageList();
      	$this->assertInternalType('array',$bResult);      	
    }
    
    /**
	* For Insert Language
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertLanguageWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->InsertLanguage('');
      	$this->assertFalse($bResult,"Language Not Insert Because Pass Blank As Parameter");
    }
    
    /**
	* For Insert Language
	* when pass blank array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertLanguageWhenBlankArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->InsertLanguage($this->asBlankArray);
      	$this->assertFalse($bResult,"Language Not Insert Because Pass Blank Array As Parameter");
    }
    
    /**
	* For Insert Language
	* when pass string as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertLanguageWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->InsertLanguage($this->ssStringParameter);
      	$this->assertFalse($bResult,"Language Not Insert Because Pass String As Parameter");
    }
    
    /**
	* For Insert Language
	* when pass Wrong Field Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertLanguageWhenWrongFieldArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->InsertLanguage($this->amInsertWrongFieldData);
        $this->assertEquals(0,$bResult);
    }
    
    /**
	* For Insert Language
	* when pass Appropriate Array
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertLanguage()
    {
    	$bResult = Doctrine::getTable('Model_Language')->InsertLanguage($this->amInsertLanguageData);
        $this->assertTrue($bResult,"Language Not Inserted");
    }    
}