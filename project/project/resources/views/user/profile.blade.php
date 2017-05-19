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
            background-color: grey;
        }
    </style>

    <ul>
        <li><a href="{{route('contacts')}}" class="active"><strong>Return</strong></a></li>
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