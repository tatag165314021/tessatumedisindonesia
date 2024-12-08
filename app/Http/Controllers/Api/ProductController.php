<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller {

    public function index() {

        $produk = Product::latest()->paginate(5, ['*'], 'page', 2);

        if (!$produk) {
            return response()->json([
                'success' => false,
            ], 409);
        }

        return new ProductResource(true, 'List Data Product', $produk);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'product_name'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = Product::create([
            'product_name'     => $request->product_name,
            'created_at'   => Carbon::now('Asia/Jakarta')->format('d-m-Y H:i:s'),
            'updated_at' => Carbon::now('Asia/Jakarta')->format('d-m-Y H:i:s'),
        ]);

        if (!$produk) {
            return response()->json([
                'success' => false,
            ], 409);
        }

        return new ProductResource(true, 'Data Produk Berhasil Ditambahkan!', $produk);
    }

    public function update(Request $request, $id) {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'product_name'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $produk = Product::find($id);

        $produk->update([
            'product_name'     => $request->product_name,
            'updated_at' => Carbon::now('Asia/Jakarta')->format('d-m-Y H:i:s'),
        ]);

        if (!$produk) {
            return response()->json([
                'success' => false,
            ], 409);
        }

        //return response
        return new ProductResource(true, 'Data Produk Berhasil Diubah!', $produk);
    }

    public function pencarian(Request $request) {

        $keyword = $request->query('keyword');
        $produk = Product::where('product_name', 'LIKE', "%$keyword%")->get();

        if (!$produk) {
            return response()->json([
                'success' => false,
            ], 409);
        }

        return new ProductResource(true, 'Detail Data Produk!', $produk);
    }
}
