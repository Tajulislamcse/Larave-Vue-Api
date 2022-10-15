<?php
namespace App\Repositories;
Class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        $productModel = resolve('App\Models\Product');
        parent::setModel($productModel);
    }
    public function store($validatedData)
    {
        parent::store($validatedData);
    }
    public function getAll()
    {
        return parent::getAll();
    }
    public function delete($id)
    {
        parent::delete($id);
    }
    public function update($validatedData,$id)
    {
        parent::update($validatedData,$id);
    }

}
