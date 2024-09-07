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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Investasi > <a href="https://stokis.app/?s=catatan+transaksi+saldo+investasi" target="_blank">Data Transaksi</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                    <div class="col-md-4">
                      <form action="{{url('prosesinvestasi')}}" method="post">
                        <p><strong>Catatan Transaksi</strong></p>
                        {{csrf_field()}}
                        Nama Investor:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <input id="nama_investor" name="nama_karyawan" required type="text" readonly class="form-control" placeholder="Pilih Investor" style="background:#fff">
                                      <input id="id" name="id_karyawan" type="hidden" required class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Saldo saat ini:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" name="old_saldo" required type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Jenis Transaksi:
                        <select required onchange="Catatan()" name="cek" id="jenis" class="form-control">
                          <option value="out">Keluar</option>
                          <option value="in">Masuk</option>
                        </select>
                        <br>
                        Nominal:
                        <input required type="text" name="jumlah" class="form-control" data-a-sign="" id="nominal" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                        <br>
                        Catatan:
                        <select name="jenis" id="catatan" required class="form-control">
                          <option value="potongan">Administrasi Bank</option>
                          <option value="out">Pengambilan Investasi</option>
                          <option value="revisi_out">Revisi Pengurangan Investasi</option>
                        </select>
                        <br>
                        Catatan Tambahan:
                        <input type="text" name="keterangan" maxlength="60" class="form-control" placeholder="opsional">
                        <br>
                        
                        Tanggal Transaksi:
                        <input required type="date" name="tgl_transaksi" value="{{date('Y-m-d')}}" class="form-control">
                        <br>
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
                        <br><br>
                        
                        <div class="form-group">
                         <div class="col-4">
                        <input type="submit" value="Simpan" class="btn btn-primary form-control">
                        </div>
                        </div>
                      </form>
                      <br>
                    </div>
                    <?php endif; ?>
                    <hr><br>
				<div class="table-responsive">
                  <table id="transaksi_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan Transaksi</th>
                              <th>Investasi Masuk</th>
                              <th>Investasi Keluar</th>
                              <th>Saldo Investasi</th>
                              <th>Admin Proses</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"){ ?>
                          <?php $no=1; $jumlah=0; foreach ($transaksi as $key => $value): ?>
                            <tr>
                              <td>{{tanggal($value->tgl_transaksi)}}</td>
                              <td>
                                  <?php if ($value->jenis == "in"){
                                    echo "Investasi Masuk - ";
                                  }else if($value->jenis == "bagi"){
                                    echo "Bagi Hasil Pengadaan- (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "selesai"){
                                    echo "Pengadaan Selesai - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "pengadaan"){
                                    echo "Pengadaan Barang - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "out"){
                                    echo "Pengambilan investasi - ";
                                  }else if($value->jenis == "revisi"){
                                    echo "Revisi Penambahan investasi - ";
                                  }else if($value->jenis == "potongan"){
                                    echo "Administrasi Bank - ";
                                  }else if($value->jenis == "revisi_out"){
                                    echo "Revisi Pengurangan investasi - ";
                                  }else if($value->jenis == "lock"){
                                    echo "Bagi Hasil Lock Investasi ";
                                  }else if($value->jenis == "lockpengembang"){
                                    echo "Fee Pengembang Lock Investasi (".$value->keterangan_transaksi.") -";
                                  }else if($value->jenis == "lockleader"){
                                    echo "Fee Leader Lock Investasi (".$value->keterangan_transaksi.") -";
                                  }else if($value->jenis == "bagipengembang"){
                                    echo "Bagi Hasil Pengadaan Pengembang (".$value->keterangan_transaksi.")- ";
                                  }else if($value->jenis == "bagileader"){
                                    echo "Bagi Hasil Pengadaan Leader (".$value->keterangan_transaksi.")- ";
                                  } ?>
                                  <?php if ($value->jenis == "lock"): ?>
                                    ({{ribuan(100/$lock[$value->id_lock]*$value->jumlah)}}) -
                                  <?php endif; ?>
                                  {{$value->nama_investor}}
                                  <?php if ($value->keterangan_transaksi != "") {
                                    if ($value->jenis == "lockpengembang" || $value->jenis == "lockleader" || $value->jenis == "bagileader" || $value->jenis == "bagipengembang") {

                                    }else{
                                      echo " (".$value->keterangan_transaksi.")";
                                    }
                                  } ?>
                                  <?php if ($value->bukti != "") {
                                            echo " (Bukti Transfer:";?>
                                  <button class="btn btn-default" onclick="Load('<?=$value->bukti?>')">{{$value->bukti}})</button><br>
                                  <?php } ?>
                                </td>
                              <td align="right">
                                <?php if ($value->jenis == "in" || $value->jenis == "bagi" || $value->jenis == "selesai" || $value->jenis == "revisi" || $value->jenis == "lock"|| $value->jenis == "lockpengembang" || $value->jenis == "lockleader" || $value->jenis == "bagipengembang" || $value->jenis == "bagileader"):
                                  $jumlah += $value->jumlah;
                                  ?>
                                  {{ribuan($value->jumlah)}}
                                <?php endif; ?>
                              </td>
                              <td align="right">
                                <?php if ($value->jenis == "out" || $value->jenis == "pengadaan" || $value->jenis == "potongan" || $value->jenis == "revisi_out"):
                                  $jumlah -= $value->jumlah;?>
                                  {{ribuan($value->jumlah)}}
                                <?php endif; ?>
                              </td>
                              <td align="right">{{ribuan($jumlah)}}</td>
                              <td>
                                <?php if (isset($value->admin)): ?>
                                  {{$admin[$value->admin]}}
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php $no++; endforeach; ?>
                        <?php }else{ ?>
                          <?php $no=1; $jumlah=0; foreach ($transaksi as $key => $value): ?>
                            <tr>
                              <td>{{tanggal($value->tgl_transaksi)}}</td>
                              <td>
                                  <?php if ($value->jenis == "in"){
                                    echo "Investasi Masuk - ";
                                  }else if($value->jenis == "bagi"){
                                    echo "Bagi Hasil Pengadaan- (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "selesai"){
                                    echo "Pengadaan Selesai - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "pengadaan"){
                                    echo "Pengadaan Barang - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "out"){
                                    echo "Pengambilan investasi - ";
                                  }else if($value->jenis == "revisi"){
                                    echo "Revisi Penambahan investasi - ";
                                  }else if($value->jenis == "potongan"){
                                    echo "Administrasi Bank - ";
                                  }else if($value->jenis == "revisi_out"){
                                    echo "Revisi Pengurangan investasi - ";
                                  }else if($value->jenis == "lock"){
                                    echo "Bagi Hasil Lock Investasi ";
                                  }else if($value->jenis == "lockpengembang"){
                                    echo "Fee Pengembang Lock Investasi (".$value->keterangan_transaksi.") -";
                                  }else if($value->jenis == "lockleader"){
                                    echo "Fee Leader Lock Investasi (".$value->keterangan_transaksi.") -";
                                  }else if($value->jenis == "bagipengembang"){
                                    echo "Bagi Hasil Pengadaan Pengembang - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }else if($value->jenis == "bagileader"){
                                    echo "Bagi Hasil Pengadaan Leader - (".$value->jumlah_barang.") ".$barang[$value->id_barang]."-";
                                  }  ?>
                                  <?php if ($value->jenis == "lock"): ?>
                                    ({{ribuan(100/$lock[$value->id_lock]*$value->jumlah)}}) -
                                  <?php endif; ?>
                                  {{$value->nama_investor}}
                                  <?php if ($value->keterangan_transaksi != "") {
                                    if ($value->jenis == "lockpengembang" || $value->jenis == "lockleader" || $value->jenis == "bagileader" || $value->jenis == "bagipengembang") {

                                    }else{
                                      echo " (".$value->keterangan_transaksi.")";
                                    }
                                  } ?>
                                  <?php if ($value->bukti != "") { echo " <br>(".$value->bukti.")"; } ?>
                              </td>
                              <td>
                                <?php if ($value->jenis == "in" || $value->jenis == "bagi" || $value->jenis == "selesai" || $value->jenis == "revisi" || $value->jenis == "lock"|| $value->jenis == "lockpengembang" || $value->jenis == "lockleader"|| $value->jenis == "bagipengembang"|| $value->jenis == "bagileader"):
                                  $jumlah += $value->jumlah; ?>
                                  {{ribuan($value->jumlah)}}
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if ($value->jenis == "out" || $value->jenis == "pengadaan" || $value->jenis == "potongan" || $value->jenis == "revisi_out"):
                                  $jumlah -= $value->jumlah; ?>
                                  {{ribuan($value->jumlah)}}
                                <?php endif; ?>
                              </td>
                              <td>{{ribuan($jumlah)}}</td>
                              <td>
                                <?php if (isset($value->admin)): ?>
                                  {{$admin[$value->admin]}}
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php $no++; endforeach; ?>
                        <?php } ?>
                      </tbody>
                  </table>
                  <?php if (Auth::user()->level == "4"): ?>
                  <span class="btn-danger">PERHATIAN: Dana saving di bank harus sebesar Rp {{ribuan($jumlah-cek_semualock(cekmyid_investor()))}},-</span>
                  <?php endif; ?>
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
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
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
      new AutoNumeric('#nominal', "euroPos");
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
    
      
      function Load(img){
        document.getElementById("img").src = "{{ asset('gambar/bukti/')}}"+"/"+img;
        $('#image').modal('show');
      }
      function pilihbarang(id,nama,nik,alamat,hp,no,ats,nama_bank,saldo){
        $('#barang').modal('hide');
        document.getElementById("id").value = id;
        document.getElementById("nama_investor").value = nama;
        if (Number(saldo) < 1) {
          saldo = 0;
        }
        document.getElementById("saldo").value = numberWithCommas(saldo);
      }
      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      function Catatan(){
        var cek = document.getElementById("jenis").value;
        if (cek == "out") {
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x = document.createElement("OPTION");
          x.setAttribute("value","potongan");
          var t = document.createTextNode("Administrasi Bank");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);

          var x2 = document.createElement("OPTION");
          x2.setAttribute("value","out");
          var t2 = document.createTextNode("Pengambilan Investasi");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);

          var x2 = document.createElement("OPTION");
          x2.setAttribute("value","revisi_out");
          var t2 = document.createTextNode("Revisi Pengurangan Investasi");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);
        }else{
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x = document.createElement("OPTION");
          x.setAttribute("value","revisi");
          var t = document.createTextNode("Revisi Penambahan Investasi");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);
        }
      }
      function Verifikasi(id,nama,jumlah){
        document.getElementById("ids").value = id;
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
                 location.href="{{url('/inputinsentif/')}}";
               }
             });
          }
        });
      }
      </script>

      <script>
          $("#transaksi_table").DataTable(
            {
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                  {
                      extend: 'print',
                      columns: [ 0, 1, 2, 3 , 4 ,5],
                      customize: function ( win ) {
                          $(win.document.body)
                              .css( 'font-size', '10pt' );
                          $(win.document.body).find( 'table' )
                              .addClass( 'compact' )
                              .css( 'font-size', 'inherit' );
                      }
                  },
                  {

                      extend: 'excel',
                      title: namadon,
                      exportOptions: {
                             columns: [ 0, 1, 2, 3 , 4 ,5],
                             format: {
                                      body: function(data, row, column, node) {
                                        if(column===2){
                                          return data.split(".").join("");
                                        }
                                        if(column===1){
                                          var temp = data.split("                                  ").join("");
                                          temp = temp.split("<br>").join("-");
                                          temp = temp.split('<button class="btn btn-default" onclick="Load(').join("");
                                          temp = temp.split(')">').join("");
                                          temp = temp.split('</button>').join("");
                                          var res = temp.split("'");
                                          if (res.length > 1) {
                                            temp = res[0]+res[2];
                                          }
                                          return temp;
                                        }
                                        if(column===3){
                                          return data.split(".").join("");
                                        }
                                        if(column===4){
                                          return data.split(".").join("");
                                        }
                                        if(column===12){
                                          return data.split(".").join("");
                                        }
                                        if(column===13){
                                          return data.split(".").join("");
                                        }
                                        if(column===14){
                                          return data.split(".").join("");
                                        }
                                        if(column===15){
                                          return data.split(".").join("");
                                        }else{
                                          return data
                                        }
                                      }
                        }
                     }

                  },
                  {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    title: namadon,
                      customize: function ( win ) {
                        win.defaultStyle.fontSize = 10
                      },
                      exportOptions: {
                        columns: [ 0, 1, 2, 3 , 4 ,5]
                      }
                  }
                ]
            }
          ).page('last').draw('page');
      </script>
@endsection
