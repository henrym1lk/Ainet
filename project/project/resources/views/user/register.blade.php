@extends('master')

@section('title', 'Register')

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
        <li><a href="{{route('index')}}" class="active"><strong>Return</strong></a></li>
    </ul>

    @if(count($errors)>0)
        @include('shared.errors')
    @endif

    <div style="
    width: 96%;
    margin: 2%;
    padding: 5px;
    display: block">
        <form action="{{route('user.create')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div style="width: 40%;" class="form-group">
                <div>
                    <label for="name">First Name</label>
                    <input required type="text" name="name" class="form-control" value="{{old('name')}}">
                </div>
                <div>
                    <label for="email">E-mail</label>
                    <input required type="text" name="email" class="form-control" value="{{old('email')}}">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input required type="password" name="password" class="form-control" value="{{old('password')}}">
                </div>
                <div>
                    <label for="password_confirmation">Password Confirmation</label>
                    <input required type="password" name="password_confirmation" class="form-control">
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                </div>
                <div>
                    <label for="photo">Profile Photo</label>
                    <input type="file" accept="image/*" name="photo" class="btn btn-primary btn-file" value="{{old('photo')}}">
                </div>
                <div>
                    <label for="profile_url">Custom Url</label>
                    <input style="width: 40%" type="text" name="profile_url" class="form-control" value="{{old('profile_url')}}">
                </div>
                <div>
                    <label for="facebook">Facebook Profile</label>
                    <input style="width: 40%" type="text" name="facebook" class="form-control" value="{{old('facebook')}}">
                </div>
                <div>
                    <label for="presentation">Presentation</label>
                    <input style="width: 40%" type="text" name="presentation" class="form-control" value="{{old('presentation')}}">
                </div>

                <div style="float: right">
                    <button type="submit" class="btn btn-danger" name="ok">Submeter</button>
                    <a type="submit" class="btn btn-default" href="{{route('index')}}">Cancel</a>
                </div>

            </div>
        </form>
    </div>
@endsection