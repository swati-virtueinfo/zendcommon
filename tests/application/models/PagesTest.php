<?php
/**
 * Tests_PagesTable
 *
 * Unit test case for Pages Table
 * Insert,Update,Delete Pages
 *
 * @package    zendcommon
 * @subpackage phpunit
 * @author     Bhaskar Joshi
 */
class Tests_PagesTable extends PHPUnit_Framework_TestCase
{
	/**
	* Page Id for listing,update 
    * 
	* @var number
	* @access private
	*/	
	private $snPageId = 1;
	
	/**
	* Page Id for Delete 
    *
	* @var number
	* @access private
	*/	
	private $snDeletePageId = 3;
	
	/**
	* StringParameter for Page add,update,delete,listing 
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
	* Culture for listing 
    *
	* @var string
	* @access private
	*/	
	private $ssCulture = 'fi';

	/** ================================ getPageMenu function tests case ===========================**/
	
	/**
	* For Fetch Pages Record
	* when pass nothing as parameter
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetPageMenuWhenNothingAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Pages')->getPageMenu();
      	$this->assertInternalType('array',$bResult);      	
    }
    
    /**
	*  For Fetch Pages Record
	* when pass only mendetory parameter 
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetPageMenuWithoutOptionalParameter()
    {
    	$bResult = Doctrine::getTable('Model_Pages')->getPageMenu($this->ssCulture);
      	$this->assertInternalType('array',$bResult);
    }
    
    /**
	*  For Fetch Pages Record
	* when pass all parameters 
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetPageMenu()
    {
    	$bResult = Doctrine::getTable('Model_Pages')->getPageMenu($this->ssCulture,$this->snPageId,false);
      	$this->assertInternalType('array',$bResult);
    }
    
    /** ================================ getPagesById function tests case ===========================**/
    
    /**
	* For get Page detail by page id
    * when user pass blank parameter
    * @author Bhaskar Joshi
	* @access public 
	*/
	public function testgetPagesByIdWhenBlankAsParameter()
	{
		$asResult = Doctrine::getTable('Model_Pages')->getPagesById('');
		$this->assertFalse($asResult, 'Records not found because pass blank value as a parameter ');	
	}
	
	
	
}
