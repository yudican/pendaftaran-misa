<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Daftar Barcode</title>
</head>

<body>
  <table width="100%">
    <tbody>
      <tr>
        <td>Nama</td>
        <td>QRCode</td>
      </tr>
      @foreach ($pendaftarans as $pendaftaran)
      <tr>
        <td>{{$pendaftaran->user->name}}</td>
        <td>
          <br>
          <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($pendaftaran->id)) !!} ">
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>