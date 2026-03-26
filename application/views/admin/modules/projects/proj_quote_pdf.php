<?php
ob_start();

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//Set Fonts
$pdf->SetFont('dejavusans', '', 10);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// Add a page
$pdf->AddPage();

$quote_id = $_REQUEST['id'];


$html = '<div>
		   <h4 align="center" style="font-weight:bold; color:black; text-transform:uppercase; font-size:11px"><u>Quotation</u></h4>
         </div>'; 

//Item Details         
$html .= '<table width="100%" height="auto" border="1px" cellpadding="5px" cellspacing="0px" style="font-size:6px">
            <tr style="font-weight:bold; background-color:#FFECB3;">
                <td>SNO.</td>
                <td>Desc.</td>
                <td>Qty</td>
                <td>Unit Price</td>
                <td>Net Price</td>
                <td>GST%</td>
                <td>Line Total</td>
                <td>Amount (WM)</td>
                <td>Amount (AE)</td>
                <td>Amount (SM)</td>
            </tr>';

            $sql_item_dtl = "select * from quote_item_details where qitm_quote_id='".$quote_id."'";
            $qry_item_dtl = $this->db->query($sql_item_dtl);

            $cnt = 0;
            $tax_amt_tot = 0;
            $line_amt_tot = 0;
            foreach($qry_item_dtl->result() as $row){
                $cnt++;
                $qitm_item_id = $row->qitm_item_id;
                $qitm_qty = $row->qitm_qty;
                $qitm_unitprice = $row->qitm_unitprice;
                $qitm_netprice = $row->qitm_netprice;
                $qitm_taxrate = $row->qitm_taxrate;
                $qitm_taxamt = $row->qitm_taxamt;
                $qitm_linetotal = $row->qitm_linetotal;

                $tax_amt_tot = $tax_amt_tot+$qitm_taxamt;
                $line_amt_tot = $line_amt_tot+$qitm_linetotal;

                $sql_itm_nm = "select * from item_mst where item_id = '".$qitm_item_id."'";
                $qry_itm_nm = $this->db->query($sql_itm_nm);

                $item_name;
                foreach($qry_itm_nm->result() as $row){
                    $item_name = $row->item_name;
                }

$html .= '  <tr>
                <td>'.$cnt.'</td>
                <td>'.$item_name.'</td>
                <td>'.$qitm_qty.'</td>
                <td>'.$qitm_unitprice.'</td>
                <td>'.$qitm_netprice.'</td>
                <td>'.$qitm_taxrate.'</td>
                <td>'.$qitm_linetotal.'</td>
                <td>'.$qitm_linetotal.'</td>
                <td>'.$qitm_linetotal.'</td>
                <td>'.$qitm_linetotal.'</td>
            </tr>';

            }

$html .= '  <tr>
                <td colspan="6" style="font-weight:bold; background-color:#FFECB3; text-align:right;"><b>GST Total Amount</b></td>
                <td style="font-weight:bold;">'.number_format($tax_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($tax_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($tax_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($tax_amt_tot,2,'.','').'</td>
            </tr>';

$html .= '  <tr>
                <td colspan="6" style="font-weight:bold; background-color:#FFECB3; text-align:right;"><b>Grand Total</b></td>
                <td style="font-weight:bold;">'.number_format($line_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($line_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($line_amt_tot,2,'.','').'</td>
                <td style="font-weight:bold;">'.number_format($line_amt_tot,2,'.','').'</td>
            </tr>';

$html .= '</table>';

$html .= '<br pagebreak="true"/>';

$html .='<h4 style="text-align:center;">ANEXTURE - 2 <br><br>LIST OF EXCLUSION</h4>';

$html .='<table width="100%" height="auto" border="1px" cellpadding="4px" cellspacing="0px" style="font-size:7px;">
            <tr style="font-weight:bold; background-color:#FFECB3;">
                <td>S.N.</td>
                <td>Particulars</td>
                <td></td>
                <td>Remark</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Items In Machine List Of Buyer Scope</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Spare Parts - Wonder Mill , Emery Stones</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Power Factor Panel & Distribution Panel</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Land & Building</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Generator Set</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Packing Machines</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Air Compressor For Packing Machine & Filter</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Civil And Mechanical Drawings</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Graphics And Signage</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>10</td>
                <td>LT/HT Connection And Cable</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Food Expenses And Travel Expenses</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>12</td>
                <td>Hotel Expenses For Consultants</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>13</td>
                <td>Lamination And HDPE Bags</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>14</td>
                <td>Alarm System</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>15</td>
                <td>Air Dust Collection System</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>16</td>
                <td>Auto Bag Loaders</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>17</td>
                <td>CCTV System</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>18</td>
                <td>Pallet Trucks</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>19</td>
                <td>Goods Lifts</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>20</td>
                <td>Project Report</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>21</td>
                <td>Any Other Item Which Is Not Offered Or Mentioned</td>
                <td></td>
                <td>TO BE SUBMIT</td>
            </tr>
            <tr>
                <td>22</td>
                <td>Freight And Loading And Crane Work at Site</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>23</td>
                <td>GST Tax,</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>24</td>
                <td>Size, specification, capacity, design change are chargeable extra</td>
                <td></td>
                <td></td>
            </tr>
        </table>';

$html .= '<br pagebreak="true"/>';

$html .='<h4 style="text-align:center; color:red;">NEW EDGE GRAIN MILLING</h4>';

$html .='<p style="text-align:justify; font-size:9px; line-height:11px">
Wheat is one of the oldest foods in the world. It is thought that the Romans were the first to have
started a milling industry using animals or teams of slaves to drive the wheels to grind the wheat.
Before this, grinding of meal had mostly been carried out in the home using a device called a handquern.
The hand-quern consisted of two round flat stones, one above the other. The upper stone was
turned by a wooden handle, wheat was trickled in through a hole in the center, and meal came out
around the edge.<br><br>
Gradual developments in milling techniques, especially the introduction of the rotary mill around
1000BC, meant improvements in flour for baking. Eventually in the 11th Century watermills and
windmills enabled real progress.<br><br>
Most of the common machines, such as the roller mill and Emery Stone flour mills, were developed by
the 1900s and are still in use in present-day mills. Today the grain milling became a science involving
new and innovative approaches consisting of high technology machinery and phases of milling process
including storing, sorting, blending, cleaning, conditioning, grinding, sieving, purifying and packing. In
India, consumers are fond of Chakki Ground WheatFlour rather than Roller Mill Ground Flour.
To satisfy the needs and wants of customers effectively and efficiently mill owners always look for the
ways to make milling better, faster and easier.<br><br>
Millers often face the problems regarding grinding as they have high-tech machinery for all the
processes of milling except Chakki grinding. When they want more high-tech grinding, they are
helpless as the Indian Chakkies are manual.<br><br>
At Choyal, we are always looking forward with our Research and Development to make grinding hazel
free. The newest and best way to mill grains is the Wonder Mill. It has been created to make this task
more pleasant, quieter, cleaner, and easier. We think you’ll be delightedwith the results, and hope you
will enjoy the Wonder Mill for years to come.<br><br>
Descriptions:
    <ul>
        <li>Wonder mill is world’s first fully automated touch screen integrated flour mill</li>
        <li>7” touch screen panel</li>
        <li>Automated controls for the individual mill and can control all the mills with a single source</li>
        <li>Auto feeder for auto input control</li>
        <li>Level Sensor for input control</li>
        <li>Auto engage and auto disengage hydraulic pressing system</li>
        <li>Grinding Input/output Recipe for individual mill or batch</li>
        <li>Auto input, Auto Temperature, Pressure, Auto Power Control</li>
        <li>Data Recording Using- Mill Running hours, Power Consumption, Output Temperature</li>
        <li>Three step control- warning, Alarm, Shut down</li>
    </ul>
</p>';

$html .= '<br pagebreak="true"/>';

$html .= '<h4 style="text-align:center;">ANNEXURE - 3<br><br>Commercial Terms & Conditions</h4>';

$html .='<table width="100%" border="1px" cellpadding="5px" cellspacing="0px" style="font-size:7px; line-height:10px;">
            <tr>
                <td>1) Price: <br>The price quoted here is FOR Unit -2 Arjun Pura Ajmer. Exclusive of other charges/ cost of erection, installation, supervision up to
                satisfactory test and trial operation.</td>
            </tr>
            <tr>
                <td>Payment Terms: <br>50% At the time of order Balance 50% Against Performa Invoice before delivery.</td>
            </tr>
            <tr>
                <td>2) Payment: <br>RTGS Code<br>Account Name: SHRI VISHVAKARMA (EMERY STONES) INDUSTRIES PVT. LTD.<br>Account No.: 01230400000375<br>Bank Name : Bank of Baroda<br>RTGS Code : BARB0AJMERX01230400000375<br>Please Note (BARB0AJMERX (it is numerical 0 - Zero)</td>
            </tr>
            <tr>
                <td>3) Packing: <br>Exclusive</td>
            </tr>
            <tr>
                <td>4) Freight :<br>Exclusive</td>
            </tr>
            <tr>
                <td>5) Local levies and Tax :<br>Any other local levies will be extra to your account.</td>
            </tr>
            <tr>
                <td>6) Transit Insurance Policy :<br>To Byers accounts, To be procured by you at your expenses at your end. In case of any damage to the machines in transit; you have to deal with “policy issuing branch of insurance Company “to lodge compensation claim.</td>
            </tr>
            <tr>
                <td>7) Specifications :<br>All specifications are approximate and under R&D, we are not binding as to details. We reserve the right to amend and alter them without notice.</td>
            </tr>
            <tr>
                <td>8) Manufacturing Period and Delivery :<br>Within 6- 8 Weeks’ time after receipt of firm order in our hands, subject to unforeseen circumstances,availability of a suitable vessel and force major clause.</td>
            </tr>
            <tr>
                <td>9) Force Meijer clause :<br>Force Meijer clause will be applicable on the delivery of the machine for the situation, which will be beyond our control like
                rejection of major bought out items, fire, strikes etc.</td>
            </tr>
            <tr>
                <td>10) Training :<br>We strongly recommend training of client’s technician at our premises (before dispatch of system) regarding operation & basic
                maintenance of machine</td>
            </tr>
            <tr>
                <td>11) Exclusions :<br>As per Annexure offer 1B and Annexure 2</td>
            </tr>
        </table>';

$html .= '<br pagebreak="true"/>';

$html .='<h4 style="text-align:center;">ANNEXURE – 3 A<br><br>TERMS AND CONDITIONS OF SALE AND DELIVERY</h4>';

$html .='<p p style="text-align:justify; font-size:7px; line-height:11px">These terms and conditions shall apply for Shri Vishvakarma (E.S.) Industries Pvt. Ltd. (hereinafter referred to as CHOYAL).
Within India or out of India, the basis of our terms and conditions of sale and delivery is ANEX-SVIPL01 that apply to the
extent the terms and conditions have not been deviated from by the below provisions:<br>
SPECIAL CONDITIONS:<br>
Drawings and descriptions<br>
Any information about weight, dimensions, capacity, technical and any other data stated in catalogues, leaflets, circulars,
advertisements, photos, dimension sketches and price lists is approximate and without any obligation on the part of
CHOYAL. At the execution of the order, CHOYAL reserves the right to make changes that CHOYAL at any time may consider
technically necessary.<br>
Offer:<br>
Offers are made subject to alteration and subject to the products being unsold. CHOYAL shall reserve the right to alter or
revoke outstanding offers without notice.<br>
Order confirmation:<br>
Any order, including hereunder orders based on offers made by CHOYAL, shall be confirmed in writing by CHOYAL before a
binding agreement of delivery shall have been concluded.<br>
Prices:<br>
All prices are current prices in the currency stated. CHOYAL shall be entitled to alter its prices if changes occur in the supply
of materials, raw material prices, wages, exchange rates or any other conditions beyond the control of CHOYAL, including
hereunder Tax, duties, freight and insurance rates, etc.<br>
Payment:<br>
For all orders our payment terms are as per following:-<br>
<ul>
    <li>50% of the basic order value along with the techno- commercial clear purchase order as advance.</li>
    <li>50% balance payment along with 100% taxes, duties, packing and forwarding, transportation charges (if any)
    against proforma invoice prior to dispatch of goods after completion of inspection (if customer wants) at our
    works.</li>
</ul><br>
Payment for supplies shall be effected as according to the order confirmation, or in the absence of same, according to the
terms and conditions of payment printed on the invoice. The buyer shall not be entitled to retain payment due to any
counterclaims. At payment later than on the above-mentioned date of payment, a penalty interest rate of 14% p.a. above
the official Bank Interest discount rate applying at any one time shall accrue as from the due date and until payment is
affected. Upon forwarding reminder letters after the due date, a fee will be added to cover any such costs.<br>
Ownership reservation:<br>
The products shall remain the property of CHOYAL until the purchase price has been paid in full.<br>
Insurance:<br>
The buyer shall be obliged to have the products supplied fully insured at its utility value as from the time of delivery until
payment has been effected.<br>
Cancellation:<br>
Orders may only be cancelled as according to written agreement with CHOYAL and against payment of CHOYAL’s accrued
costs. Delivered products cannot be returned unless it has been specifically agreed with CHOYAL and in which case a
deduction of at least 20% of the value of the returned products must be made as return charges.<br>
Delivery:<br>
Delivery is effected Ex Works (Saradhana - Ajmer). CHOYAL shall not be responsible if the time of delivery shall be changed
or delayed due to industrial disputes or any other circumstances beyond the control of CHOYAL, such as fire, war, currency
restrictions, lack of means of transportation, general shortage of products, etc.<br>
Default of the buyer:<br>
If the buyer does not observe the agreed conditions regarding the payment of the purchase price or the receipt of
products, CHOYAL shall not be committed to supply the products and CHOYAL shall then be entitled to cancel confirmed
orders and claim damages.<br>
Complaints/Inspection:<br>
The buyer shall, as soon as possible, carry out a reasonable inspection of the products supplied and not later than two
weeks later having forwarded a written complaint to CHOYAL.<br>
The buyer shall not have the right to claim defects that could have been found at such an inspection.<br>
Liability for defects CHOYAL shall be obliged to remedy any defect due to design, manufacturing or use of faulty material,
provided that the defect shall be detected within a year as from the day on
Which the delivery is notified to be ready for dispatch from CHOYAL. Where the nature of the defect is such that in the
opinion of CHOYAL it would not be appropriate to carry out repairs at the site of the installation or where CHOYAL deems
replacement delivery necessary, the buyer shall return the products/parts bought that are defective hence CHOYAL may
repair or replace the parts or undertake replacement deliveries.
Transportation of defective parts to CHOYAL shall be at the buyer’s own risk and expense, whereas transportation of the
repaired or new parts from CHOYAL to the buyer shall be at CHOYAL’s risk and expense. Replaced defective parts shall be
the property of CHOYAL. CHOYAL’s liability shall not include defects arising from material delivered by the buyer or from an
independent third party or from a design ordered by the buyer. CHOYAL’s liability shall include only defects arising under
the terms of function assumed in the agreement and by the correct use hereof.
The liability shall not include defects arising out of defective maintenance or incorrect installation by the buyer, changes
made without the written consent of CHOYAL, faulty repairs carried out – according to written consent of CHOYAL – by the
buyer or ordinary wear and tear or deterioration. CHOYAL shall be entitled to remedy any defect whether the defect is
remedied before or after delivery.<br>
Product liability:<br>
CHOYAL shall not assume any product liability of any kind. CHOYAL shall not be responsible for damage to real and personal
property occurring while the supply in question is in the buyer’s possession. Neither shall CHOYAL be responsible for
damage to products manufactured by the buyer or to products where these form part.
In relation to product liability in other respects reference is made to ANEX-SVIPL02 including any limitations as stated in
these conditions. To the extent CHOYAL may be imposed product liability towards third party, the buyer shall be obliged to
indemnify CHOYAL to the same extent as CHOYAL’s liability shall be limited as according to the four preceding paragraphs.
If any third party puts forward a claim towards one of the parties for compensation as according to this paragraph, this
party shall immediately without delay inform the other party. CHOYAL and the buyer shall be mutually obliged to let actions
be brought against them at the court dealing with any such claims for damages raised against one of them on the basis of
the damage claimed to have been made to the products delivered. Any disputes between the buyer and seller should,
however, always be settled by arbitration.<br>
Consequential loss etc.<br>
In relation to claims raised against CHOYAL in the form of liquidated damages reference shall be made to in which it is
stated that CHOYAL shall only be liable for any such claims in special circumstances and if so only by a maximum amount
specified.
CHOYAL shall in relation to defects in the products supplied, delay, in product liability cases and in any other case not
assume any liability for loss of production, loss of time, loss of profit, consequential loss or any other indirect loss
whatsoever.
Should CHOYAL by arbitration or by any other court or tribunal have such liability incurred, the liability of CHOYAL shall
never be in excess of Rs. 100000.00 per claim.<br>
Installation:<br>
Installation is not included in the offer of CHOYAL unless otherwise expressly stated. The same applies to any construction
work, foundation and electrical installations. If CHOYAL workers are detained at the site of installation for reasons that
cannot be ascribed to CHOYAL, the ensuing costs shall be defrayed by the buyer.<br>
Arbitration<br>
Any dispute arising out of and related to this agreement cannot be tried at the courts but shall be settled by the Ajmer
Courts as according to the legislation and rules applying for arbitration proceedings in India. Any dispute arising out of this
agreement shall be settled under Indian law. Hindi or English shall be the procedural language.
</p>';

$html .= '<br pagebreak="true"/>';

$html .='<h4 style="text-align:center;">ANEXURE -4<br><br>“Read the instructions before attempting to use the product.”<br><br>Warranty Policy<br><br>One-Year Limited Warranty</h4>';

$html .='<p p style="text-align:justify; font-size:7px; line-height:11px">Shri Vishvakarma (E.S.) Ind. Pvt. Ltd. warrants only to the original purchaser of this product from a Choyal-authorized seller or distributor
that this product will be free from defects in material and workmanship under normal use and service for one year after date of
purchase.<br>
SVIPL warrants the owner of this product against defects in materials or workmanship as declared below:<br>
SVIPL will repair or replace the product at no charge for a period of one (1) year from the date of purchase from a SVIPL authorized
dealer/seller, after one year, the consumer must pay for the repair or replacement. This warranty does not cover shipping, installation,
removal or any other costs. Proof of purchase is required and should be retained.<br>
This warranty does not cover cosmetic damage, acts of God, misuse, accidents, any modifications to the product, improper connection,
improper use, or attempted repair by unauthorized dealers other than SVIPL.<br>
This warranty is also void if the product is damaged by a connecting product that may have cause damages through misuse or
malfunction.<br>
A proof of purchase may be in the form of a bill of sale, with the model of the product and the date of purchase stated.<br>
SVIPL reserves the right, before having any obligation under this limited warranty, to inspect the damaged SVIPL product, and all costs of shipping the SVIPL product to SVIPL for inspection shall be borne solely by the purchaser. In order to recover under this limited warranty, Purchaser must make claim to SVIPL within 30 days of occurrence, and must present acceptable proof of original ownership (such as original receipt, warranty card registration, or other documentation SVIPL deems acceptable) for the product. SVIPL, at its option, shall repair or replace the defective unit covered by this warranty. Please retain the dated sales receipt as evidence of the original purchasers date of purchase. You will need it for any warranty service. In order to keep this limited warranty in effect, the product must have been handled and used as prescribed in the instructions accompanying this warranty.<br>
DISCLAIMER OF WARRANTY - except for the limited warranty provided herein, to the extent permitted by law, SVIPL disclaims all
warranties, express or implied, including all warranties of merchantability and/or fitness for a particular purpose. To the extent that any impliedwarranties may nonetheless exist by operation of law, any such warranties are limited to the duration of this warranty. Title or non-infringement, or warranties or obligations arising from a course of dealing, usage or trade practice. Further, novation does not warrant that the product is error free or that buyer will be able to use the product without problems or interruption.<br>
LIMITATION OF LIABILITY<br>
Repair or replacement of this product, as provided herein, is your exclusive remedy. SVIPL shall not be liable for any special, incidental or consequential damages, including, but not limited to, lost revenues, lost profits, loss of use of software, loss or recovery of data, rental of replacement equipment, downtime, damage to property, and third-party claims, arising out of any theory of recovery, including warranty, contract, statutory or tort. Notwithstanding the term of any limited warranty or any warranty implied by law, or in the event that any limited warranty fails of its essential purpose, in no event will SVIPL entire liability exceed the purchase price of this product.<br>
<ul>
    <li>The warranty does not cover damage or loss incurred in transportation of the product including paints.</li>
    <li>The warranty does not cover replacement or repair necessitated by loss or damage from any cause beyond the control of SVIPL,
    such as lightning or other natural and weather related events or wartime environments.</li>
    <li>The warranty does not cover any labor involved in the removal and or reinstallation of warranted equipment or parts on site, or
    any labor required to diagnose the necessity for repair or replacement.</li>
    <li>All out of warranty repairs would be at charge</li>
    <li>In keeping with our policy of continued improvement, SVIPL reserve the right to alter specifications without prior notice.</li>
</ul><br></p>';
		

//echo $html; 
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('uploads/pdf/'.$quote_id.'.pdf', 'FI');
?>