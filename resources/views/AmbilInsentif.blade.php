<?php //dd(saldomas()); ?>
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
                              <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Insentif Pemasaran > <a href="https://stokis.app/?s=tarik+insentif" target="_blank">Penarikan Insentif</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>

                    <div class="row">
                      <div class="col-md-6">
                        <?php if (Auth::user()->name == "MAS"){ ?>
                          <?php if (count(cekambilinsentifmas(cekmyid_karyawan())) < 1): ?>
                          <form action="{{url('penarikansaldoinsentifmas')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
                          <?php endif; ?>
                        <?php }else{?>
                          <?php if (count(cekambilinsentif(cekmyid_karyawan())) < 1): ?>
                          <form action="{{url('penarikansaldoinsentif')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
                          <?php endif; ?>
                        <?php } ?>
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Saldo saat ini</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <?php if (Auth::user()->name == "MAS"){ ?>
                                      <input id="saldo" type="text" readonly value="<?=ribuan(saldomas())?>" class="form-control">
                                    <?php }else{?>
                                      <input id="saldo" type="text" readonly value="<?=ribuan(saldokaryawan())?>" class="form-control">
                                    <?php } ?>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nominal Penarikan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="saldo" type="text" id="in_saldo" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="kolom">
                        <strong>Catatan:</strong>
                        <ul>
                            <li>Penarikan Insentif bisa dilakukan kapan saja selama saldo tersedia.</li>
                            <li>Dana Penarikan Insentif akan di transfer ke No. Rekening Bank / akun e-Wallet milik User, setelah proses validasi selesai.</li>
                            <li>Transfer insentif dikenakan potongan administrasi Rp 1.000 + Biaya transfer antar bank bila ada.</li>
                            <li>Apabila terbukti terjadi kesalahan atau adanya proses retur dari penjualan yang berhubungan dengan pembagian insentif tersebut, maka revisi dapat dilakukan dengan penyesuaian saldo insentif Anda berikutnya.</li>
                            <li>Dengan menekan tombol Proses dibawah ini, User menerima syarat dan ketentuan yang berlaku.</li>
                        </ul>
                        </div>
                        <br>
                        <center>
                          <input type="submit" class="btn btn-success btn-lg"
                          <?php if (Auth::user()->name == "MAS"){ ?>
                            <?php if (count(cekambilinsentifmas(cekmyid_karyawan())) > 0): ?>
                            disabled
                            <?php endif; ?>
                          <?php }else{?>
                            <?php if (count(cekambilinsentif(cekmyid_karyawan())) > 0): ?>
                            disabled
                            <?php endif; ?>
                          <?php } ?>
                          value="Proses">
                        </center>
                      </form>
                      </div>
                    </div>
                    <br><br><br><hr>

                    <center><strong>Daftar Transaksi Pending</strong><br>
                    (Menunggu verifikasi dari Admin)</center><br>
                    <div class="table-responsive">
                    <table id="insentif" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan Transaksi</th>
                                <th>Keterangan Rekening</th>
                                <th>Jumlah Penarikan Saldo</th>
                                <?php if (Auth::user()->level == "4" || Auth::user()->level == "1"){ ?>
                                  <th>Tindakan</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;
                          foreach ($pending as $key => $value): ?>
                            <tr>
                              <td>{{tanggal($value->tgl_transaksi)}}</td>
                              <td>
                                {{$value->no_trip}}<?php if ($value->jenis != "Trip") {
                                  echo $value->jenis;
                                }?>-{{$value->nama_karyawan}}
                              </td>
                              <td>
                                Nama Bank: {{$karyawan[$value->id_karyawan]['nama_bank']}}<br>No Rekening: {{$karyawan[$value->id_karyawan]['no_rekening']}}<br>Atas Nama: {{$karyawan[$value->id_karyawan]['ats_bank']}}
                              </td>
                              <td>
                                  {{ribuan($value->jumlah)}}
                              </td>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                              <td><button class="btn btn-success" onclick="Verifikasi('{{$value->id_tr}}','{{$value->nama_karyawan}}','{{$value->jumlah}}')">Verifikasi</button>
                                  <button class="btn btn-danger" onclick="Batalkan('{{$value->id_tr}}','{{$value->nama_karyawan}}','{{$value->jumlah}}')">Batalkan</button></td>
                              <?php endif; ?>
                            </tr>
                          <?php $no++; endforeach; ?>
                          <?php if (isset($pending2)){
                            foreach ($pending2 as $key => $value){ ?>
                              <tr>
                                <td>{{tanggal($value->tgl_transaksi)}}</td>
                                <td>
                                  {{$value->no_trip}}<?php if ($value->jenis != "Trip") {
                                    echo $value->jenis;
                                  }?>-{{$value->nama_karyawan}}
                                </td>
                                <td>
                                  Nama Bank: {{$karyawan[$value->id_karyawan]['nama_bank']}}<br>No Rekening: {{$karyawan[$value->id_karyawan]['no_rekening']}}<br>Atas Nama: {{$karyawan[$value->id_karyawan]['ats_bank']}}
                                </td>
                                <td>
                                    {{ribuan($value->jumlah)}}
                                </td>
                                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                                <td><button class="btn btn-success" onclick="Verifikasim('{{$value->id_tr}}','{{$value->nama_karyawan}}','{{$value->jumlah}}')">Verifikasi</button>
                                    <button class="btn btn-danger" onclick="Batalkanm('{{$value->id_tr}}','{{$value->nama_karyawan}}','{{$value->jumlah}}')">Batalkan</button></td>
                                <?php endif; ?>
                              </tr>
                            <?php $no++; } } ?>
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
            <form action="{{url('/verifikasipenarikan')}}" enctype="multipart/form-data" method="post" onsubmit="return validateForm()" id="form_verifikasi">
            {{csrf_field()}}
            Nama Karyawan<br><input type="text" id="nama" readonly class="form-control">
            Jumlah Penarikan<br><input type="text" id="jumlah" readonly class="form-control">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="previllage" id="previllage" value="umum">
            Administrasi Bank<br><input type="text" name="jumlah" id="in_jumlah" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." class="form-control"><br>
            Transaksi Pembayaran<br>
            <select name="transaksi" class="form-control" id="transaksi" onchange="Transaksi()">
              <option value="tunai">Tunai</option>
              <option value="transfer">Transfer</option>
            </select>
            <div id="rekening" hidden>
            Dana dari Rekening<br>
            <select name="rekening" class="form-control">
            <?php foreach($rekening as $val){ ?>
                <option value="{{$val->id}}">{{$val->nama}} {{$val->no_rekening}}</option>
            <?php } ?>
            </select>
            </div>
            <br>
            <input type="submit" value="Verifikasi" class="form-control btn-success">
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
      new AutoNumeric('#in_saldo', "euroPos");
      new AutoNumeric('#in_jumlah', "euroPos");
      function caribarang(){
        $('#barang').modal('show');
      }
      
      function Transaksi(){
          var tr = document.getElementById("transaksi").value;
          if(tr == "transfer"){
              document.getElementById("rekening").hidden = false;
          }else{
              document.getElementById("rekening").hidden = true;
          }
      }
      
      $('#form_tarik_insentif').submit(function() {
          var saldo = document.getElementById("saldo").value;
          var in_saldo = document.getElementById("in_saldo").value;
          saldo = saldo.split(".").join("");
          in_saldo = in_saldo.split(".").join("");
          if (Number(saldo) > 0 && Number(saldo) >= Number(in_saldo) && Number(in_saldo) > 0) {
            return true;
          }else{
            Swal.fire({
            type: 'error',
            title: 'Pastikan Nominal Penarikan dan Saldo Mencukupi!',
            showConfirmButton: false,
            timer: 1500
            }, function() {
            });
            return false;
          }
      });


      function validateForm() {
        var in_jumlah = document.getElementById("in_jumlah").value;
        in_jumlah = in_jumlah.split(".").join("");
        if (Number(in_jumlah) >= 1000) {
          return true;
        }else{
          Swal.fire({
          type: 'error',
          title: 'Isian Admin Minimal 1000 untuk bisa diproses',
          showConfirmButton: false,
          timer: 1500
          }, function() {
          });
          return false;
        }
      }

      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      function Verifikasi(id,nama,jumlah){
        document.getElementById("id").value = id;
        document.getElementById("nama").value = nama;
        document.getElementById("jumlah").value = numberWithCommas(jumlah);
        $('#myModal').modal('show');
      }
      function Batalkan(id,nama,jumlah){
        Swal.fire(
          'Batalkan Penarikan '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'bataltarik/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/ambilinsentif/')}}";
               }
             });
          }
        });
      }
      function Verifikasim(id,nama,jumlah){
        document.getElementById("id").value = id;
        document.getElementById("nama").value = nama;
        document.getElementById("previllage").value = "mase";
        document.getElementById("jumlah").value = numberWithCommas(jumlah);
        $('#myModal').modal('show');
      }
      function Batalkanm(id,nama,jumlah){
        Swal.fire(
          'Batalkan Penarikan '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'bataltarikmase/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/ambilinsentif/')}}";
               }
             });
          }
        });
      }
      </script>
@endsection
