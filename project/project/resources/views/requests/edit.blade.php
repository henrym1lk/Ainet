@extends('master')

@section('title', 'Make Request')

@section('content')

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            height: 600px;
            text-align: center;
            border-collapse: collapse;
        }
    </style>

    <ul>
        <li><a class="active" href="{{route('requests.details', $request->id)}}"><strong>Return</strong></a></li>
    </ul>

    @if(count($errors)>0)
        @include('shared.errors')
    @endif



    <div style="
    width: 96%;
    margin: 2%;
    padding: 5px;
    display: block;
    height: 600px">
        <form style="height: 100%; width: 100%" action="{{route('requests.save', $request->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div style="height: 100%; width: 50%; float: right">
                <b>Descrição (opcional)</b>
                <textarea style="height: 60%; width: 100%" name="description" value="{{$request->description}}"></textarea>
                <button style="height: 20%; width: 100%; margin-top: 1%" type="submit" class="btn btn-danger" name="ok">
                    Submeter
                </button>
            </div>

            <div style="height: 80%;width: 10%; float: right; margin-right: 20%">
                <div style="width: 100%; margin-bottom: 10%;margin-right: 5%">
                    <label for="due_date">Due Date: (opcional)</label>
                    <input type="text" name="due_date" class="form-control" value="{{$request->due_date}}">
                </div>
                <div style="width: 100%; margin-bottom: 10%;margin-right: 5%">
                    <label for="quantity">Number of Copies: </label>
                    <input required style="width: 25%" type="text" name="quantity" value="{{$request->quantity}}">
                </div>
                <div style="margin-bottom: 10%;margin-right: 5%">
                    <select name="colored" class="form-control" value="{{$request->colored}}">
                        <option value="1">Colored</option>
                        <option value="0">Black/White</option>
                    </select>
                </div>
                <div style="margin-bottom: 10%;margin-right: 5%">
                    <select name="stapled" class="form-control" value="{{$request->stapled}}">
                        <option value="1">Stapled</option>
                        <option value="0">N/ Stapled</option>
                    </select>
                </div>
                <div style="margin-bottom: 10%;margin-right: 5%">
                    <select name="paper_size" class="form-control" value="{{$request->paper_size}}">
                        <option value="0">A4</option>
                        <option value="1">A3</option>
                    </select>
                </div>
                <div style="margin-bottom: 10%;margin-right: 5%">
                    <select name="paper_type" class="form-control" value="{{$request->paper_type}}">
                        <option value="1">Draft</option>
                        <option value="2">Normal</option>
                        <option value="3">Photo</option>
                    </select>
                </div>
                <div style="margin-bottom: 10%;margin-right: 5%">
                    <input required type="file" name="file" class="btn btn-secondary btn-file" value="{{old('file')}}">
                </div>
            </div>
        </form>
    </div>
@endsection