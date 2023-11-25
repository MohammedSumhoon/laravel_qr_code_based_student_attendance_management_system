<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </x-slot>
    <style>
        table {
            text-align: center;
            border: 2px solid black;
            margin-right: 20px;
        }

        a {
            text-decoration: none;
        }

        table:hover {
            color: red;
            cursor: pointer;
        }

        .box {
            margin-left: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .box:hover {
            box-shadow: 5px 10px #888888;
            margin-left: 20px;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    <div class="col">
                        <div class="card box" style="width:16rem;">
                            <img src="{{url('/images/sumhoon.jpg')}}" height="100px" width="150px" style="margin:auto">
                            <div class="card-body">
                                <h5 class="card-title">{{$name}}</h5>
                                <p class="card-text"></p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">DOB :{{$dob}}</li>
                                <li class="list-group-item">CAT-I :80%</li>
                                <li class="list-group-item">CAT-II :82%</li>
                            </ul>
                            <div class="card-body">
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <span class="badge rounded-pill bg-warning  text-dark" style="float:right">Total Earned Leaves :{{$leaveCount}}</span><br>
                        <table class="table">
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            @foreach($datas as $data)
                            @if($data->status==='Present')
                            <tr>
                                <td class="table-success">{{$data->date}}</td>
                                <td class="table-success">{{$data->status}}</td>
                            </tr>
                            @else
                            <tr>
                                <td class="table-danger">{{$data->date}}</td>
                                <td class="table-danger">{{$data->status}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>