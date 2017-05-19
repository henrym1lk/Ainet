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

    </style>

    <ul>
        <li><a href="{{route('requests')}}" class="active"><strong>Requests</strong></a></li>
        @if(\Illuminate\Support\Facades\Auth::user()->admin==0)
        <li><a href="{{route('requests.make')}}">Make Request</a></li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->admin==1)
            <li><a href="{{route('admin.users')}}">Users</a></li>
        @endif
        <li style="float: right"><a href="{{route('logout')}}">Logout</a></li>
    </ul>

    {{--
    <div style="
            float: right;
            width: 20%;
            font-size: 20px;">
        <b>Ordenação:</b> <select>
            <option>Crescente</option>
            <option>Decrescente</option>
        </select>
    </div>
    --}}

    {{--
    <div style="
            float:left;
            //border: 2px solid #000000;
            //border-radius: 5px;
            margin: 25px;
            overflow:auto;
            height: 400px;
            width: 20%;">
        <table style="font-size: 20px;" id="tabelaFiltros" class="table table-striped">
            <thead>
            <th>Filtros:</th>
            <th>Selecione</th>
            </thead>
            <tbody>
            <form action="">
                <tr>
                    <td>Pendente</td>
                    <td><input type="checkbox" name="concluido" value="pendente"></td>
                </tr>
                <tr>
                    <td>Concluido</td>
                    <td><input type="checkbox" name="pendente" value="concluido"></td>
                </tr>
                @for ($i=0;$i<10;$i++)
                    <tr>
                        <td>teste</td>
                        <td><input type="checkbox" name="pendente" value=""></td>
                    </tr>
                @endfor
            </form>
            </tbody>
        </table>
    </div>
    --}}


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