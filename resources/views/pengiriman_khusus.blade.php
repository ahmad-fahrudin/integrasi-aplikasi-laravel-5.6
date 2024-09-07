@extends('template/nav')
@section('content')
<script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=pengaturan+kiriman+lokal+area" target="_blank">Pengiriman Lokal Area</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <b>Tambah Area Pengiriman Khusus</b>
                    <br><br>
				    <form action="{{url('simpankurirlokal')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                          <label class="col-lg-3">Provinsi</label>
                              
                                  <div class="col-md-12">
                                    <select required id="provinsis" name="provinsi" class="form-control" onchange="CProvinsi('kotas')">
                                      <option disabled selected>Pilih Provinsi</option>
                                      <?php foreach ($provinsi as $key => $value): ?>
                                      <option value="{{$value->id}}">{{$value->name}}</option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                        <br>
                          <label class="col-lg-3">Kabupaten/Kota</label>
                              
                                  <div class="col-md-12">
                                    <select name="kota"class="form-control" id="kotas" onchange="CKabupaten('kecamatans')">
                                      <option>Pilih Kabupaten/Kota</option>
                                    </select>
                                  </div>
                        <br>
                            <div class="col-md-12">
                                <center><button class="btn btn-success btn-lg">Tambahkan</button></center>
                            </div>
                    </form>
                    <br>
                    <hr>
                    <div class="table-responsive">
                        <b>Data Area Pengiriman Khusus</b>
                        <br><br>
                    <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <tr>
                            <td style="font-weight:bold">Kabupaten</td>
                            <td style="font-weight:bold">Provinsi</td>
                            <td style="font-weight:bold">Tindakan</td>
                        </tr>
                        <?php foreach($data as $key => $value){ ?>
                            <tr>
                                <td>{{$value->name}}</td>
                                <td>{{$value->nama_provinsi}}</td>
                                <td><button class="btn btn-default" onclick="Deleted('{{$value->id}}')"><i class="icon-trash"></i></button></td>
                            </tr>
                        <?php } ?>
                    </table>
                    </div>
                    <hr>
                    
                  </div>
                </div>
              </div>
            
              <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item text-muted" aria-current="page"><a href="https://stokis.app/?s=pengaturan+kiriman+lokal+area" target="_blank">Ongkir Lokal Area</a></li>
                        </ol>
                    </nav>
                  </h4>
                  <hr>
                    <b>Buat Ketentuan Biaya Ongkir</b>
                        <br>
                  <form action="{{url

                    ('simpanhargakurirlokal')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <br>
                        Ongkir Per-KG Pertama:
                        <input type="number" class="form-control" name="kilo_pertama" value="{{$harga[0]->harga}}">
                            <br>
                        Ongkir Per-KG Berikutnya:
                        <input type="number" class="form-control" name="kilo_selanjutnya" value="{{$harga[0]->harga2}}">
                            <br>
                        <center><input type="submit" class="btn btn-primary btn-lg" value="Simpan"></center>
                    </form>

            </div>
          </div>
        </div>
            </div>
            
        </div>
    </div>


        
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

      
      <script>
    function Deleted(value)
    {
      Swal.fire(
        'Delete '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deletekabupaten/')}}"+"/"+value;
        }
      });
    }

      function CProvinsi(key){
        var val = document.getElementById("provinsis").value;
        $.ajax({
             url: 'getkabupaten/'+val,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               document.getElementById(key).innerHTML = "";
               var y = document.getElementById(key);
               var options = document.createElement("option");
               options.text = "Pilih Kabupaten";
               y.add(options);
               for (var i = 0; i < response.length; i++) {
                  var x = document.getElementById(key);
                  var option = document.createElement("option");
                  option.text = response[i]['name'];
                  option.value = response[i]['id'];
                  x.add(option);
               }
             }
        });
      }
      </script>
@endsection
