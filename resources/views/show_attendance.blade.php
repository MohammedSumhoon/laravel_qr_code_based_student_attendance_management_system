<html>
<x-app-layout>

    <head>
        <title>Attendance Status</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <style>
            body {
                background: #f7f7f7;
            }

            .table {
                border-spacing: 0 0.85rem !important;
            }

            .table .dropdown {
                display: inline-block;
            }

            .table td,
            .table th {
                vertical-align: middle;
                margin-bottom: 10px;
                border: none;
            }

            .table thead tr,
            .table thead th {
                border: none;
                font-size: 12px;
                letter-spacing: 1px;
                text-transform: uppercase;
                background: transparent;
            }

            .table td {
                background: #fff;
            }

            .table td:first-child {
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
            }

            .table td:last-child {
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
            }

            .avatar {
                width: 2.75rem;
                height: 2.75rem;
                line-height: 3rem;
                border-radius: 50%;
                display: inline-block;
                background: transparent;
                position: relative;
                text-align: center;
                color: #868e96;
                font-weight: 700;
                vertical-align: bottom;
                font-size: 1rem;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            .avatar-sm {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 0.83333rem;
                line-height: 1.5;
            }

            .avatar-img {
                width: 100%;
                height: 100%;
                -o-object-fit: cover;
                object-fit: cover;
            }

            .avatar-blue {
                background-color: #c8d9f1;
                color: #467fcf;
            }

            table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before,
            table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
                top: 28px;
                left: 14px;
                border: none;
                box-shadow: none;
            }

            table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child,
            table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child {
                padding-left: 48px;
            }

            table.dataTable>tbody>tr.child ul.dtr-details {
                width: 100%;
            }

            table.dataTable>tbody>tr.child span.dtr-title {
                min-width: 50%;
            }

            table.dataTable.dtr-inline.collapsed>tbody>tr>td.child,
            table.dataTable.dtr-inline.collapsed>tbody>tr>th.child,
            table.dataTable.dtr-inline.collapsed>tbody>tr>td.dataTables_empty {
                padding: 0.75rem 1rem 0.125rem;
            }

            div.dataTables_wrapper div.dataTables_length label,
            div.dataTables_wrapper div.dataTables_filter label {
                margin-bottom: 0;
            }

            @media (max-width: 767px) {
                div.dataTables_wrapper div.dataTables_paginate ul.pagination {
                    -ms-flex-pack: center !important;
                    justify-content: center !important;
                    margin-top: 1rem;
                }
            }

            .btn-icon {
                background: #fff;
            }

            .btn-icon .bx {
                font-size: 20px;
            }

            .btn .bx {
                vertical-align: middle;
                font-size: 20px;
            }

            .dropdown-menu {
                padding: 0.25rem 0;
            }

            .dropdown-item {
                padding: 0.5rem 1rem;
            }

            .badge {
                padding: 0.5em 0.75em;
            }

            .badge-success-alt {
                background-color: #d7f2c2;
                color: #7bd235;
            }

            .table a {
                color: #212529;
            }

            .table a:hover,
            .table a:focus {
                text-decoration: none;
            }

            table.dataTable {
                margin-top: 12px !important;
            }

            .icon>.bx {
                display: block;
                min-width: 1.5em;
                min-height: 1.5em;
                text-align: center;
                font-size: 1.0625rem;
            }

            .btn {
                font-size: 0.9375rem;
                font-weight: 500;
                padding: 0.5rem 0.75rem;
            }

            .avatar-blue {
                background-color: #c8d9f1;
                color: #467fcf;
            }

            .avatar-pink {
                background-color: #fcd3e1;
                color: #f66d9b;
            }
            
            a {
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row py-5">
                <div class="col-12">
                    <a class="btn btn-primary" href="{{url('exportExcel')}}" style="float:right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Get as Excel</a><br>
                    <pre>                                                       </pre>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    <table id="example" class="table table-hover responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Student Name</th>
                                <th>Status</th>
                                <th>Present at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            @foreach($attendanceStatus as $status)
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>{{$status->student_name}}</td>
                                <td>
                                    @if($status->status==='Absent')
                                    <div class="badge bg-danger">{{$status->status}}</div>
                                    @else
                                    <span class="badge bg-success">{{$status->status}}</span>
                                    @endif
                                </td>
                                <td>{{$status->date}}</td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#example").DataTable({
                    aaSorting: [],
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });

                $(".dataTables_filter input")
                    .attr("placeholder", "Search here...")
                    .css({
                        width: "300px",
                        display: "inline-block"
                    });
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</x-app-layout>

</html>