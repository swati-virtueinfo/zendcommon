<?php
/**
 * Tests_VariableModel
 *
 * Unit test case for Variable Table
 * Insert,Update,Delete Variable
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
	* For change active language
    *
	* @var string
	* @access private
	*/
	private $bIsActive = 0;
	
	/**
	* For Fetch All Variable List
	* when pass nothing as parameter
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
    	$bResult = Doctrine::getTable('Model_Variable')->deleteVariable($this->snDeleteVariableId);
      	$this->assertTrue($bResult,"Variable Not Delete Because Pass Array As Id Parameter");
    }
    
    /**
	* For change Active Variable
	* when pass blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeActiveVariableWhenPassBlankAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeActiveVariable('',$this->bIsActive);
      	$this->assertFalse($bResult,"Actibe Variable Not Changed Because Pass Blank As Id Parameter");
    }
    
    /**
	* For change Active Variable
	* when pass String As Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeActiveVariableWhenPassStringAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeActiveVariable($this->ssStringParameter,$this->bIsActive);
      	$this->assertFalse($bResult,"Actibe Variable Not Changed Because Pass String As Id Parameter");
    }
    
     /**
	* For change Active Variable
	* when pass Proper parameters
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testchangeActiveVariable()
    {
    	$bResult = Doctrine::getTable('Model_Variable')->changeActiveVariable($this->snVariableId,$this->bIsActive);
      	$this->assertTrue($bResult,"Actibe Variable Not Changed Because");
    }	
}