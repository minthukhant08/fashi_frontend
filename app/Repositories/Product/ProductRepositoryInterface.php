<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface{
  public function getAll();
  public function find($id);
  public function store($data);
  public function update($request, $id);
  public function delete($id);
  public function substractQty($id, $qty);
  public function search($categories, $brands, $types, $keyword );
  public function searchPromo($categories, $brands, $types, $keyword );
}
