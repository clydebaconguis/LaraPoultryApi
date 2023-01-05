<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Stock;
use App\Models\Pricing;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCategoryResource;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCategory::all();
    }

    public function windex()
    {
        return view('content.products', [
            'products' => ProductCategory::get();
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['purpose'] == "add") {
            $isTaken = ProductCategory::where('name', $request->name)->first();
            if (!$isTaken) {
                $products = $request->validate([
                    'name' => 'required|string',
                    'image' => 'image|mimes:jpg,jpeg,png',
                    'stock' => 'required',
                    'status' => 'required',
                ]);
                if ($request->hasFile('image')) {
                    $filename = Str::random(10);
                    $request->file('image')->storeAs('', $filename, 'google');
                    $path = Storage::disk('google')->getMetadata($filename);
                    $products['image'] = '';
                    $products['image'] = $path['path'];
                    $id = ProductCategory::create($products)->id;
                    $json_params = json_decode($request['prices'], true);
                    $price = array();
                    foreach ($json_params as $item) {
                        $price = array();
                        $price = [
                            'product_category_id' => $id,
                            'type' => $item['type'],
                            'unit' => $item['unit'],
                            'value' => $item['value'],
                        ];
                        Pricing::create($price);
                    }
                }
            }
        } else {

            $formfields = $request->validate([
                'name' => 'required|string',
                'image' => 'image|mimes:jpg,jpeg,png',
                'stock' => 'required',
                'status' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $filename = Str::random(10);
                $request->file('image')->storeAs('', $filename, 'google');
                $path = Storage::disk('google')->getMetadata($filename);
                $formfields['image'] = '';
                $formfields['image'] = $path['path'];
            }

            $json_params = json_decode($request['prices'], true);
            $price = array();
            foreach ($json_params as $item) {
                $price = array();
                $price = [
                    'product_category_id' => $request['id'],
                    'type' => $item['type'],
                    'unit' => $item['unit'],
                    'value' => $item['value'],
                ];
                if ($item['id'] != 0) {
                    Pricing::where('id', $item['id'])->update($price);
                } else {
                    Pricing::create($price);
                }
            }

            return ProductCategory::where('id', $request['id'])->update($formfields);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return $productCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $formfields = $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png',
            'stock' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $filename = Str::random(10);
            $request->file('image')->storeAs('', $filename, 'google');
            $path = Storage::disk('google')->getMetadata($filename);
            $formfields['image'] = '';
            $formfields['image'] = $path['path'];
        }

        $json_params = json_decode($request['prices'], true);
        $price = array();
        foreach ($json_params as $item) {
            $price = array();
            $price = [
                'product_category_id' => $productCategory['id'],
                'type' => $item['type'],
                'unit' => $item['unit'],
                'value' => $item['value'],
            ];
            if ($item['id'] != 0) {
                Pricing::where('id', $item['id'])->update($price);
            } else {
                Pricing::create($price);
            }
        }

        return $productCategory->update($formfields);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $path = $productCategory['image'];
        $productCategory->delete();
        $isExist = Storage::disk('google')->getMetadata($path);
        if ($isExist) {
            Storage::disk('google')->delete($path);
            return response(['message' => 'Success!']);
        }
        return 'File does not exists';
    }
}
