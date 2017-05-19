@extends('master')

@section('title', 'Contacts')

@section('content')

    <ul>
        <li><a href="{{route('index')}}"><strong>Home</strong></a></li>
        <li><a href="{{route('stats')}}">Statistics</a></li>
        <li><a href="{{route('contacts')}}" class="active">Contacts</a></li>
    </ul>




    <form action="{{route('contacts.filter')}}" method="get" class="form-group" style="">
        <div style="margin-top: 1%; margin-bottom: 5%">
            <div style="width: 15%; float: left; margin-left: 5%">
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

                <button type="submit" class="btn btn-primary" name="filterBtn">Filter</button>

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

                <div style="
    width: 90%;
    margin-left: 40px;
    margin-bottom: 15px;
    padding: 5px;
    display: block;
    height: 400px;
    float: right;
    overflow: auto;
    ">



                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{route('user.profile', $user->profile_url, $user->id)}}">{{$user->name}}</a>
                                </td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </form>


@endsection