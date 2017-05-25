@extends('master')


@section('title', 'Users')
@section('content')



    <style>
        .tables {
            width: 30%;
            margin-left: 1%;
            padding: 5px;
            display: block;
            height: 400px;
            overflow: auto;
            text-align: left;
            float: left
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
        <div style="width: 91%; float: left; height: 100%">
            <li><a href="{{route('requests')}}">Requests</a></li>
            @if(\Illuminate\Support\Facades\Auth::user()->admin==1)
                <li><a href="{{route('admin.users')}}" class="active"><strong>Users</strong></a></li>
            @endif
        </div>
        <li style="float: right; " class="dropdown">
            <a href="/user/profile/{{Auth::user()->profile_url}}" style="padding: 14px 15px;"
               class="dropbtn"><strong>{{Auth::user()->name}}</strong></a>
            <div class="dropdown-content">
                <a href="/user/logout">Logout</a>
            </div>
        </li>
    </ul>
    <div name="left">
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
    </div>
    <div>
        <div class="tables" name="Users" style="float: left; margin-left: 10%; width: 40%;margin-top: 1%">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>E-Mail</th>
                    <th>Admin</th>
                    <th>Block</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($adminOrNotUsers as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->dep}}</td>
                        <td>{{$user->email}}</td>
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
            {{$adminOrNotUsers->links()}}
        </div>
    </div>


@endsection