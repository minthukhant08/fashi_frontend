@extends('layout.master')
@section('content')
  <section class="checkout-section spad">
        <div class="container">
            <form id="checkoutform" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Biiling Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="fir">First Name<span>*</span></label>
                                <input id="first_name" required  type="text">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name<span>*</span></label>
                                <input id="last_name" required type="text" >
                            </div>
                            <div class="col-lg-12">
                                <label for="cun">Country<span>*</span></label>
                                <input name="Country" required type="text" id="cun">
                            </div>
                            <div class="col-lg-12">
                                <label for="street">Street Address<span>*</span></label>
                                <input   required  type="text" id="address" class="street-first">
                            </div>
                            <div class="col-lg-12">
                                <label for="zip">Postcode / ZIP (optional)</label>
                                <input  type="text" id="zip">
                            </div>
                            <div class="col-lg-12">
                                <label for="town">Town / City<span>*</span></label>
                                <input  required type="text" id="town">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Address<span>*</span></label>
                                <input  required type="text" id="email">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input  id="phone" required type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table" >
                                    <li>Product <span>Total</span></li>
                                    <div id="checkout" style="padding-top:10px;">

                                    </div>
                                    {{-- <li class="fw-normal">Subtotal <span id="checkoutsubtotal"></span></li> --}}
                                    <li class="total-price">Total <span id="checkouttotal"></span></li>
                                </ul>
                                <div class="payment-check">
                                    <div class="col-lg-12" style="padding-bottom:20px;">
                                        <label for="town">Bank Account<span>*</span></label>
                                        <select class="custom-select mr-sm-2" id="bank" >
                                          <option value="AGD">AGD</option>
                                          <option value="KBZ">KBZ</option>
                                          <option value="AYA">AYA</option>
                                          <option value="CB">CB</option>
                                          <option value="YOMA">YOMA</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">

                                        <input type="text" id="bank_account" required  placeholder="Enter bank account number">
                                    </div>
                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-btn">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
  <script type="text/javascript">
  var total_amount_check=0;
  $(function () {
    draw_checkout();
    $('#checkoutform').submit(function(event){
      event.preventDefault();
      var name = $('#first_name').val() + " " + $('#last_name').val();
      var address = $('#address').val() + ", " + $('#town').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var bank  = $('#bank').val();
      var bank_account  = $('#bank_account').val();
      $.ajax({
        url : '/checkout',
        type: 'post',
        data : {
           name:name,
           address:address,
           email:email,
           phone:phone,
           bank:bank,
           total:total_amount_check,
           bank_account:bank_account,
           cart:cart
        },
        statusCode: {
           200: function (response) {
             clearCart();
             location.href="/thanks";
           }
        }
      }).done(function(response){ //
        clearCart();
        location.href="/thanks";
      });
    })
  });

  function draw_checkout(){
      var total = 0;
      $("#checkout").empty();
      for (var i in cart) {
          var item = cart[i];
          total +=cart[i].Qty * cart[i].price;
          var row = "<li class='fw-normal'>"+cart[i].name+ " x "+ cart[i].Qty +"<span>"+thousandseparator(cart[i].price* cart[i].Qty)+" MMK</span></li>";
          $("#checkout").append(row);
      }
      total_amount_check = total;
      // $("#deliveryfee").text("5,000 MMK");
      // $("#checkout").text(total + " MMK");
      $("#checkouttotal").text(thousandseparator(total + 5000) +  " MMK");
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
