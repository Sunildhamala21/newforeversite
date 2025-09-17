<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::get()->toArray();

        return view('admin.documents.index', compact('documents'));
    }

    public function documentList()
    {
        $documents = Document::all();

        return response()->json([
            'data' => $documents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImageService $imageService): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png,gif,webp|max:10000',
        ]);

        $status = 0;
        $msg = '';
        $document = new Document;
        $document->name = $request->name;

        if ($request->hasFile('file')) {
            $imageName = md5($request->file->getClientOriginalName().microtime()).'.webp';
            $document->file = $imageName;
        }

        if ($document->save()) {
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $document,
                    $document->file = $imageName,
                    'public/documents/'.$document->id.'/',
                    json_decode($request->cropped_data, false)
                );
                $status = 1;
                $msg = 'Document created successfully.';
                session()->flash('success_message', $msg);
            }
        }

        return redirect()->back();
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
        $path = 'public/documents/';

        if (Document::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Document has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }
}
