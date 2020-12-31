<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::inRandomOrder()->take(12)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo1' => 'image:jpeg,png,jpg,gif,svg|max:2048'
         ]);
         if ($validator->fails()) {
            return false;
         }

         if ($request->photo1) {
            $uploadFolder = 'products';
            $image = $request->file('photo1');
            $photo1_path = $image->store($uploadFolder, 'public');
        } else {
            $photo1_path = null;
        }
        
        $data = [
            'store' => $request->store,
            'name' => $request->name,
            'caption' => $request->caption,
            'brand' => $request->brand,
            'storage_initial' => $request->storage_initial,
            'available' => $request->available,
            'price' => $request->price,
            'photo1' => $photo1_path,
         ];

         return Product::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::where('store',$id)->orderByDesc('id')->get()->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
