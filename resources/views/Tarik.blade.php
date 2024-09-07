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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Investasi > <a href="https://stokis.app/?s=tarik+saldo+investasi" target="_blank">Penarikan Investasi</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>

                    <div class="row">
                      <div class="col-md-6">

                        <form action="{{url('penarikansaldo')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Saldo yang bisa di Tarik</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" type="text" readonly value="Rp <?php
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
                                            }?> ,-" class="form-control">
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
                            <li>Dana Penarikan investasi akan di transfer ke No. Rekening Bank milik investor, setelah proses validasi selesai.</li>
                            <li>Transfer antar bank mungkin dikenakan potongan sesuai biaya administrasi bank yang berlaku.</li>
                            <li>Investor tidak dapat melakukan Penarikan investasi sebelum masa Lock saldo & Lock Investasi berakhir.</li>
                            <li>Dana Bagi Hasil dan Dana yang tidak dalam masa Lock Saldo ataupun Lock Investasi bisa diambil kapan saja.</li>
                            <li>Apabila terbukti terjadi kesalahan, maka revisi dapat dilakukan dengan penyesuaian saldo investasi yang tersedia.</li>
                            <li>Dengan menekan tombol Proses dibawah ini, Investor menerima syarat dan ketentuan yang berlaku.</li>
                        </ul>
                        </div>
                        <br>
                        <center>
                          <input type="submit" class="btn btn-success btn-lg"
                          <?php if (cektarik(cekmyid_investor())): ?>
                            disabled
                          <?php endif; ?>
                          value="Proses">
                        </center>
                      </form>
                      </div>
                    </div>
                    <br><br><br><hr>

                    <center><strong>Daftar Transaksi Pending</strong><br>
                    (Menunggu verifikasi dari Admin)</center><br>
                    <div class="table-responsive">
                    <table id="kulakan" class="table table-striped table-bordered no-wrap" style="width:100%">
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
                                  <?php if ($value->jenis == "in"){
                                    echo "Investasi Masuk - ";
                                  }else if($value->jenis == "bagi"){
                                    echo "Bagi Hasil - ".$barang[$value->id_barang]." ".$value->jumlah_barang."-";
                                  }else if($value->jenis == "selesai"){
                                    echo "Pengadaan Selesai - ".$barang[$value->id_barang]." ".$value->jumlah_barang."-";
                                  }else if($value->jenis == "pengadaan"){
                                    echo "Pengadaan Barang - ".$barang[$value->id_barang]." ".$value->jumlah_barang."-";
                                  }else if($value->jenis == "out"){
                                    echo "Pengambilan investasi - ";
                                  } ?>
                                  {{$value->nama_investor}}
                              </td>
                              <td>
                                Nama Bank: {{$investor[$value->id_investor]['nama_bank']}}<br>
                                No Rekening: {{$investor[$value->id_investor]['no_rekening']}}<br>
                                Atas Nama: {{$investor[$value->id_investor]['ats_bank']}}
                              </td>
                              <td align="right">
                                <?php if ($value->jenis == "out" || $value->jenis == "pengadaan"): ?>
                                  {{ribuan($value->jumlah)}}
                                <?php endif; ?>
                              </td>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                              <td><button class="btn btn-success" onclick="Verifikasi('{{$value->id_tr}}','{{$value->nama_investor}}','{{$value->jumlah}}')">Verifikasi</button>
                                  <button class="btn btn-danger" onclick="Batalkan('{{$value->id_tr}}','{{$value->nama_investor}}','{{$value->jumlah}}')">Batalkan</button></td>
                              <?php endif; ?>
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
              <form action="{{url('/verifikasitarik')}}" method="post">
              {{csrf_field()}}
              Nama Investor<br><input type="text" id="nama" readonly class="form-control">
              Jumlah Penarikan<br><input type="text" id="jumlah" readonly class="form-control">
              <input type="hidden" name="id" id="id">
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
            title: 'Pastikan Nilai Penarikan dan Saldo Mencukupi!',
            showConfirmButton: false,
            timer: 1500
            }, function() {
            });
            return false;
          }
      });
      
      function Transaksi(){
          var tr = document.getElementById("transaksi").value;
          if(tr == "transfer"){
              document.getElementById("rekening").hidden = false;
          }else{
              document.getElementById("rekening").hidden = true;
          }
      }
      
      function pilihbarang(id,nama,nik,alamat,hp,no,ats,nama_bank,saldo){
        $('#barang').modal('hide');
        document.getElementById("id").value = id;
        document.getElementById("nama_investor").value = nama;
        document.getElementById("alamat").value = alamat;
        document.getElementById("no_hp").value = hp;
        document.getElementById("bank").value = nama_bank;
        document.getElementById("saldo").value = numberWithCommas(saldo);
      }
      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      function Verifikasi(id,nama,jumlah){
        document.getElementById("id").value = id;
        document.getElementById("nama").value = nama;
        document.getElementById("jumlah").value = numberWithCommas(jumlah);
        $('#myModal').modal('show');
        /*Swal.fire(
          'Verifikasi Penarikan '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'verifikasitarik/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/datatransaksi/')}}";
               }
             });
          }
        });*/
      }

      function Batalkan(id,nama,jumlah){
        Swal.fire(
          'Verifikasi Penarikan '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'batalkantarik/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/tariktransaksi/')}}";
               }
             });
          }
        });
      }
      </script>
@endsection
