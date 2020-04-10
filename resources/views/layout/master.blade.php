<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
      <meta name="description" content="Fashi Template">
      <meta name="keywords" content="Fashi, unica, creative, html">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Fashi | Template</title>
      <!-- Google Font -->
      <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

      <!-- Css Styles -->
      <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/themify-icons.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/elegant-icons.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/owl.carousel.min.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/nice-select.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/jquery-ui.min.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/slicknav.min.css')}}" type="text/css">
      <link rel="stylesheet" href="{{url('css/style.css')}}" type="text/css">
      <style>
        .dropbtn {
          background-color: white;
          font-size: 16px;
          border: none;
          cursor: pointer;
        }

        .dropdown {
          position: relative;
          display: inline-block;
        }

        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }

        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
        }

        .dropdown-content a:hover {background-color: #f1f1f1}

        .dropdown:hover .dropdown-content {
          display: block;
        }

</style>
  </head>
  <body>
    @include('layout.header')

    @yield('content')

    @include('layout.footer')
  </body>
  <script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{url('js/bootstrap.min.js')}}"></script>
  <script src="{{url('js/jquery-ui.min.js')}}"></script>
  <script src="{{url('js/jquery.countdown.min.js')}}"></script>
  <script src="{{url('js/jquery.nice-select.min.js')}}"></script>
  <script src="{{url('js/jquery.zoom.min.js')}}"></script>
  <script src="{{url('js/jquery.dd.min.js')}}"></script>
  <script src="{{url('js/jquery.slicknav.js')}}"></script>
  <script src="{{url('js/owl.carousel.min.js')}}"></script>
  <script src="{{url('js/main.js')}}"></script>
  <script type="text/javascript">
    var cart = [];
    var keywords="";
    var categories=[];
    var brands=[];
    var types=[];
    var host_url = "http://localhost:8000";
  </script>
  <script type="text/javascript">


  $(function () {
            if (localStorage.cart)
            {
                cart = JSON.parse(localStorage.getItem('cart'));
                draw_cart();
            }
            if (localStorage.keyword)
            {
                keyword = JSON.parse(localStorage.getItem('keyword'));
            }
            if (localStorage.categories)
            {
                categories = JSON.parse(localStorage.getItem('categories'));
            }
            if (localStorage.brands)
            {
                brands = JSON.parse(localStorage.getItem('brands'));
            }
            if (localStorage.types)
            {
                types = JSON.parse(localStorage.getItem('types'));
            }

        });

  function thousandseparator(value){
    return value.toLocaleString()
  }

  function clearCart(){
    localStorage.setItem('cart', []);
  }

  function clearFilter(){
    localStorage.setItem('cart', []);
    localStorage.setItem('keyword', '');
    localStorage.setItem('categories', []);
    localStorage.setItem('brands', []);
    localStorage.setItem('types', []);
    window.location.reload(true);
  }

  function changeCategories(event, val) {
    if (categories==null) {
      categories=[];
    }
    var index = categories.indexOf(val);
    if (event.target.checked) {
      if (index < 0) categories.push(val);
    }else{
      if (index !== -1) categories.splice(index, 1);
    }
    saveCategories();
    console.log(categories);
  }

  function changeBrands(event, val) {
    if (brands==null) {
      brands=[];
    }
    var index = brands.indexOf(val);
    if (event.target.checked) {
      if (index < 0) brands.push(val);
    }else{
      if (index !== -1) brands.splice(index, 1);
    }

    saveBrands();
    console.log(brands);
  }

  function changeTypes(event, val) {
    if (types==null) {
      types=[];
    }
    var index = types.indexOf(val);
    if (event.target.checked) {
      if (index < 0) types.push(val);
    }else{
      if (index !== -1) types.splice(index, 1);
    }

    saveTypes();
    console.log(types);
  }

  function addToCart(para) {
    para.Qty = 1;
      // update qty if product is already present
      for (var i in cart) {
          if(cart[i].id == para.id)
          {
              cart[i].Qty += 1;
              // showCart();
              saveCart();
              return;
          }
      }
      // create JavaScript Object
      // var item = { Product: name,  Price: price, Qty: qty };
      cart.push(para);
      saveCart();
      // showCart();
  }

  function saveCart() {
      localStorage.setItem('cart', JSON.stringify(cart));
      draw_cart();
  }

  function saveCategories() {
      localStorage.setItem('categories', JSON.stringify(categories));
  }

  function saveBrands() {
      localStorage.setItem('brands', JSON.stringify(brands));
  }

  function saveTypes() {
      localStorage.setItem('types', JSON.stringify(types));
  }

  function deleteItem(index){
      cart.splice(index,1);
      saveCart();
  }

  function draw_cart(){
    $('#cart').text(cart.length);
    $("#cartBody").empty();
    $("#carttotal").empty();
    $("#cartbutton").empty();
    var total = 0;
    for (var i in cart) {
        var item = cart[i];
        total +=cart[i].Qty * cart[i].price;
        var row = "<tr><td class='si-pic' style='width:100px;height:100px;'><img  src='"+host_url+cart[i].image+"'></td><td class='si-text'><div class='product-selected'><p>" + cart[i].Qty + " x " + thousandseparator(cart[i].price) +" MMK</p><h6>"+ cart[i].name +"</h6></div></td><td class='si-close'><i class='ti-close' onClick='deleteItem("+ i +")'></i></td></tr>";
        $("#cartBody").append(row);
    }

    $("#carttotalsummary").text(thousandseparator(total) + " MMK");

    if (total==0) {
      $('#cartbutton').append("<h4>No Item to preview</h4>")
    }else{
      $("#carttotal").append("<span>total:</span> <h5>"+ thousandseparator(total) +" MMK</h5>");

      $('#cartbutton').append("<a href='/cart' class='primary-btn view-card'>VIEW CART</a><a href='/checkout' class='primary-btn checkout-btn'>CHECK OUT</a>")
    }
  }
 function removespace(val) {
   return val.replace(/ /g,"")
 }
  </script>
  @yield('script')
</html>
