<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs=Blog::orderBy('created_at','DESC');


        if(!empty($request->keyword))
        {
            $blogs=$blogs->where('title','like','%'.$request->keyword.'%');
        }

        $blogs=$blogs->get();


        return response()->json([
            'status'=>true,
            'data'=>$blogs
    ]);
    }
    public function show($id)
    {
        $blog=Blog::find($id);

        if($blog==null)
        {
            return response()->json([
                'status'=>false,
                'message'=>'Blog not found',
        ]);
        }

        $blog['date']=\Carbon\Carbon::parse($blog->created_at)->format('d M,Y');

        return response()->json([
            'status' =>true,
            'data'=>$blog,
    ]);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:4',
            'author' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'erroes' => $validator->errors(),
            ]);
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;
        $blog->save();

        $tempImage = TempImage::find($request->image_id);

        if ($tempImage != null) {
            $imageExtArray = explode('.', $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time() . '-' . $blog->id . '.' . $ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $destPath = public_path('uploads/temp/blogs/' . $imageName);

            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destPath);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Temporary image not found',
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog Added Successfully',
            'data' => $blog,
        ]);
    }
    public function update($id,Request $request)
    {
        $blog= Blog::find($id);

        if($blog==null)
        {
            return response()->json([
                'status'=>false,
                'message'=>'Blog not found',
        ]);
        }

        $validator=Validator::make($request->all(),[
            'title'=>'required|min:4',
            'author'=>'required|min:3'
    ]);

    if($validator->fails())
    {
        return response()->json([
            'status'=>false,
            'message'=>'Please fix the errors',
            'errors'=>$validator->errors()
    ]);
    }

    $blog->title=$request->title;
    $blog->author=$request->author;
    $blog->description=$request->description;
    $blog->shortDesc=$request->shortDesc;
    $blog->save();

    $tempImage=TempImage::find($request->image_id);

    if ($tempImage != null) {
            $imageExtArray = explode('.', $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time() . '-' . $blog->id . '.' . $ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path('uploads/temp/' . $tempImage->name);
            $destPath = public_path('uploads/temp/blogs/' . $imageName);

            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destPath);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Temporary image not found',
                ]);
            }
        }

        return response()->json([
            'status'=>true,
            'message'=>'Blog Edited successfully',
            'data'=>$blog
    ]);
    
    }
    public function destroy($id)
    {
        $blog =Blog::find($id);

        if($blog==null)
        {
            return response()->json([
                'status'=>false,
                'message'=>'blog not found',
        ]);
        }

        File::delete(public_path('uploads/temp/blogs/'.$blog->image));

        $blog->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Blog Deleted successfully'
    ]);

    }
}
