@extends('master')

@section('title', 'Profile')

@section('content')

    <style>
        #main {
            margin-right: 1%;
            margin-left: 1%;
        }

        #descricao {
            padding: 1%;
            margin-left: 15%;
            margin-right: 15%;
            width: 70%;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #74787E;
            color: white;
        }

        .dropbtn {
            background-color: #2F3131;
            color: white;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .dropdown {
            position: absolute;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        li a, .dropbtn {
            display: inline-block;
            color: white;
            padding: 14px 16px;
            text-decoration: none;
        }
    </style>

    <ul>
        <div style="width: 90%">
            <li><a href="{{route('contacts')}}" class="active"><strong>Return</strong></a></li>
        </div>
        <div style="width: 10%; float: right;">
            <li style="float: right; " class="dropdown">
                <a href="/user/profile/{{Auth::user()->profile_url}}" style="padding: 14px 15px;"
                   class="dropbtn"><strong>{{Auth::user()->name}}</strong></a>
                <div class="dropdown-content">
                    <a href="/user/logout">Logout</a>
                </div>
            </li>
        </div>
    </ul>

    <div id="main">
        <div id="descricao">

            <p>Name: {{$data->name}}</p>
            <p>Email: {{$data->email}}</p>
            <p>Phone: {{$data->phone}}</p>
            <p>Profile Photo: <img src="{{$data->profile_photo}}" style="width:228px;height:228px;"></p>
            <p>Department: {{$data->department}}</p>
            <p>Facebook: <a href="{{$data->facebook}}">{{$data->facebook}}</a></p>
            <p>Presentation: {{$data->presentation}}</p>

        </div>

        @if(!is_null(\Illuminate\Support\Facades\Auth::user()) && \Illuminate\Support\Facades\Auth::user()->admin==1)
            <a class="btn btn-danger" style="margin-left: 15%;
        margin-right: 15%;
        margin-top: 1%;
        width: 70%;
height: 5%" href="{{route('user.block', $id)}}">Block</a>
        @endif
    </div>

@endsection