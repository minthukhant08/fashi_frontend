@extends('layout.master')
@section('content')
  <!-- Breadcrumb Section Begin -->
  <div class="breacrumb-section">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="breadcrumb-text">
                      <a href="#"><i class="fa fa-home"></i> Home</a>
                      <span>Shop</span>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Breadcrumb Section Begin -->

  <!-- Product Shop Section Begin -->
  <section class="product-shop spad">
      <div class="container">
          <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                  <div class="filter-widget">
                      <h4 class="fw-title">Keyword</h4>
                      <div class="blog-sidebar">
                        <div class="search-form">
                              <form >
                                  <input type="text" id="keyword" placeholder="Enter keyword . . .  ">
                              </form>
                          </div>
                      </div>

                  </div>

                  <div class="filter-widget">
                      <h4 class="fw-title">Categories</h4>
                      <ul class="fw-brand-check">
                          @foreach ($categories as $category)
                            <div class="bc-item">
                                <label for="{{str_replace(' ', '', $category->name)}}">
                                    {{$category->name}}
                                    <input type="checkbox" id="{{str_replace(' ', '', $category->name)}}" value="{{$category->id}}" onChange="changeCategories(event, '{{$category}}');">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                          @endforeach
                      </ul>
                  </div>
                  <div class="filter-widget">
                      <h4 class="fw-title">Brand</h4>
                      <div class="fw-brand-check">
                          @foreach ($brands as $brand)
                            <div class="bc-item">
                                <label for="{{str_replace(' ', '', $brand->name)}}">
                                    {{$brand->name}}
                                    <input type="checkbox" id="{{str_replace(' ', '', $brand->name)}}" value="{{$brand->id}}" onChange="changeBrands(event, '{{$brand}}');">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                          @endforeach
                      </div>
                  </div>
                  <div class="filter-widget">
                      <h4 class="fw-title">Type</h4>
                      <div class="fw-brand-check">
                          @foreach ($types as $type)
                            <div class="bc-item">
                                <label for="{{str_replace(' ', '', $type->name)}}">
                                    {{$type->name}}
                                    <input type="checkbox" id="{{str_replace(' ', '', $type->name)}}" value="{{$type->id}}" onChange="changeTypes(event, '{{$type}}');">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                          @endforeach
                      </div>
                  </div>
                  <div >
                    <input onclick="clearFilter();" type="button" name="" value="Clear" class="btn btn-light">&nbsp;&nbsp;
                    <input onclick="search('promotion');" type="submit" id="apply" name="" value="Apply" class="btn btn-primary">
                  </div>

              </div>
              <div class="col-lg-9 order-1 order-lg-2">
                  {{ $products->links() }}
                  <br>
                  <div class="product-list">
                      <div class="row">
                          @foreach ($products as $product)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic" style="height:200px;">
                                        <img src="http://localhost:9000{{$product->image}}" alt="" style="height:100%;">
                                        {{-- <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div> --}}
                                        <ul>
                                            <li class="w-icon active" onClick="addToCart({{$product}});"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                            <li class="quick-view"><a href="javascript:;" data-toggle="modal" data-target="#modal-add" onclick="getData('{{$product}}');">+ Quick View</a></li>
                                            {{-- <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li> --}}
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <a href="#">
                                            <h5>{{$product->name}}</h5>
                                        </a>
                                        <div class="catagory-name">{{$product->category->name}}</div>
                                        <div class="product-price">
                                            {{$product->price - $product->promotion->amount}} MMK
                                        </div>

                                    </div>
                                </div>
                            </div>
                          @endforeach
                      </div>
                  </div>
                  <br>
                  {{ $products->links() }}
              </div>
          </div>
      </div>
  </section>
  <!-- Product Shop Section End -->

  <!-- Partner Logo Section Begin -->
  <div class="partner-logo">
      <div class="container">
          <div class="logo-carousel owl-carousel">
              <div class="logo-item">
                  <div class="tablecell-inner">
                      <img src="img/logo-carousel/logo-1.png" alt="">
                  </div>
              </div>
              <div class="logo-item">
                  <div class="tablecell-inner">
                      <img src="img/logo-carousel/logo-2.png" alt="">
                  </div>
              </div>
              <div class="logo-item">
                  <div class="tablecell-inner">
                      <img src="img/logo-carousel/logo-3.png" alt="">
                  </div>
              </div>
              <div class="logo-item">
                  <div class="tablecell-inner">
                      <img src="img/logo-carousel/logo-4.png" alt="">
                  </div>
              </div>
              <div class="logo-item">
                  <div class="tablecell-inner">
                      <img src="img/logo-carousel/logo-5.png" alt="">
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Partner Logo Section End -->

  <div class="modal fade" id="modal-add" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Product Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form role="form" id="add_form" nctype="multipart/form-data">
           <div class="card-body">
             <div class="form-group">
               <div class="row">
                 <div class="col-sm-6" style="position:relative;">
                   <input style="display:none;" type="file" name="add_img" id="add_img" />
                   <img id = "image_add_preview" src="" alt="" style="width:100%; height:310px;">
                 </div>
                 <div class="col-sm-6">
                   <div class="form-group">
                     Name : <label id="name" name ="name" ></label>
                   </div>
                   <div class="form-group">
                      Size : <label id="size" name ="size"  ></label>
                   </div>
                   <div class="form-group">
                     Brand : <label id="brand" name ="brand" ></label>
                   </div>
                   <div class="form-group">
                     Category : <label id="category" name ="category" class="form-category" ></label>
                   </div>
                   <div class="form-group">
                     Promotion : <label id="promotion" name ="promotion" class="form-category"></label>
                   </div>
                   <div class="form-group">
                     Price : <label id="price" name ="price"></label>
                   </div>
                 </div>
               </div>
             </div>
             Description
             <div class="form-group">
               <label class="form-control" id="description"></label>
             </div>
           </div>
           <!-- /.card-body -->
           <div class="modal-footer">
             <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
           </div>
         </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <script type="text/javascript">

      function getData(para) {
        var obj = JSON.parse(para);
        // console.log(obj);
        $('#image_add_preview').attr('src', host_url + obj.image);
        $('#name').text(obj.name);
        $('#size').text(obj.size);
        $('#quantity').text(obj.quantity);
        $('#category').text(obj.category.name);
        $('#brand').text(obj.brand.name);
        $('#price').text(thousandseparator(obj.price) + " MMK");
        console.log(obj.promotion);
        if (obj.promotion==null) {
          $('#promotion').text('None');
        }else{
          $('#promotion').text(obj.promotion);
        }
        $('#description').text(obj.description);
      }
      </script>
@endsection
@section('script')
  <script type="text/javascript">
  $(document).ready(function(){
    console.log(categories);
    for (var i = 0; i < categories.length; i++) {
      $("#"+removespace(JSON.parse(categories[i]).name)).prop("checked", true);
    }
    for (var i = 0; i < brands.length; i++) {
      $("#"+removespace(JSON.parse(brands[i]).name)).prop("checked", true);
      console.log(removespace("#"+JSON.parse(brands[i]).name));
    }
    for (var i = 0; i < types.length; i++) {
      $("#"+removespace(JSON.parse(types[i]).name)).prop("checked", true);
    }
  });


  </script>
@endsection

</section>
