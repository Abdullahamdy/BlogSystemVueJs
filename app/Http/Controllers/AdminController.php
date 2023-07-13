<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createtag(Request $request)
    {
        $this->validate($request,[
            'tagName'=>'required'
        ]);
       $tag = Tag::create(['tagName' => $request->tagName]);
        return response()->json(['status'=>200,'tag'=>$tag]);

    }

    public function gettags(){

        return Tag::orderBy('id','desc')->get();

    }
    public function editetag(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'tagName'=>'required',
        ]);
        return   Tag::where('id',$request->id)->update([
            'tagName'=>$request->tagName,
        ]);


    }

    public function deletetag(Request $request){
       $tag =   Tag::where('id',$request->id)->first();
       $tag->delete();


    }

}
