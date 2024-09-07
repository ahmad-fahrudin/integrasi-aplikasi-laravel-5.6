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
                              <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Slip Gaji > <a href="https://stokis.id/?s=data+slip+Gaji" target="_blank">Data Slip Gaji</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
            <div class="form-group">
            <form action="{{url('data_slip_gaji')}}" method="post">
                {{csrf_field()}}
            <strong>Filter Berdasarkan:</strong>
            <div class="row">
                <div class="col-md-3">
                    Dari Tanggal
                    <input type="date" class="form-control" name="mulai" <?php if(isset($mulai)){ echo 'value="'.$mulai.'"'; }?>>
                </div>
                <div class="col-md-3">
                    Sampai Tanggal
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
                            <th>No. ID Karyawan</th>	
                            <th>Nama Karyawan</th>		
                            <th>Alamat</th>	
                            <th>Periode Penggajian</th>	
                            <th hidden>Masuk</th>	
                            <th hidden>Sakit</th>	
                            <th hidden>Izin</th>
                            <th hidden>Alfa</th>
                            <th hidden>Rolling</th>
                            <th hidden>Libur</th>
                            <th hidden>Terlambat</th>
                            <th hidden>Pulang Cepat</th>		
                            <th>No. ID Upah</th>	
                            <th>Status Penggajian</th>	
                            <th hidden>Gaji Pokok	</th>
                            <th hidden>Total UpahKinerja</th>	
                            <th hidden>Bonus Kehadiran</th>	
                            <th hidden>Bonus Kinerja</th>	
                            <th hidden>#1 Keterangan Pendapatan Lain Lain</th>	
                            <th hidden>#1 Pendapatan Lain Lain	</th>
                            <th hidden>#2 Keterangan Pendapatan Lain Lain	</th>
                            <th hidden>#2 Pendapatan Lain Lain	</th>
                            <th hidden>BPJS Kesehatan</th>
                            <th hidden>BPJS Ketenagakerjaan</th>	
                            <th hidden>Potongan Gaji Pokok	</th>
                            <th hidden>#1 Keterangan Potongan Lain Lain	</th>
                            <th hidden>#1 Potongan Lain Lain	</th>
                            <th hidden>#2 Keterangan Potongan Lain Lain</th>	
                            <th hidden>#2 Potongan Lain Lain</th>
                            <th>Total Penerimaan</th>
                            <th>Status Pembayaran</th>	
                            <th>Tanggal Pembayaran	</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($slip as $key => $value){ ?>
                            <tr>
                                <td>{{$value->id_karyawan}}</td>
                                <td>{{$karyawan[$value->id_karyawan]->nama}}</td>
                                <td>{{$karyawan[$value->id_karyawan]->alamat}}</td>
                                <td>{{$value->mulai}} ~ {{$value->sampai}}</td>
                                <td hidden>{{$value->masuk}}</td>
                                <td hidden>{{$value->sakit}}</td>
                                <td hidden>{{$value->izin}}</td>
                                <td hidden>{{$value->alfa}}</td>
                                <td hidden>{{$value->rolling}}</td>
                                <td hidden>{{$value->libur}}</td>
                                <td hidden>{{$value->terlambat}}</td>
                                <td hidden>{{$value->pulang_cepat}}</td>
                                <td>{{$value->no_id_upah}}</td>
                                <td>{{$value->status_penggajian}}</td>
                                <td hidden>{{ribuan($value->gaji_pokok)}}</td>
                                <td hidden>{{ribuan($value->upah_kinerja)}}</td>
                                <td hidden>{{ribuan($value->bonus_kehadiran)}}</td>
                                <td hidden>{{ribuan($value->bonus_kinerja)}}</td>
                                <td hidden>{{$value->ketpendapatanlain1}}</td>
                                <td hidden>{{ribuan($value->valpendapatanlain1)}}</td>
                                <td hidden>{{$value->ketpendapatanlain2}}</td>
                                <td hidden>{{ribuan($value->valpendapatanlain2)}}</td>
                                <td hidden>{{ribuan($value->bpjs_kesehatan)}}</td>
                                <td hidden>{{ribuan($value->bpjs_ketenagakerjaan)}}</td>
                                <td hidden>{{ribuan($value->potongan_gaji_pokok)}}</td>
                                <td hidden>{{$value->ketpotonganlain1}}</td>
                                <td hidden>{{ribuan($value->valpotonganlain1)}}</td>
                                <td hidden>{{$value->ketpotonganlain2}}</td>
                                <td hidden>{{ribuan($value->valpotonganlain2)}}</td>
                                <td style="text-align: right;">{{ribuan($value->total_gaji)}}</td>
                                <td>{{$value->status_pembayaran}}</td>
                                <td>{{$value->tgl_pembayaran}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="LihatDetailInsentifKinerja('{{$value->id}}')">Lihat Detail Insentif Kinerja</button> 
                                    <a class="btn btn-warning btn-sm" target="_blank" href="{{url('cetakslipgaji/'.$value->id)}}">Cetak Ulang Slip Gaji</a> 
                                    <?php if($value->status_pembayaran == "Pending"){ ?>
                                    <button class="btn btn-secondary btn-sm" onclick="Terbayar('{{$karyawan[$value->id_karyawan]->nama_karyawan}}','{{$value->no_id_upah}}')">Tandai Terbayar</button> 
                                    <?php } ?>
                                </td>
                            </tr>   
                        <?php $no++; } ?>
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
                Nama Karyawan
                <input type="text" id="nama" readonly class="form-control">
                <br>
                No. ID Gaji
                <input type="text" id="no_id_upah" readonly class="form-control"><br>
                Tanggal Bayar
                <input type="date" id="tgl_bayar" class="form-control">
                <br>
                <center><button class="btn btn-success btn-sm" onclick="UpdateData()">Update</button></center>
           </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>





<div class="modal fade" id="dfd" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <tr>
                            <th>No ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th hidden>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $key => $value){ ?>
                        <tr onclick="Pilih('{{$value->id}}','{{$value->nama}}','{{$value->id_divisi}}','{{$value->alamat}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->alamat}}</td>
                            <td hidden>{{$value->no_hp}}</td>
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
              <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
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

<div class="modal fade" id="insentif" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <b>Periode Penggajian:</b><br>
                    <br>
                    Dari:
                    <input type="date" name="mulai"  class="form-control" id="det_mulai" readonly>
                    <br>
                    Sampai:
                    <input type="date" name="sampai"  class="form-control" id="det_sampai" readonly>
                    <br>
                    <b>Karyawan:</b><br>
                    <br>
                    No. ID Karyawan:
                    <input type="text" id="det_id_karyawan" name="det_id_karyawan" class="form-control" placeholder="Pilih"readonly>
                    <br>
                    Nama Karyawan:
                    <input type="text" name="nama_karyawan"  class="form-control" id="det_nama_karyawan" readonly>
                    <br>
                    Alamat:
                    <input type="text" name="alamat"  class="form-control" id="det_alamat" readonly>
                    <br>
                    No. HP:
                    <input type="text" name="no_hp"  class="form-control" id="det_no_hp" readonly>
                    <br>
                    No. Rekening:
                    <input type="text" name="no_rekening"  class="form-control" id="det_no_rekening" readonly>   
                    <br>
                    Status Pekerja:
                    <input type="text" name="status_pekerja"  class="form-control" id="det_status_pekerja" readonly>   
                    <br>
                    <hr>
                    <br>
                    <b>Absensi:</b><br>
                    <br>
                    Masuk:
                    <input type="number" name="masuk"  class="form-control" id="det_masuk" readonly> 
                    <br>
                    Sakit:
                    <input type="number" name="sakit"  class="form-control" id="det_sakit" readonly>  
                    <br>
                    Izin:
                    <input type="number" name="izin"  class="form-control" id="det_izin" readonly>  
                    <br>
                    Alfa:
                    <input type="number" name="alfa"  class="form-control" id="det_alfa" readonly>
                    <br>
                    Rolling:
                    <input type="number" name="rolling"  class="form-control" id="det_rolling" readonly>
                    <input hidden type="number" name="libur"  class="form-control" id="det_libur" readonly>
                    <br>
                    Terlambat Masuk:
                    <input type="number" name="terlambat"  class="form-control" id="det_terlambat" readonly>  
                    <br>
                    Pulang Cepat:
                    <input type="number" name="pulang_cepat"  class="form-control" id="det_pulang_cepat" readonly>
                    <br>
                    Prosentase Kinerja  
                    <input type="number" name="rata_rata_prosentase"  placeholder="0" class="form-control" id="det_rata_rata_prosentase" readonly>
                    <br>
                </div>
                <div class="col-md-6">
                    Status Pembayaran:
                    <input type="text" name="rata_rata_prosentase"  class="form-control" id="det_status_pembayaran" readonly>
                    <br>
                    Status Penggajian
                    <input type="text" name="rata_rata_prosentase"  class="form-control" id="det_status_penggajian" readonly>
                    <br>
                    <b>Pendapatan:</b><br>
                    <br>
                    Gaji Pokok:
                    <input type="number" name="gaji_pokok"  class="form-control" id="det_gaji_pokok" readonly>
                    <br>
                    No. ID UPAH:
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="det_no_id_upah" name="no_id_upah" class="form-control" placeholder="Pilih"
                                readonly>
                        </div>
                    </div>
                    <br>
                    Upah Kinerja:
                    <input type="number" name="upah_kinerja"  placeholder="0" class="form-control" id="det_upah_kinerja" readonly>
                    <br>
                    Bonus Kehadiran:
                    <input type="number" name="bonus_kehadiran"  class="form-control" id="det_bonus_kehadiran" readonly>
                    <br>
                    Bonus Kinerja:
                    <input type="number" name="bonus_kinerja"  class="form-control" id="det_bonus_kinerja" readonly>
                    <br>
                    Pendapatan Lain:
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpendapatanlain1" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpendapatanlain1" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpendapatanlain2" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpendapatanlain2" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpendapatanlain3" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpendapatanlain3" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <b>Potongan:</b><br>
                    <br>
                    Potongan Gaji Pokok:
                    <input type="number" name="potongan_gaji_pokok"  class="form-control" id="det_potongan_gaji_pokok" readonly>
                    <br>
                    BPJS Kesehatan:
                    <input type="number" name="bpjs_kesehatan"  class="form-control" id="det_bpjs_kesehatan" readonly>
                    <br>
                    BPJS Ketenagakerjaan:
                    <input type="number" name="bpjs_ketenagakerjaan"  class="form-control" id="det_bpjs_ketenagakerjaan" readonly>
                    <br>
                    Potongan Lain:
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpotonganlain1" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpotonganlain1" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpotonganlain2" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpotonganlain2" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" id="det_ketpotonganlain3" placeholder="-" class="form-control" readonly></div>
                        <div class="col"><input type="number" id="det_valpotonganlain3" placeholder="0" class="form-control" readonly></div>
                    </div>
                    <br>
                    <hr>
                    <strong>
                        <br>
                    Total Penerimaan:
                    <p id="det_total_gaji"></p>
                    </strong>
                </div>

        </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

<script>
function LihatDetailInsentifKinerja(val){
    $.ajax({
        url: '{{url("cekinsentifkinerja")}}/' + val,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            document.getElementById("det_mulai").value = response[0]['mulai'];
            document.getElementById("det_sampai").value = response[0]['sampai'];
            document.getElementById("det_id_karyawan").value = response[0]['id_karyawan'];
            document.getElementById("det_nama_karyawan").value = response[0]['nama_karyawan'];
            document.getElementById("det_alamat").value = response[0]['alamat_karyawan'];
            document.getElementById("det_no_hp").value = response[0]['no_hp'];
            document.getElementById("det_no_rekening").value = response[0]['no_rekening'];
            document.getElementById("det_status_pekerja").value = response[0]['status_pekerja'];
            document.getElementById("det_masuk").value = response[0]['masuk'];
            document.getElementById("det_sakit").value = response[0]['sakit'];
            document.getElementById("det_izin").value = response[0]['izin'];
            document.getElementById("det_alfa").value = response[0]['alfa'];
            document.getElementById("det_rolling").value = response[0]['rolling'];
            document.getElementById("det_libur").value = response[0]['libur'];
            document.getElementById("det_terlambat").value = response[0]['terlambat'];
            document.getElementById("det_pulang_cepat").value = response[0]['pulang_cepat'];
            document.getElementById("det_rata_rata_prosentase").value = response[0]['rata_rata_prosentase'];
            document.getElementById("det_status_pembayaran").value = response[0]['status_pembayaran'];
            document.getElementById("det_status_penggajian").value = response[0]['status_penggajian'];
            document.getElementById("det_gaji_pokok").value = response[0]['gaji_pokok'];
            document.getElementById("det_no_id_upah").value = response[0]['no_id_upah'];
            document.getElementById("det_upah_kinerja").value = response[0]['upah_kinerja'];
            document.getElementById("det_bonus_kehadiran").value = response[0]['bonus_kehadiran'];
            document.getElementById("det_bonus_kinerja").value = response[0]['bonus_kinerja'];
            document.getElementById("det_ketpendapatanlain1").value = response[0]['ketpendapatanlain1'];
            document.getElementById("det_valpendapatanlain1").value = response[0]['valpendapatanlain1'];
            document.getElementById("det_ketpendapatanlain2").value = response[0]['ketpendapatanlain2'];
            document.getElementById("det_valpendapatanlain2").value = response[0]['valpendapatanlain2'];
            document.getElementById("det_ketpendapatanlain3").value = response[0]['ketpendapatanlain3'];
            document.getElementById("det_valpendapatanlain3").value = response[0]['valpendapatanlain3'];
            document.getElementById("det_potongan_gaji_pokok").value = response[0]['potongan_gaji_pokok'];
            document.getElementById("det_bpjs_kesehatan").value = response[0]['bpjs_kesehatan'];
            document.getElementById("det_bpjs_ketenagakerjaan").value = response[0]['bpjs_ketenagakerjaan'];
            document.getElementById("det_ketpotonganlain1").value = response[0]['ketpotonganlain1'];
            document.getElementById("det_valpotonganlain1").value = response[0]['valpotonganlain1'];
            document.getElementById("det_ketpotonganlain2").value = response[0]['ketpotonganlain2'];
            document.getElementById("det_valpotonganlain2").value = response[0]['valpotonganlain2'];
            document.getElementById("det_ketpotonganlain3").value = response[0]['ketpotonganlain3'];
            document.getElementById("det_valpotonganlain3").value = response[0]['valpotonganlain3'];
            document.getElementById("det_total_gaji").innerHTML = response[0]['total_gaji'];
            $('#insentif').modal('show');
        }
    });
}
function CariKaryawan() {
    $('#dfd').modal('show');
}

function CariDivisi() {
    $('#pkrj').modal('show');
}

function Pilih(id, nama, id_divisi, alamat) {
    document.getElementById("id").value = id_karyawan;
    document.getElementById("nama").value = nama_karyawan;
    document.getElementById("alamat").value = alamat_karyawan;
    $('#dfd').modal('hide');
}

function PilihDivisi(id_divisi, nama_divisi) {
    document.getElementById("id_divisi").value = id_divisi;
    document.getElementById("nama_divisi").value = nama_divisi;
    $('#pkrj').modal('hide');
}

function Terbayar(nama,no_id_upah){
    document.getElementById("nama").value = nama;
    document.getElementById("no_id_upah").value = no_id_upah;
    $('#capmi').modal('show');
}

function Deleted(nama,id) {
    Swal.fire({
        title: "Delete " + nama,
        text: 'Tindakan ini tidak bisa dibatalkan ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = "{{url('delete_penilaian_kinerja')}}/" + id;
        }
    })
}


function UpdateData(){
    var no_id_upah = document.getElementById("no_id_upah").value;
    var tgl_bayar = document.getElementById("tgl_bayar").value;

    $.post("postupdatedata",
        {no_id_upah:no_id_upah, tgl_bayar:tgl_bayar, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
            {
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                    if (result.value) {
                        location.href="{{url('/data_slip_gaji/')}}";
                    }else{
                        location.href="{{url('/data_slip_gaji/')}}";
                    }
                });
            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
    });

}

</script>
@endsection