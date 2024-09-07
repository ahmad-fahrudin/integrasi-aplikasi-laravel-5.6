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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Projek Pengadaan Barang > <a href="https://stokis.app/?s=ambil+danai+projek+pengadaan+barang" target="_blank">Ambil & Danai Projek</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
				<div class="table-responsive">
				    <center><h2>Daftar Projek Pengadaan Barang Tersedia</h2></center><br>
                  <table id="kulakan" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Pengadaan</th>
                              <th>Pembiayaan</th>
                              <th>Bagi Hasil</th>
                              <th>Estimasi Waktu</th>
                              <th>Tindakan / Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no=1; $pembiayaan=0; $bagi=0;
                        if (cek_investor_punya_pengembang() > 0) {
                          foreach ($pengadaan as $key => $value): ?>
                            <tr id="dt{{$no}}">
                              <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td align="center">{{$value->jumlah_kulakan}}</td>
                              <td align="right">{{ribuan($value->jumlah_investasi)}}</td>
                              <td align="right">
                                  <?php
                                    if(Auth::user()->level == 1){?>
                                      {{ribuan($value->estimasi_pendapatan)}}
                                    <?php }else if(persentase_pengadaan()==0){ ?>
                                    Pembagian muncul jika anda sudah lock saldo anda
                                  <?php }else{ ?>
                                    {{ribuan(persentase_pengadaan() * $value->estimasi_pendapatan)}}
                                  <?php } ?>
                              </td>
                              <td id="estimasi_waktu{{$no}}">{{$value->estimasi_waktu}} Hari</td>
                              <td>
                                <button class="btn btn-primary" id="ambil{{$no}}" onclick="Ambil('{{$value->id}}','{{$barang[$value->id_barang]['no_sku']}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->jumlah_kulakan}}','{{$value->jumlah_investasi}}','{{round(persentase_pengadaan()*$value->estimasi_pendapatan)}}','{{$value->estimasi_waktu}}','{{$no}}')">Ambil</button>
                                <?php if (Auth::user()->level == '1' || Auth::user()->level == '4'): ?>
                                <button class="btn btn-secondary" onclick="Edit('{{$value->id}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->estimasi_waktu}}','{{$no}}')">edit</button>
                                <button class="btn btn-danger" onclick="Deleted('{{$value->id}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->estimasi_waktu}}','{{$no}}')">Delete</button>
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php $no++; $pembiayaan+=$value->jumlah_investasi; $bagi+= (persentase_pengadaan()* $value->estimasi_pendapatan); endforeach;
                        }else{
                          foreach ($pengadaan as $key => $value): ?>
                            <tr id="dt{{$no}}">
                              <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td align="center">{{$value->jumlah_kulakan}}</td>
                              <td align="right">{{ribuan($value->jumlah_investasi)}}</td>
                              <td align="right">
                                  <?php
                                  if(Auth::user()->level == 1){?>
                                    {{ribuan($value->estimasi_pendapatan)}}
                                  <?php }else if(persentase_pengadaan()==0){ ?>
                                    Pembagian muncul jika anda sudah lock saldo Anda
                                  <?php }else{ ?>
                                    {{ribuan(persentase_pengadaan()*($value->estimasi_pendapatan))}}
                                  <?php } ?>
                            </td>
                              <td id="estimasi_waktu{{$no}}">{{$value->estimasi_waktu}} Hari</td>
                              <td>
                                <button class="btn btn-primary" id="ambil{{$no}}" onclick="Ambil('{{$value->id}}','{{$barang[$value->id_barang]['no_sku']}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->jumlah_kulakan}}','{{$value->jumlah_investasi}}','{{round(persentase_pengadaan()*($value->estimasi_pendapatan))}}','{{$value->estimasi_waktu}}','{{$no}}')">Ambil</button>
                                <?php if (Auth::user()->level == '1' || Auth::user()->level == '4'): ?>
                                <button class="btn btn-secondary" onclick="Edit('{{$value->id}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->estimasi_waktu}}','{{$no}}')">edit</button>
                                <button class="btn btn-danger" onclick="Deleted('{{$value->id}}','{{$barang[$value->id_barang]['nama_barang']}}','{{$value->estimasi_waktu}}','{{$no}}')">Delete</button>
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php $no++; $pembiayaan+=$value->jumlah_investasi; $bagi+= persentase_pengadaan()*($value->estimasi_pendapatan); endforeach;
                        } ?>

                      </tbody>
                  </table>
                  <br>
                  <div class="row">
                    <div class="col-md-3"><h4>Total Pembiayaan : {{ribuan($pembiayaan)}}</span></h4></div>
                    <div class="col-md-3"><h4>Total Bagi Hasil : {{ribuan($bagi)}}</span></h4></div>
                  </div>
                  <br>
                  <hr>
                  <center><h2>Projek Pengadaan Barang Pilihan Anda</h2></center>
                  <br>
                  <table id="investasi" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Pengadaan</th>
                              <th>Pembiayaan</th>
                              <th>Bagi Hasil</th>
                              <th>Estimasi Waktu</th>
                              <th>Tindakan / Status</th>
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                  <br>
                  <div class="row">
                    <div class="col-md-3"><h3>Total Pembiayaan : <span id="total_investasi"></span></h3></div>
                    <div class="col-md-3"><h3>Total Bagi Hasil : <span id="total_estimasi"></span></h3></div>
                  </div>
                  <br><hr>
                  <br>
                        <center>
                        <div class="kolom col-md-6" style="text-align:left">
                        <strong>Catatan:</strong>
                        <ul>
                            <li>Sebelum mengambil dan mendanai Projek Pengadaan Barang, Pastikan Saldo Investasi tersedia dan harus Lock Saldo terlebih dahulu.</li>
                            <li>Saldo Investasi akan berkurang sesuai pembiayaan dari Projek Pengadaan Barang yang dipilih.</li>
                            <li>Saldo Investasi akan bertambah kembali setelah Projek Pengadaan Barang selesai, berikut dengan Bagi Hasilnya.</li>
                            <li>Selama masa pembiayaan Projek Pengadaan Barang ini berlangsung atau selama dalam periode Lock Saldo, Saldo Investasi tidak dapat ditarik. Penarikan saldo bisa dilakukan untuk Bagi Hasil yang tersedia dan Saldo yang tidak dalam kondisi Lock.</li>
                            <li>Dengan menekan tombol dibawah ini, Investor menerima syarat dan ketentuan yang berlaku.</li>
                        </ul>
                        </div>
                        </center>
                        <br>
                  <center><button class="btn btn-success btn-lg" onclick="Simpan()"> Simpan & Biayai sekarang !</center>
					<br><br>	
					</div>
					
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    <div id="editmodal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <center><h2>Detail Barang</h2></center><br><br>
            <div class="form-group row">
              <label class="control-label col-sm-3" for="email">Nama Barang:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="ed_nama_barang" disabled placeholder="Enter email">
              </div>
            </div>
            <input type="hidden" id="id_inves">
            <input type="hidden" id="no">
            <div class="form-group row">
              <label class="control-label col-sm-3" for="email">Estimasi Waktu:</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="ed_estimasi_waktu">
              </div>
            </div>
            <button class="form-control btn-success" onclick="Ubah()">Simpan Data</button><br><br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    var total_estimasi = 0;
    var total_investasi = 0;
    var saldo = Number({{saldo_pengadaan()-pengadaan_berjalan()}});

    var data_inves = [];
    function Edit(id,nama,estimasi,no){
      document.getElementById("id_inves").value = id;
      document.getElementById("ed_nama_barang").value = nama;
      document.getElementById("ed_estimasi_waktu").value = estimasi;
      document.getElementById("no").value = no;
      $('#editmodal').modal('show');
    }
    function Deleted(id,nama,estimasi,no){
      Swal.fire(
        'Delete '+nama+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          $.ajax({
             url: 'deleteinves/'+id,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               Swal.fire({
                   title: 'Berhasil',
                   icon: 'success',
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Lanjutkan!'
                 }).then((result) => {
                   if (result.value) {
                      location.href="{{url('/pengadaanbarang/')}}";
                   }else{
                      location.href="{{url('/pengadaanbarang/')}}";
                   }
                 });
             }
           });
        }
      });
    }
    function Ubah(){
      var id = document.getElementById("id_inves").value;
      var estimasi_waktu = document.getElementById("ed_estimasi_waktu").value;
      var no = document.getElementById("no").value;
      if (Number(estimasi_waktu) > 0) {
      $.ajax({
         url: 'updateinves/'+id+"/"+estimasi_waktu,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           document.getElementById("estimasi_waktu"+no).innerHTML = estimasi_waktu+" Hari";
           $('#editmodal').modal('hide');
           Swal.fire({
               title: 'Berhasil',
               icon: 'success',
             });
         }
       });
     }else{
       alert("Estimasi Tidak Boleh 0 !");
     }
    }

    var indek = 1;

    function Ambil(id_investasi,no_sku,nama_barang,jumlah_kulakan,jumlah_investasi,estimasi_pendapatan,estimasi_waktu,no){
      if (Number(jumlah_investasi) <= Number(saldo)) {
        document.getElementById("dt"+no).style.background = "#93ffaa";
        document.getElementById("ambil"+no).disabled = true;
        var table = document.getElementById("investasi");
        var lastRow = table.rows.length;
        var row = table.insertRow(lastRow);
        row.id = lastRow;
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
        data_inves.push(id_investasi);
        cell1.innerHTML = no_sku+"<input type='hidden' name='ives"+lastRow+"' value='"+id_investasi+"'>";
        cell2.innerHTML = nama_barang;
        cell3.innerHTML = jumlah_kulakan;
        cell4.innerHTML = numberWithCommas(jumlah_investasi);
        cell5.innerHTML = numberWithCommas(estimasi_pendapatan);
        cell6.innerHTML = estimasi_waktu+" hari";
        var a = "<button class='btn btn-danger' onclick='Hapus(";
        var b = ")'>hapus</button>";
        cell7.innerHTML = a+lastRow+","+no+","+id_investasi+","+jumlah_investasi+","+estimasi_pendapatan+b;
        indek += 1;

        total_investasi = Number(total_investasi) + Number(jumlah_investasi);
        total_estimasi = Number(total_estimasi) + Number(estimasi_pendapatan);
        document.getElementById("total_investasi").innerHTML = numberWithCommas(total_investasi);
        document.getElementById("total_estimasi").innerHTML = numberWithCommas(total_estimasi);

        saldo = Number(saldo) - jumlah_investasi;

      }else{
        alert("Saldo Tidak Mencukupi, Saldo anda hanya "+ numberWithCommas(saldo));
      }
    }

    function Hapus(id,no,ives,jumlah_investasi,jumlah_estimasi){
      Swal.fire(
        'Delete ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          $.ajax({
             url: 'deleteinves/'+id,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){

               total_investasi = Number(total_investasi) - Number(jumlah_investasi);
               total_estimasi = Number(total_estimasi) - Number(jumlah_estimasi);
               document.getElementById("total_investasi").innerHTML = numberWithCommas(total_investasi);
               document.getElementById("total_estimasi").innerHTML = numberWithCommas(total_estimasi);

               document.getElementById("dt"+no).style.background = "transparent";
               document.getElementById("ambil"+no).disabled = false;
               var row = document.getElementById(id);
               row.parentNode.removeChild(row);

               for (var i = 0; i < data_inves.length; i++) {
                 if (Number(data_inves[i]) == ives) {
                  delete data_inves[i];
                 }
               }

               saldo = Number(saldo)+Number(jumlah_investasi);

             }
           });
        }
      });
    }

    function Simpan(){
      if (data_inves.length > 0) {
        Swal.fire(
          'Simpan Data Investasi ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            $.ajax({
               url: 'simpaninvesbaru/'+data_inves.toString(),
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 Swal.fire({
                     title: 'Berhasil',
                     icon: 'success',
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Lanjutkan!'
                   }).then((result) => {
                     if (result.value) {
                       location.href="{{url('/datapengadaanbarang/')}}";
                     }else{
                       location.href="{{url('/datapengadaanbarang/')}}";
                     }
                   });
               }
             });
          }
        });
      }
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    </script>
@endsection
