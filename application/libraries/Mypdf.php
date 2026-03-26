<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/config/tcpdf_config.php';
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
require_once dirname(__FILE__) . '/tcpdf/include/tcpdf_fonts.php';
require_once dirname(__FILE__) . '/tcpdf/include/tcpdf_font_data.php';
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'header.jpg';
		$header_image = '<div style="width:100px !important;height:100px;"><img width:"1000px;" src="' . $image_file . '" /></div>';
		$this->Image($image_file, 0.5, 0.5, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		
		// Title
		//$this->Cell(0, 15, $header_image, 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-6);
		// Set font
		$this->SetFont('helvetica', 'BI', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		$image_file = K_PATH_IMAGES.'footer.jpg';
		$header_image = '<div style="width:100px !important;height:100px;"><img width:"1000px;" src="' . $image_file . '" /></div>';
		$this->Image($image_file, 0.5, 26, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
	}
}
