<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubscriberExport;
use App\Http\Controllers\Controller;
use App\Models\EmailSubscriber;
use Maatwebsite\Excel\Facades\Excel;

class EmailSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = EmailSubscriber::get()->toArray();

        return view('admin.emailSubscribers.index', compact('subscribers'));
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

        if (EmailSubscriber::find($id)->delete()) {
            $status = 1;
            $http_status_code = 200;
            $msg = 'Subscriber has been deleted';
        }

        return response()->json([
            'status' => $status,
            'message' => $msg,
        ], $http_status_code);
    }

    public function subscriberList()
    {
        $subscribers = EmailSubscriber::all();

        return response()->json([
            'data' => $subscribers,
        ]);
    }

    public function exportToExcel()
    {
        session()->flash('success_message', 'Exported successfully.');

        return Excel::download(new SubscriberExport, 'subscribers.xlsx');
    }
}
