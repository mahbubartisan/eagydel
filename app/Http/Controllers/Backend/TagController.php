<?php

namespace App\Http\Controllers\Backend;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function ShowTag(){

        $data['tags'] = Tag::with('types')->get()->groupBy('type_id');

        return view('admin.tag.show', $data);
    }

    public function CreateTag(){

        $data['types'] = Type::all();

        return view('admin.tag.create', $data);
    }

    public function StoreTag(Request $request){

       foreach ($request->tag_eng as $key => $value) {
        
            $tags = [

                'tag_eng' => $request->tag_eng[$key],
                'tag_hindi' => $request->tag_hindi[$key],
                'type_id' => $request->type_id,
                'created_at' => now()
            ];

            Tag::insert($tags);

       }

       return redirect()->route('show.tag');
    }

    public function EditTag($key){

        $data['tags'] = Tag::with('types')->where('type_id', $key)->get();

        return view('admin.tag.edit', $data);

    }

    public function UpdateTag(Request $request, $id){

        $type = Type::find($id);

        $type->update([
            'type_eng' => $request->type_eng,
            'type_hindi' => $request->type_hindi,
            'updated_at' => now()
        ]);


        $type->tags()->delete();


        foreach ($request->tag_eng as $key => $value) {
            
            $data[] = [

                'tag_eng' => $request->tag_eng[$key],
                'tag_hindi' => $request->tag_hindi[$key],
                'type_id' => $id,
                'updated_at' => now()

            ];

        }

        // dd($data);

        $type->tags()->insert($data);

        return redirect()->route('show.tag'); 


    }

    public function DeleteTag($id){

        Tag::where('type_id', $id)->delete();

        return back();
    }
}
