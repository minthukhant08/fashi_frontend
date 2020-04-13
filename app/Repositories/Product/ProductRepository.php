<?php

namespace App\Repositories\Product;

use App\Product;
use App\Repositories\Product\ProductRepositoryInterface as ProductInterface;

class ProductRepository implements ProductInterface
{
  public $product;

  public function __construct(Product $product)
  {
     $this->product = $product;
  }

  public function getAll(){
     // dd($this->product::with(['brand', 'category', 'promotion'])->whereNull('deleted_at')->orderBy('created_at','desc')->get());
    return $this->product::with(['brand', 'category', 'promotion'])->whereNull('deleted_at')->orderBy('created_at','desc')->paginate(9);
  }

  public function search($categories, $brands, $types, $keyword ){
     // dd($this->product::with(['brand', 'category', 'promotion'])->whereNull('deleted_at')->orderBy('created_at','desc')->get());
    return $this->product::with(['brand', 'category', 'type', 'promotion'])
                          ->whereHas('brand', function ($query) use($brands){
                              if (count($brands)>0) {
                                $query->whereIn('id',$brands);
                              }
                          })
                          ->whereHas('category', function ($query) use($categories){
                              if (count($categories)>0) {
                                $query->whereIn('id',$categories);
                              }
                          })
                          ->whereHas('type', function ($query) use($types){
                              if (count($types)>0) {
                                $query->whereIn('id',$types);
                              }
                          })
                          ->where([
                            ['name', 'like', '%'.$keyword.'%'],
                            ['promotion_id', '=', null]
                          ])
                          ->whereNull('deleted_at')->orderBy('created_at','desc')->paginate(9);
  }

  public function searchPromo($categories, $brands, $types, $keyword ){
     // dd($this->product::with(['brand', 'category', 'promotion'])->whereNull('deleted_at')->orderBy('created_at','desc')->get());
    return $this->product::with(['brand', 'category', 'type', 'promotion'])
                          ->whereHas('brand', function ($query) use($brands){
                              if (count($brands)>0) {
                                $query->whereIn('id',$brands);
                              }
                          })
                          ->whereHas('category', function ($query) use($categories){
                              if (count($categories)>0) {
                                $query->whereIn('id',$categories);
                              }
                          })
                          ->whereHas('type', function ($query) use($types){
                              if (count($types)>0) {
                                $query->whereIn('id',$types);
                              }
                          })
                          ->where([
                            ['name', 'like', '%'.$keyword.'%'],
                            ['promotion_id', '!=', null]
                          ])
                          ->whereNull('deleted_at')->orderBy('created_at','desc')->paginate(9);
  }


  public function find($id)
  {
    return $this->product::where('id', '=', $id)->first();
  }

  public function substractQty($id, $qty)
  {
    $temp = $this->product::find($id);
    $temp->quantity = $temp->quantity - $qty;
    if ($temp->save()) {
      return $temp->id;
    }

  }
  public function destroy($id)
  {
    return $this->product::find($id)->delete();
  }

  public function total()
  {
    return $this->product::count();
  }

  public function store($data){
      $this->product->fill($data);
      if ($this->product->save()) {
        return $this->product->id;
      }
  }

  public function delete($id)
  {
    $this->product = $this->product->find($id);
    $this->product->softdelete();
  }

  public function update($request, $id)
  {
    $this->product = $this->product->find($id);
    $this->product->fill($request);
    if ($this->product->save()) {
        return true;
    }
  }
}
