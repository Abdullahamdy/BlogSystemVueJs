<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Blogtag;
use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }

        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }

        return $this->checkPermission($user);
    }
    public function checkPermission($user)
    {
        $permissions = json_decode($user->role->permission);
        if (!$permissions) return view('welcome');
        $haspermission = false;
        foreach ($permissions as $per) {
            if ($per->name == request()->path()) {
                if ($per->read) {
                    $haspermission = true;
                }
            }
        }
        if ($haspermission) return view('welcome');
        return view('notfound');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
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
    public function addcategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        $categroy = Category::create($request->all());
        return response()->json(['status' => 200, 'categroy' => $categroy]);
    }
    public function deleteFileFromServer($fileName)
    {

        if (file_exists(public_path(request()->isAdd ? 'uploads/' . $fileName : $fileName))) {
            unlink(public_path(request()->isAdd ? 'uploads/' . $fileName : $fileName));
        }
        return;
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

    public function deletecategory(Request $request)
    {

        $category =   Category::where('id', $request->id)->first();
        $fileName = $category->iconImage;
        if ($category) {
            if (file_exists(public_path($fileName))) {
                unlink(public_path($fileName));
                $category->delete();
            }
        }
    }


    public function getusers()
    {
        return  User::orderBy('id', 'desc')->get();
    }
    public function createuser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ]);

        $password = bcrypt($request->password);
        $user =  User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);

        return $user;
    }

    public function edituser(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'fullName' => 'required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ]);
        // dd($request->id);
        $password = bcrypt($request->password);
        return   User::where('id', $request->id)->update([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);
    }

    public function deleteuser(Request $request)
    {
        $user =   User::where('id', $request->id)->first();
        $user->delete();
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json(['msg' => 'Incorrect Login Details']);
            }
            return response()->json(['msg' => 'You Are Login', 'user' => $user]);
        } else {
            return response()->json(['msg' => 'Invalid Credentials']);
        }
    }
    public function getroles()
    {
        return Role::orderBy('id', 'desc')->get();
    }

    public function addrole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required'
        ]);
        $role = Role::create(['roleName' => $request->roleName]);
        return response()->json(['status' => 200, 'role' => $role]);
    }


    public function editrole(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'roleName' => 'required',
        ]);
        return   Role::where('id', $request->id)->update([
            'roleName' => $request->roleName,
        ]);
    }

    public function deleterole(Request $request)
    {
        $role =   Role::where('id', $request->id)->first();
        $role->delete();
    }

    public function assignrole(Request $request)
    {
        return  Role::find($request->id)->update($request->except('id'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $picName);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://localhost:8000/uploads/$picName",
            ]
        ]);
        return $picName;
    }

    public function createBlog(Request $request)
    {
        DB::beginTransaction();
        try {
            $blog = Blog::create([
                'title' => $request->title,
                'post' => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'metaDescription' => $request->metaDescription,
                'user_id' => Auth::id(),
                'jsonData' => $request->jsonData,
                'slug' => $request->title,
            ]);
            $blogCategories = [];
            foreach ($request->category_id as $ca) {
                array_push($blogCategories, ['category_id' => $ca, 'blog_id' => $blog->id]);
            }
            Blogcategory::insert($blogCategories);
            $blogTags = [];
            foreach ($request->tag_id as $ta) {
                array_push($blogTags, ['tag_id' => $ta, 'blog_id' => $blog->id]);
            }
            Blogtag::insert($blogTags);
            DB::commit();
            return 'done';
        } catch (\Throwable $err) {
            DB::rollBack();
            return $err;
        }
    }

    public function blogdata(){
       return Blog::with(['cat','tag'])->get();

    }


    public function deleteBlog(Request $request){
        $blog =   Blog::where('id', $request->id)->first();
        $blog->delete();
    }
}
