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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Investasi > <a href="https://stokis.app/?s=lock+saldo+investasi" target="_blank">Lock Saldo</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <?php if (Auth::user()->level == "4" || Auth::user()->level == "1"){ ?>
                    <div class="row">
                      <div class="col-md-6">

                        <form action="{{url('simpanlock2')}}" method="post" enctype="multipart/form-data" id="form_tarik_insentif">
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
                          <label class="col-lg-3">Saldo investasi</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" type="text" readonly value="" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nominal Lock Saldo</label>
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
                          <label class="col-lg-3">Durasi Lock</label>
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
                        <ul><li>Dana investasi yang di Lock Saldo di gunakan untuk mengikuti projek pengadaan barang.</li>
                            <li>Dana investasi yang di Lock Saldo tidak dapat ditarik hingga durasi masa Lock Saldo selesai.</li>
                            <li>Bagi hasil dana Lock Saldo mengikuti bagi hasil dari Projek Pengadaan Barang yang di ikuti.</li>
                            <li>Bagi hasil dari Projek Pengadaan Barang akan otomatis masuk ke saldo investor setiap Projek Pengadaan Barang selesai.</li>
                            <li>Saldo investasi yang sedang tidak digunakan untuk projek pengadaan barang atau tidak dalam masa lock Saldo dan Lock Investasi, bisa ditarik kembali kapan saja.</li>
                            <li>Dengan menekan tombol Lock Saldo dibawah ini, investor menerima syarat dan ketentuan yang berlaku.</li>
                        </ul>
                        </div>
                        <br>
                        <center>
                          <input type="submit" class="btn btn-success btn-lg" value="Lock Saldo">
                        </center>
                      </form>
                      </div>
                    </div>
                    <br><br><br><hr>
                    <?php } ?>
                    <center><strong>Data Lock Saldo</strong><br>
                    <div class="table-responsive">
                    <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Investor</th>
                                <th>Tanggal Lock</th>
                                <th>Tanggal Open</th>
                                <th>Jumlah Saldo</th>
                                <th>Durasi Lock</th>
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
                              <td align="center">
                                <?php if ($value->status == "lock"){ ?>
                                  {{tanggal($value->tgl_open)}}
                                <?php }else{ ?>
                                  tidak ada
                                <?php } ?>
                              </td>
                              <td align="right">{{ribuan($value->jumlah_lock)}}</td>
                              <td align="right">{{$value->durasi}} bulan</td>
                              <?php if (Auth::user()->level == "4" || Auth::user()->level == "1"){ ?>
                                <td>
                                          <?php if ($value->status == "lock"){ ?>
                                            <button class="btn btn-warning" onclick="Unlock('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">UnLock</button>
                                          <?php } ?>
                                          <button class="btn btn-danger" onclick="Deleted('{{$value->id}}','{{$investor[$value->id_investor]['nama']}}','{{$value->jumlah_lock}}')">Hapus</button>
                                  </td>
                              <?php } ?>
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
               url: 'unlock2/'+id,
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
               url: 'lock2/'+id,
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
               url: 'deletelock2/'+id,
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
