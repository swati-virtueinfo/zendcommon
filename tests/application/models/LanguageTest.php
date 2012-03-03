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
}