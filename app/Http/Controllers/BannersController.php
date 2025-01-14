<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerValidationRequest;
use App\Models\Banners;
use App\Models\Categories;
use Exception;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = Banners::with(['subcategory'=> function ($query) {
                $query->select('id', 'name');
            },])->orderBy('created_at','desc')->paginate(10);   
            return response()->json([
                'success'=>true,
                'status' => 200,
                'data' => $data
            ]);
        } catch(Exception $e){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'error'=>$e
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerValidationRequest $request)
    {
        try {
            if ($request->has('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                $image_name = time() . "." . $extention;
                $file->move('upload/banners/', $image_name);
            }
            // $bannername = Banners::where('sub_category_id',$request->id);
            // dd($bannername);
            Banners::create([
                'image' => $image_name,
                'description' => $request->description,
                'banner_title' => $request->banner_title,
                'banner_url' => url("/upload/banners/$image_name"),
                'sub_category_id' => $request->sub_category_id,
                'category_id' => $request->category_id
            ]);
            return response()->json([
                'success'=>true,
                'status' => 200,
                'message' => 'banner added successfully'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'error'=>$e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data = Banners::with(['subcategory'=> function ($query) {
                $query->select('id', 'name');
            },])->get()
            ->find($id,['id','image','description']);
            if($data){
                return response()->json([
                    'success'=>true,
                    'status'=>200,
                    'data'=>$data,
                    'message'=>'country details fetch successfully'
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'code'=>404,
                    'message'=>'record not found'
                ]);
            }
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Banners::find($id);
            if (!$item) {
                return response()->json([
                    'success'=>false,
                    'status' => 404,
                    'message' => 'record not found'
                ]);
            }
            if ($request->has('image')) {
                if ($item->image) {
                    $name = $item->image;
                    $image_path = "upload/banners/$name";
                    unlink($image_path);
                }

                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                $banner_name = time() . "." . $extention;
                $file->move('upload/banners/', $banner_name);
                $item->image = $banner_name;
                $item->banner_url = url("/upload/banners/$banner_name");
            }
            $item->update($request->input());
            return response()->json([
                'success'=>true,
                'status' => 200,
                'message' => 'banner updated successfully'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'error'=>$e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Banners::find($id);
            if (!$item) {
                return response()->json([
                    'success'=>false,
                    'status' => 404,
                    'message'=>'record not found'
                ]);
            }
            unlink("upload/banners/$item->image");
            $item->delete();
            return response()->json([
                'success'=>true,
                'status' => 200,
                'message' => 'banner deleted successfully'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'error'=>$e
            ]);
        }
    }
    // function for get banner frontend side 

    // public function createBanner(Request $request,$id){
    //     if ($request->has('image')) {
    //         $file = $request->file('image');
    //         $extention = $file->getClientOriginalExtension();
    //         $image_name = time() . "." . $extention;
    //         $file->move('upload/banners/', $image_name);
    //     }
    //     // $ = Banners::find($id);

    //     Banners::create([
    //         'image'=>$image_name,
    //         'description'=>$request->description,
    //         'banner_title'=>$request->banner_title,
    //         // 'sub_category_id'=>
    //     ]);
    // }
    public function homeBanner()
    {
        try {
            $BannerWithSubcategory = Banners::select('id', 'image', 'description', 'banner_title', 'sub_category_id')->with('subcategory')->orderBy('id', 'DESC')->get();
            if ($BannerWithSubcategory) {
                $BannerWithSubcategory = $BannerWithSubcategory->makeHidden('subcategory');
                $BannerWithSubcategory = $BannerWithSubcategory->makeHidden('sub_category_id');
                // dd($BannerWithSubcategory);
                foreach ($BannerWithSubcategory as $subcat) {
                    $subcat['image'] = url("/upload/banners/" . $subcat->image);
                }
                foreach ($BannerWithSubcategory as $cat) {
                    $cat->url = url('/' . Categories::find($cat->subcategory->category_id)->name . '/' . $cat->subcategory->name);
                }
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'bannerData' => $BannerWithSubcategory,
                    'message' => 'Banner Show Successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'status' => 404,
                    'message' => 'Banners Are Not Found'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
