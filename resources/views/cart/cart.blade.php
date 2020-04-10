@extends('layout.master')
@section('content')
  <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th class="p-name">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th><i class="ti-close"></i></th>
                                </tr>
                            </thead>
                            <tbody id="maincart">

                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    {{-- <li class="subtotal" >Subtotal <span id="maincartsubtotal"></span></li> --}}
                                    <li class="cart-total">Total <span id="maincarttotal"></span></li>
                                </ul>
                                <a href="/checkout" class="proceed-btn">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
  <script type="text/javascript">
  $(function () {
    draw_main_cart()
  });

  function draw_main_cart(){
      var total = 0;
      $("#maincart").empty();
      for (var i in cart) {
          var item = cart[i];
          total +=cart[i].Qty * cart[i].price;
          var row = "<tr><td class='cart-pic'><img src='"+host_url+cart[i].image+"' ></td><td class='cart-title'><h5>&nbsp;&nbsp;"+ cart[i].name +"</h5></td><td class='p-price'>"+ thousandseparator(cart[i].price) +" MMK</td><td class='qua-col'><div class='quantity'><div style='border:2px solid #ebebeb;'></span><input onChange='changeQty(event, "+i+");' type='number' value='"+ cart[i].Qty+"'></div></div></td><td class='total-price'>"+ thousandseparator(cart[i].Qty * cart[i].price) +" MMK</td><td class='close-td'><i class='ti-close' onClick='deleteItem("+ i +");draw_main_cart();'></i></td></tr>";
          $("#maincart").append(row);
      }
      // $("#deliveryfee").text("5,000 MMK");
      // $("#maincartsubtotal").text(total + " MMK");
      $("#maincarttotal").text(thousandseparator(total + 5000) +  " MMK");
  }


  function changeQty(event, i){
      if (event.target.value <=0) {
        deleteItem(i);

      }else{
        cart[i].Qty=event.target.value;
        console.log(cart[i].Qty);
        saveCart();
      }
      draw_main_cart();

  }

  </script>
@endsection
