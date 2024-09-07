@extends('template/nav')
@section('content')
  <script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Poin Hadiah > <a href="https://stokis.app/?s=tukar+poin+hadiah" target="_blank">Tukar Poin</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <center><b>Tukar Poin Pending</b><br>(Menunggu verifikasi dari admin)</center>
                    <div class="table-responsive">
                    <table id="examples" class="table table-striped table-bordered no-wrap" style="width:99%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Alamat</th>
                                <th>NO HP</th>
                                <th>Nama Hadiah</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no=1; foreach ($penukaranpoin as $key => $value): ?>
                            <tr>
                              <td>{{$no}}</td>
                              <td>{{$konsumen[$value->id_konsumen]->nama_pemilik}}</td>
                              <td><?=$konsumen[$value->id_konsumen]->alamat?>Kec.{{$data_kecamatan[$konsumen[$value->id_konsumen]->kecamatan]}}, Kab/Kota.{{$data_kabupaten[$konsumen[$value->id_konsumen]->kota]}}, Provinsi {{$data_provinsi[$konsumen[$value->id_konsumen]->provinsi]}}</td>
                              <td>{{$konsumen[$value->id_konsumen]->no_hp}}</td>
                              <td>{{$hadiah[$value->id_hadiah]->nama}}</td>
                              <td>
                                <button class="btn btn-primary" onclick="Verifikasi('{{$value->id}}')">Verifikasi</button>
                                <button class="btn btn-danger" onclick="Batalkan('{{$value->id}}')">Batal</button>
                              </td>
                            </tr>
                          <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
  								</div>
                  <br><hr><br>
                  <center><h2>Riwayat Tukar Poin</h2>(Selesai)</center>
                  <div class="table-responsive">
                  <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:99%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Member</th>
                              <th>Alamat</th>
                              <th>No. HP</th>
                              <th>Nama Hadiah</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; foreach ($selesai as $key => $value): ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td>{{$konsumen[$value->id_konsumen]->nama_pemilik}}</td>
                            <td><?=$konsumen[$value->id_konsumen]->alamat?>Kec.{{$data_kecamatan[$konsumen[$value->id_konsumen]->kecamatan]}}, Kab/Kota.{{$data_kabupaten[$konsumen[$value->id_konsumen]->kota]}}, Provinsi {{$data_provinsi[$konsumen[$value->id_konsumen]->provinsi]}}</td>
                            <td>{{$konsumen[$value->id_konsumen]->no_hp}}</td>
                            <td>{{$hadiah[$value->id_hadiah]->nama}}</td>
                            <td>Selesai</td>
                          </tr>
                        <?php $no++; endforeach; ?>
                      </tbody>
                  </table>
                </div>

                <br><hr><br>
                <center hidden><h2>Tukar Poin Batal</h2></center>
                <div hidden class="table-responsive">
                <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:99%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Member</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Nama Hadiah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach ($batal as $key => $value): ?>
                        <tr>
                          <td>{{$no}}</td>
                          <td>{{$konsumen[$value->id_konsumen]->nama_pemilik}}</td>
                          <td><?=$konsumen[$value->id_konsumen]->alamat?>Kec.{{$data_kecamatan[$konsumen[$value->id_konsumen]->kecamatan]}}, Kab/Kota.{{$data_kabupaten[$konsumen[$value->id_konsumen]->kota]}}, Provinsi {{$data_provinsi[$konsumen[$value->id_konsumen]->provinsi]}}</td>
                          <td>{{$konsumen[$value->id_konsumen]->no_hp}}</td>
                          <td>{{$hadiah[$value->id_hadiah]->nama}}</td>
                          <td>Selesai</td>
                        </tr>
                      <?php $no++; endforeach; ?>
                    </tbody>
                </table>
              </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <form action="{{url('/updatehadiah')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            Nama Hadiah<br><input type="text" id="nama" name="nama" class="form-control">
            Jumlah Poin<br><input type="text" id="jumlahpoin" name="jumlah_poin" class="form-control">
            <input type="hidden" name="id" id="id">
            Gambar<br><input type="file" name="gbr"><br>
            <input type="submit" value="Update" class="form-control btn-success">
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function Verifikasi(id){
      Swal.fire(
        'Verifikasi  ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/verifikasihadiah/')}}/"+id;
        }
      });
    }
    function Batalkan(id){
      Swal.fire(
        'Verifikasi  ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/batalhadiah/')}}/"+id;
        }
      });
    }
    </script>
@endsection
