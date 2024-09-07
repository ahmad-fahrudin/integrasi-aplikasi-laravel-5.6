@extends('template/nav')
@section('content')
<?php 
    $variabel_upah = variableupah();
    $variableupahborongan = variableupahborongan();
?>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Perhitungan Upah > <a href="https://stokis.id/?s=data+perhitungan+upah" target="_blank">Data Perhitungan Upah</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
            <div class="form-group">
            <form action="{{url('data_perhitungan_upah')}}" method="post">
                {{csrf_field()}}
            <strong>Filter Berdasarkan:</strong>
            <div class="row">
                <div class="col-md-3">
                    Dari Tanggal
                    <input type="date" class="form-control" name="mulai" <?php if(isset($mulai)){ echo 'value="'.$mulai.'"'; }?>>
                </div>
                <br>
                <div class="col-md-3">
                    Sampai Tanggal
                    <input type="date" class="form-control" name="sampai" <?php if(isset($sampai)){ echo 'value="'.$sampai.'"'; }?>>
                </div>
                <br>
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
                <br>
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
                <br>
                <div class="col-md-3">
                    Status Penggajian
                    <select name="status_penggajian" class="form-control" id="status_penggajian">
                        <option <?php if(isset($status_penggajian) && $status_penggajian == "Harian"){ echo 'selected'; }?>>Harian</option>
                        <option <?php if(isset($status_penggajian) && $status_penggajian == "Borongan"){ echo 'selected'; }?>>Borongan</option>
                        <option <?php if(isset($status_penggajian) && $status_penggajian == "Perubahan BH-HB"){ echo 'selected'; }?>>Perubahan BH-HB</option>
                        <option <?php if(isset($status_penggajian) && $status_penggajian == "Peralihan 1"){ echo 'selected'; }?>>Peralihan 1</option>
                        <option <?php if(isset($status_penggajian) && $status_penggajian == "Peralihan 2"){ echo 'selected'; }?>>Peralihan 2</option>
                    </select>
                </div>
                <br>
                <div class="col-md-3">
                    Status Pembayaran
                    <select name="status_pembayaran" class="form-control" id="status_pembayaran">
                        <option <?php if(isset($status_pembayaran) && $status_pembayaran == "Proses"){ echo 'selected'; }?>>Proses</option>
                        <option <?php if(isset($status_pembayaran) && $status_pembayaran == "Pending"){ echo 'selected'; }?>>Pending</option>
                        <option <?php if(isset($status_pembayaran) && $status_pembayaran == "Terbayar"){ echo 'selected'; }?>>Terbayar</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <br>
                    <input type="submit" class="btn btn-success" value="Filter Data">
                </div>
            </div>
            </form>
            </div>
            </div>
            <hr><br>
             	<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No. ID Upah</th>	
                            <th>Status Penggajian</th>	
                            <th>No. Job</th>	
                            <th>Tanggal</th>	
                            <th>No. ID Karyawan</th>
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
                            <th>Harga Satuan</th>	
                            <th>Jumlah Upah</th>
                            <th>MF (7.5%)</th>
                            <th>Kategori Kerja</th>	
                            <th>Supervisor</th>	
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $value)
                        @if(isset($pekerja[$value->nama_pekerjaan]))
                        <tr>
                            <td>{{$value->no_id_upah}}</td>
                            <td>{{$value->status_penggajian}}</td>
                            <td>{{$value->no_job}}</td>
                            <td>{{$value->tanggal}}</td>
                            <td  class="text-center">{{$value->no_id_karyawan}}</td>
                            <td>
                                <?php if(isset($karyawan[$value->no_id_karyawan])){ ?>
                                    {{$karyawan[$value->no_id_karyawan]->nama_karyawan}}
                                <?php } ?>
                            </td>
                            <td>
                                <?php if(isset($divisi[$value->divisi])){ ?>
                                    {{$divisi[$value->divisi]->nama_divisi}}
                                <?php } ?>
                            </td>
                            <td>
                                <?php if(isset($pekerja[$value->nama_pekerjaan])){ ?>
                                    {{$pekerja[$value->nama_pekerjaan]->nama_pekerjaan}}
                                <?php } ?>
                            </td>
                            <td class="text-right">{{ribuan($value->jumlah)}}</td>
                            <td class="text-center">
                                <?php if(isset($pekerja[$value->nama_pekerjaan])){ ?>
                                    {{$pekerja[$value->nama_pekerjaan]->satuan}}
                                <?php } ?>
                            </td>
                            <td class="text-right">
                                <?php if(isset($pekerja[$value->nama_pekerjaan])){ ?>
                                    {{$pekerja[$value->nama_pekerjaan]->target}}
                                <?php } ?>
                            </td>
                            <td class="text-right">{{floor($value->jam_kerja)}}</td>
                            <td class="text-right">{{($value->jam_kerja - floor($value->jam_kerja))*60}}</td>
                            <td class="text-right">
                                <?php if(($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja) > 0){ ?>
                                <?php if(isset($pekerja[$value->nama_pekerjaan])){ ?>
                                    {{ribuan($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja)}}
                                <?php } ?>
                                <?}else{?>
                                    0
                                <?php } ?>
                            </td>
                            <td class="text-right">{{ribuan($value->jumlah)}}</td>
                            <td class="text-right">
                                <?php if( ($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja) >0 ) { ?>
                                {{round($value->jumlah/($pekerja[$value->nama_pekerjaan]->target * $value->jam_kerja)*100,2)}}
                                <?}else{?>
                                    0
                                <?php } ?>
                            </td>
                            <td class="text-right">
                                @if($value->status_penggajian == "Borongan")
                                    <?php 
                                    if(isset($value->status_penggajian) && isset($value->nama_pekerjaan) && isset($variableupahborongan[strtolower($value->status_penggajian)]) && isset($variableupahborongan[strtolower($value->status_penggajian)][$value->nama_pekerjaan]) ){
                                        $vup = $variableupahborongan[strtolower($value->status_penggajian)][$value->nama_pekerjaan];
                                    }else{
                                        $vup = 0;
                                    } ?>
                                    {{ribuan($vup)}}
                                @else
                                    <?php 
                                    if(isset($value->status_penggajian) && isset($value->kategori_kerja) && isset($variabel_upah[strtolower($value->status_penggajian)]) && isset($variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja])){
                                        $vup = $variabel_upah[strtolower($value->status_penggajian)][$value->kategori_kerja];
                                    }else{
                                        $vup = 0;
                                    }
                                    ?>
                                    {{ribuan($vup)}}
                                @endif
                            </td>
                            <td class="text-right">
                                <?php if($value->status_penggajian == "Borongan"){
                                    if($value->kategori_kerja == "Shift 2"){
                                        echo ribuan(($value->jumlah * $vup) + 2000);
                                    }else{
                                        echo ribuan($value->jumlah * $vup);
                                    }
                                }else{
                                    echo ribuan($value->jam_kerja * $vup);
                                } ?>
                            </td>
                            <td class="text-right">
                             <?php if($value->status_penggajian !== "Harian"){
                                 if($value->status_penggajian == "Borongan"){
                                    if($value->kategori_kerja == "Shift 2"){
                                        echo ribuan(7.5/100*($value->jumlah * $vup) + 2000);
                                    }else{
                                        echo ribuan(7.5/100*($value->jumlah * $vup));
                                    }
                                }else{
                                    echo ribuan(7.5/100* ($value->jam_kerja * $vup));
                                }
                             } ?>  
                            </td>
                            <td>{{$value->kategori_kerja}}</td>
                            <td>{{$supervisor[$value->supervisor]->name}}</td>
                            <td>{{$value->status_pembayaran}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                </div>
              </div>
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
</script>
@endsection