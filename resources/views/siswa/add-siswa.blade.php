<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

  <form action="/siswa/store" method="POST">
    @csrf
    <input type="text" name="nis" required="required"> NIS <br/>
    <input type="text" name="nama" required="required"> Nama <br/>
    <input type="text" name="alamat" required="required"> Alamat <br/>
    <input type="text" name="telepon" required="required"> No Telp <br/>
    <input type="text" name="jenis_kelamin" required="required"> Jenis Kelamin <br/>
    <input type="text" name="foto" required="required"> foto <br/>
    <input type="text" name="agama" required="required"> Agama<br/>
    <input type="text" name="email" required="required"> Email <br/>
    <input type="text" name="password" required="required"> Password <br/>
    {{-- select nama kelas beserta tingkat kelasnya--}}
    <select name="nama_kelas" id="nama_kelas">
      @foreach ($kelas as $kls)
        <option value="{{ $kls->kode_kelas }}">{{ $kls->tingkat->nama_tingkat ." ".$kls->nama_kelas }}</option>
      @endforeach
    </select>

    <br/>
    


    <input type="submit" value="Simpan Data">

  </form>

</body>
</html>