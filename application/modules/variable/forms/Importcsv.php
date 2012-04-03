<?php
/**
 * Variable_Form_Importcsv
 * Import csv file form
 *
 * @category   Zend
 * @package    admin
 * @subpackage form
 * @author     Bhaskar Joshi
 * @uses       Zend_Form
 */
class Variable_Form_Importcsv extends Zend_Form
{
    public function init()
    {
        //Set flag file control 
		$oImportCsv = new Zend_Form_Element_File("importcsv");
       	$oImportCsv->setLabel($this->getTranslator()->_("lbl_select_file "));
       	$oImportCsv->setDestination(APPLICATION_PATH.'/tmp/import/');
        $oImportCsv->addValidator('NotEmpty', true, array('messages' => $this->getTranslator()->_('err_please_select_file')));
	   	$oImportCsv->addValidator('Extension', false, array('csv','messages' => 'err_select_only_csv_file'));
	   	$oImportCsv->setRequired(true);
	   	
	   	$this->addElements(array($oImportCsv));
    }
}

