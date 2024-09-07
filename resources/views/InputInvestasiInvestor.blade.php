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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Investasi > <a href="https://stokis.app/?s=deposit+saldo+investasi" target="_blank">Deposit Saldo</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <?php if(cekmyid_investor() > 0){ ?>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('pengisiansaldo')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Saldo saat ini</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="no_hp" type="text" readonly value="Rp <?=ribuan(saldo())?> ,-" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nominal Transfer</label>
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
                          <label class="col-lg-3">Tanggal Transfer</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="tgl_transfer" type="date" value="<?php echo date('Y-m-d'); ?>" required class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tujuan Rekening</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select required name="tujuan_rekening" id="tujuan_rekening" class="form-control">
                                          <option selected value="0">-- Pilih Rekening Tujuan -- </option>
                                        <?php foreach ($rekening as $key => $value): ?>
                                          <option value="{{$value->id}}">{{$value->nama}} - No Rek: {{$value->no_rekening}} - {{$value->ats}}</option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bukti Transfer</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="file" type="file" required class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="kolom">
                        <strong>Catatan:</strong>
                        <ul>
                            <li>Bukti transfer harus dalam bentuk .png atau .jpg dengan file maximal 1MB.</li>
                            <li>Dana investasi akan bertambah ke saldo investor setelah proses verifikasi selesai.</li>
                            <li>Saldo investasi yang sedang tidak digunakan untuk projek pengadaan barang dan tidak sedang lock Saldo atau Lock investasi, bisa ditarik kembali kapan saja.</li>
                            <li>Untuk mendapat surat penjanjian kerja sama dan penandatanganan surat penjanjian oleh kedua belah pihak, silahkan hubungi Admin / Pengembang Investor.</li>
                            <li>Dengan klik tombol Simpan, Anda dianggap telah menyetujui syarat & ketentuan yang berlaku, sesuai penjanjian yang telah disepakati bersama.</li>
                        </ul>
                        </div>
                        <br>

                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                      </form>
                      </div>
                    </div>
                  <?php } ?>
                    <br><br><br><hr>

                    <center><strong>Daftar Transaksi Pending</strong><br>
                    (Menunggu verifikasi dari admin)</center><br>
                    <div class="table-responsive">
                    <table id="kulakan" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan Transaksi</th>
                                <th>Jumlah Transfer Saldo</th>
                                <th>Bukti Transfer</th>
                                <th>Rekening Tujuan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no=1; foreach ($pending as $key => $value): ?>
                            <tr>
                              <td align="right">{{tanggal($value->tgl_transaksi)}}</td>
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
                                  {{$value->nama_investor}}</td>
                              <td align="right">{{ribuan($value->jumlah)}}</td>
                              <td>
                                <button class="btn btn-default" onclick="Load('<?=$value->bukti?>')">{{$value->bukti}}</button><br>
                                <?php if (Auth::user()->level == "6"): ?>
                                  <!--button type="button" class="btn btn-info btn-sm" onclick="Upload('<?=$value->id_tr?>')">Upload Bukti</button-->
                                <?php endif; ?>
                              </td>
                              <td>Nama Bank :{{$rek[$value->rekening_tujuan]['nama']}}<br>
                                  No Rekening :{{$rek[$value->rekening_tujuan]['no_rek']}}<br>
                                  Atas Nama :{{$rek[$value->rekening_tujuan]['ats']}}</td>
                              <td>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                              <button class="btn btn-success" onclick="Verifikasi('{{$value->id_tr}}','{{$value->nama_investor}}','{{$value->jumlah}}')">Verifikasi</button>
                              <?php endif; ?>
                              <button class="btn btn-danger" onclick="Canceled('{{$value->id_tr}}','{{$value->nama_investor}}','{{$value->jumlah}}')">Cancel</button>
                              </td>
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
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <h3><center>Upload Bukti Transfer</h3></center><br>
            <form action="{{url('uploadbuktitransfer')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
              <center>
              <input type="hidden" name="id_transaksi" id="id_transaksi">
              <input type="file" name="file"><br><br>
              <button class="btn btn-success btn-lg">Simpan</button>
              <center>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="image" class="modal fade" role="dialog">
      <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <img width="100%" id="img">
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

      $('#form_tarik_insentif').submit(function() {
          var in_saldo = document.getElementById("in_saldo").value;
          in_saldo = in_saldo.split(".").join("");
          var tujuan_rekening = document.getElementById("tujuan_rekening").value;
          if (Number(in_saldo) > 0 && Number(tujuan_rekening) != 0) {
            return true;
          }else{
            Swal.fire({
            type: 'error',
            title: 'Pastikan No Rekening dan Nominal Transfer Benar',
            showConfirmButton: false,
            timer: 1500
            }, function() {
            });
            return false;
          }
      });

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
      function Upload(id){
        document.getElementById("id_transaksi").value = id;
        $('#myModal').modal('show');
      }
      function Load(img){
        document.getElementById("img").src = "{{ asset('gambar/bukti')}}"+"/"+img;
        $('#image').modal('show');
      }
      function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      function Verifikasi(id,nama,jumlah){
        Swal.fire(
          'Verifikasi Transfer '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'verifikasitransfer/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/datatransaksi/')}}";
               }
             });
          }
        });
      }
      function Canceled(id,nama,jumlah){
        Swal.fire(
          'Cancel Transfer '+'\n'+numberWithCommas(jumlah)+' oleh '+nama+' ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'canceltransfer/'+id,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 location.href="{{url('/inputinvestasi/')}}";
               }
             });
          }
        });
      }
      </script>
@endsection
