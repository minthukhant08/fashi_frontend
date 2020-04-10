<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Order\OrderRepositoryInterface as OrderInterface;
use App\Repositories\Delivery\DeliveryRepositoryInterface as DeliveryInterface;
use App\Repositories\Product\ProductRepositoryInterface as ProductInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface as OrderDetailInterface;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\OrderDetail;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public $orderInterface;
     public $productInterface;
     public $deliveryInterface;
     public $orderDetailInterface;

     public function __construct(Request $request, OrderInterface $orderInterface, OrderDetailInterface $orderDetailInterface, DeliveryInterface $deliveryInterface, ProductInterface $productInterface)
     {
         $this->middleware('auth');
         $this->orderInterface=$orderInterface;
         $this->productInterface=$productInterface;
         $this->deliveryInterface=$deliveryInterface;
         $this->orderDetailInterface=$orderDetailInterface;
     }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('cart.cart');
    }

    public function checkout(){
      return view('cart.checkout');
    }

    public function saveorder(Request $request)
    {
      try {
        DB::beginTransaction();
        $delivery['customer_name'] = $request->name;
        $order['customer_id'] = Auth::id();
        $delivery['address'] = $request->address;
        $delivery['phone'] = $request->phone;
        $order['bank_type'] = $request->bank;
        $order['bank_account'] = $request->bank_account;
        $order['total_amount'] = $request->total;
        $order['order_date'] = Carbon::now();
        $orderDetails = $request->cart;

        $result = $this->orderInterface->store($order);
        $delivery['order_id'] = $result;
        $this->deliveryInterface->store($delivery);
        // dd($orderDetails);
        // $temp;
        foreach ($orderDetails as $orderDetail) {
           $temp['quantity'] = $orderDetail['Qty'];
           $temp['price'] = $orderDetail['price'];
           $temp['amount'] = $orderDetail['Qty']* $orderDetail['price'];
           $temp['product_id'] = $orderDetail['id'];
           $temp['order_id'] = $result;
           $test = $this->orderDetailInterface->store($temp);
           $this->productInterface->substractQty($orderDetail['id'], $orderDetail['Qty']);
           // dd($test, $temp);
           //update
        }
        DB::commit();
        return "success";
      } catch (\Exception $e) {
          DB::rollback();
      }

    }

    public function thanks()
    {
      return view('cart.thanks');
    }
}
