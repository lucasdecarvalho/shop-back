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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo1' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            'photo2' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            'photo3' => 'image:jpeg,png,jpg,gif,svg|max:2048'
         ]);

        //  if ($validator->fails()) {
        //     return false;
        //  }

         if ($request->photo1) {
            $uploadFolder = 'products';
            $image = $request->file('photo1');
            $photo1_path = $image->store($uploadFolder, 'public');
        } else {
            $photo1_path = null;
        }

         if ($request->photo2) {
            $uploadFolder = 'products';
            $image = $request->file('photo2');
            $photo2_path = $image->store($uploadFolder, 'public');
        } else {
            $photo2_path = null;
        }

         if ($request->photo3) {
            $uploadFolder = 'products';
            $image = $request->file('photo3');
            $photo3_path = $image->store($uploadFolder, 'public');
        } else {
            $photo3_path = null;
        }
        
        $data = [
            'store' => $request->store,
            'brand' => $request->brand,
            
            'photo1' => $photo1_path,
            'photo2' => $photo2_path,
            'photo3' => $photo3_path,

            'name' => $request->name,
            'storage_initial' => $request->storage_initial,
            'caption' => $request->caption,
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'discount' => $request->discount,
            'video' => $request->video,
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
        // return Product::where('store',$store)->orderByDesc('id')->get()->all();
        return Product::findOrFail($id);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProd($store)
    {
        // return Product::findOrFail($id);
        return Product::where('store',$store)->orderByDesc('id')->get()->all();
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
        $validator = Validator::make($request->all(), [
            'photo1' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            'photo2' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            'photo3' => 'image:jpeg,png,jpg,gif,svg|max:2048'
         ]);

        //  if ($validator->fails()) {
        //     return false;
        //  }

        $data = [];

         if ($request->photo1) {
            $uploadFolder = 'products';
            $image = $request->file('photo1');
            $photo1_path = $image->store($uploadFolder, 'public');

            $data += [
                'photo1' => $photo1_path,
            ];
        }

         if ($request->photo2) {
            $uploadFolder = 'products';
            $image = $request->file('photo2');
            $photo2_path = $image->store($uploadFolder, 'public');

            $data += [
                'photo2' => $photo2_path,
            ];
        }

         if ($request->photo3) {
            $uploadFolder = 'products';
            $image = $request->file('photo3');
            $photo3_path = $image->store($uploadFolder, 'public');

            $data += [
                'photo3' => $photo3_path,
            ];
        }
        
            $data += [
                'store' => $request->store,
                'brand' => $request->brand,
                'name' => $request->name,
                'available' => $request->available,
                // 'storage_initial' => $request->storage_initial,
                'caption' => $request->caption,
                'description' => $request->description,
                'details' => $request->details,
                'price' => $request->price,
                // 'discount' => $request->discount,
                'video' => $request->video,
            ];

        $prod = Product::findOrFail($id);
        $prod->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = Product::find($id);
        
        $imgProd1 = $prod->photo1;
        $imgProd2 = $prod->photo2;
        $imgProd3 = $prod->photo3;

        Storage::delete($imgProd1, $imgProd2, $imgProd3);
        
        $prod->delete();
    }
}
