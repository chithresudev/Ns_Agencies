<?php

namespace App\Http\Controllers;

use PDF;
use App\Donor;
use App\Printable;
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

    public function printall()
    {
      $query = app('request');
      $session_id = session('ids');


      if($query->has('id')) {

        $print = new Printable;
        $print->user_id = auth()->user()->id;
        $print->donor_id = $query->id;
        $print->save();

        $donors = Donor::where('id', $query->id)->get();
      }
       else {

         for ($i = 0; $i < count($session_id) ; $i++) {
           $print = new Printable;
           $print->user_id = auth()->user()->id;
           $print->donor_id = $session_id[$i];
           $print->save();
         }
        $donors = Donor::whereIn('id', $session_id)->get();
      }

       $left = '';
       $right = '';

       foreach ($donors as $key => $donor) {

        if($donor->id % 2 != 0) {
          $left.= str_replace(',', "<br/>" , $donor->print_address ) . '<br/><hr><br/><br/>';
        } else {

          $right.= str_replace(',', "<br/>" , $donor->print_address ) . '<br/><hr><br/><br/>';
        }

       }

         $pdf = new TCPDF();
         $pdf::AddPage();
         $first_column_width = 100;
         $xPos = [];

        $current_y_position = $pdf::getY();
        $pdf::writeHTMLCell($first_column_width, 0, 5, $current_y_position, $left, 0, 0, 0);
        $pdf::writeHTMLCell(0, 40, $first_column_width, $current_y_position, $right, 0, 1, 0);

        $pdf::Output('kovil.pdf');

     }

  }
