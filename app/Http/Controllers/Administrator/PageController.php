<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy("id", 'desc')->get();
        return view("administrator.pages.list", compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administrator.pages.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
            'extras' => 'required',
            'banner' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);

        $page = new Page();
        $page->name = $request->name;
        $page->content = $request->content;
        $page->extras = $request->extras;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = $request->meta_keywords;

        $page->save();

        if ($request->hasfile('banner')) {

            $image      = $request->file('banner');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/pages/' . $page->slug . '/', $name, 'public');

            Page::find($page->id)->update(['banner' => $name]);
        }

        return redirect()->route('administrator.pages.index')->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $page = Page::find($id);
        $page->avatar  = "https://placehold.co/150x150/D82D36/FFF?text=".$page->name[0];
        return view("administrator.pages.view", compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::find($id);
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : "https://placehold.co/150x150/D82D36/FFF?text=".$page->name;
        return view("administrator.pages.edit", compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
            'extras' => 'required',
            'banner' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);

        $page = Page::find($id);
        $page->name = $request->name;
        $page->content = $request->content;
        $page->extras = $request->extras;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = $request->meta_keywords;

        $page->save();

        if ($request->hasfile('banner')) {

            $image      = $request->file('banner');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/pages/' . $page->slug . '/', $name, 'public');

            Page::find($page->id)->update(['banner' => $name]);
        }

        return redirect()->route('administrator.pages.index')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::find($id)->delete();
        return redirect()->route('administrator.pages.index')->with('success', 'Page deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Page::whereIn('id', $request->pages)->delete();
        return response()->json(['success' => 'Pages deleted successfully!'], 200);
    }
}
