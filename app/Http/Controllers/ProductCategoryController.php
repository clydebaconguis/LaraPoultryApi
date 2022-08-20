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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png',
        ]);

        // $filename = Str::random(10);
        // $fileMetadata = new \Google_Service_Drive_DriveFile(array(
        //     'name' => $filename,
        //     'parents' => array(env('GOOGLE_DRIVE_FOLDER_ID')),

        // ));
        // $fileId = $service->files->create($fileMetadata, array(
        //     'data' => $products['image'],
        //     'mimeType' => 'image/jpeg',
        //     'uploadType' => 'multipart',
        //     'fields' => 'id',
        // ));

        if ($request->hasFile('image')) {
            $fileId = "";
            $filename = Str::random(10);
            $path = [];
            $path['name'] = $request->file('image')->storeAs('', $filename, 'google');
            if ($path) {
                $files = Storage::disk('google')->allFiles();
                $data = array();
                foreach ($files as $file) {
                    $data = Storage::disk('google')->getMetadata($file);
                }
                if (count($data) > 0) {
                    foreach ($data as $item) {
                        if ($item['filename'] == $path['name']) {
                            $fileId = $item['path'];
                        }
                    }
                }
            }
            if ($fileId) {
                $products['image'] = "https://drive.google.com/uc?export=view&id=" . $fileId;
                $url = ProductCategory::create($products)->image;
            }
            return response(['url' => $url]);
        }

        // $json_params = json_decode($request['prices'], true);
        // $price = array();
        // foreach ($json_params as $item) {
        //     $price = array();
        //     $price = [
        //         'product_category_id' => $id,
        //         'type' => $item['type'],
        //         'unit' => $item['unit'],
        //         'value' => $item['value'],
        //     ];

        //     Pricing::create($price);
        // }
        // if ($price) {
        //     return response(['message' => 'Success!'], 201);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $data = [
        //     'stocks' =>  Stock::where('product_category_id', $id)->get(),
        // ];

        // return response($data, 201);
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
        //
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
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response(['message' => 'Success!']);
        }
        return 'File does not exists';
    }
}
