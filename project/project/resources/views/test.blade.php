@extends('master')

@section('title', 'Test')

@section('content')

    <html>
    <body>

    {{Form::open(array('url' => '/test','files'=>'true'))}}
    {{'Select the file to upload.'}}
    {{Form::file('image')}}
    {{Form::submit('Upload File')}}
    {{Form::close()}}

    </body>
    </html>

@endsection