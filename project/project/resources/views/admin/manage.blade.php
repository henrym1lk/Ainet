@extends('master')

@section('title', 'Manage')

@section('content')

    <style>
        .tables {
            width: 32%;
            border: 2px solid crimson;
            border-radius: 5px;
            margin-left: 1%;
            margin-bottom: 15px;
            padding: 5px;
            display: block;
            height: 400px;
            overflow: scroll;
            text-align: center;
            float: left
        }
    </style>

    <ul>
        <ul>
            <li><a href="{{route('requests')}}"><strong>Requests</strong></a></li>
            <li><a href="{{route('requests.make')}}">Make Request</a></li>
            @if(\Illuminate\Support\Facades\Auth::user()->admin==1)
                <li><a href="{{route('admin.manage')}}" class="active">Manage</a></li>
            @endif
            <li style="float: right"><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </ul>


    <div style="
            width: 100%;">


        <div class="tables">

            <p style="font-size: 30px">Blocked Users</p>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Block</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($blockedUsers as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->dep}}</td>
                        <td><a class="btn btn-danger" href="{{route('user.unblock', $user->id)}}">Unblock</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="tables">

            <p style="font-size: 30px">Users</p>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Admin</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($adminOrNotUsers as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->dep}}</td>
                        <td><a class="btn btn-danger"
                               href="{{$user->admin==0?route('user.concede', $user->id):route('user.revoke', $user->id)}}">{{$user->admin==0?"Concede":"Revoke"}}</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="tables">

            <p style="font-size: 30px">Blocked Comments</p>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Comment</th>
                    <th>Block</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{$comment->comment}}</td>
                        <td><a class="btn btn-danger" href="{{route('comment.unblock', $comment->id)}}">Unblock</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>

@endsection