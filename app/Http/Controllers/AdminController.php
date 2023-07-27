<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createtag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        $tag = Tag::create(['tagName' => $request->tagName]);
        return response()->json(['status' => 200, 'tag' => $tag]);
    }

    public function gettags()
    {

        return Tag::orderBy('id', 'desc')->get();
    }
    public function editetag(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required',
        ]);
        return   Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
    }

    public function deletetag(Request $request)
    {
        $tag =   Tag::where('id', $request->id)->first();
        $tag->delete();
    }
    public function getcategories()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function uploadimage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }
    public function addcategory(Request $request){
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        $categroy = Category::create($request->all());
        return response()->json(['status' => 200, 'categroy' => $categroy]);
    }
    public function deleteFileFromServer($fileName)
    {

        if (file_exists(public_path(request()->isAdd ? 'uploads/' . $fileName:$fileName))) {
            unlink(public_path(request()->isAdd ? 'uploads/' . $fileName :$fileName));
        }
        return ;
    }

    public function editcategory(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'categoryName' => 'required',
        ]);
        return   Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    public function deletecategory(Request $request){

        $category =   Category::where('id', $request->id)->first();
        $fileName = $category->iconImage;
        if($category){
            if (file_exists(public_path( $fileName))) {
                unlink(public_path($fileName));
                $category->delete();
            }
        }
    }


    public function getusers(){
       return  User::orderBy('id', 'desc')->get();
    }
    public function createuser(Request $request){
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'userType' => 'required',
        ]);

        $password = bcrypt($request->password);
        $user =  User::create([
            'fullName'=>$request->fullName,
            'email'=>$request->email,
            'password'=>$password,
            'userType'=>$request->userType,
        ]);

        return $user;

    }

    public function edituser(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'fullName' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'userType' => 'required',
        ]);
        $password = bcrypt($request->password);
        return   User::where('id', $request->id)->update([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password'=>$password,
            'userType'=>$request->userType,
        ]);
    }

    public function deleteuser(Request $request){
        $user =   User::where('id', $request->id)->first();
        $user->delete();
    }

}
