<html>

<head>
    <style>
        .box {
            border: 1px solid black;
            padding: 20px;
            width: 200px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="box">
        {{QrCode::size(200)->backgroundColor(255,255,255)->generate($studentData);}}
    </div>
</body>

</html>