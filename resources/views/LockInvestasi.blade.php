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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Investasi > <a href="https://stokis.app/?s=lock+saldo+investasi" target="_blank">Lock Investasi</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">

                        <form action="{{url('simpanlock')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
                          {{csrf_field()}}
                          <?php if (Auth::user()->level == "4" || Auth::user()->level == "1"){ ?>
                          <div class="row">
                            <label class="col-lg-3">Nama Investor:</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="input-group">
                                        <input id="nama_investor" name="nama_investor" required type="text" readonly class="form-control" placeholder="Pilih Investor" style="background:#fff">
                                        <input id="id" name="id_investor" type="hidden" required class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        <?php }else{ ?>
                          <input id="id" name="id_investor" value="{{cekmyid_investor()}}" type="hidden" required class="form-control">
                        <?php } ?>
                          <br>
                        <div class="row">
                          <label class="col-lg-3">Saldo investasi Anda</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" type="text" readonly
                                        value="Rp <?php
                                              $cek = cek_lock2(cekmyid_investor()) - ( ($pending_pati[0]->jumlah_investasi) + ($pending_jkt[0]->jumlah_investasi) );
                                              if ($cek > 0) {
                                                $hasil = saldo()-cek_lock(cekmyid_investor())-cek_lock2(cekmyid_investor());
                                              }else{
                                                $hasil = saldo()-cek_lock(cekmyid_investor())+$cek-cek_lock2(cekmyid_investor());
                                              }
                                              if ($hasil > 0) {
                                                echo ribuan($hasil);
                                              }else{
                                                echo "0";
                                              }?> ,-"
                                      class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nominal Lock investasi</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="saldo" type="text" id="in_saldo" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Durasi Tempo</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="durasi" class="form-control">
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="12">12 Bulan</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="kolom">
                        <strong>Catatan:</strong>
                        <ul><li>Dana investasi yang di Lock Investasi tidak dapat di gunakan untuk mengikuti projek pengadaan barang.</li>
                            <li>Dana investasi yang di Lock Investasi tidak dapat ditarik hingga durasi masa Lock Investasi selesai.</li>
                            <li>Bagi hasil dana Lock Investasi durasi tempo 3 bulan (<?php echo perseninvestor()[0]->investasiLS3; ?>%), 6 bulan (<?php echo perseninvestor()[0]->investasiLS6; ?>%), 12 bulan (<?php echo perseninvestor()[0]->investasiLS12; ?>%).</li>
                            <li>Bagi hasil dari dana Lock Investasi akan otomatis masuk ke saldo investor tiap bulan, per tanggal Lock Investasi.</li>
                            <li>Saldo investasi tidak dalam masa Lock Saldo maupun Lock Investasi, bisa ditarik kembali kapan saja.</li>
                            <li>Dengan menekan tombol Lock Investasi dibawah ini, investor menerima syarat dan ketentuan yang berlaku.</li>
                        </ul>
                        </div>
                        <br>
                        <center>
                          <input type="submit" class="btn btn-success btn-lg" value="Lock Investasi">
                        </center>
                      </form>
                      </div>
                    </div>
                    <br><br><br><hr>

                    <center><strong>Data Lock Investasi</strong><br>
                    <div class="table-responsive">
                    <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Investor</th>
                                <th>Tanggal Lock</th>
                                <th>Jangka Waktu (Bulan)</th>
                                <th>Tanggal Bagi Hasil</th>
                                <th>Jumlah Saldo</th>
                                <th>Jumlah Bagi Hasil / Bulan</th>
                                <?php if (Auth::user()->level == "4" || Auth::user()->level == "1"){ ?>
                                  <th>Tindakan</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;
                          foreach ($lock as $key => $value) { ?>
                            <tr>
                              <td>{{$no}}</td>
                              <td>{{$investor[$value->id_investor]['nama']}}</td>
                              <td>{{tanggal($value->tgl_lock)}}</td>
                              <td>{{ribuan($value->durasi)}}</td>
                              <td align="center">
                                <?php if ($value->status == "lock"){ ?>
                                  {{date("d", strtotime($value->tgl_lock))}}
                                <?php }else{ ?>
                                  tidak ada
                                <?php } ?>
                              </td>
                              <td align="right">{{ribuan($value->jumlah_lock)}}</td>
                              <td align="right">
                                {{ribuan($value->share/100*$value->jumlah_lock)}}</td>
                              <?php if (Auth::user()->level == "4"){ ?>
                                <td>
                                  <?php $x = strtotime($value->tgl_lock);
                                        $s = date("Y-m-d",strtotime("+".$value->durasi." month",$x));
                                        if ($s < date('Y-m-d')) { ?>
                                          <?php if ($value->status == "lock"){ ?>
                                            <button class="btn btn-warning" onclick="Unlock('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">UnLock</button>
                                          <?php }else{ ?>
                                            <button class="btn btn-success" onclick="Lock('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">Lock</button>
                                          <?php } ?>
                                          <button class="btn btn-danger" onclick="Deleted('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">Hapus</button>
                                        <?php } ?>
                                  </td>
                              <?php } ?>
                              <?php if (Auth::user()->level == "1"){ ?>
                                <td>
                                          <?php if ($value->status == "lock"){ ?>
                                            <button class="btn btn-warning" onclick="Unlock('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">UnLock</button>
                                          <?php }else{ ?>
                                            <button class="btn btn-success" onclick="Lock('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">Lock</button>
                                          <?php } ?>
                                          <button class="btn btn-danger" onclick="Deleted('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">Hapus</button>
                                  </td>
                              <?php } ?>
                            </tr>
                          <?php $no++; } ?>
                        </tbody>
                    </table>
  								</div>

                  <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                  <br><br>
                  <center><strong>Verifikasi Bagi Hasil</strong><br>
                  <div class="table-responsive">
                  <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Investor</th>
                              <th>Tanggal Lock</th>
                              <th>Tanggal Bagi Hasil</th>
                              <th>Jumlah Saldo</th>
                              <th>Jumlah Bagi Hasil / Bulan</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;
                        foreach ($bagi as $key => $value) { ?>
                          <tr>
                            <td>{{$no}}</td>
                            <td>{{$investor[$value->id_investor]['nama']}}</td>
                            <td>{{tanggal($value->tgl_lock)}}</td>
                            <td align="center">
                              <?php if ($value->status == "lock"){ ?>
                                {{date("d", strtotime($value->tgl_lock))}}
                              <?php }else{ ?>
                                tidak ada
                              <?php } ?>
                            </td>
                            <td align="right">{{ribuan($value->jumlah_lock)}}</td>
                            <td align="right">{{ribuan($value->share/100*$value->jumlah_lock)}}</td>
                            <td><button class="btn btn-success" onclick="Verifikasi('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->share/100*$value->jumlah_lock}}')">Verifikasi</button></td>
                          </tr>
                        <?php $no++; } ?>
                      </tbody>
                  </table>
                </div>
                <?php endif; ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="barang" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>NIK</th>
                          <th>Nama Investor</th>
                          <th>Alamat</th>
                          <th>No HP</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($karyawan as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_investor}}','{{$value->nik}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->no_rekening}}','{{$value->ats_bank}}','{{$value->nama_bank}}','{{$value->saldo}}')">
                          <td>{{$value->nik}}</td>
                          <td>{{$value->nama_investor}}</td>
                          <td><?=$value->alamat?></td>
                          <td>{{$value->no_hp}}</td>
                      </tr>
                     <?php } ?>
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

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>
      new AutoNumeric('#in_saldo', "euroPos");
      function caribarang(){
        $('#barang').modal('show');
      }
      function pilihbarang(id,nama,nik,alamat,hp,no,ats,nama_bank,saldo){
        $('#barang').modal('hide');
        document.getElementById("id").value = id;
        document.getElementById("nama_investor").value = nama;
        if (Number(saldo) < 1) {
          saldo = 0;
        }

        $.ajax({
           url: 'cektransaksipending/'+nik,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             saldo = Number(saldo) - Number(response['pending']);
             if (saldo < 0) {
               saldo = 0;
             }
           }
         });

        document.getElementById("saldo").value = numberWithCommas(saldo);
      }
      function Unlock(id,nama,jumlah){
        Swal.fire(
          'Unlock Investasi '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'unlock/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.reload();
               }
             });
          }
        });
      }
      function Lock(id,nama,jumlah){
        Swal.fire(
          'Lock Investasi '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'lock/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.reload();
               }
             });
          }
        });
      }
      function Deleted(id,nama,jumlah){
        Swal.fire(
          'Delete Lock Investasi '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'deletelock/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.reload();
               }
             });
          }
        });
      }
      function Verifikasi(id,nama,jumlah){
        Swal.fire(
          'Verifikasi Bagi Hasil Sejumlah'+'\n'+numberWithCommas(jumlah)+' kepada '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'verifikasi_lock_investasi/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.reload();
               }
             });
          }
        });
      }
      </script>
@endsection
