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
	private $snPageId = 1;
	private $snDeletePageId = 3;
	private $snPageParentId = 0;
	private $snOrder = 1;
	
	private $ssStringParameter = 'test';
	private $ssCulture = 'fi';

	private $asBlankArray = array();
	private $amInsert = array('parent_id' => '0', 'pages_title_en' => 'Test', 'pages_menu_name_en'=> 'Test', 'pages_meta_title_en' => 'test', 'pages_meta_keyword_en' => '', 'pages_content_en' => '', 'pages_meta_description_en' => '', 'pages_title_fi' => 'Test_fi', 'pages_menu_name_fi' => 'Test_fi', 'pages_meta_title_fi' => 'Test_fi', 'pages_meta_keyword_fi' => '', 'pages_content_fi' => '', 'pages_meta_description_fi' => '', 'url' => 'test', 'is_active' => '1') ;
	private $IsActiveArray = array('id' => '1', 'is_active' => '1');
	private $ssEmpty = '';
	
	private $snWrongPageId = 'd500';
	private $ssWrongCulture = 'bkj';
	private $snWrongParentId = 'f2500';
	private $snWrongOrder = 'f250000';
	private $amWrongInsertArray = array('parent' => '', 'pages_title_en' => 'Test', 'pages_menu_name_en'=> 'Test', 'pages_meta_title_en' => 'test', 'pages_meta_keyword_en' => '', 'pages_content_en' => '', 'pages_meta_description_en' => '', 'pages_title_fi' => 'Test_fi', 'pages_menu_name_fi' => 'Test_fi', 'pages_meta_title_fi' => 'Test_fi', 'pages_meta_keyword_fi' => '', 'pages_content_fi' => '', 'pages_meta_description_fi' => '', 'url' => 'test', 'is_active' => '1') ;
	private $WrongIsActiveArray = array('id' => 'test', 'is_active' => '0');
	
	private $bFalse;
	private $bTrue;
	
	/**
	 * Test function getPageMenu 
	 * @param  string  $ssCulture is For current language
	 * @param  number  $snPageId  is For Page id
	 * @param  boolean $bNeedTree is For call buildTree function or not
	 * @return Array
	 * @author Bhaskar Joshi
	 * @access public
	 */
	public function testGetPageMenu()
	{
		$bResult = Model_PagesTable::getPageMenu();
		$this->assertGreaterThan(0,$bResult);
		$this->assertInternalType('array',$bResult);
		
		$bResult = Model_PagesTable::getPageMenu($this->ssEmpty, $this->ssEmpty, $this->ssEmpty);
		$this->assertInternalType('boolean',$bResult);
		$this->assertEmpty($bResult);	
		
		$bResult = Model_PagesTable::getPageMenu($this->ssWrongCulture, $this->ssEmpty);
		$this->assertInternalType('array',$bResult);
		
		$bResult = Model_PagesTable::getPageMenu($this->ssCulture, $this->ssEmpty,$this->bTrue);
		$this->assertInternalType('array',$bResult);
		$this->assertGreaterThan(0,$bResult);
		
		$bResult = Model_PagesTable::getPageMenu($this->ssCulture, $this->ssEmpty,$this->bFalse);
		$this->assertInternalType('array',$bResult);
		$this->assertArrayHasKey('items',$bResult);
		$this->assertGreaterThan(0,$bResult);		
	}
	
	/**
	 * Test function getPagesById 
	 * @param  number  $snPageId  is For Page id
	 * @return object
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testGetPagesById()
    {
      	$bResult = Model_PagesTable::getPagesById();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesById($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesById($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesById($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesById($this->snWrongPageId);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesById($this->snPageId);
        $this->assertInternalType('object', $bResult);
        $this->assertInstanceOf('Model_Pages', $bResult);
    }
    
    /**
	 * Test function getPagesByParentId 
	 * @param  number  $snPageParentId  is For Page parent id
	 * @param  number  $snUpdateOredrId is For Page order id
	 * @return object
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testGetPagesByParentId()
    {
    	$bResult = Model_PagesTable::getPagesByParentId();
        $this->assertFalse($bResult);
        $this->assertEmpty($bResult);	
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesByParentId($this->ssEmpty,$this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertEmpty($bResult);	
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesByParentId($this->snWrongParentId,$this->snWrongOrder);
        $this->assertFalse($bResult);
        $this->assertEmpty($bResult);	
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesByParentId($this->asBlankArray,$this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertEmpty($bResult);	
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesByParentId($this->ssStringParameter,$this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertEmpty($bResult);	
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::getPagesByParentId($this->snPageParentId,$this->snOrder);
        $this->assertInternalType('object', $bResult);
        $this->assertInstanceOf('Model_Pages', $bResult);
    }
    
    /**
	 * Test function InsertPage 
	 * @param  array   $amPageData is For Page insert Data
	 * @return boolean
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testInsertPage()
    {
    	$bResult = Model_PagesTable::InsertPage();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::InsertPage($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::InsertPage($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::InsertPage($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::InsertPage($this->amWrongInsertArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
    }
    
     /**
	 * Test function UpdatePage 
	 * @param  array $amPageData is For Page update Data
	 * @return boolean
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testUpdatePage()
    {
    	$bResult = Model_PagesTable::UpdatePage();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::UpdatePage($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::UpdatePage($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::UpdatePage($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
    }
    
    /**
	 * Test function changeIsActive 
	 * @param  array $amUpdateData 
	 * @return boolean
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testChangeIsActive()
    {
    	$bResult = Model_PagesTable::changeIsActive();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::changeIsActive($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::changeIsActive($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::changeIsActive($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::changeIsActive($this->WrongIsActiveArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);	
        
        $bResult = Model_PagesTable::changeIsActive($this->IsActiveArray);
        $this->assertTrue($bResult);
        $this->assertInternalType('boolean', $bResult);
    }
    
    /**
	 * Test function deletePage 
	 * @param  number $snPageId for Page Id
	 * @return boolean
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testDeletePage()
    {
    	$bResult = Model_PagesTable::deletePage();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::deletePage($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::deletePage($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::deletePage($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::deletePage($this->snWrongPageId);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_PagesTable::deletePage($this->snDeletePageId);
        $this->assertTrue($bResult);
        $this->assertInternalType('boolean', $bResult);
    }	
}