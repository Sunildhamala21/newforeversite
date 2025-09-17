<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::get()->toArray();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Models\FaqCategory::all();

        return view('admin.faqs.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $status = 0;
        $msg = '';
        $faq = new Faq;
        $faq->title = $request->title;
        $faq->content = $request->content;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->slug = $this->create_slug_title($faq->title);
        $faq->status = 1;

        if ($faq->save()) {
            $status = 1;
            $msg = 'Faq created successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
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
        $faq = Faq::find($id);
        $categories = \App\Models\FaqCategory::all();

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $status = 0;
        $msg = '';
        $faq = Faq::find($request->id);
        $faq->title = $request->title;
        $faq->content = $request->content;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->slug = $this->create_slug_title($faq->title);
        $faq->status = 1;

        if ($faq->save()) {
            $status = 1;
            $msg = 'Faq updated successfully.';
            session()->flash('message', $msg);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = 0;
        $http_status_code = 400;
        $msg = '';
        $path = 'public/faqs/';

        if (Faq::find($id)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'Faq has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function faqList()
    {
        $faqs = Faq::all();

        return response()->json([
            'data' => $faqs,
        ]);
    }

    public function updateCategory(Request $request, $id)
    {
        $success = false;
        $message = '';

        $faq = Faq::find($id);
        $faq->faq_category_id = $request->category_id;
        if ($faq->save()) {
            $success = true;
            $message = 'Category updated successfully.';
        }

        return response()->json([
            'data' => (object) [],
            'success' => $success,
            'message' => $message,
        ]);
    }
}
