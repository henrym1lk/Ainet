@extends('master')


@section('title', 'Requests')
@section('content')

    <style>
        .pedidos {
            text-align: center;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            height: 75%;
        }

        td, th {
            text-align: left;
            padding: 8px;
        }

        .dropdown-content a:hover {
            background-color: #74787E;
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
            background-color: #2F3133;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            background-color: #2F3133;
            color: white;
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

        .active {
            background-color: #d43f3a;
            position: relative;
            display: inline-block;
        }
    </style>

    <ul>
        <div name="left" style="width: 50%">
            <div>
                <li class="dropdown">
                    <a style="background-color: #d43f3a" href="{{route('requests')}}"
                       class="dropbtn"><strong>Requests</strong></a>
                    <div class="dropdown-content">
                        <a style="background-color: #d43f3a" href="/requests/my">My Requests</a>
                    </div>
                </li>
            </div>

            <div style="margin-left: 10%">
                @if(\Illuminate\Support\Facades\Auth::user()->admin==0)
                    <li><a href="{{route('requests.make')}}">Make Request</a></li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->admin==1)
                    <li><a href="{{route('admin.users')}}">Users</a></li>
                @endif
            </div>
        </div>
        <div name="right" style="width: 50%; margin-left: 91.6%">
            <li style="float: right; " class="dropdown">
                <a href="/user/profile/{{Auth::user()->profile_url}}" style="padding: 14px 15px;"
                   class="dropbtn"><strong>{{Auth::user()->name}}</strong></a>
                <div class="dropdown-content" style="background-color: #74787E">
                    <a href="/user/logout">Logout</a>
                </div>
            </li>
        </div>
    </ul>

    <form action="{{route('requests.filter')}}" method="get" class="form-group" style="">
        <div style="margin-top: 1%; margin-bottom: 5%">
            <div style="width: 15%; float: left; margin-left: 5%">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control"
                           name="name"/>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option disabled selected> -- select an option --</option>
                        <option value="1">Finished</option>
                        <option value="0">Pendent</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control"
                           name="date"/>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control"
                           name="department"/>
                </div>

                <button style="margin-bottom: 5%;" type="submit" class="btn btn-primary" name="filterBtn">Filter
                </button>
            </div>
            <div class="pedidos" style="
            width: 70%;
            margin-right: 5%;
            overflow:auto;
            float: right">
                <div class="form-group">
                    <label for="column">Column</label>
                    <select name="column" class="form-control">
                        <option disabled selected> -- select an option --</option>
                        <option value="users.name">Name</option>
                        <option value="departaments.name">Department</option>
                        <option value="requests.status">State</option>
                        <option value="requests.open_date">Request Date</option>
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
                <button type="submit" class="btn btn-primary" name="orderBtn">Order</button>

                <table id="tabelaPedidos" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Departamento</th>
                        <th>Funcionario</th>
                        <th>Data</th>
                        <th>Estado</th>
                        <th>ID</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--
                    @foreach($data as $row)
                        <tr>
                            <td><img src="https://i1.sndcdn.com/avatars-000198033687-20g02p-t500x500.jpg" height="20px"
                                     width="20px" alt=""></td>
                            <td>{{$row->dep}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->data}}</td>
                            <td>{{\App\RequestModel::statusToString($row->state)}}</td>
                            <td>{{$row->id}}</td>
                            <td><a href="{{route('requests.details', $row->id)}}">Open</a></td>
                        </tr>
                    @endforeach
                    --}}
                    @foreach($requests as $request)
                        <tr>
                            <td><img src="https://i1.sndcdn.com/avatars-000198033687-20g02p-t500x500.jpg"
                                     height="20px"
                                     width="20px" alt=""></td>
                            <td>{{$request->dep}}</td>
                            <td>{{$request->name}}</td>
                            <td>{{$request->data}}</td>
                            <td>{{\App\RequestModel::statusToString($request->state)}}</td>
                            <td>{{$request->id}}</td>
                            <td><a href="{{route('requests.details', $request->id)}}">Open</a></td>
                        </tr>
                    @endforeach

                </table>
                {{$requests->links()}}
                {{--
                <div class="pagination">
                    <a href="#">&laquo;</a>
                    <a href="#">1</a>
                    <a href="#" class="active">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">&raquo;</a>
                </div>
                --}}
            </div>
        </div>
    </form>

@endsection