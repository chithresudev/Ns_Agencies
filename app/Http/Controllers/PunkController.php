<?php

namespace App\Http\Controllers;

use App\Fuel;
use App\Payment;
use App\Stock;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

class PunkController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return void
     */
    public function index()
    {
      if (auth()->user()->role == 'admin') {
        $petrol_read = Fuel::where('fuel', 'petrol')->sum('read_value');
        $diesel_read = Fuel::where('fuel', 'diesel')->sum('read_value');
        $petrol_payment = Payment::where('fuel', 'petrol')->sum('bal_amt');
        $diesel_payment = Payment::where('fuel', 'diesel')->sum('bal_amt');
        $in_petrol_stock = Stock::where('fuel', 'petrol')->sum('in_stock');
        $in_diesel_stock = Stock::where('fuel', 'diesel')->sum('in_stock');

        $summary = [
          'petrol_read' => $petrol_read,
          'diesel_read' => $diesel_read,
          'petrol_payment' => $petrol_payment,
          'diesel_payment' => $diesel_payment,
          'in_petrol_stock' => $in_petrol_stock,
          'in_diesel_stock' => $in_diesel_stock,
        ];
        return view('punk.index', $summary);
      }
         return view('punk.index');
    }

    /**
     * Show the Fuel Form.
     *
     * @return void
     */
    public function fuel()
    {
         return view('punk.fuel');
    }

    /**
     * Store the Fuel Form.
     *
     * @return void
     */
    public function fuelStore(Request $request)
    {

      $request->validate([
          'tank' => 'required',
          'shift' => 'required',
          'fuel' => 'required',
          'price' => 'required|numeric',
          'reading_value' => 'required',
          'total_amt' => 'required|numeric',
      ]);

      $custom = $request->from_hr . $request->from_format . '_to_' . $request->to_hr . $request->to_format;
      $shit_time = ($request->shift_time == 'custom_time') ? $custom :  $request->shift_time;

      $fuel = new Fuel();
      $fuel->user_id = auth()->user()->id;
      $fuel->tank = $request->tank;
      $fuel->shift = $request->shift;
      $fuel->shift_time = $shit_time;
      $fuel->fuel = $request->fuel;
      $fuel->price = $request->price;
      $fuel->read_value = $request->reading_value;
      $fuel->total_amt = $request->total_amt;
      $fuel->save();

      return back()->with('status', 'ok');
    }

    /**
     * Show the Payment Form.
     *
     * @return void
     */
    public function payment()
    {
         return view('punk.payment');
    }

    /**
     * Store the Payment from Form.
     *
     * @return void
     */
    public function paymentStore(Request $request)
    {

      $request->validate([
          'payment' => 'required',
          'fuel' => 'required',
          'in_amount' => 'required|numeric',
          'out_amount' => 'required|numeric'
      ]);

      $payment = new Payment();
      $payment->user_id = auth()->user()->id;
      $payment->type = $request->payment;
      $payment->fuel = $request->fuel;
      $payment->in_amount = $request->in_amount;
      $payment->out_amount = $request->out_amount;
      $payment->comment = $request->comment;
      $payment->bal_amt = $request->bal_amt;
      $payment->save();

      return back()->with('status', 'ok');
    }

    /**
     * Show the Payment Form.
     *
     * @return void
     */
    public function stock()
    {
         return view('punk.stock');
    }

    /**
     * Store the Payment from Form.
     *
     * @return void
     */
    public function stockStore(Request $request)
    {
      $request->validate([
          'fuel' => 'required',
          'in_stock' => 'required|numeric',
          'out_stock' => 'required|numeric',
      ]);

      $payment = new Stock();
      $payment->user_id = auth()->user()->id;
      $payment->fuel = $request->fuel;
      $payment->in_stock = $request->in_stock;
      $payment->out_stock = $request->out_stock;
      $payment->comment = $request->comment;
      $payment->bal_stock = $request->bal_stock;
      $payment->save();

      return back()->with('status', 'ok');
    }

    /**
     * Show the Payment Form.
     *
     * @return void
     */
    public function fuelView(Request $request)
    {

      if ($request->has('fuel')) {

         if($request->from == null && $request->to == null && $request->fuel=='all') {
           $fuels = Fuel::get();
         }

         else if($request->from != null && $request->to != null && $request->fuel=='all') {
           $fuels = Fuel::whereBetween('created_at', [$request->from, $request->to])
                           ->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel!='all') {
           $fuels = Fuel::where('fuel', $request->fuel)->whereBetween('created_at', [$request->from, $request->to])
                              ->get();
         }

         else {
           $fuels = Fuel::where('fuel', $request->fuel)->get();

         }

        }

         return view('punk.fuel', ['fuels' => $fuels]);
    }

    /**
     * Report the Payment Form.
     *
     * @return void
     */
    public function paymentView(Request $request)
    {


         if($request->from == null && $request->to == null && $request->fuel=='all' && $request->payment=='all') {
           $payments = Payment::get();
         }

         else if($request->from == null && $request->to == null && $request->fuel=='all' && $request->payment!='all') {
           $payments = Payment::where('type', $request->payment)->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel=='all' && $request->payment=='all') {
           $payments = Payment::whereBetween('created_at', [$request->from, $request->to])
                           ->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel!='all' && $request->payment=='all') {
           $payments = Payment::where('fuel', $request->fuel)->whereBetween('created_at', [$request->from, $request->to])
                              ->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel!='all' && $request->payment!='all') {
           $payments = Payment::where('fuel', $request->fuel)->where('type', $request->payment)->whereBetween('created_at', [$request->from, $request->to])
                              ->get();
         }


         else {
           $payments = Payment::where('fuel', $request->fuel)->get();

         }



         return view('punk.payment', ['payments' => $payments]);
    }
    /**
     * Report the Payment Form.
     *
     * @return void
     */
    public function stockView(Request $request)
    {

      if ($request->has('fuel')) {

         if($request->from == null && $request->to == null && $request->fuel=='all') {
           $stocks = Stock::get();
         }

         else if($request->from != null && $request->to != null && $request->fuel=='all') {
           $stocks = Stock::whereBetween('created_at', [$request->from, $request->to])
                           ->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel!='all') {
           $stocks = Stock::where('fuel', $request->fuel)->whereBetween('created_at', [$request->from, $request->to])
                              ->get();
         }

         else {
           $stocks = Stock::where('fuel', $request->fuel)->get();

         }

        }


         return view('punk.stock', ['stocks' => $stocks]);
    }


    public function tcpdfFuel(Request $request)
    {

      $fuels = Fuel::whereIn('id', $request->print)->get();
      $fual_data = '<table style="border:1px solid">
          <tr>
          <th>ID</th>
          <th>Tank</th>
          <th>Shift</th>
          <th>Fuel</th>
          <th>Price</th>
          <th>Reading</th>
          <th>Total</th>
          <th>Fuel At</th>
          </tr>';

      foreach ($fuels as $key => $fuel) {

         $fual_data .= '
         <tr>
         <td>' . $fuel->id . '</td>
         <td>' . ucfirst($fuel->tank) . '</td>
         <td>' . ucfirst(str_replace('_', ' ', $fuel->shift)) . '</td>
         <td>' . ucfirst($fuel->fuel) . '</td>
         <td>' . $fuel->price . '</td>
         <td>' . $fuel->read_value . '</td>
         <td>' . $fuel->total_amt . '</td>
         <td>' . $fuel->created_at . '</td>
         </tr>';
       }


         $pdf = new TCPDF();
         $pdf::AddPage();

         $xPos = [];

        $current_y_position = $pdf::getY();
        $pdf::writeHTMLCell(0, 40, 0, 0, $fual_data, 0, 1, 0);
        $pdf::Output('kovil.pdf');


      //
      // $html = '<h1>'. str_replace(',', "<br/>" , $request->print . '</h1>';
      //
      //   PDF::SetTitle('Petrol Punk');
      //   PDF::AddPage();
      //   PDF::writeHTML($html . ',' ,10);
      //   PDF::Output('hello_world.pdf');

    }



}
