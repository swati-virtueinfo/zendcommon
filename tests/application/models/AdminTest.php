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
	private $snAdminId = 1;
	private $smPasswordValue = 'f527018312300912dc6cc319e6b25dc28aa013b3';//Password : admin1234
	
	private $ssEmpty = '';
	private $asBlankArray = array();
	private $ssStringParameter = 'test';
	
	private $snWrongAdminId = 'd500';
	
	/**
	 * Test function getAdminRecordById 
	 * @param  number  $snAdminId  is For admin id
	 * @return Array
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testGetAdminRecordById()
    {
    	$bResult = Model_AdminTable::getAdminRecordById();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult); 	
        
        $bResult = Model_AdminTable::getAdminRecordById($this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_AdminTable::getAdminRecordById($this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_AdminTable::getAdminRecordById($this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_AdminTable::getAdminRecordById($this->snWrongAdminId);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_AdminTable::getAdminRecordById($this->snAdminId);
        $this->assertInternalType('array', $bResult);
    }
    
    /**
	 * Test function changeAdminPassword 
	 * @param  mixed  $smPassword is for Password
	 * @param  number $snAdminId  is For admin id
	 * @return boolean
	 * @author Bhaskar Joshi
	 * @access public
	 */
    public function testChangeAdminPassword()
    {
    	$bResult = Model_AdminTable::changeAdminPassword();
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult); 
        
        $bResult = Model_AdminTable::changeAdminPassword($this->ssEmpty, $this->ssEmpty);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);	
        
        $bResult = Model_AdminTable::changeAdminPassword($this->asBlankArray, $this->asBlankArray);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);	
        
        $bResult = Model_AdminTable::changeAdminPassword($this->smPasswordValue, $this->snWrongAdminId);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);	
        
        $bResult = Model_AdminTable::changeAdminPassword($this->smPasswordValue, $this->ssStringParameter);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);
        
        $bResult = Model_AdminTable::changeAdminPassword($this->ssEmpty, $this->snAdminId);
        $this->assertFalse($bResult);
        $this->assertInternalType('boolean', $bResult);	
        
        $bResult = Model_AdminTable::changeAdminPassword($this->smPasswordValue, $this->snAdminId);
        $this->assertTrue($bResult);
        $this->assertInternalType('boolean', $bResult);	        
    }    
}