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
	* Language Id for listing, edit 
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
	private $amInsertLanguageData = array('name' => "Gujarati_with",'lang' => "gi", 'is_default' => "0", 'is_active' => "1", 'flag' => "1329972498_gb.png");
	
	/**
	* For update Language detail
    *
	* @var Array
	* @access private
	*/
	private $amUpdateLanguage = Array ( 'id' => 3, 'name' => 'Gujarati_update', 'lang' => 'gj', 'is_active' => 0, 'flag' => 'logo.jpeg' ) ;
	
	
	/**
	* For change active language
    *
	* @var string
	* @access private
	*/
	private $bIsActive = 1;
	
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
    	//$bResult = Doctrine::getTable('Model_Language')->InsertLanguage($this->amInsertLanguageData);
        //$this->assertTrue($bResult,"Record add successfully");
    }
	
    
    // Update languages
    
	/**
	* For updating language detail
	* When user pass blank  array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateLanguageDetailWhenPassBlankArrayParameter()
    {
        $bResult = Doctrine::getTable('Model_Language')->UpdateLanguage($this->asBlankArray);
		$this->assertFalse($bResult ,"Record do not update successfully because pass blank array as parameter");
    }

	/**
	* For updating language detail
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateLanguageDetailWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Language')->UpdateLanguage($this->ssStringParameter);
		$this->assertFalse($bResult ,"Record do not update successfully  because pass string value as a parameter");
	}

	/**
	* For updating language detail
	* When user pass blank value parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateLanguageDetailWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Language')->UpdateLanguage('');
		$this->assertFalse($bResult ,"Record do not update successfully  because pass blank value as a parameter");
    }

    /**
	* For updating language detail
	* When user pass array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateLanguageDetailWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Language')->UpdateLanguage($this->amUpdateLanguage);
		$this->assertFalse($bResult ,"Record update successfully");
    }
    
	/**
	* For Delete language.
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testdeleteLanguageWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->deleteLanguage('');
      	$this->assertFalse($bResult,"language Not Delete Because Pass Blank As Id Parameter");
    }
    
    /**
	* For Delete language. 
	* when pass String as Id parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testdeleteLanguageWhenPassStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->deleteLanguage($this->ssStringParameter);
      	$this->assertFalse($bResult,"language Not Delete Because Pass String As Id Parameter");
    }
    
    /**
	* For Delete language
	* when pass blank array as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testdeleteLanguageWhenPassArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->deleteLanguage($this->asBlankArray);
      	$this->assertFalse($bResult,"language Not Delete Because Pass Array As Id Parameter");
    }
    
    /**
	* For Delete language
	* when pass Appropriate Id parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testdeleteLanguage()
    {
    	$bResult = Doctrine::getTable('Model_Language')->deleteLanguage($this->snDeleteLanguageId);
      	$this->assertTrue($bResult,"language deleted sucessfully");
    }
    
    
	/**
	* For change default language
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeDefaultLanguageWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeDefaultLanguage('');
      	$this->assertFalse($bResult,"Default language Not Changed Because Pass Blank value As Parameter");
    }
    
	/**
	* For change default language
	* when pass null as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeDefaultLanguageWhenPassNullAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeDefaultLanguage();
      	$this->assertFalse($bResult,"Default language Not Changed Because Pass Null As Parameter");
    }
	/**
	* For change default language
	* when pass blank array as parameter.
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeDefaultLanguageWhenPassBlankArrayParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeDefaultLanguage($this->asBlankArray);
      	$this->assertFalse($bResult,"Default language Not Changed Because Pass Blank Array As Parameter");
    }
    
	/**
	* For change default language
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeDefaultLanguageWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Language')->changeDefaultLanguage($this->ssStringParameter);
		$this->assertFalse($bResult ,"Default language Not Changed because pass string value as a parameter");
	}
	
	/**
	* For change default language
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeDefaultLanguage()
    {
		$bResult = Doctrine::getTable('Model_Language')->changeDefaultLanguage($this->snLanguageId);
		$this->assertTrue($bResult ,"Change default language sucessfully");
	}
	
	
	/**
	* For change language status
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeActiveLanguageWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeActiveLanguage('');
      	$this->assertFalse($bResult,"language status Not Changed Because Pass Blank As Id Parameter");
    }
    
	/**
	* For change language status
	* when pass null parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeActiveLanguageWhenPassNullAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeActiveLanguage();
      	$this->assertFalse($bResult,"language status Not Changed Because Pass Null As Parameter");
    }
	/**
	* For change language status
	* when pass blank array as parameter 
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testchangeActiveLanguageWhenPassBlankArrayParameter()
    {
    	$bResult = Doctrine::getTable('Model_Language')->changeActiveLanguage($this->asBlankArray);
      	$this->assertFalse($bResult,"language status not Changed Because Pass Blank Array As Parameter");
    }
    
	/**
	* For change language status
	* When user pass string as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeActiveLanguageWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Language')->changeActiveLanguage($this->ssStringParameter);
		$this->assertFalse($bResult ,"language status not Changed because pass string value as a parameter");
	}
	
	/**
	*For change language status
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeActiveLanguage()
    {
		$bResult = Doctrine::getTable('Model_Language')->changeActiveLanguage($this->snLanguageId, $this->bIsActive);
		$this->assertTrue($bResult ,"language status changed sucessfully");
	}    
}