<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|unique:categories',
            'image' => 'required|mimes:jpg,png,jpeg,bmp'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name);

        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imagename   = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            //check category dir is exist
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            // resize category image for upload
            $category  = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/' . $imagename, $category);

            ////check category slider dir is exist

            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            // resize category slider image for upload
            $slider  = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/' . $imagename, $slider);
        }

        //optional
        else {
            $imagename = "default.png";
        }

        $category = new Category();

        $category->name  = $request->name;
        $category->slug  = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category Successully Saved', 'Success');

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required',
            'image' => 'mimes:jpg,png,jpeg,bmp,webp'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name);
        $category = Category::find($id);

        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imagename   = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            //check category dir is exist
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }

            //Delete old image
            if(Storage::disk('public')->exists('category/'.$category->image))
            {
                Storage::disk('public')->delete('category/'.$category->image);
            }

            // resize category image for upload
            $categoryimage  = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/' . $imagename, $categoryimage);

            ////check category slider dir is exist

            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            //Delete old image
            if(Storage::disk('public')->exists('category/slider/'.$category->image))
            {
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

            // resize category slider image for upload
            $slider  = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/' . $imagename, $slider);
        }

        //optional
        else {
            $imagename = $category->image;
        }

        $category->name  = $request->name;
        $category->slug  = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category Successully Updated :)','Success');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        //deleteing category image
        if(Storage::disk('public')->exists('category/'.$category->image))
        {
            Storage::disk('public')->delete('category/'.$category->image);
        }
        // Same for deleting slider image
        if(Storage::disk('public')->exists('category/slider/'.$category->image))
        {
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Category Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
