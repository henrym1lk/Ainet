@extends('master')

@section('title', 'Request Details')

@section('content')

    <style>

        #mainLeft {
            width: 50%;
            height: 700px;
            float: left;
        }

        #stars {
            margin-left: 5%;
            display: inline;
        }

        #mainRight {
            width: 50%;
            height: 700px;
            float: left;

        }

        #descricao {
            padding: 1%;
            margin: 2%;
            width: 70%;
            height: 300px;
            background-color: grey;
        }

        #comentarios {
            float: right;
            margin-top: 2%;
            margin-right: 5%;
            width: 90%;
            height: 40%;
            overflow: scroll;
        }

        #comentario {
            float: right;
            margin-top: 2%;
            margin-right: 5%;
            margin-bottom: 2%;
            width: 90%;
            height: 10%;
        }

        {{--
        #classificacao {

            margin-left: 10%;
            width: 50%;
            height: 100px;

        }

        #star, #nostar {
            height: 100%;
            width: 20%;
            float: left;
        }
        --}}

        #buttoncomment {
            width: 20%;
            margin-right: 5%;
            float: right;
            background-color: #FF0000;
            color: white;
        }

        #tabelaComentarios {
            width: 100%;
            height: 200px;
            overflow: auto;
        }

        .answer {
            color: red;
        }

    </style>

    <ul>
        <li><a href="{{route('requests')}}" class="active"><strong>Return</strong></a></li>
        <li style="float: right"><a href="{{route('logout')}}">Logout</a></li>
    </ul>

    @if(\Illuminate\Support\Facades\Auth::user()->admin == 1 || \Illuminate\Support\Facades\Auth::user()->id == $data->owner_id)

        <div id="mainLeft">
            <div id="descricao">

                <p>Description: {{$data->description}}</p>
                <p>Date: {{$data->open_date}}</p>
                <p>Colored: {{\App\RequestModel::booleanToString($data->colored)}}</p>
                <p>Front/Back: {{\App\RequestModel::booleanToString($data->front_back)}}</p>
                <p>Stapled: {{\App\RequestModel::booleanToString($data->stapled)}}</p>
                <p>Paper Size: {{$data->paper_size}}</p>
                <p>Paper Type: {{$data->paper_type}}</p>
                <p>Status: {{\App\RequestModel::statusToString($data->status)}}</p>

            </div>

            @if($data->status == 1)

                <form action="{{route('requests.rate', $request_id)}}" id="stars" method="post">
                    {{ csrf_field() }}
                    Rate 1-3 stars:
                    <input type="radio" name="rating" value="1" onclick="this.form.submit()"> 1
                    <input type="radio" name="rating" value="2" onclick="this.form.submit()"> 2
                    <input type="radio" name="rating" value="3" onclick="this.form.submit()"> 3
                </form>

            @endif

            @if($data->status == 0 && \Illuminate\Support\Facades\Auth::user()->id == $data->owner_id)

                <a class="btn btn-danger" href="{{route('requests.delete', $request_id)}}" name="request_id">Delete</a>

            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                @if($data->status == 0 && is_null($data->refused_reason))

                    <form action="{{route('requests.print', $request_id)}}" id="stars" method="post">
                        {{ csrf_field() }}
                        Printed with:
                        <select name="printer">
                            @foreach(\App\PrinterModel::all() as $printer)
                                <option value="{{$printer->id}}">{{$printer->name}}</option>
                            @endforeach
                        </select>
                        <button type="submit">PrintIT!</button>
                    </form>

                    <form action="{{route('requests.refuse', $request_id)}}" method="post">
                        {{ csrf_field() }}
                        <div id="comentario">
                            <textarea required name="reason" style="height: 100%; width: 100%"></textarea>
                        </div>
                        <button id="buttoncomment" class="btn" type="submit">Refuse</button>
                    </form>

                @endif
            @endif

            {{--
            <div id="classificacao">
                <div id="star">
                    <img src="http://www.clipartkid.com/images/2/gold-star-clipart-no-background-clipart-panda-free-clipart-images-HxcUfZ-clipart.jpeg"
                         height="100%">
                </div>
                <div id="star">
                    <img src="http://www.clipartkid.com/images/2/gold-star-clipart-no-background-clipart-panda-free-clipart-images-HxcUfZ-clipart.jpeg"
                         height="100%">
                </div>
                <div id="star">
                    <img src="http://www.clipartkid.com/images/2/gold-star-clipart-no-background-clipart-panda-free-clipart-images-HxcUfZ-clipart.jpeg"
                         height="100%">
                </div>
                <div id="star">
                    <img src="http://www.clipartkid.com/images/2/gold-star-clipart-no-background-clipart-panda-free-clipart-images-HxcUfZ-clipart.jpeg"
                         height="100%">
                </div>
                <div id="nostar">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/18/Five-pointed_star.svg/1088px-Five-pointed_star.svg.png "
                         height="100%">
                </div>


            </div>
            --}}

        </div>

    @endif

    <div id="mainRight">

        <form action="{{route('requests.comment', $request_id)}}" method="post">
            {{ csrf_field() }}
            <div id="comentarios">
                <table id="tabelaComentarios" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Comments</th>
                        @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                            <th>Block</th>
                        @else
                            <th>Report</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                            <th>Report Count</th>
                        @endif
                        <th>Answer</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($comments as $comment)
                        <tr>
                            <td>{{$comment->comment}}</td>
                            <td>
                                @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                                    <a href="{{route('comment.block', ['request_id' => $request_id, 'comment_id' => $comment->id])}}">Block</a>
                                @else
                                    <a href="{{route('comment.report', ['request_id' => $request_id, 'comment_id' => $comment->id])}}">Report</a>
                                @endif
                            </td>
                            @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                                <td>{{$comment->reports}}</td>
                            @endif
                            <td>
                                <button class="btn" type="submit" name="answerTo" value="{{$comment->id}}" onclick="">Comment
                                </button>
                            </td>
                        </tr>
                        @foreach($commentsToComments as $subComment)
                            @if($subComment->parent_id == $comment->id)
                                <tr class="answer">
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subComment->comment}}</td>
                                    <td>
                                        @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                                            <a href="{{route('comment.block', ['request_id' => $request_id, 'comment_id' => $subComment->id])}}">Block</a>
                                        @else
                                            <a href="{{route('comment.report', ['request_id' => $request_id, 'comment_id' => $subComment->id])}}">Report</a>
                                        @endif
                                    </td>
                                    @if(\Illuminate\Support\Facades\Auth::user()->admin == 1)
                                        <td>{{$subComment->reports}}</td>
                                    @endif
                                    <td>
                                        <button class="btn" type="submit" name="answerTo" value="{{$comment->id}}">Comment</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach


                    </tbody>
                </table>

            </div>

            <div id="comentario">
                <textarea required name="comment" style="height: 100%; width: 100%"></textarea>
            </div>
            <button id="buttoncomment" class="btn" type="submit">Comment</button>
        </form>


    </div>



@endsection