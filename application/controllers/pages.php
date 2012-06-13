<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Pages extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->invoiceReport('Prothikkah', 'June 2012');
    }

    public function view($page = 'home') {
        if (!file_exists('application/views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function headers() {
        $this->load->library('cezpdf/cezpdf');
        $this->load->helper('pdf');

        prep_pdf(); // creates the footer for the document we are creating.

        $db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
        $db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
        $db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');

        $col_names = array(
            'name' => 'Name',
            'phone' => 'Phone Number',
            'email' => 'E-mail Address'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Contact List', array('width' => 400));
        $this->cezpdf->ezStream();
    }

    public function invoiceReport($houseName, $rentMonth) {

//        require_once('../config/lang/eng.php');
//        require_once('../tcpdf.php');
        $this->load->library('tcpdf/tcpdf');

//Invoice Report Creation Date        
        $this->load->helper('date');
        $format = "%l - %j%S %F %Y, %g:%i %A";
        $time = time();

// create new PDF document
        $pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tahmid Tanzim Lupin');
        $pdf->SetTitle('House Rent: ' . $houseName);
        $pdf->SetSubject('Rent for ' . $rentMonth);
        $pdf->SetKeywords($houseName . ' , ' . $rentMonth);

// set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . $rentMonth, PDF_HEADER_STRING . '   [ '.mdate($format, $time).' ]');
// set header and footer fonts
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

// set default monospaced font
        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
//        $pdf->setLanguageArray($l); // TCPDF ERROR: Some data has already been output, can't send PDF file
// ---------------------------------------------------------
// set font
//        $pdf->SetFont('helvetica', 'B', 20);
// add a page
        $pdf->AddPage();

//        $pdf->Write(0, 'Example of House Rent tables', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('times', '', 8);

        $Apartment = '<table border="0.5" cellpadding="2">
                <tr style="background-color:#CACACA;">
                    <th colspan="2"><h2>3-B &nbsp;&nbsp; | &nbsp;&nbsp; September 2012</h2></th>                          
                </tr>
                <tr>
                    <td width="70%" align="left">&nbsp;&nbsp;1. House Rent </td>
                    <td width="30%">$5,465</td>
                </tr>
                <tr>
                    <td width="70%"  align="left">&nbsp;&nbsp;2. Electricity </td>
                    <td width="30%">$465</td>
                </tr>
                <tr>
                    <td width="70%"  align="left">&nbsp;&nbsp;3. Gas </td>
                    <td width="30%">$123</td>
                </tr>
                <tr>
                    <td width="70%"  align="left">&nbsp;&nbsp;4. Water </td>
                    <td width="30%">$465</td>
                </tr>
                <tr>
                    <td width="70%" align="left">&nbsp;&nbsp;5. Sweeper </td>
                    <td width="30%">$50</td>
                </tr>
                <tr>
                    <td width="70%" align="left">&nbsp;&nbsp;6. Previous Due </td>
                    <td width="30%">$70</td>
                </tr>
                <tr>
                    <td width="70%" align="left">&nbsp;&nbsp;7. Misc. </td>
                    <td width="30%">$0</td>
                </tr>                
                <tr  style="background-color:#F2F2F2;">
                    <td width="70%" align="left">&nbsp;&nbsp;<b>Total:</b></td>
                    <td width="30%"><b>$420</b></td>
                </tr> 
                <tr>                    
                    <td colspan="2" align="left" >&nbsp;&nbsp;Note: </td>
                </tr>
                <tr>
                     <td colspan="2" >
                     <br />
                     <br />
                     <br />
                        Paid: ................................ Due: ..............................
                     <br />
                     <br />
                     <br />
                     <br />                        
                     <br />                     
                        Signature: .............................................................. 
                     <br />
                        <small>' . mdate($format, $time) . ' @ Thank You</small>
                     </td>
                </tr>
            </table>';

        $ApartmentRow = '<td>4-A</td>                            
                        <td>-</td>
                        <td>$12,345</td>
                        <td>$12,345</td>
                        <td>$12,345</td>
                        <td>$12,345</td>
                        <td>$12,345</td>
                        <td>-</td>                    
                        <td><b>$12,345</b></td>
                        <td></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>';
        $AllApt = '';
        for ($i = 0; $i < 15; $i++) {
            if ($i % 2) {
                $AllApt.='<tr style="background-color:#E8E8E8;">' . $ApartmentRow . '</tr>';
            } else {
                $AllApt.='<tr>' . $ApartmentRow . '</tr>';
            }
        }
// -----------------------------------------------------------------------------
        $table = '<table cellspacing="3" cellpadding="3" border="0" align="center" width="100%">
    <tr>
        <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
       </td>
        <td>
            ' . $Apartment . '
        </td>
    </tr>
    <tr>
    	<td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
    </tr>
    <tr>
       <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
    </tr>
    <tr>
       <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
    </tr>
    <tr>
       <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
        <td>
            ' . $Apartment . '
        </td>
    </tr>
    <tr>

        <td colspan="3">
            <table border="0.5" cellspacing="0" cellpadding="2" width="100%">
                <tr style="background-color:#DEDEDE;">
                    <th colspan="14"><b>Rent for the month of <em>September 2012</em></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @ Rent Collection Date: .....................................................&nbsp;&nbsp;&nbsp;&nbsp;[ <small>' . mdate($format, $time) . '</small> ]</th> 
                </tr>
                <tr style="background-color:#C0C0C0;">
                    <th><b>Flat No.</b></th>                            
                    <th><b>Prev. Due</b></th>
                    <th><b>H. Rent</b></th>
                    <th><b>Electricity</b></th>
                    <th><b>Gas</b></th>
                    <th><b>Water</b></th>
                    <th><b>Sweeper</b></th>
                    <th><b>Misc.</b></th>
                    <th><b>Total</b></th>                    
                    <th><b>Amt. Paid</b></th>
                    <th><b>Curr. Due</b></th>
                    <th colspan="2"><b>Note</b></th>
                    <th><b>Signature</b></th>
                </tr>
                ' . $AllApt . '   
                    
                <tr  style="background-color:#CACACA;">
                <td><b>Total</b></td>                            
                <td><b>-</b></td>
                <td><b>$12,345</b></td>
                <td><b>$12,345</b></td>
                <td><b>$12,345</b></td>
                <td><b>$12,345</b></td>
                <td><b>$12,345</b></td>
                <td><b>-</b></td>                    
                <td><b><em>$12,345</em></b></td>
                <td><b>-</b></td>                    
                <td><b>-</b></td>                    
                <td colspan="3"><small>&copy; 2012 Tahmid Tanzim Lupin</small></td>
                </tr>                
            </table>
        </td>
    </tr>
</table>';

        $pdf->writeHTML($table, true, false, true, false, '');
// -----------------------------------------------------------------------------
//        $tbl = <<<EOD
//<table cellspacing="0" cellpadding="1" border="1">
//    <tr>
//        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3<br />text line<br />text line<br />text line<br />text line<br />text line<br />text line</td>
//        <td>COL 2 - ROW 1</td>
//        <td>COL 3 - ROW 1</td>
//    </tr>
//    <tr>
//    	<td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
//    	 <td>COL 3 - ROW 2<br />text line<br />text line</td>
//    </tr>
//    <tr>
//       <td>COL 3 - ROW 3</td>
//    </tr>
//  
//</table>
//EOD;
//
//        $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//        $tbl = <<<EOD
//<table border="1">
//<tr>
//<th rowspan="3">Left column</th>
//<th colspan="5">Heading Column Span 5</th>
//<th colspan="9">Heading Column Span 9</th>
//</tr>
//<tr>
//<th rowspan="2">Rowspan 2<br />This is some text that fills the table cell.</th>
//<th colspan="2">span 2</th>
//<th colspan="2">span 2</th>
//<th rowspan="2">2 rows</th>
//<th colspan="8">Colspan 8</th>
//</tr>
//<tr>
//<th>1a</th>
//<th>2a</th>
//<th>1b</th>
//<th>2b</th>
//<th>1</th>
//<th>2</th>
//<th>3</th>
//<th>4</th>
//<th>5</th>
//<th>6</th>
//<th>7</th>
//<th>8</th>
//</tr>
//</table>
//EOD;
//
//        $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
// Table with rowspans and THEAD
//        $tbl = <<<EOD
//<table border="1" cellpadding="2" cellspacing="2">
//<thead>
// <tr style="background-color:#FFFF00;color:#0000FF;">
//  <td width="30" align="center"><b>A</b></td>
//  <td width="140" align="center"><b>XXXX</b></td>
//  <td width="140" align="center"><b>XXXX</b></td>
//  <td width="80" align="center"> <b>XXXX</b></td>
//  <td width="80" align="center"><b>XXXX</b></td>
//  <td width="45" align="center"><b>XXXX</b></td>
// </tr>
// <tr style="background-color:#FF0000;color:#FFFF00;">
//  <td width="30" align="center"><b>B</b></td>
//  <td width="140" align="center"><b>XXXX</b></td>
//  <td width="140" align="center"><b>XXXX</b></td>
//  <td width="80" align="center"> <b>XXXX</b></td>
//  <td width="80" align="center"><b>XXXX</b></td>
//  <td width="45" align="center"><b>XXXX</b></td>
// </tr>
//</thead>
// <tr>
//  <td width="30" align="center">1.</td>
//  <td width="140" rowspan="6">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
//  <td width="140">XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td width="80">XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
// <tr>
//  <td width="30" align="center" rowspan="3">2.</td>
//  <td width="140" rowspan="3">XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
// <tr>
//  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
// <tr>
//  <td width="80" rowspan="2" >RRRRRR<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
// <tr>
//  <td width="30" align="center">3.</td>
//  <td width="140">XXXX1<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
// <tr>
//  <td width="30" align="center">4.</td>
//  <td width="140">XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td width="80">XXXX<br />XXXX</td>
//  <td align="center" width="45">XXXX<br />XXXX</td>
// </tr>
//</table>
//EOD;
//
//        $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
// NON-BREAKING TABLE (nobr="true")
//
//        $tbl = <<<EOD
//<table border="1" cellpadding="2" cellspacing="2" nobr="true">
// <tr>
//  <th colspan="3" align="center">NON-BREAKING TABLE</th>
// </tr>
// <tr>
//  <td>1-1</td>
//  <td>1-2</td>
//  <td>1-3</td>
// </tr>
// <tr>
//  <td>2-1</td>
//  <td>3-2</td>
//  <td>3-3</td>
// </tr>
// <tr>
//  <td>3-1</td>
//  <td>3-2</td>
//  <td>3-3</td>
// </tr>
//</table>
//EOD;
//
//        $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
// NON-BREAKING ROWS (nobr="true")
//        $tbl = <<<EOD
//<table border="1" cellpadding="2" cellspacing="2" align="center">
// <tr nobr="true">
//  <th colspan="3">NON-BREAKING ROWS</th>
// </tr>
// <tr nobr="true">
//  <td>ROW 1<br />COLUMN 1</td>
//  <td>ROW 1<br />COLUMN 2</td>
//  <td>ROW 1<br />COLUMN 3</td>
// </tr>
// <tr nobr="true">
//  <td>ROW 2<br />COLUMN 1</td>
//  <td>ROW 2<br />COLUMN 2</td>
//  <td>ROW 2<br />COLUMN 3</td>
// </tr>
// <tr nobr="true">
//  <td>ROW 3<br />COLUMN 1</td>
//  <td>ROW 3<br />COLUMN 2</td>
//  <td>ROW 3<br />COLUMN 3</td>
// </tr>
//</table>
//EOD;
//
//        $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
        $pdf->Output($houseName . ' ' . $rentMonth . '.pdf', 'I');
    }

}

?>
