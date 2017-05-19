@extends('master')

@section('title', 'Statistics')

@section('content')

    <style>
        .stats{
            width: 800px;
            border: 2px solid crimson;
            border-radius: 5px;
            margin-left: 100px;
            margin-bottom: 15px;
            padding: 5px;
            display: block;
            float: left;
            text-align: center;
            font-size: 30px
        }
    </style>

    <ul>
        <li><a href="{{route('index')}}"><strong>Home</strong></a></li>
        <li><a href="{{route('stats')}}" class="active">Statistics</a></li>
        <li><a href="{{route('contacts')}}">Contacts</a></li>
    </ul>

    <div style="
    width: 300px;
    border: 2px solid crimson;
    border-radius: 5px;
    margin-left: 40px;
    margin-bottom: 15px;
    padding: 5px;
    display: block;
    float: left;
    height: 400px;
    overflow: scroll;
    text-align: center;">
        <p style="font-size: 30px">Total Prints for Department</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Departamento</th>
                <th>Total Impressões</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deps as $dep)
                <tr>
                    <td><a href="{{route('stats.dep', $dep->id)}}">{{$dep->name}}</a></td>
                    <td>{{$dep->total}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="stats">
        <p style="font-size: 40px">Various Statistics</p>
        <p>Nº total de impressões: {{$totalImp}}</p>
        <p>Percentagem de impressões a cor vs preto e branco: {{$percCor}}/{{$percPeB}}</p>
        <p>Nº de impressões do dia de hoje: {{$totalHj}}</p>
        <p>Média diária de impressões no mês atual: {{$mediaMes}}</p>
    </div>

@endsection