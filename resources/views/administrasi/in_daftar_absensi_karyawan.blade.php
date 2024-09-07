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
                              <li class="breadcrumb-item text-muted" aria-current="page">Absensi > <a href="https://stokis.app/?s=absensi" target="_blank">Daftar Absensi Karyawan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">            
            <p><strong>Filter Berdasarkan</strong></p>
            <form action="{{url('daftar_absensi_karyawan')}}" method="post">
                {{csrf_field()}}
             
            <div class="row">
                <div class="col-md-4">
                    Dari Tanggal
                    <input type="date" class="form-control" name="mulai" <?php if(isset($mulai)){ echo 'value="'.$mulai.'"'; }?>>
                </div>
                <div class="col-md-4">
                    Sampai Tanggal
                    <input type="date" class="form-control" name="sampai" <?php if(isset($sampai)){ echo 'value="'.$sampai.'"'; }?>>
                </div>
                <div class="col-md-4">
                    <br>
                    <input type="submit" class="btn btn-success" value="FILTER">
                </div>
            </div>
            </form>
            </div>
                    <hr>
                    <div class="table-responsive">
                <table id="prc" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr><th>Tanggal</th>
                            <th hidden>ID Karyawan</th>
                            <th>Nama</th>
                            
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ 
                        if(isset($value->status_kehadiran) && $value->status_kehadiran == "hadir"){ ?>
                            <tr><td>{{$value->tanggal_hadir}}</td>
                                <td hidden>{{$value->id_karyawan}}</td>
                                <td>{{$karyawan[$value->id_karyawan]->nama}}</td>
                                
                                <td>{{$value->jam_masuk}}</td>
                                <td>{{$value->jam_pulang}}</td>
                                <td>{{$value->keterangan}}</td>
                            </tr>
                        <?php }else{ ?>
                            <tr><td>{{$value->tanggal_tidak_hadir}}</td>
                                <td hidden>{{$value->id_karyawan}}</td>
                                <td>{{$karyawan[$value->id_karyawan]->nama}}</td>
                                
                                <td>Tidak Hadir</td>
                                <td></td>
                                <td>{{$value->keterangan}}</td>
                            </tr>
                        <?php } $no++; } ?>
                    </tbody>
                </table>
                
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection