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
                              <li class="breadcrumb-item text-muted" aria-current="page">Kinerja Karyawan > <a href="https://stokis.app/?s=kinerja+karyawan" target="_blank">Data Kegiatan Pekerjaan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
            
            
            
            <form action="{{url('data_penilaian_kinerja')}}" method="post">
                {{csrf_field()}}
           
            <div class="row">
                <div class="col-md-2">
                    Dari
                    <input type="date" class="form-control" name="mulai" <?php if(isset($mulai)){ echo 'value="'.$mulai.'"'; }?>>
                </div>
                <div class="col-md-2">
                    Sampai
                    <input type="date" class="form-control" name="sampai" <?php if(isset($sampai)){ echo 'value="'.$sampai.'"'; }?>>
                </div>
                <div class="col-md-3">
                    Karyawan
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" readonly  style="background:#fff" placeholder="Pilih Karyawan" <?php if(isset($nama_karyawan)){ echo 'value="'.$nama_karyawan.'"'; }?>>
                            <input type="hidden" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="Pilih Karyawan" <?php if(isset($id_karyawan)){ echo 'value="'.$id_karyawan.'"'; }?>>
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CariKaryawan()"><i
                                        class="fa fa-folder"></i></button>
                            </span>
                        </div>
                    </div> 
                </div>
                <div class="col-md-3">
                    Divisi
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" readonly  style="background:#fff" placeholder="Pilih Divisi" <?php if(isset($nama_divisi)){ echo 'value="'.$nama_divisi.'"'; }?>>
                            <input type="hidden" id="id_divisi" name="id_divisi" class="form-control" placeholder="Pilih Divisi" <?php if(isset($id_divisi)){ echo 'value="'.$id_divisi.'"'; }?>>
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CariDivisi()"><i
                                        class="fa fa-folder"></i></button>
                            </span>
                        </div>
                    </div> 
                </div>
                <div class="col-md-2">
                    <br>
                    <input type="submit" class="btn btn-success" value="Filter Data">
                </div>
            </div>
            </form>
            
            </div>
                        <hr><br>
            
            
            
            <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No. Job</th>
                            <th>Tanggal</th>
                            <th hidden>No. ID Karyawan</th>
                            <th>Nama Karyawan</th>
                            <th>Divisi</th>
                            <th>Nama Pekerjaan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Target Perjam</th>
                            <th>Jam Kerja (Jam)</th>
                            <th>Jam Kerja (Menit)</th>
                            <th>Target</th>
                            <th>Realisasi</th>
                            <th>Prosentase Realisasi</th>
                            <th>Kategori Kerja</th>
                            <th>Supervisor</th>
                            <?php if (Auth::user()->level == "1"): ?>
                            <th>Tindakan</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ ?>
                            <tr>
                                <td>{{$value->no_job}}</td>
                                <td>{{$value->tanggal}}</td>
                                <td hidden>{{$value->id_karyawan}}</td>
                                <td>{{$karyawan[$value->id_karyawan]->nama}}</td>
                                <td>{{$divisi[$value->divisi]->nama_divisi}}</td>
                                <td>{{$pekerja[$value->nama_pekerjaan]->nama_pekerjaan}}</td>
                                <td class="text-right">{{ribuan($value->jumlah)}}</td>
                                <td class="text-right">{{$pekerja[$value->nama_pekerjaan]->satuan}}</td>
                                <td class="text-right">{{$pekerja[$value->nama_pekerjaan]->target}}</td>
                                <td class="text-right">{{floor($value->jam_kerja)}}</td>
                                <td class="text-right">{{floor(($value->jam_kerja - floor($value->jam_kerja)) * 60)}}</td>
                                <td class="text-right">
                                    <?php if(($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja) > 0){ ?>
                                    {{ribuan($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja)}}
                                    <?}else{?>
                                         0
                                    <?php } ?>
                                    </td>
                                <td class="text-right">{{ribuan($value->jumlah)}}</td>
                                <td class="text-right">
                                    <?php if(($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja) > 0){ ?>
                                    {{round($value->jumlah/($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja)*100,2)}}
                                    <?}else{?>
                                         0
                                    <?php } ?>
                                </td>
                                <td>{{$value->kategori_kerja}}</td>
                                <td>{{$supervisor[$value->supervisor]->name}}</td>
                                <?php if (Auth::user()->level == "1"): ?>
                                <td>
                                    <a class="btn btn-default" href="{{url('/edit_kinerja_karyawan/'.$value->no_job)}}"><i class="icon-pencil"></i></a>
                                    <button class="btn btn-default" onclick="Deleted('{{$pekerja[$value->nama_pekerjaan]->nama_pekerjaan}}','{{$value->id_p}}')"><i class="icon-trash"></i></button>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                
                
            </div>
        </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="capmi" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $key => $value){ ?>
                        <tr onclick="Pilih('{{$value->id}}','{{$value->nama}}','{{$value->id_divisi}}','{{$value->alamat}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
             </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    <div class="modal fade" id="pkrj" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No ID</th>
                            <th>Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($divisi as $key => $value){ ?>
                        <tr onclick="PilihDivisi('{{$value->id_divisi}}','{{$value->nama_divisi}}')">
                            <td>{{$value->id_divisi}}</td>
                            <td>{{$value->nama_divisi}}</td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


<script>
function CariKaryawan() {
    $('#capmi').modal('show');
}

function CariDivisi() {
    $('#pkrj').modal('show');
}

function Pilih(id_karyawan, nama_karyawan, id_divisi, alamat_karyawan) {
    document.getElementById("id_karyawan").value = id_karyawan;
    document.getElementById("nama_karyawan").value = nama_karyawan;
    $('#capmi').modal('hide');
}

function PilihDivisi(id_divisi, nama_divisi) {
    document.getElementById("id_divisi").value = id_divisi;
    document.getElementById("nama_divisi").value = nama_divisi;
    $('#pkrj').modal('hide');
}

function Deleted(nama,id) {
    Swal.fire({
        title: "Delete " + nama,
        text: 'Tindakan ini tidak bisa dibatalkan ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "{{url('delete_penilaian_kinerja')}}/" + id_p;
        }
    })
}
</script>
@endsection