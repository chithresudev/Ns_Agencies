<?php

namespace App\Http\Controllers;

use PDF;
use App\Fuel;
use App\Payment;
use App\Stock;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

class TCPDFController extends Controller
{

    public function index(Request $request)
    {

      $html = '<h1>'. str_replace(',', "<br/>" , $printdetails->print_address ) . '</h1>';

        PDF::SetTitle('Donors Detail');
        PDF::AddPage();
        PDF::writeHTML($html . ',' ,10);
        PDF::Output('hello_world.pdf');

    }


    public function tcpdfFuel(Request $request)
    {
      $style = $this->getStyle();
      $fuels = Fuel::whereIn('id', $request->print ?? [0])->get();

      $fual_data = '';
      foreach ($fuels as $key => $fuel) {

        $fual_data .= '
        <tr>
        <td>' . ($key + 1) . '</td>
        <td>' . ucfirst($fuel->tank) . '</td>
        <td>' . ucfirst(str_replace('_', ' ', $fuel->shift)) . '</td>
        <td>' . ucfirst($fuel->fuel) . '</td>
        <td>' . $fuel->price . '</td>
        <td>' . $fuel->read_value . '</td>
        <td>' . $fuel->total_amt . '</td>
        <td>' . $fuel->insert . '</td>
        <td>' . $fuel->created . '</td>
        </tr>';
      }

  $getData = <<<EOD
    $style
     <h4>Fuel Reports</h4>
    <table cellspacing="0" cellpadding="1">
        <thead>
          <tr>
          <th>#</th>
          <th>MPD</th>
          <th>Shift</th>
          <th>Fuel</th>
          <th>Price</th>
          <th>Reading</th>
          <th>Total</th>
          <th>Fuel At</th>
          <th>Updated At</th>
          </tr>
        </thead>
        <tbody>
          $fual_data
        </tbody>
    </table>
    <br>

EOD;

         $pdf = new TCPDF();
         $pdf::AddPage('L', 'A4');

         $xPos = [];

        $current_y_position = $pdf::getY();
        $pdf::writeHTMLCell(0, 40, 10, 10, $getData, 0, 1, 0);
        $pdf::Output('Fuel-report.pdf');

    }

    public function tcpdfPayment(Request $request)
    {
      $style = $this->getStyle();
      $payments = Payment::whereIn('id', $request->print ?? [0])->get();
      $grandTotal = Payment::whereIn('id', $request->print ?? [0])->sum('bal_amt');

      $payment_data = '';
      foreach ($payments as $key => $payment) {
        $payment_data .= '
        <tr>
        <td>' . ($key + 1) . '</td>
        <td>' . ucfirst($payment->tank . '</td>
        <td>' . ucfirst(str_replace('_', ' ', $payment->shift)) . '</td>
        <td>' . str_replace('_', ' ', $payment->shift_time)) . '</td>
        <td>' . ucfirst($payment->fuel) . '</td>
        <td>' . $payment->cash . '</td>
        <td>' . $payment->checque . '</td>
        <td>' . $payment->card . '</td>
        <td>' . $payment->paytm . '</td>
        <td>' . $payment->created . '</td>
        <td>' . $payment->insert . '</td>
        <td>' . $payment->bal_amt . '</td>

        </tr>';
      }

  $getData = <<<EOD
    $style
     <h4>Payments Reports</h4>
    <table cellspacing="0" cellpadding="1">
    <thead>
    <tr>
    <th>#</th>
    <th>MPD</th>
    <th>Shift</th>
    <th>Time</th>
    <th>Fuel</th>
    <th>Cash</th>
    <th>Checque</th>
    <th>Card</th>
    <th>Paytm</th>
    <th>Pay Date</th>
    <th>Updated</th>
    <th>Total</th>
      </tr>
    </thead>
        <tbody>
          $payment_data
          <tr>
          <td colspan="10">Grand Total</td>
          <td colspan="2">Rs : $grandTotal</td>
          </tr>
        </tbody>
    </table>
    <br>
EOD;

         $pdf = new TCPDF();
         $pdf::AddPage('L', 'A4');

         $xPos = [];

        $current_y_position = $pdf::getY();
        $pdf::writeHTMLCell(0, 40, 10, 10, $getData, 0, 1, 0);
        $pdf::Output('Payment-report.pdf');

    }

    public function tcpdfStock(Request $request)
    {
      $style = $this->getStyle();
      $stocks = Stock::whereIn('id', $request->print ?? [0])->get();

      $stocks_data = '';
      foreach ($stocks as $key => $stock) {

        $stocks_data .= '
        <tr>
        <td>' . ($key + 1) . '</td>
        <td>' . ucfirst($stock->fuel) . '</td>
        <td>' . $stock->in_stock . '</td>
        <td>' . $stock->out_stock . '</td>
        <td>' . $stock->bal_stock . '</td>
        <td>' . $stock->inserted_date  . '</td>
        <td>' . $stock->created  . '</td>
        </tr>';
      }

  $getData = <<<EOD
    $style
     <h4>Stock Reports</h4>
    <table cellspacing="0" cellpadding="1">
        <thead>
          <tr>
          <th scope="col">#</th>
          <th scope="col">Fuel</th>
          <th scope="col">In Stock</th>
          <th scope="col">Out Stock</th>
          <th scope="col">Balance Stock</th>
          <th scope="col">Stock At</th>
          <th scope="col">Updated At</th>
          </tr>
        </thead>
        <tbody>
          $stocks_data
        </tbody>
    </table>
    <br>

EOD;

         $pdf = new TCPDF();
         $pdf::AddPage('L', 'A4');

         $xPos = [];

        $current_y_position = $pdf::getY();
        $pdf::writeHTMLCell(0, 40, 10, 10, $getData, 0, 1, 0);
        $pdf::Output('Stock-report.pdf');

    }

    private function getStyle()
   {
       $style = '
       <style>
           h1 {
               font-size:20px;
               color:#ef3e41;
               font-weight:bold;
           }



           h2 {
               font-size:40px;
               color:#ef3e41;
               font-weight:bold;
               text-transform:uppercase;
               letter-spacing:1px;
               line-height:20px;
           }



           h4 {
               font-size:16px;
               color : #1B75BC;
               font-weight:bold;
           }



           p,
           ul > li {
               font-size:14px;
               line-height:20px;
               color:#808285;
               font-weight:normal;
               text-align: justify;
           }



           p > strong{
               font-size:13px;
               color:#65666d;
               font-weight:normal;
           }



           table {
                border: solid 1px #cacbd8;
                border-collapse: collapse;
                border-spacing: 0;
                color:#808285;
                font-weight:normal;
                line-height:28px;
                text-align:center;
           }



           th {
               font-weight : bold;
               border: solid 1px #cacbd8;
               font-size:12px;
           }




           td {
                font-size:12px;
                border: solid 1px #cacbd8;
                padding:20px;
           }



           .high {
               background:red;
           }
       </style>
       ';



       return $style;
   }



  }
