<?php

namespace App\Http\Controllers\Backend;

use App\Models\Type;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function ShowBrand(){

        $data['brands'] = Brand::withCount('product')->get();

        return view('admin.brand.show', $data);
    }

    public function CreateBrand(){

        $data['types'] = Type::latest()->get();

        return view('admin.brand.create', $data);
    }

    public function StoreBrand(Request $request){

        $brand_image = $request->file('brand_image');

        $brand_image_name = hexdec(uniqid()). '.'. $brand_image->getClientOriginalExtension();

        Image::make($brand_image)->resize(300,300)->save('upload/brands/'. $brand_image_name);

        $image_save = 'upload/brands/'. $brand_image_name;

        Brand::create([

            'brand_name_eng' => $request->brand_name_eng,
            'brand_name_hindi' => $request->brand_name_hindi,
            'type_id' => $request->type_id,
            'brand_image' => $image_save,
            'brand_slug_eng' => strtolower(str_replace(' ', '-', $request->brand_name_eng)),
            'brand_slug_hindi' => strtolower(str_replace(' ', '-', $request->brand_name_hindi)),
            'created_at' => now()


        ]);

        return redirect()->route('show.brand');
    }

    public function EditBrand($id){

        $data['brands'] = Brand::find($id);
        $data['types']  = Type::all();

        return view('admin.brand.edit', $data);
    }

    public function UpdateBrand(Request $request, $id){

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        if($brand_image){

            $brand_image_name = hexdec(uniqid()). '.' . $brand_image->getClientOriginalExtension();

            Image::make($brand_image)->resize(300,300)->save('upload/brands/' .$brand_image_name);
            
            $image_save = 'upload/brands/'. $brand_image_name;
    
            unlink($old_image);

            Brand::find($id)->update([
                'brand_name_eng' => $request->brand_name_eng,
                'brand_name_hindi' => $request->brand_name_hindi,
                'brand_image' => $image_save,
                'brand_slug_eng' => strtolower(str_replace(' ', '-', $request->brand_name_eng)),
                'brand_slug_hindi' => strtolower(str_replace(' ', '-', $request->brand_name_hindi)),
                'updated_at' => now()
            ]);
        }

        
        Brand::find($id)->update([
            'brand_name_eng' => $request->brand_name_eng,
            'brand_name_hindi' => $request->brand_name_hindi,
            'brand_slug_eng' => strtolower(str_replace(' ', '-', $request->brand_name_eng)),
            'brand_slug_hindi' => strtolower(str_replace(' ', '-', $request->brand_name_hindi)),
            'updated_at' => now()
        ]);

        return redirect()->route('show.brand');

    }

    public function DeleteBrand($id){

        Brand::find($id)->delete();

        return redirect()->route('show.brand');
    }
}
