@extends('master')

@section('title', 'Password Recover')

@section('content')

    <ul>
        <li><a href="{{route('index')}}" class="active"><strong>Return</strong></a></li>
    </ul>

    @if(count($errors)>0)
        @include('shared.errors')
    @endif

    <form action="{{route('user.recover.submit')}}" method="post" class="form-group">
        {{csrf_field()}}
        <div style="margin-bottom: 10px;
                        margin-top: 10px">
            <label for="inputEmail">Email</label>
            <input required
                   type="email" class="form-control"
                   name="email" id="inputEmail"
                   value="{{old('email')}}"/>
        </div>
        <div style="margin-bottom: 10px">
            <button type="submit" class="btn btn-danger" name="ok">Confirm</button>
            <a type="submit" class="btn btn-default" href="{{route('index')}}">Cancel</a>
        </div>
    </form>

@endsection
