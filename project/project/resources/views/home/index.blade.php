@extends('master')

@section('title', 'Main Page')

@section('content')

    <ul>
        <li><a href="{{route('index')}}" class="active"><strong>Home</strong></a></li>
        <li><a href="{{route('stats')}}">Statistics</a></li>
        <li><a href="{{route('contacts')}}">Contacts</a></li>
    </ul>

    <h1 style="text-align: center;
        margin-bottom: 10px">
        Welcome to PrintIT! main page! Here you can log in or create a new account!
    </h1>

    @if(count($errors)>0)
        @include('shared.errors')
    @endif

    <div style="
    width: 600px;
    border: 2px solid crimson;
    border-radius: 5px;
    margin: auto;
    padding: 5px;
    display: block">

        <form action="{{route('login')}}" method="post" class="form-group">
            {{csrf_field()}}
            <div class="form-group" style="width: 500px;
                                    margin: auto">
                <div style="margin-bottom: 10px;
                        margin-top: 10px">
                    <label for="inputEmail">Email</label>
                    <input required
                           type="email" class="form-control"
                           name="email" id="inputEmail"
                           value="{{old('email')}}"/>
                </div>
                <div style="margin-bottom: 10px">
                    <label for="inputPassword">Password</label>
                    <input
                            required
                            type="password" class="form-control"
                            name="password" id="inputPassword"/>
                </div>
                <div style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary" name="signIn">Sign In</button>
                </div>

                <div>
                    <a href="{{route('user.recover')}}">I forgot my password... :(</a>
                </div>
                <a href="{{route('user.register')}}">I don't have an account... :(</a>

            </div>
        </form>

    </div>

@endsection
