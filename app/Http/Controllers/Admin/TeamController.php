<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamCertificate;
use App\Models\TeamGallery;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::get()->toArray();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teams.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $status = 0;
        $msg = '';
        $team = new Team;
        $team->name = $request->name;
        $team->description = $request->description;
        $team->position = $request->position;
        $team->sort_order = 0;
        $team->type = $request->type;
        $team->slug = $this->create_slug_title($team->name);
        $team->status = 1;

        if ($request->hasFile('file')) {
            $team->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($team->save()) {
            // save image.
            if ($request->hasFile('file')) {
                $imageService->processAndStoreImage(
                    $request->file,
                    $team,
                    $team->image_name,
                    'public/teams/'.$team->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            // save files.
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $certificate = new TeamCertificate;
                    // save mother signature file.
                    $fileOriginal = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = pathinfo($fileOriginal, PATHINFO_FILENAME);
                    $filename = time().'_'.Str::random(5).'_'.Str::slug($filename).'.'.$extension;

                    $image = Image::read($file);
                    $document_file_path = '/public/teams/'.$team['id'].'/certificates/';
                    Storage::put($document_file_path.$filename, (string) $image->toJpeg(90));
                    $certificate->file = $filename;
                    $team->certificates()->save($certificate);
                }
            }

            // save galleries.
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $file) {
                    $gallery = new TeamGallery;
                    // save mother signature file.
                    $fileOriginal = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = pathinfo($fileOriginal, PATHINFO_FILENAME);
                    $filename = time().'_'.Str::random(5).'_'.Str::slug($filename).'.'.$extension;

                    $image = Image::read($file);
                    $document_file_path = '/public/teams/'.$team['id'].'/galleries/';
                    Storage::put($document_file_path.$filename, (string) $image->toJpeg(90));
                    $gallery->file = $filename;
                    $team->galleries()->save($gallery);
                }
            }

            $status = 1;
            $msg = 'Team created successfully.';
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
        $team = Team::find($id);

        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageService $imageService): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $status = 0;
        $msg = '';
        $team = Team::find($request->id);
        $team->name = $request->name;
        $team->description = $request->description;
        $team->position = $request->position;
        $team->type = $request->type;
        $team->slug = $this->create_slug_title($team->name);
        $team->status = 1;

        if ($request->hasFile('file')) {
            $team->image_name = md5($request->file->getClientOriginalName().microtime()).'.webp';
        }

        if ($team->save()) {
            // save image.
            if ($request->hasFile('file')) {
                Storage::deleteDirectory('public/teams/'.$team['id']);
                $imageService->processAndStoreImage(
                    $request->file,
                    $team,
                    $team->image_name,
                    'public/teams/'.$team->id.'/',
                    json_decode($request->cropped_data, true)
                );
            }

            // save files.
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $certificate = new TeamCertificate;
                    // save mother signature file.
                    $fileOriginal = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filesize = $file->getClientSize();
                    $filename = pathinfo($fileOriginal, PATHINFO_FILENAME);
                    $filename = time().'_'.Str::random(5).'_'.Str::slug($filename).'.'.$extension;

                    $image = Image::read($file);
                    $document_file_path = '/public/teams/'.$team['id'].'/certificates/';
                    Storage::put($document_file_path.$filename, (string) $image->toJpeg(90));
                    $certificate->file = $filename;
                    $team->certificates()->save($certificate);
                }
            }

            // remove files if any.
            if (! empty($request->remove_files_arr)) {
                $remove_files = explode(',', $request->remove_files_arr);

                foreach ($remove_files as $file) {
                    $doc = TeamCertificate::find($file);
                    $fullImage = storage_path('app/public/teams/'.$team['id'].'/certificates/'.$doc->file);
                    if (file_exists($fullImage) && is_file($fullImage)) {
                        unlink($fullImage);
                    }
                    $doc->delete();
                }
            }

            // save galleries.
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $file) {
                    $gallery = new TeamGallery;
                    // save mother signature file.
                    $fileOriginal = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filesize = $file->getClientSize();
                    $filename = pathinfo($fileOriginal, PATHINFO_FILENAME);
                    $filename = time().'_'.Str::random(5).'_'.Str::slug($filename).'.'.$extension;

                    $image = Image::read($file);
                    $document_file_path = '/public/teams/'.$team['id'].'/galleries/';
                    Storage::put($document_file_path.$filename, (string) $image->toJpeg(90));
                    $gallery->file = $filename;
                    $team->galleries()->save($gallery);
                }
            }

            // remove galleries if any.
            if (! empty($request->remove_pictures_arr)) {
                $remove_files = explode(',', $request->remove_pictures_arr);

                foreach ($remove_files as $file) {
                    $doc = TeamGallery::find($file);
                    $fullImage = storage_path('app/public/teams/'.$team['id'].'/galleries/'.$doc->file);
                    if (file_exists($fullImage) && is_file($fullImage)) {
                        unlink($fullImage);
                    }
                    $doc->delete();
                }
            }

            $status = 1;
            $msg = 'Team updated successfully.';
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
        $path = 'public/teams/';

        if (Team::find($id)->delete()) {
            Storage::deleteDirectory($path.$id);
            $status = 1;
            $http_status_code = 200;
            $msg = 'Team has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function teamList()
    {
        $teams = Team::all();

        return response()->json([
            'data' => $teams,
        ]);
    }
}
