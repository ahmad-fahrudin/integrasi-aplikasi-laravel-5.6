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
                              <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Insentif Pemasaran > <a href="https://stokis.app/?s=data+insentif" target="_blank">Data Insentif</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                    <div class="col-md-4">
                      <form action="{{url('prosesinsentif')}}" method="post">
                        <p><strong>Catatan Transaksi</strong></p>
                        {{csrf_field()}}
                        Nama Karyawan:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <input id="nama_investor" name="nama_karyawan" required type="text" readonly class="form-control" placeholder="Cari karyawan">
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
                          <option value="Potongan Insentif">Administrasi Bank</option>
                          <option>Pengambilan Insentif</option>
                          <option>Revisi Pengurangan Insentif</option>
                        </select>
                        <br>
                        Catatan Tambahan:
                        <input type="text" name="keterangan" class="form-control" placeholder="opsional">
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
                      <br><br>
                    </div>
                    <?php endif; ?>
									<div class="table-responsive">
                  <table id="insentif_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan Transaksi</th>
                              <th>Insentif Masuk</th>
                              <th>Insentif Keluar</th>
                              <th>Saldo Insentif</th>
                              <th>Admin</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; $jumlah = 0; foreach ($insentif as $key => $value):?>
                          <tr>
                            <td>
                              <?php if ($value->tgl_verifikasi != ""){ ?>
                              {{tanggal($value->tgl_verifikasi)}}
                              <?php }else{ ?>
                              {{tanggal($value->tgl_transaksi)}}
                            <?php } ?></td>
                            <td>{{$value->no_trip}}<?php if ($value->jenis != "Trip") {
                              if ($value->jenis == "Potongan Insentif") {
                                echo "Administrasi Bank";
                              }else{
                                if ($value->jenis == "Bagi Hasil Stokis") {
                                    echo "-".$value->jenis;
                                }else{
                                    echo $value->jenis;
                                }
                              }
                            }?>
                            <?php if ($value->jenis == "Fee Transfer Insentif"): ?>
                              ({{$value->keterangan}})
                            <?php endif; ?>
                            -{{$value->nama_karyawan}}
                            <?php if ($value->keterangan != "" && $value->jenis != "Fee Transfer Insentif"){
                              echo " (".$value->keterangan.")";
                            } ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "Trip" || $value->jenis == "Revisi Penambahan Insentif" || $value->jenis == "Bagi Hasil HPP"  || $value->jenis == "Bagi Hasil Stokis" || $value->jenis == "Fee Transfer Insentif"): $jumlah += $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "Potongan Insentif" || $value->jenis == "Pengambilan Insentif" || $value->jenis == "Potongan Administrasi" || $value->jenis == "Revisi Pengurangan Insentif"): $jumlah -= $value->jumlah;?>
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
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama}}','{{$value->nik}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->no_rekening}}','{{$value->ats_bank}}','{{$value->nama_bank}}','{{$value->saldo}}')">
                          <td>{{$value->nik}}</td>
                          <td>{{$value->nama}}</td>
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

      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <br>
              <form action="{{url('/verifikasipenarikan')}}" method="post">
              {{csrf_field()}}
              Nama Karyawan<br><input type="text" id="nama" readonly class="form-control">
              Jumlah Penarikan<br><input type="text" id="jumlah" readonly class="form-control">
              <input type="hidden" name="id" id="ids">
              Administrasi Bank<br><input type="text" name="jumlah" id="in_jumlah" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." class="form-control"><br>
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
    new AutoNumeric('#nominal', "euroPos");
    new AutoNumeric('#in_jumlah', "euroPos");
    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(id,nama,nik,alamat,hp,no,ats,nama_bank,saldo){
      $('#barang').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("nama_investor").value = nama;
      document.getElementById("saldo").value = numberWithCommas(saldo);

      $.ajax({
         url: 'updins/'+nik,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
         }
       });

    }

  function Transaksi(){
      var tr = document.getElementById("transaksi").value;
      if(tr == "transfer"){
          document.getElementById("rekening").hidden = false;
      }else{
          document.getElementById("rekening").hidden = true;
      }
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
        x.setAttribute("value","Potongan Insentif");
        var t = document.createTextNode("Administrasi Bank");
        x.appendChild(t);
        document.getElementById("catatan").appendChild(x);

        var x2 = document.createElement("OPTION");
        x2.setAttribute("value","Pengambilan Insentif");
        var t2 = document.createTextNode("Pengambilan Insentif");
        x2.appendChild(t2);
        document.getElementById("catatan").appendChild(x2);

        var x3 = document.createElement("OPTION");
        x3.setAttribute("value","Revisi Pengurangan Insentif");
        var t3 = document.createTextNode("Revisi Pengurangan Insentif");
        x3.appendChild(t3);
        document.getElementById("catatan").appendChild(x3);
      }else{
        var select = document.getElementById("catatan");
        var length = select.options.length;
        for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
        }

        var x = document.createElement("OPTION");
        x.setAttribute("value","Revisi Penambahan Insentif");
        var t = document.createTextNode("Revisi Penambahan Insentif");
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
        $("#insentif_table").DataTable(
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
