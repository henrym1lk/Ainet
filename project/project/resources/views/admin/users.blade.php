@extends('master')


@section('title', 'Users')
@section('content')



    <style>
        .tables {
            width: 32%;
            margin-left: 1%;
            margin-bottom: 15px;
            padding: 5px;
            display: block;
            height: 400px;
            overflow: auto;
            text-align: left;
            float: left
        }
    </style>

    <ul>
        <ul>
            <li><a href="{{route('requests')}}">Requests</a></li>
            @if(\Illuminate\Support\Facades\Auth::user()->admin==1)
                <li><a href="{{route('admin.users')}}" class="active"><strong>Users</strong></a></li>
            @endif
            <li style="float: right"><a href="{{route('logout')}}">Logout</a></li>
        </ul>


    </ul>
    <form action="{{route('admin.users.filter')}}" method="get" class="form-group" style="">
        <div style="width: 15%; float: left; margin-left: 5%;  margin-top: 1%">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control"
                       name="name"/>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control"
                       name="department"/>
            </div>
            <div style=" float: left; width: 100%">
                <div class="form-group">
                    <label for="column">Column</label>
                    <select name="column" class="form-control">
                        <option disabled selected> -- select an option --</option>
                        <option value="users.name">Name</option>
                        <option value="departaments.name">Department</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="order">Order</label>
                    <select name="order" class="form-control">
                        <option disabled selected> -- select an option --</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <button style="width: 100%" type="submit" class="btn btn-primary" name="orderBtn">Filter</button>
            </div>
        </div>
    </form>





    <div class="tables" name="Users" style="float: right; margin-right: 10%">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Admin</th>
                <th>Block</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($adminOrNotUsers as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->dep}}</td>
                    <td>@if($user->admin == 0)
                            <a class="btn btn-info"
                               href="{{route('user.concede', $user->id)}}">Concede</a>
                        @endif
                        @if($user->admin == 1)
                            <a class="btn btn-warning"
                               href="{{route('user.revoke', $user->id)}}">Revoke</a>
                        @endif
                    </td>
                    <td>@if($user->blocked == 0)
                            <a class="btn btn-danger"
                               href="{{route('user.block', $user->id)}}">Block</a>
                        @endif
                        @if($user->blocked == 1)
                            <a class="btn btn-success"
                               href="{{route('user.unblock', $user->id)}}">Unblock</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>


@endsection