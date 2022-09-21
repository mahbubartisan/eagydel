<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function Homepage(){
// return
        // Product::with('tags')->get();
       
        $data['types'] = Type::latest()->get();
        $data['sliders'] = Slider::where('status', 1)->limit(3)->get();
        // return
        $data['products'] = Product::where('status', 1)->limit(6)->get();
        $data['featured_products'] = Product::where('featured', 1)->limit(6)->get();
        $data['hot_deal_products'] = Product::where('hot_deal', 1)->where('discount_price', '!=', NULL)
        ->limit(3)->get();
        $data['special_offer_products'] = Product::where('special_offer', 1)->limit(6)->get();
        $data['special_deal_products'] = Product::where('special_deal', 1)->limit(6)->get();
        $brand_products = Brand::skip(0)->first();
        $data['brand_wise_products'] = Product::where('brand_id', $brand_products->id)->limit(6)->get();

        $data['categories'] = Category::whereNotNull('parent_id')->get();

        return view('frontend.index', $data, compact('brand_products'));
    }

   public function ProductDetail($id){
    // // return
    // $data['attributes'] = Attribute::with('attributeValue')->get();
    // // return
    // $data['attr_values'] = AttributeValue::with('attributes')->get();
    // return
    $product = Product::with('multiImages','attributevalue')->findOrFail($id);
// return
    $data['product_attributes'] = $product->attributevalue()->get()->groupBy('attribute_id');
    $data ['related_products'] = Product::where('category_id', $product->category_id)
    ->where('id', '!=', $id)->get();
    $data['hot_deal_products'] = Product::where('hot_deal', 1)->where('discount_price', '!=', NULL)
    ->where('category_id', $product->category_id )->get();
    // $data['multi_images'] = MultiImage::where('product_id', $id)->get();
    $data['category'] = Category::where('id', $product->category_id )->get();
    return view('frontend.product.product_detail', $data, compact('product'));
   }

   public function TagWiseProduct($tag_id){

    // return
    $tag = Tag::where('id', $tag_id)->first();
   
    // dd(;
// return
    $data['products'] = Product::where('status', 1)->where('type_id', $tag->type_id)->get();
    
    // // $tags = DB::table('product_tag')->where('tag_id', $tag_id)->get();

    // dd($tags);

    // if(count($tags) == 0){

    //     // $data['products'] = null;
        
    // }else{

    //     // dd($tags );

    //     $tags = Tag::with('products')->where('id' , $tags)->get();

    //     // $data['products'] = DB::table('product_tag')->where('product_id', $product->id)->get();
    // }

    return view('frontend.product.tag_wise_product', $data);
   }

   public function CategoryWiseProduct($type_slug, $cat_slug){

        $category = Category::with('parents')->where('category_slug_eng', $cat_slug)->first();
        
        $data['cat_wise_products'] = Product::where('status', 1)->where('category_id', $category->id)->get();

    return view('frontend.product.category_wise_product', $data, compact('category'));

   }

   public function ChildCategoryWiseProduct($type_slug, $parent_slug, $child_slug, Request $request){
         
    if ($request->ajax()) {
        
        $data = $request->all();

        $url = $data['url'];
      
        // echo"<pre>"; print_r($data); die;

        $category = Category::where('category_slug_eng', $child_slug)->first();
        
        $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(20);

        if(isset($data['sort']) && !empty($data['sort'])) {

            if ($data['sort'] == 'newest') {
               $products = Product::where('status', 1)
                                    ->where('category_id', $category->id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            }elseif($data['sort'] == 'price_lowest'){
                        $products = Product::where('status', 1)
                                    ->where('category_id', $category->id)
                                    ->orderBy('discount_price', 'ASC')
                                    ->get();
            }elseif($data['sort'] == 'price_highest'){
                        $products = Product::where('status', 1)
                                    ->where('category_id', $category->id)
                                    ->orderBy('discount_price', 'DESC')
                                    ->get();
            }elseif($data['sort'] == 'a_to_z'){
                        $products = Product::where('status', 1)
                                    ->where('category_id', $category->id)
                                    ->orderBy('product_name_eng', 'ASC')
                                    ->get();
            }elseif($data['sort'] == 'z_to_a'){
                        $products = Product::where('status', 1)
                                    ->where('category_id', $category->id)
                                    ->orderBy('product_name_eng', 'DESC')
                                    ->get();
            }

        }

        if(isset($data['brand']) && !empty($data['brand'])) {


         $products = Product::where('category_id', $category->id)->whereIn('brand_id', $data['brand'])->get();
        
        //  echo"<pre>"; print_r($products); die;
        
        }
         
    return view('frontend.product.ajax_product_filter', compact('products','category', 'url'));

    }else
    
       $url = $child_slug;
    //   return 
        $category = Category::with('parents')->where('category_slug_eng', $child_slug)->first();
        
        $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(20);
// return
        $productID = Product::select('id')->where('category_id', $category->id)
        ->pluck('id')->toArray();

        $brandID = Product::select('brand_id')->whereIn('id', $productID)->get()->toArray();

        $brands = Brand::select('id', 'brand_name_eng')->whereIn('id', $brandID)->get()->toArray();

        // return
        // $attrID = Attribute::select('id')->get()->toArray();
        //  return
       $product_attributes = Product::with('attributevalue')->where('category_id', $category->id)->get();
         
    //    return
    //    $pro = $product_attributes->attributevalue;


// echo"<pre>"; print_r($brands); die;

    return view('frontend.product.child_category_wise_product', compact('products','category', 'url', 'brands', 'product_attributes'));

   }


   public function SearchProduct(Request $request)
   {

     $request->validate(['search' => 'required']);
     $SearchProduct = $request->search;
    
    $products = Product::where('product_name_eng', 'LIKE', "%$SearchProduct%")->get();

    return view('frontend.product.search', compact('products', 'SearchProduct'));

   }

   public function AjaxProductSearch(Request $request)
   {

   $request->validate(['search' => 'required']);
   $SearchProduct = $request->search;
   $products = Product::where('product_name_eng', 'LIKE', "%$SearchProduct%")
                        ->select('product_name_eng', 'thumb_image', 'selling_price', 'id')
                        ->limit(5)
                        ->get();
  
    return view('frontend.product.product_search', compact('products'));

   }

}
