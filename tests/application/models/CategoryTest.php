<?php 

/**
 * Tests_CategoryTable
 *
 * Unit test case for CategoryTable 
 * Listing, insert, edit, update, delete category.
 *
 * @package zendcommom
 * @subpackage phpunit
 * @author Suresh Chikani
 */
class Tests_CategoryTable extends PHPUnit_Framework_TestCase
{
	
	/**
	* For insert, listing, update category status and update categoty detail.  
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
	private $asBlankArrayAsCategory = array();
	
	/**
	* For insert, listing, update category status and update categoty detail.
	* @author Suresh Chikani
	* @var string
	* @access private
	*/
	private $ssStringAsCategory = 'Category';
	
	/**
	* For get category list by lang.
	* @author Suresh Chikani
	* @var string
	* @access private
	*/
	private $ssLang = 'fi';
	
	/**
	* For insert category detail with not exits field. 
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
    private $asCategoryNotExistsField = array('name_en' => 'suresh_en', 'name_fi' => 'suresh_fr', 'imagename' => 'lion-4-1-jpeg-wallpapers.jpeg', 'is_active' => 1 , 'parentid' => 2);
                                         
	/**
	* For insert category detail.
    * @author Suresh Chikani    
	* @var array
	* @access private
	*/
    private $asCategory = Array ( 'name_en' => 'suresh_en', 'name_fi' => 'suresh_fr',  'cat_name' => 'name', 'image_name' => 'lion-4-1-jpeg-wallpapers.jpeg', 'is_active' => '1', 'parentid' => 2 ); 
	
    
    /**
	* For edit category id, delete category id. 
    * @author Suresh Chikani 
	* @var numaric
	* @access private
	*/
	private $snCategoryId = 1;

   /**
	* For edit category id, delete category id.
    * @author Suresh Chikani
	* @var string
	* @access private
	*/
	private $ssCategoryId = 'a';

    /**
	* For edit category id, delete category id.
    * @author Suresh Chikani.
	* @var numaric
	* @access private
	*/
	private $snWrongCategoryId = 18;
    
	/**
	* For category is_active update status
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
	private $asCategoryStatusForUpdate = Array ( 'id' => 4, 'is_active' => 0 ); 
	
	/**
	* For update category detail.
    * @author Suresh Chikani
	* @var array
	* @access private
	*/
	private $amCategoryDetailUpdate = Array( 'name_en' => 'Bouquet shops', 'name_fi' => 'Bouquet kaupat', 'editid' => 10, 'image_name' => 'lion-4-1-jpeg-wallpapers.jpeg','is_active' => 1 );
	
	
	/** ================================ getAllCategoryData function tests case ===========================**/
	/**
	* For get all category record
    * 
    * @author suresh chikani
	* @access public
	*/
    public function testgetAllCategoryData()
    {
        $asResult = Doctrine::getTable('Model_Category')->getAllCategoryData();
        $this->assertInternalType('array', $asResult); 
    }
    
	/** ============================= insertCategory function tests cases =============================== */
     
	/**
	* For insert Category details
	* When user pass blank array as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassBlankArrayParameter()
	{
		$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asBlankArrayAsCategory);
		$this->assertFalse($bResult, "Record do not add successfully because pass blank array as a parameter");
	}

	/**
	* For insert Category details
	* When user pass string as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassStringParameter()
    { 
       	$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->ssStringAsCategory);
	 	$this->assertFalse($bResult, "Record do not add successfully  because pass string value as a parameter");
	}

	/**
	* For insert Category details
	* When user pass blank value as a parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->insertCategory('');
		$this->assertFalse($bResult, "Record do not add successfully because pass blank value as a parameter");
	}
	
	/**
	* For insert Category details
	* When user pass null parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassNullParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->insertCategory();
		$this->assertFalse($bResult, "Record do not add successfully because pass null value as a parameter");
	}

	/**
	* For insert Category details
	* When user pass array parameter with not exists field in table.
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassArrayWithNotExistsField()
    {
		
		$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asCategoryNotExistsField);
		$this->assertFalse($bResult, "Record do not add successfully  because pass array with not exists field in table");
    }

	/**
	* For insert Category details
	* When user pass proper array parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testinsertCategoryWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->insertCategory($this->asCategory);
		$this->assertTrue($bResult, "Record add successfully");
    }
    
    /** ===============Start getCategoryList function tests cases =================================**/
    
	/**
	* For listing of category Detail
    * When user pass null parameter 
    * @author suresh chikani
	* @access public
	*/
    public function testgetCategoryListWhenNullAsParameter()
    {
        $asResult = Doctrine::getTable('Model_Category')->getCategoryList();
        $this->assertInternalType('array', $asResult);
    }

	/**
	* For listing of category Detail
    * When user pass blank parameter 
    * @author suresh chikani
	* @access public
	*/
    public function testgetCategoryListWhenblankAsParameter()
    {
        $asResult = Doctrine::getTable('Model_Category')->getCategoryList('');
        $this->assertFalse($asResult, 'Records not found because pass blank value as a parameter'); 
       
    }
    
	/**
	* For listing of category Detail
    * When user pass blank array as parameter 
    * @author suresh chikani
	* @access public
	*/
    public function testgetCategoryListWhenBlankArrayAsParameter()
    {
       $asResult = Doctrine::getTable('Model_Category')->getCategoryList($this->asBlankArrayAsCategory);
       $this->assertFalse($asResult, 'Records not found because you pass blank array as parameter');
    }
    
	/**
	* For listing of category details
	* When user pass string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testgetCategoryListWhenPassStringParameter()
    { 
       	$bResult = Doctrine::getTable('Model_Category')->getCategoryList($this->ssStringAsCategory);
	 	$this->assertInternalType('array', $bResult);
	}
	
	/**
	* For get all category record.
    *
    * @author suresh chikani
	* @access public
	*/
    public function testgetCategoryList()
    {
        $asResult = Doctrine::getTable('Model_Category')->getCategoryList($this->ssLang);
        $this->assertInternalType('array', $asResult); 
    }
    
    
    /** ===============Start getCategoryById function tests cases =================================**/
	/**
	* For get category detail by category id
    * when user pass blank parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testgetCategoryByIdWhenBlankAsParameter()
	{
		$asResult = Doctrine::getTable('Model_Category')->getCategoryById('');
		$this->assertFalse($asResult, 'Records not found because pass blank value as a parameter ');	
	}
	/**
	* For get category detail by category id
    * When user pass null parameter
    * @author suresh chikani
	* @access public 
	*/
	public function testgetCategoryByIdWhenNullAsParameter()
    {
       $bResult = Doctrine::getTable('Model_Category')->getCategoryById();
       $this->assertFalse($bResult, 'Record not found  because pass null value as a parameter');
    }

   /**
	*For get category detail by category id
    * When user pass string
    * @author suresh chikani
	* @access public 
	*/
	public function testgetCategoryByIdWhenPassStringId()
	{
		$asResult = Doctrine::getTable('Model_Category')->getCategoryById($this->ssCategoryId);
		$this->assertFalse($asResult, 'Records not found because you pass string as a parameter');	
	}

    /**
	* For get category detail by category id
    * When user pass  wrong id
    * @author suresh chikani
	* @access public 
	*/
	public function testgetCategoryByIdWhenPassWrongId()
	{
		$asResult = Doctrine::getTable('Model_Category')->getCategoryById($this->snWrongCategoryId);
		$this->assertEquals(0, false, count( $asResult));
	}

    /**
	* For get category detail by category id
    * When user pass id
    * @author suresh chikani
	* @access public 
	*/
	public function testgetCategoryByIdWhenPassId()
	{
		$asResult = Doctrine::getTable('Model_Category')->getCategoryById($this->snCategoryId);
		$this->assertInternalType('array', $asResult);
	}
	
	/** =============== Start deleteCategoryById function tests cases =================================**/
	
	/**
	* For delete of category by category id.
	* when user pass null parameter as id
    *
    * @author suresh chikani
	* @access public
	*/
    public function testdeleteCategoryByIdWhenNullAsParameter()
    {
       $bResult = Doctrine::getTable('Model_Category')->deleteCategoryById();
       $this->assertFalse($bResult, 'Record not delete successfully because pass null as parameter');
    }
    
	/**
	* For delete category detail by category id.
    * When user pass blank value as id
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCategoryByIdWithBlankId()
	{
		$asResult = Doctrine::getTable('Model_Category')->deleteCategoryById('');
		$this->assertFalse($asResult, 'Records not delete successfully because pass balnk as parameter');	
	}

   /**
	* For delete category detail by category id.
    * When user pass string as id
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCategoryByIdWithStringId()
	{
		$asResult = Doctrine::getTable('Model_Category')->deleteCategoryById($this->ssCategoryId);
		$this->assertFalse($asResult, 'Records not delete because you pass string as a parameter');	
	}

    /**
	* For delete category detail by category id.
    * When user pass  wrong id
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCategoryByIdWithWrongId()
	{
		$asResult = Doctrine::getTable('Model_Category')->deleteCategoryById($this->snWrongCategoryId);
		$this->assertEquals(0, false, count( $asResult));
	}

   /**
	* For delete category detail by category id.
    * When user pass id
    * @author suresh chikani
	* @access public 
	*/
	public function testdeleteCategoryByIdWithCategoryId()
	{
		//$asResult = Doctrine::getTable('Model_Category')->deleteCategoryById($this->snCategoryId);
		//$this->assertTrue($asResult,"Record deleted sucessfully");
	}
	
	/** =============== Start changeIsActive function tests cases =================================**/
	
 	/**
	* For updating category status
	* When user pass blank  array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeIsActiveWhenPassBlankArrayParameter()
    {
        $bResult = Doctrine::getTable('Model_Category')->changeIsActive($this->asBlankArrayAsCategory);
		$this->assertFalse($bResult, "Record do not update successfully because pass blank array");
    }
    
	/**
	* For updating category status
	* When user pass string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeIsActiveWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->changeIsActive($this->ssStringAsCategory);
		$this->assertFalse($bResult, "Record do not update successfully  because pass string value as a parameter");
	}

	/**
	* For updating category status
	* When user pass balnk parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeIsActiveWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->changeIsActive('');
		$this->assertFalse($bResult, "Record do not update successfully because pass blank value as a parameter");
    }
    
	/**
	* For updating category status
	* When user pass null parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeIsActiveWhenPassNullParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->changeIsActive();
		$this->assertFalse($bResult, "Record do not update successfully because pass null value as a parameter");
    }

    /**
	* For updating category status
	* When user pass array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testchangeIsActiveWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->changeIsActive($this->asCategoryStatusForUpdate);
		$this->assertTrue($bResult, "Record update successfully");
    }
    
    /** =============== Start updateCategory function tests cases ================================= **/
    
	/**
	* For updating category detail
	* When user pass blank  array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testupdateCategoryWhenPassBlankArrayParameter()
    {
        $bResult = Doctrine::getTable('Model_Category')->updateCategory($this->asBlankArrayAsCategory);
		$this->assertFalse($bResult, "Record do not update successfully because pass blank array");
    }

	/**
	* For updating category detail
	* When user pass string parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testupdateCategoryWhenPassStringParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->updateCategory($this->ssStringAsCategory);
		$this->assertFalse($bResult, "Record do not update successfully  because pass string value as a parameter");
	}

	/**
	* For updating category detail
	* When user pass blank value as parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testupdateCategoryWhenPassBlankParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->updateCategory('');
		$this->assertFalse($bResult, "Record do not update successfully  because pass blank value as a parameter");
    }

    /**
	* For updating category detail
	* When user pass array  parameter
	*
	* @author suresh chikani
	* @access public
	*/
	public function testupdateCategoryWhenPassAppropriateArrayParameter()
    {
		$bResult = Doctrine::getTable('Model_Category')->updateCategory($this->amCategoryDetailUpdate);
		$this->assertTrue($bResult, "Record update successfully");
    }
}
?>