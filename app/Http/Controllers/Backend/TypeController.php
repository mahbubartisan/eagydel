<?php

namespace App\Http\Controllers\Backend;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function ShowType(){

        $data['types'] = Type::all();

        return view('admin.type.show', $data);
    }

    public function CreateType(){

        return view('admin.type.create');
    }

    public function StoreType(Request $request){
        
        foreach ($request->type_eng as $key => $value) {
            
            $data = [

                'type_eng' => $request->type_eng[$key],
                'type_hindi' => $request->type_hindi[$key],
            ];
        }

        Type::create($data);

        return redirect()->route('show.type');
    }

    public function EditType($id){

        $data['types'] = Type::find($id);

        return view ('admin.type.edit', $data);
    }

    public function UpdateType(Request $request, $id){

        foreach ($request->type_eng as $key => $value) {
            
            $data = [

                'type_eng' => $request->type_eng[$key],
                'type_hindi' => $request->type_hindi[$key],
            ];
        }

        Type::find($id)->update($data);

        return redirect()->route('show.type');

    }

    public function DeleteType($id){

        Type::find($id)->delete();

        return back();
    }
}
