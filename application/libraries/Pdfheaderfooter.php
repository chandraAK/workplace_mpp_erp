 <?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
//require_oncedirname(__FILE__) . '/tcpdf/tcpdi.php';

class Pdfheaderfooter extends TCPDI {
 
  //Page header
  public function Header() {
    $html = 'Chandra Narayan Sharma Header code';
 
    $this->SetFontSize(8);
    $this->WriteHTML($html, true, 0, true, 0);
  }
 
  // Page footer
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    $html = 'chandra narayan sharma footer code';
 
    $this->SetFontSize(8);
    $this->WriteHTML($html, true, 0, true, 0);
  }
}