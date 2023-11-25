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
    <table>
        <tr>
            <th><b>Student Name</b></th>
            <td>{{$name}}</td>
        </tr>
        <tr>
            <th><b>Reason :</b></th>
            <td>{{$reason}}</td>
        </tr>
    </table>
        Thanks,
        {{ config('app.name') }}
        @endcomponent
</body>

</html>