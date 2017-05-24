<?php

namespace App\Http\Controllers;

use App\CommentModel;
use Faker\Provider\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use League\Flysystem\Exception;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*
        if(!Auth::check()){
            return redirect('index');
        }
        */
    }

    public function deleteRequest($id)
    {
        $requestModel = RequestModel::where('id', $id)->first();
        if (is_null($requestModel)) {
            return redirect()->route('requests');
        }
        if ($requestModel->owner_id == Auth::user()->id) {
            $requestModel->delete();
            return redirect()->route('requests');
        }
        return redirect()->back();
    }

    public function editRequest($id)
    {
        $request = RequestModel::find($id);
        return view('requests.edit', compact('request'));
    }

    public function requests()
    {
        $requests = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->select('requests.file as file', 'requests.id as id', 'departaments.name as dep', 'users.name as name', 'requests.open_date as data', 'requests.status as state')
            ->whereNull('requests.refused_reason')
            ->orderBy('requests.id')
            ->paginate(10);

        return view('requests.requests', compact('requests'));
    }

    public function requestsFilter()
    {
        if (is_null(Input::get('column')) || is_null(Input::get('order'))) {
            $requests = DB::table('requests')
                ->join('users', 'requests.owner_id', '=', 'users.id')
                ->join('departaments', 'users.department_id', '=', 'departaments.id')
                ->select('requests.id as id', 'departaments.name as dep', 'users.name as name', 'requests.open_date as data', 'requests.status as state')
                ->where('users.name', 'like', is_null(Input::get('name')) ? '%' : '%' . Input::get('name') . '%')
                ->where('requests.status', 'like', is_null(Input::get('status')) ? '%' : '%' . Input::get('status') . '%')
                ->where('requests.open_date', 'like', is_null(Input::get('date')) ? '%' : '%' . Input::get('date') . '%')
                ->where('departaments.name', 'like', is_null(Input::get('department')) ? '%' : '%' . Input::get('department') . '%')
                ->whereNull('requests.refused_reason')
                ->paginate(10);
        } else {
            $requests = DB::table('requests')
                ->join('users', 'requests.owner_id', '=', 'users.id')
                ->join('departaments', 'users.department_id', '=', 'departaments.id')
                ->select('requests.id as id', 'departaments.name as dep', 'users.name as name', 'requests.open_date as data', 'requests.status as state')
                ->where('users.name', 'like', is_null(Input::get('name')) ? '%' : '%' . Input::get('name') . '%')
                ->where('requests.status', 'like', is_null(Input::get('status')) ? '%' : '%' . Input::get('status') . '%')
                ->where('requests.open_date', 'like', is_null(Input::get('date')) ? '%' : '%' . Input::get('date') . '%')
                ->where('departaments.name', 'like', is_null(Input::get('department')) ? '%' : '%' . Input::get('department') . '%')
                ->whereNull('requests.refused_reason')
                ->orderBy(Input::get('column'), Input::get('order'))
                ->paginate(10);
        }

        return view('requests.requests', compact('requests'));
    }

    public function requestsDetails($id)
    {
        $data = DB::table('requests')
            ->where('id', '=', $id)
            ->first();

        if (is_null($data)) {
            return redirect()->back();
        }

        $request_id = $id;

        $comments = DB::table('comments')
            ->select('comment', 'id', 'reports')
            ->where('request_id', '=', $id)
            ->where('blocked', '=', 0)
            ->whereNull('parent_id')
            ->get();

        $commentsToComments = DB::table('comments as son')
            ->leftJoin('comments as father', 'son.parent_id', '=', 'father.id')
            ->select('son.comment as comment', 'son.id as id', 'son.parent_id as parent_id', 'son.reports as reports')
            ->where('son.request_id', '=', $id)
            ->where('son.blocked', '=', 0)
            ->where('father.blocked', '=', 0)
            ->whereNotNull('son.parent_id')
            ->get();

        return view('requests.details', compact('data', 'request_id', 'comments', 'commentsToComments'));
    }

    public function rate(Request $request, $id)
    {
        DB::table('requests')
            ->where('id', $id)
            ->update(['satisfaction_grade' => $request['rating']]);

        DB::table('users')
            ->where('id', Auth::user()['id'])
            ->increment('print_evals');

        return redirect()->route('requests.details', $id);
    }

    public function requestsComment(Request $request, $id)
    {
        $comment = new CommentModel();
        $comment['comment'] = $request['comment'];
        $comment['request_id'] = $id;
        $comment['blocked'] = 0;
        $comment['parent_id'] = $request['answerTo'];
        $comment['user_id'] = Auth::user()->id;
        $comment->save();

        return redirect()->route('requests.details', $id);
    }

    public function commentReport()
    {
        DB::table('comments')
            ->where('id', '=', Input::get('comment_id'))
            ->increment('reports');

        return redirect()->route('requests.details', Input::get('request_id'));
    }

    public function commentBlock()
    {
        DB::table('comments')
            ->where('id', '=', Input::get('comment_id'))
            ->update(['blocked' => 1]);

        return redirect()->route('requests.details', Input::get('request_id'));
    }

    public function submit(Request $data)
    {
        $this->validate($data, [
            'due_date' => 'nullable|date',
            'quantity' => 'required',
            'file' => 'required|file'
        ]);

        $request = new RequestModel();
        $request->fill($data->all());
        $request['status'] = 0;
        $request['owner_id'] = Auth::user()['id'];
        $request['open_date'] = date('Y-m-d H:i:s');

        $file = $data->file('file');

        $fileName = "file" . $request->id . "." . $file->getClientOriginalExtension();

        $data->file('file')->move(
            base_path() . 'storage/files/', $fileName
        );

        $request['file'] = $fileName;
        $request->save();

        DB::table('users')
            ->where('id', Auth::user()['id'])
            ->increment('print_counts');

        return redirect()->route('requests');
    }

    public function save(Request $data, $request_id)
    {
        $this->validate($data, [
            'due_date' => 'nullable|date',
            'quantity' => 'required',
            'file' => 'required|file'
        ]);

        $request = RequestModel::find($request_id);

        $oldFile = $request->file;

        $request->fill($data->all());

        $request->status = 0;
        $request->owner_id = Auth::user()['id'];
        $request->open_date = date('Y-m-d H:i:s');

        $file = $data->file('file');

        $fileName = "file" . $request->id . "." . $file->getClientOriginalExtension();

        unlink(base_path() . 'storage/files/' . $oldFile);

        $data->file('file')->move(
            base_path() . 'storage/files/', $fileName
        );

        $request->file = $fileName;
        $request->save();

        return redirect()->route('requests');
    }

    public function requestFile($requestId)
    {
        $request = RequestModel::find($requestId);

        if (is_null($request)) {
            return redirect()->route('requests');
        }

        if (Auth::user()->id == $request->owner_id || Auth::user()->admin == 1) {
            $path = base_path() . 'storage/files/' . $request->file;

            Response::download($path, $request->file);
        }

        return redirect()->route('requests');
    }

    public function create()
    {
        return view('requests.make');
    }
}
