<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode</title>
</head>
<style>
    @media print {
        .noPrint {
            display: none;
        }
    }
</style>

<body style="display: flex; flex-direction: column; row-gap: 10px">
    {!! $image !!}
    <button style="width: 100px" onclick="window.print()" class="noPrint">In barcode</button>
</body>

</html>
