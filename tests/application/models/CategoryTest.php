<?php 

 /**
 * Tests_CategoryTable
 *
 * Unit test case for CategoryTable 
 * Insert, update, delete and listing category detail tests cases.
 *
 * @package vendep
 * @subpackage phpunit
 * @author Suresh Chikani
 */
class ModelTestsCase extends PHPUnit_Framework_TestCase
{
	
	/**
	* For insert Category details
    *
	* @var array
	* @access private
	*/
	private $asAddBlankCategory = array();
	
	/**
	* For insert Category details
	*
	* @var string
	* @access private
	*/
	private $ssCategory = 'Category';
	
	/**
	* For insert Category details
    *
	* @var array
	* @access private
	*/
    private $asCategoryNotExistsField = array('name_en' => 'suresh_en', 'name_fi' => 'suresh_fr', 'imagename' => 'lion-4-1-jpeg-wallpapers.jpeg', 'is_active' => 1 , 'parentid' => 2);
    
	 /**
	* For insert Category details
    *    
	* @var array
	* @access private
	*/
	
    private $asCategory = Array ( 'name_en' => 'suresh_en', 'name_fi' => 'suresh_fr',  'cat_name' => 'name', 'image_name' => 'lion-4-1-jpeg-wallpapers.jpeg', 'is_active' => '1', 'parentid' => 2 ); 
	
	/**
	* For insert Category details
	* When user pass blank array parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testAddCategoryWhenPassBlankArrayParameter()
	{
		$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asAddBlankCategory);
		$this->assertFalse($bResult  ,"Record do not add successfully because pass blank array");
	}

	/**
	* For insert Category details
	* When user pass  string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testAddCategoryWhenPassStringParameter()
    {
        $bResult = Doctrine::getTable('Model_Category')->insertCategory($this->ssCategory);
		$this->assertFalse($bResult ,"Record do not add successfully  because pass string value as a parameter");
	}

	/**
	* For insert Category details
	* When user pass null parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testAddCategoryWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->insertCategory('');
		$this->assertFalse($bResult ,"Record do not add successfully  because pass blank value as a parameter");
	}

	/**
	* For insert Category details
	* When user pass array parameter with not exists filed in person table
	*
	* @author suresh chikani
	* @access public
	*/
	public function testAddCategoryWhenPassArrayWithNotExistsField()
    {
		
		//$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asCategoryNotExistsField);
		//$this->assertFalse($bResult ,"Record do not add successfully  because pass array with not exists field in table");
    }

	/**
	* For insert Category details
	* When user pass array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testAddCategoryWhenPassAppropriateArrayParameter()
    {
		//$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asCategory);
		//$this->assertTrue($bResult ,"Record add successfully");
    }
    
    
    
}
?>
