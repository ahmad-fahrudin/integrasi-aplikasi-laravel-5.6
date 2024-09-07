@extends('template/nav')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Projek Pengadaan Barang > <a href="https://stokis.app/?s=posting+projek+pengadaan+barang" target="_blank">Posting Projek</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
					<div class="table-responsive">
                  <!--select onchange="ubah()" id="selecting" class="form-control col-md-2">
                    <option value="sebagian">Sebagian</option>
                    <option value="semua">Semua Barang</option>
                  </select-->
                  
                  <form action="{{url('simpanpengadaanbaru')}}" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Pengadaan</th>
                              <th>Pembiayaan</th>
                              <th>Bagi Hasil</th>
                              <th>Estimasi Waktu</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($pengadaan as $value) {
                          if($value->jumlah_kulakan > 0){
                          ?>
                          <tr>
                              <input type="hidden" name="id_barang{{$no}}" id="id_barang{{$no}}" disabled value="{{$value->id_barang}}">
                              <td>{{$no}}</td>
                              <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td><input type="hidden" name="jumlah_kulakan{{$no}}" id="jumlah_kulakan{{$no}}" readonly disabled value="{{$value->jumlah_kulakan}}">{{ribuan($value->jumlah_kulakan)}}</td>
                              <td><input type="hidden" name="jumlah_investasi{{$no}}" id="jumlah_investasi{{$no}}" readonly disabled value="{{$value->jumlah_investasi}}">{{ribuan($value->jumlah_investasi)}}</td>
                              <?php if ($value->estimasi_pendapatan < 0){
                                $value->estimasi_pendapatan = 0;
                              } ?>
                              <td><input type="hidden" name="estimasi_pendapatan{{$no}}" id="estimasi_pendapatan{{$no}}" disabled readonly value="{{$value->estimasi_pendapatan}}">
                                {{ribuan($value->estimasi_pendapatan)}}
                              </td>
                              <td><input type="number" name="estimasi_waktu{{$no}}" id="estimasi_waktu{{$no}}" disabled value="20"></td>
                              <td>
                                <input type="checkbox" onchange="cek({{$no}})" name="cek{{$no}}" style="width:20px;height:20px;" id="cek{{$no}}">&emsp;
                                <button type="button" onclick="deletebarangbaru({{$value->id}},'{{$barang[$value->id_barang]['nama_barang']}}')" class="btn btn-default"><i class="icon-trash"></i></button>
                              </td>
                          </tr>
                        <?php $no++; } } ?>
                        <input type="text" name="loop" readonly style="visibility:hidden;" value="{{$no}}">
                      </tbody>
                  </table>
                  <hr>
                  <center><input type="submit" value="Buat Projek Pengadaan Barang" class="btn btn-primary btn-lg"></center>
                  <br><br>
                </form>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function ubah(){
      var val = document.getElementById("selecting").value;
      var loop = <?=$no ?>;
      if (val == "semua") {
        for (var i = 1; i < loop; i++) {
          document.getElementById("cek"+i).checked = true;
        }
      }else{
        for (var i = 1; i < loop; i++) {
          document.getElementById("cek"+i).checked = false;
        }
      }
    }

    function deletebarangbaru(id,namabarang){
      Swal.fire(
        'Delete '+namabarang+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deletepengadaanbarangbaru/')}}/"+id;
        }
      });
    }

    function cek(id){
      var check = document.getElementById("cek"+id);
      if (check.checked == true) {
        document.getElementById("id_barang"+id).disabled = false;
        document.getElementById("jumlah_kulakan"+id).disabled = false;
        document.getElementById("jumlah_investasi"+id).disabled = false;
        document.getElementById("estimasi_pendapatan"+id).disabled = false;
        document.getElementById("estimasi_waktu"+id).disabled = false;
      }else{
        document.getElementById("id_barang"+id).disabled = true;
        document.getElementById("jumlah_kulakan"+id).disabled = true;
        document.getElementById("jumlah_investasi"+id).disabled = true;
        document.getElementById("estimasi_pendapatan"+id).disabled = true;
        document.getElementById("estimasi_waktu"+id).disabled = true;
      }
    }


    </script>
@endsection
