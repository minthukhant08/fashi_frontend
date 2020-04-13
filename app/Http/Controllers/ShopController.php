<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface as ProductInterface;
use App\Repositories\Category\CategoryRepositoryInterface as CategoryInterface;
use App\Repositories\Promotion\PromotionRepositoryInterface as PromotionInterface;
use App\Repositories\Brand\BrandRepositoryInterface as BrandInterface;
use App\Repositories\Type\TypeRepositoryInterface as TypeInterface;

class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public $productInterface;
     public $categoryInterface;
     public $brandInterface;

     public function __construct(
       Request $request,
       ProductInterface $productInterface,
       CategoryInterface $categoryInterface,
       BrandInterface $brandInterface,
       TypeInterface $typeInterface
       )
     {
         $this->middleware('auth');
         $this->productInterface = $productInterface;
         $this->categoryInterface = $categoryInterface;
         $this->brandInterface = $brandInterface;
         $this->typeInterface = $typeInterface;
     }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $para_categories = isset($request->categories)? $request->categories : [];
        $cat_arr = array();
        $brand_arr = array();
        $type_arr = array();
        foreach ($para_categories as $value) {
          try {
            $cat_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }
        $para_brands = isset($request->brands)? $request->brands : [];
        foreach ($para_brands as $value) {
          try {
            $brand_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }

        $para_types =  isset($request->types)? $request->types : [];
        foreach ($type_arr as $value) {
          try {
            $type_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }
        $para_keyword = isset($request->keyword)? $request->keyword : '%';
        $categories = $this->categoryInterface->getAll();
        $products = $this->productInterface->search($cat_arr,$brand_arr,$type_arr, $para_keyword  );
        $brands = $this->brandInterface->getAll();
        $types = $this->typeInterface->getAll();
        return view('shop.shop')->with('categories', $categories)
                                ->with('products', $products)
                                ->with('brands', $brands)
                                ->with('types', $types);
    }

    public function promotion(Request $request)
    {
        $para_categories = isset($request->categories)? $request->categories : [];
        $cat_arr = array();
        $brand_arr = array();
        $type_arr = array();
        foreach ($para_categories as $value) {
          try {
            $cat_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }
        $para_brands = isset($request->brands)? $request->brands : [];
        foreach ($para_brands as $value) {
          try {
            $brand_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }

        $para_types =  isset($request->types)? $request->types : [];
        foreach ($type_arr as $value) {
          try {
            $type_arr[] = json_decode($value)->id;
          } catch (\Exception $e) {

          }

        }
        $para_keyword = isset($request->keyword)? $request->keyword : '%';
        $categories = $this->categoryInterface->getAll();
        $products = $this->productInterface->searchPromo($cat_arr,$brand_arr,$type_arr, $para_keyword  );
        $brands = $this->brandInterface->getAll();
        $types = $this->typeInterface->getAll();
        return view('shop.promo')->with('categories', $categories)
                                ->with('products', $products)
                                ->with('brands', $brands)
                                ->with('types', $types);
    }
}
