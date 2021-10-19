<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if($id){
            $category = ProductCategory::find($id);
           if($category){
               return ResponseFormatter::success(
                   $category,
                   'Data Kategori berhasil diambil'
               );
           } 
           else{
               return ResponseFormatter::error(
                   $category,
                   'Data Kategori tidak ada',
                    404
                );
           } 
        }

        $category = ProductCategory::query();

        if($name){
            $category->where(
                'name', 'like' , '%' . $name . '%'
            );        
        }

        if($show_product){
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit), 'Data list Kategori Berhasil diambil'
        
        );

    }

    public function createdata(Request $request){
        $create = ProductCategory::create([
            'name' => $request->name
        ]);

        return ResponseFormatter::success(
            $create,
            'Data Kategori berhasil dibuat'
        );
    }
    public function updatedata(Request $request, $id){

        $update = ProductCategory::where('id',$id)->first();

        $update->update([
            'name' => $request->name
        ]);


        return ResponseFormatter::success(
            '',
            'Data Kategori berhasil diupdate'
        );
    }

    public function deletedata($id){

        $delete = ProductCategory::where('id',$id)->first();
        
        if(!$delete){
            return ResponseFormatter::error(
                '',
                'Data Kategori tidak ada',
                 401
             );
        }
        $delete->delete();

        return ResponseFormatter::success(
            '',
            'Data Kategori berhasil dihapus'
        );
    }
    
}
