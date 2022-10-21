<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $productRepository ;
    public function __construct()
    {
     // $this->middleware('auth:api');
      $this->productRepository = resolve('App\Repositories\ProductRepository');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $product = $this->productRepository->getAll();
      return response()->json(['products'=>$product],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['description'] = $request->description;
        $product = $this->productRepository->store($validatedData);
        $data = array(
            'success'=>true,
            'message' => 'The product stored successfully'
        );
        return response()->json($data,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $this->productRepository->update($validatedData,$id);
        $data = array(
            'success'=>true,
            'message' => 'The product updated successfully'
        );
        return response()->json($data,200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productRepository->delete($id);
        $data = [
            'status'=>200,
            'message'=>'The product deleted successfully'
        ];
        return response()->json($data);

    }
}
