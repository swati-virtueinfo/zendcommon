<?php
/**
 * Tests_VariableModel
 *
 * Unit test case for Variable Table
 * Insert, Edit, Update, Delete, Change status Variable
 *
 * @package    zendcommon
 * @subpackage phpunit
 * @author     Bhaskar Joshi
 */
class Tests_VariableTable extends PHPUnit_Framework_TestCase
{
	/**
	* Variable Id for listing,update 
    *
	* @var number
	* @access private
	*/	
	private $snVariableId = 1;
	
	/**
	* Variable Id for Delete 
    *
	* @var number
	* @access private
	*/	
	private $snDeleteVariableId = 3;
	
	/**
	* StringParameter for variable add,update,delete,listing 
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
	* For insert variable details
    * @author Suresh Chikani    
	* @var array
	* @access private
	*/
	private $asVariable = Array ( 'name' => 'lbl_Title', 'value_en' => 'Title', 'value_fi' => 'Title_fi', 'is_active' => 1 ); 
	
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
	* For store language in listing 
    *
	* @var string
	* @access private
	*/
	private $ssLang = 'en';

   /**
	* For store search field value
    *
	* @var string
	* @access private
	*/
	private $ssSearchField = 'name';

   /**
	* For store insert variable array
    *
	* @var array
	* @access private
	*/
	private $ssSearchKeyword = 'lbl';
	
	/**
	* For Insert
    *
	* @var string
	* @access private
	*/
	private $amInsertArray = array();
	
	/**
	* For update variable  detail array
    *
	* @var array
	* @access private
	*/
	private $amUpdateVariabel = Array ( 'id' => 5, 'name' => 'lbl_Label_variable', 'value_en' => 'lbl_Label_variable_en', 'value_fi' => 'lbl_Label_variable_fi', 'is_active' => 1 ) ;
	
	
	/**
	* For change active variabel
    *
	* @var string
	* @access private
	*/
	private $bIsActive = 1;
	
	
	/**
	* For Fetch All Variable List
	* 
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableList()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableList();
      	$this->assertInternalType('array',$bResult);      	
    }
    
    /**
	* For Fetch All Variable List
	* when pass parameter 
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableListWithOptionalParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableList($this->ssSortOn,$this->ssSortBy,$this->ssSearchField,$this->ssSearchKeyword,$this->ssLang);
      	$this->assertInternalType('array',$bResult);
    }
    
	//Get all variable list by language
    
	/**
	* For get all variable by language
	* when pass blank value as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetAllVariableListWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getAllVariableList('');
      	$this->assertFalse($bResult,"Variable record not found beacuse Pass Blank value As Parameter");
    }
	/**
	* For get all variable by language
	* when pass null as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetAllVariableListWhenNullAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getAllVariableList();
      	$this->assertFalse($bResult,"Variable record not found beacuse Pass Null As Parameter");
    }
    
    /**
	* For get all variable by language
	* when pass String as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetAllVariableListWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getAllVariableList($this->ssStringParameter);
      	$this->assertInternalType('array',$bResult);
    }
    
    /**
	* For get all variable by language
	* when pass blank array as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetAllVariableListWhenArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getAllVariableList($this->asBlankArray);
      	$this->assertFalse($bResult,"Variable record not found beacuse pass blank Array As Parameter");
    }
    
    /**
	* For get all variable by language
	* when pass Proper id as parameter
    *
    * @author Suresh Chikani
	* @access public
	*/
    public function testgetAllVariableList()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getAllVariableList($this->ssLang);
      	$this->assertInternalType('array',$bResult);
    }
    
    
    /**
	* For Fetch Variable by id
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableByIdWhenEmptyAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableById('');
      	$this->assertFalse($bResult,"Pass Blank As Parameter");
    }
    
    /**
	* For Fetch Variable by id
	* when pass String as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableByIdWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableById($this->ssStringParameter);
      	$this->assertFalse($bResult,"pass String insted of number As Parameter");
    }
    
    /**
	* For Fetch Variable by id
	* when pass array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableByIdWhenArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableById($this->asBlankArray);
      	$this->assertFalse($bResult,"pass Array insted of number As Parameter");
    }
    
     /**
	* For Fetch Variable by id
	* when pass Proper id as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetVariableById()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->getVariableById($this->snVariableId);
      	$this->assertInternalType('array',$bResult);
    }
    
    
    /**
	* For Insert Variable
	* when pass blank as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertVariableWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->InsertVariable('');
      	$this->assertFalse($bResult,"Variable Not Insert Because Pass Blank As Parameter");
    }
    
    /**
	* For Insert Variable
	* when pass blank array as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertVariableWhenBlankArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->InsertVariable($this->asBlankArray);
      	$this->assertFalse($bResult,"Variable Not Insert Because Pass Blank Array As Parameter");
    }
    
    /**
	* For Insert Variable
	* when pass string as parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testInsertVariableWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->InsertVariable($this->ssStringParameter);
      	$this->assertFalse($bResult,"Variable Not Insert Because Pass String As Parameter");
    }
    
	/**
	* For Insert Variable
	* When user pass array parameter
    *
    * @author suresh chikani
	* @access public
	*/
    public function testInsertVariableWhenPassAppropriateArrayParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->InsertVariable($this->asVariable);
      	$this->assertTrue($bResult ,"Record add successfully");
    }
    
	// Updtae variable detail 
	   
	/**
	* For updating variable detail
	* When user pass blank  array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateVariableDetailWhenPassBlankArrayParameter()
    {
        $bResult = Doctrine::getTable('Model_Variable')->UpdateVariable($this->asBlankArray);
		$this->assertFalse($bResult ,"Record do not update successfully because pass blank array");
    }

	/**
	* For updating variable detail
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateVariableDetailWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Variable')->UpdateVariable($this->ssStringParameter);
		$this->assertFalse($bResult ,"Record do not update successfully  because pass string value as a parameter");
	}

	/**
	* For updating variable detail
	* When user pass blank value parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateVariableDetailWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Variable')->UpdateVariable('');
		$this->assertFalse($bResult ,"Record do not update successfully  because pass blank value as a parameter");
    }
    
	/**
	* For updating variable detail
	* When user pass null parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateVariableDetailWhenPassNullParameter()
    {
		$bResult = Doctrine::getTable('Model_Variable')->UpdateVariable();
		$this->assertFalse($bResult ,"Record do not update successfully  because pass null parameter");
    }
	
    /**
	* For updating variable detail
	* When user pass array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testUpdateVariableDetailWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Variable')->UpdateVariable($this->amUpdateVariabel);
		$this->assertTrue($bResult ,"Record update successfully");
    }
   
    
    /**
	* For Delete Variable
	* when pass blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteVariableWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->deleteVariable('');
      	$this->assertFalse($bResult,"Variable Not Delete Because Pass Blank As Id Parameter");
    }
    
    /**
	* For Delete Variable
	* when pass String as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteVariableWhenPassStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->deleteVariable($this->ssStringParameter);
      	$this->assertFalse($bResult,"Variable Not Delete Because Pass String As Id Parameter");
    }
    
    /**
	* For Delete Variable
	* when pass array as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteVariableWhenPassArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->deleteVariable($this->asBlankArray);
      	$this->assertFalse($bResult,"Variable Not Delete Because Pass Array As Id Parameter");
    }
    
    /**
	* For Delete Variable
	* when pass Appropriate Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testdeleteVariable()
    {
    	//$bResult = Doctrine::getTable('Model_Variable')->deleteVariable($this->snDeleteVariableId);
      	//$this->assertTrue($bResult,"record deleted sucessfully");
    }
    
    /**
	* For change Active Variable
	* when pass blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeIsActiveWhenPassBlankAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeIsActive('',$this->bIsActive);
      	$this->assertFalse($bResult,"Actibe Variable Not Changed Because Pass Blank As Id Parameter");
    }
    
    /**
	* For change Active Variable
	* when pass String As Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeIsActiveWhenPassStringAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeIsActive($this->ssStringParameter,$this->bIsActive);
      	$this->assertFalse($bResult,"Actibe Variable Not Changed Because Pass String As Id Parameter");
    }
    
     /**
	* For change Active Variable
	* when pass Proper parameters with is_active status 1
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeIsActive()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeIsActive($this->snVariableId,$this->bIsActive);
      	$this->assertTrue($bResult,"Actibe Variable Not Changed Because");
    }
}
