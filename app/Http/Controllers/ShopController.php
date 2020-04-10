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
    public function index()
    {
        $categories = $this->categoryInterface->getAll();
        $products = $this->productInterface->getAll();
        $brands = $this->brandInterface->getAll();
        $types = $this->typeInterface->getAll();
        return view('shop.shop')->with('categories', $categories)
                                ->with('products', $products)
                                ->with('brands', $brands)
                                ->with('types', $types);
    }
}
