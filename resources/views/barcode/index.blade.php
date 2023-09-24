<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode</title>
</head>

<body>
    <img src="{{ DNS1D::getBarcodePNG($id, 'C128', 3, 33, [1, 1, 1], true) }}" alt="barcode" />
    {{-- {!! DNS1D::getBarcodeHTML($id, 'C128', 1.4, 22) !!} --}}
</body>

</html>
