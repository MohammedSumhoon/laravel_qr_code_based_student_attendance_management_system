<html>
<head>
    <style>
        table,
        th,
        td,
        tr {
            border: 1px solid yellow;
            font-size: 18px;
            color:white;
        }
    </style>
</head>
<body>
    @component('mail::message')
    Hi {{$name}} ,your login username and password,
    <table>
        <tr>
            <th><b>username</b></th>
            <td>{{$username}}</td>
        </tr>
        <tr>
            <th><b>Password</b></th>
            <td>{{$password}}</td>
        </tr>
    </table>
        Thanks,
        {{ config('app.name') }}
        @endcomponent
</body>
</html>