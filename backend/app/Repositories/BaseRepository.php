<?php
namespace App\Repositories;
class BaseRepository
{
 public function setModel($model)
 {
    $this->model = $model;
 }
 public function store(array $data)
 {
    $this->model->create($data);
 }
 public function getAll()
 {
    return $this->model->all();
 }
 public function delete($id)
 {
    $this->model->destroy($id);
 }
 public function update(array $data,$id)
 {
    $this->model->findOrFail($id)->update($data);

 }
}

