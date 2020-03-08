<?php

namespace App\Http\Controllers;

use App\Fuel;
use App\Payment;
use App\Stock;
use App\User;
use App\Todayprice;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
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
      $today_price = Todayprice::where('date', Carbon::today())->first();

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
          'todaypetrol' => $today_price->petrol ?? 0,
          'todaydiesel' => $today_price->diesel ?? 0,
          'todayspeed' => $today_price->speed ?? 0,
        ];
        return view('punk.index', $summary);
      }
        $summary = [
        'todaypetrol' => $today_price->petrol ?? 0,
        'todaydiesel' => $today_price->diesel ?? 0,
        'todayspeed' => $today_price->speed ?? 0,
      ];

         return view('punk.index', $summary);
    }

    /**
     * Show the Fuel Form.
     *
     * @return void
     */
    public function fuel()
    {
      $request = app('request');
      $today_price = Todayprice::where('date', Carbon::parse($request->date))->first();

         return view('punk.fuel', ['today_price' => $today_price]);
    }

    /**
     * Store the Fuel Form.
     *
     * @return void
     */
    public function fuelStore(Request $request)
    {

      $request->validate([
          'mpd' => 'required',
          'filler' => 'required',
          'fuel' => 'required',
          'price' => 'required|numeric',
          'reading_value' => 'required',
          'total_amt' => 'required|numeric',
          'insert_date' => 'required|date',
      ]);

      $fuel = new Fuel();
      $fuel->user_id = auth()->user()->id;
      $fuel->mpd = $request->mpd;
      $fuel->filler = $request->filler;
      $fuel->fuel = $request->fuel;
      $fuel->price = $request->price;
      $fuel->read_value = $request->reading_value;
      $fuel->total_amt = $request->total_amt;
      $fuel->insert_date = $request->insert_date;
      $fuel->save();

      return back()->with('status', 'ok');
    }

    /**
     * Store the Fuel Form.
     *
     * @return void
     */
    public function fuelUpdate(Fuel $fuel, Request $request)
    {

      $request->validate([
          'mpd' => 'required',
          'filler' => 'required',
          'fuel' => 'required',
          'price' => 'required|numeric',
          'reading_value' => 'required',
          'total_amt' => 'required|numeric',
          'insert_date' => 'required|date',
      ]);


      $fuel->mpd = $request->mpd;
      $fuel->filler = $request->filler;
      $fuel->fuel = $request->fuel;
      $fuel->price = $request->price;
      $fuel->read_value = $request->reading_value;
      $fuel->total_amt = $request->total_amt;
      $fuel->insert_date = $request->insert_date;
      $fuel->save();

      return back()->with('updatestatus', 'ok');
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
          'mpd' => 'required',
          'filler' => 'required',
          'fuel' => 'required',
          'insert_date' => 'required|date',
          'paytm' => 'numeric',
          'cash' => 'numeric',
          'checque' => 'numeric',
          'card' => 'numeric'
      ]);

      $payment = new Payment();
      $payment->user_id = auth()->user()->id;
      $payment->mpd = $request->mpd;
      $payment->filler = $request->filler;
      $payment->fuel = $request->fuel;

      $payment->cash = $request->cash;
      $payment->checque = $request->checque;
      $payment->card = $request->card;
      $payment->paytm = $request->paytm;
      $payment->comment = $request->comment;
      $payment->bal_amt = $request->bal_amt;
      $payment->insert_date = $request->insert_date;
      $payment->save();

      return back()->with('status', 'ok');
    }

    /**
     * Store the Payment from Form.
     *
     * @return void
     */
    public function paymentUpdate(Payment $payment, Request $request)
    {

      $request->validate([
          'mpd' => 'required',
          'filler' => 'required',
          'fuel' => 'required',
          'insert_date' => 'required|date',
          'paytm' => 'numeric',
          'cash' => 'numeric',
          'checque' => 'numeric',
          'card' => 'numeric'
      ]);

      $payment->mpd = $request->mpd;
      $payment->filler = $request->filler;
      $payment->fuel = $request->fuel;

      $payment->cash = $request->cash;
      $payment->checque = $request->checque;
      $payment->card = $request->card;
      $payment->paytm = $request->paytm;
      $payment->comment = $request->comment;
      $payment->bal_amt = $request->bal_amt;
      $payment->insert_date = $request->insert_date;
      $payment->save();

      return back()->with('paymentstatus', 'ok');
    }

    /**
     * Show the Payment Form.
     *
     * @return void
     */
    public function stock()
    {
      $request = app('request');

      if($request) {
        $yesterday = Carbon::parse($request->date)->subDay(1)->startOfDay();
        $balance = Stock::where('fuel', $request->fuel)->where('insert_date', $yesterday)->first();

      } else {

        $balance = Stock::where('insert_date', Carbon::yesterday())->first();
      }
      return view('punk.stock', ['balance' => $balance]);
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
          'insert_date' => 'required|date',
      ]);

      $payment = new Stock();
      $payment->user_id = auth()->user()->id;
      $payment->fuel = $request->fuel;
      $payment->in_stock = $request->in_stock;
      $payment->out_stock = $request->out_stock;
      $payment->comment = $request->comment;
      $payment->bal_stock = $request->bal_stock;
      $payment->insert_date = $request->insert_date;
      $payment->save();

      return back()->with('status', 'ok');
    }

    /**
     * Store the Payment from Form.
     *
     * @return void
     */
    public function stockUpdate(Stock $stock, Request $request)
    {
      $request->validate([
          'fuel' => 'required',
          'in_stock' => 'required|numeric',
          'out_stock' => 'required|numeric',
          'insert_date' => 'required|date',
      ]);

      $stock->fuel = $request->fuel;
      $stock->in_stock = $request->in_stock;
      $stock->out_stock = $request->out_stock;
      $stock->comment = $request->comment;
      $stock->bal_stock = $request->bal_stock;
      $stock->insert_date = $request->insert_date;
      $stock->save();

      return back()->with('updatestatus', 'ok');
    }

    /**
     * Show the Payment Form.
     *
     * @return void
     */
    public function fuelView(Request $request)
    {

      if ($request->has('mpd')) {

         if($request->from == null && $request->to == null && $request->mpd=='all') {
           $fuels = Fuel::get();
         }

         else if($request->from != null && $request->to != null && $request->mpd=='all') {
           $fuels = Fuel::whereBetween('insert_date', [$request->from, $request->to])
                           ->get();
         }

         else if($request->from != null && $request->to != null && $request->mpd!='all') {
           $fuels = Fuel::where('mpd', $request->mpd)->whereBetween('insert_date', [$request->from, $request->to])
                              ->get();
         }

         else {
           $fuels = Fuel::where('mpd', $request->mpd)->get();

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

         if($request->from == null && $request->to == null && $request->mpd=='all') {
           $payments = Payment::get();
         }


         else if($request->from != null && $request->to != null && $request->mpd=='all') {

           $payments = Payment::whereBetween('insert_date', [$request->from, $request->to])
                              ->get();
         }

         else if($request->from != null && $request->to != null && $request->mpd!='all') {
           $payments = Payment::where('mpd', $request->mpd)->whereBetween('insert_date', [$request->from, $request->to])
           ->get();
         }

         else {

           $payments = Payment::where('mpd', $request->mpd)->get();

         }
         // if($request->from == null && $request->to == null && $request->fuel=='all') {
         //   $payments = Payment::get();
         // }
         //
         // else if($request->from != null && $request->to != null && $request->fuel!='all') {
         //   $payments = Payment::where('fuel', $request->fuel)->whereBetween('insert_date', [$request->from, $request->to])
         //                      ->get();
         // }
         //
         // else if($request->from != null && $request->to != null && $request->fuel=='all') {
         //   $payments = Payment::where('fuel', $request->fuel)->whereBetween('insert_date', [$request->from, $request->to])
         //                      ->get();
         // }
         //
         //
         // else {
         //   $payments = Payment::where('fuel', $request->fuel)->get();
         //
         // }



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
           $stocks = Stock::whereBetween('insert_date', [$request->from, $request->to])
                           ->get();
         }

         else if($request->from != null && $request->to != null && $request->fuel!='all') {
           $stocks = Stock::where('fuel', $request->fuel)->whereBetween('insert_date', [$request->from, $request->to])
                              ->get();
         }

         else {
           $stocks = Stock::where('fuel', $request->fuel)->get();

         }

        }


         return view('punk.stock', ['stocks' => $stocks]);
    }


    public function riseQuery(Request $request)
    {
        $riseQuery = new RiseQuery();
        $riseQuery->user_id = auth()->user()->id;
        $riseQuery->module = $request->module;
        $riseQuery->comment = $request->comment;
        $riseQuery->save();
        return back();


    }

    public function remove($value='')
    {
        $request = app('request');

        if ($request->module == 'fuel') {
          $remove = Fuel::find($request->fuel_id)->delete();
        }

        if ($request->module == 'payment') {
          $remove = Payment::find($request->payment_id)->delete();
        }

        if ($request->module == 'stock') {
          $remove = Stock::find($request->stock_id)->delete();
        }

        if ($request->module == 'users') {
          $remove = User::find($request->user_id)->delete();
        }

        if ($request->module == 'todayprice') {
          $remove = Todayprice::find($request->id)->delete();
        }

        return back()->with('removestatus', 'ok');

    }

    public function profile()
    {
       return view('auth.change-profile');
    }

    public function profileUpdate(User $user, Request $request)
    {

      $validator = Validator::make($request->all(), [
         'name' => 'required|string',
         'email' => 'required|email',
         'old_password' => 'required|string|min:8',
         'password' => 'required|string|min:8|regex:/^\S*$/u',
         'password_confirmation' => 'required|string|min:6|same:password',
      ]);


      if ($validator->fails()) {
          return back()->withErrors($validator)->withInput();
      }

      $user = auth()->user();

      if (Hash::check($request->old_password, $user->password)) {
          $user->password = Hash::make($request->password);
          $user->save();
     } else {
         return back()->withInput()->withErrors([
           'old_password' => 'You have entered wrong password'
         ]);
     }

        return back()->with('updatestatus', 'ok');
    }


    public function users()
    {
        $users = User::whereNotIn('role', ['admin'])->get();
       return view('auth.users', ['users' => $users]);
    }


    public function register()
    {
       return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8|confirmed'
      ]);


      if ($validator->fails()) {
          return back()->withErrors($validator)->withInput();
      }

     $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'role' => 'manager',
          'password' => Hash::make($request->password),
      ]);
      return back()->with('status', 'ok');

    }

    public function todayPrice()
    {
        $today_prices = Todayprice::paginate(10);
        return view('punk.todayprice', ['todayprices' => $today_prices]);
    }

    public function todayPriceStore(Request $request)
    {

      $validator = Validator::make($request->all(), [
        'petrol' => 'required|numeric',
        'diesel' => 'required|numeric',
        'speed' => 'required|numeric',
        'date' => 'required|date|unique:todayprices',
      ]);


      if ($validator->fails()) {
          return back()->withErrors($validator)->withInput();
      }

       $today_price = new Todayprice;
       $today_price->petrol = $request->petrol;
       $today_price->diesel = $request->diesel;
       $today_price->speed = $request->speed;
       $today_price->date = $request->date;
       $today_price->save();

      return back()->with('status', 'ok');

    }



}
