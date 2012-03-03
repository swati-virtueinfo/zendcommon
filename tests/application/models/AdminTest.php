<?php
/**
 * Tests_AdminModel
 *
 * Unit test case for Admin Table
 * get Records & changepassword of admin
 *
 * @package    zendcommon
 * @subpackage phpunit
 * @author     Bhaskar Joshi
 */
class Tests_AdminTable extends PHPUnit_Framework_TestCase
{
	
	/**
	* Admin Id for get Record & change Password
    *
	* @var number
	* @access private
	*/	
	private $snAdminId = 1;
	
	/**
	* StringParameter for get Record & change Password
    *
	* @var string
	* @access private
	*/	
	private $ssStringParameter = 'test';
	
	/**
	* Blank Array for get Record & change Password
    *
	* @var array
	* @access private
	*/	
	private $asBlankArray = array();	
	
	/**
	* Password for change Password
    *
	* @var string
	* @access private
	*/	
	private $smPasswordValue = 'f527018312300912dc6cc319e6b25dc28aa013b3';//Password : admin1234
	
	
	/**
	* For get Record from admin table
	* when pass blank id as Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetAdminRecordByIdWhenBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->getAdminRecordById('');
      	$this->assertFalse($bResult  ,"Record not Fount because Pass blank As perameter");
    }
    
    /**
	* For get Record from admin table
	* when pass String as Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetAdminRecordByIdWhenStringAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->getAdminRecordById($this->ssStringParameter);
      	$this->assertFalse($bResult  ,"Record not Fount because Pass String As perameter");
    }
    
    /**
	* For get Record from admin table
	* when pass blank Array as Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetAdminRecordByIdWhenArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->getAdminRecordById($this->asBlankArray);
      	$this->assertFalse($bResult  ,"Record not Fount because Pass Array As perameter");
    }
    
    /**
	* For get Record from admin table
	* when pass Correct Id as Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testgetAdminRecordById()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->getAdminRecordById($this->snAdminId);
      	$this->assertTrue($bResult  ,"Record Found By Given Id");
    }
    
    /**
	* For Change Admin Password
	* when pass only one Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePasswordWhenPassOnlyOneParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword($this->snAdminId);
      	$this->assertFalse($bResult  ,"Your Password Not changed Pls Try Again");
    }
    
    
    /**
	* For Change Admin Password
	* when pass Array as Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePasswordWhenPassArrayAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword($this->asBlankArray);
      	$this->assertFalse($bResult  ,"Your Password Not changed Pls Try Again");
    }
    
    /**
	* For Change Admin Password
	* when pass String as Id Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePasswordWhenPassStringAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword($this->smPasswordValue,$this->ssStringParameter);
      	$this->assertFalse($bResult  ,"Your Password Not changed Pls Try Again");
    }
    
    /**
	* For Change Admin Password
	* when pass Blank as Id parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePasswordWhenPassBlankAsIdParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword($this->smPasswordValue,'');
      	$this->assertFalse($bResult  ,"Your Password Not changed Pls Try Again");
    }
    
    /**
	* For Change Admin Password
	* when pass Blank parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePasswordWhenPassBlankAsParameter()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword('');
      	$this->assertFalse($bResult  ,"Your Password Not changed Pls Try Again");
    }
    
     /**
	* For Change Admin Password
	* when pass Appropriate Parameter
    *
    * @author Bhaskar Joshi
	* @access public
	*/
    public function testChangePassword()
    {
    	$bResult = Doctrine::getTable('Model_Admin')->ChangePassword($this->smPasswordValue,$this->snAdminId);
      	$this->assertTrue($bResult  ,"Your Password changed Successfully ");
    }    
}