@extends('master')

@section('title', 'Statistics In Department')

@section('content')

    <style>
        .stats{
            width: 70%;
            border: 2px solid crimson;
            border-radius: 5px;
            margin-left: 15%;
            margin-right: 15%;
            margin-bottom: 15px;
            padding: 5px;
            display: block;
            text-align: center;
            font-size: 30px
        }
    </style>

    <ul>
        <li><a href="{{route('stats')}}" class="active"><strong>Return</strong></a></li>
    </ul>

    @include('partials.stats')

@endsection