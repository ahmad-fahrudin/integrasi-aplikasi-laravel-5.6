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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > <a href="https://stokis.app/?s=transaksi+keluar+masuk+kas+di+bank" target="_blank">Kas di Bank</a></li>
                          </ol>
                      </nav>
                    </h4>

                    <div class="col-md-4">
                      <form action="{{url('proseskasdibank')}}" method="post" id="form_proseslabarugi" onsubmit="return validateForm()" enctype="multipart/form-data">
                        <p><strong>Catatan Transaksi</strong></p>
                        {{csrf_field()}}
                        Saldo saat ini:
                        <div class="row">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="saldo" name="old_saldo" required type="text" readonly class="form-control" value={{ribuan(cek_kas_dibank())}}>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        Jenis Transaksi:
                        <select required onchange="Catatan()" name="cek" id="jenis" class="form-control">
                          <option value="in">Masuk</option>
                          <option value="out">Keluar</option>
                        </select>
                        <br>
                        Nominal:
                        <input required type="text" name="jumlah" class="form-control" data-a-sign="" id="nominal" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                        <br>
                        Kategori Transaksi:
                        <select name="nama_jenis" id="catatan" required class="form-control" onchange="cekchange()">
                          <option>Modal</option>
                          <option>Pembiayaan</option>
                          <option>Setoran Penjualan</option>
                          <option>Setoran Jasa</option>
                          <option>Pemasukan Lain - Lain</option>
                          <option>Deposit Saldo</option>
                          <option>PPN</option>
                          <option>Revisi</option>
                        </select>
                        <br>
                        Rekening:
                        <select class="form-control" name="kode_bank">
                            <option disabled selected>Pilih Rekening</option>
                          <?php foreach ($rekening as $key => $value): ?>
                            <option value="{{$value->id}}">{{$value->nama}} ({{$value->no_rekening}})</option>
                          <?php endforeach; ?>
                        </select>
                        <br>
                        
                        <div id="kerekening" hidden>
                        Pindah ke Rekening:
                        <select class="form-control" name="kode_bank_transfer" id="kode_bank_transfer">
                            <option disabled selected>Pilih Rekening</option>
                          <?php foreach ($rekening as $key => $value): ?>
                            <option value="{{$value->id}}">{{$value->nama}} ({{$value->no_rekening}})</option>
                          <?php endforeach; ?>
                        </select>
                        <br>
                        </div>
                        
                        
                        Catatan:
                        <input type="text" name="keterangan" class="form-control" required placeholder="Keterangan transaksi">
                        <br>
                        Tanggal Transaksi:
                        <input required type="date" name="tgl_transaksi" value="{{date('Y-m-d')}}" class="form-control">
                        <br>
                        <div class="form-group">
                        <div class="col-4">
                        <input type="submit" value="Simpan" class="btn btn-primary form-control">
                        </div>
                        </div>
                      </form>
                      <br>
                    </div>
                    <hr>
                    <form action="{{url('kasdibank')}}" method="post">
                      {{csrf_field()}}
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                        <p><strong>Filter Berdasarkan</strong></p>

                    <div class="form-group">
                      <div class="row">
                        <label class="col-lg-2">Range Tanggal</label>
                        <div class="col-md-2">
                          <div class="row">
                            <div class="col-md-12">
                              <input type="date" name="from"
                              <?php if (isset($from)): ?>
                                value="{{$from}}"
                              <?php endif; ?>
                              class="form-control">
                            </div>
                          </div>
                        </div>
                        <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                        <div class="col-md-2">
                          <div class="row">
                            <div class="col-md-12">
                              <input type="date" name="to"
                              <?php if (isset($to)): ?>
                                value="{{$to}}"
                              <?php endif; ?>
                              class="form-control">
                            </div>
                          </div>
                        </div>

                    <div class="col-md-1">
                      <div class="row">
                        <div class="col-md-2">&emsp;&emsp;
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <label class="col-lg-2">Jenis Transaksi</label>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-12">
                          <select onchange="CatatanFilter()" name="jenis" id="jenis_filter" class="form-control">
                            <option value="">Semua</option>
                            <option value="in" <?php if (isset($jenis) && $jenis == "in"): ?>selected<?php endif; ?>>Masuk</option>
                            <option value="out" <?php if (isset($jenis) && $jenis == "out"): ?>selected<?php endif; ?>>Keluar</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <label class="col-lg-0.5">Catatan</label>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-12">
                          <?php if (isset($jenis) && $jenis == "in"){ ?>
                            <select name="nama_jenis" id="catatan_filter" class="form-control">
                              <option value="">Semua</option>
                              <option <?php if ($nama_jenis == "Modal"): ?>selected<?php endif; ?>>Modal</option>
                              <option <?php if ($nama_jenis == "Pembiayaan"): ?>selected<?php endif; ?>>Pembiayaan Investasi</option>
                              <option <?php if ($nama_jenis == "Setoran Penjualan"): ?>selected<?php endif; ?>>Setoran Penjualan</option>
                              <option <?php if ($nama_jenis == "Setoran Jasa"): ?>selected<?php endif; ?>>Setoran Jasa</option>
                              <option <?php if ($nama_jenis == "Pemasukan Lain - Lain"): ?>selected<?php endif; ?>>Pemasukan Lain - Lain</option>
                              <option <?php if ($nama_jenis == "Ambil dari Bank"): ?>selected<?php endif; ?>>Deposit Saldo</option>
                            </select>
                          <?php }else if(isset($jenis) && $jenis == "out"){ ?>
                            <select name="nama_jenis" id="catatan_filter" class="form-control">
                              <option value="">Semua</option>
                              <option <?php if ($nama_jenis == "Pengadaan Barang"): ?>selected<?php endif; ?>>Pengadaan Barang</option>
                              <option <?php if ($nama_jenis == "Beban Operasional"): ?>selected<?php endif; ?>>Beban Operasional</option>
                              <option <?php if ($nama_jenis == "Penarikan Investasi"): ?>selected<?php endif; ?>> Penarikan Investasi</option>
                              <option <?php if ($nama_jenis == "Insentif Non Gaji"): ?>selected<?php endif; ?>>Insentif Non Gaji</option>
                              <option <?php if ($nama_jenis == "Prive Modal"): ?>selected<?php endif; ?>>Prive Modal</option>
                              <option <?php if ($nama_jenis == "Bon Karyawan"): ?>selected<?php endif; ?>>Bon Karyawan</option>
                              <option <?php if ($nama_jenis == "Pengeluaran Lain - Lain"): ?>selected<?php endif; ?>>Pengeluaran Lain - Lain</option>
                              <option <?php if ($nama_jenis == "Simpan di Bank"): ?>selected<?php endif; ?>>Penarikan Saldo</option>
                            </select>
                          <?php }else{ ?>
                            <select name="nama_jenis" id="catatan_filter" class="form-control">
                              <option value="">Semua</option>
                              <option>Modal</option>
                              <option>Pembiayaan</option>
                              <option>Setoran Penjualan</option>
                              <option>Setoran Jasa</option>
                              <option>Pemasukan Lain - Lain</option>
                              <option>Deposit Saldo</option>
                              <option>Pengadaan Barang</option>
                            </select>
                          <?php } ?>
                        </div>
                      </div>
                    </div>

              </div>
              <br>

              <div class="row">
                <label class="col-lg-2">Rekening</label>
                <div class="col-md-2">
                  <div class="row">
                    <div class="col-md-12">
                      <select name="kode_bank" id="kode_bank" class="form-control">
                        <option value="">Semua</option>
                        <?php foreach ($rekening as $key => $value): ?>
                          <option value="{{$value->id}}"
                            <?php if (isset($kode_bank) && $kode_bank == $value->id): ?>
                              selected
                            <?php endif; ?>
                          >{{$value->nama}} ({{$value->no_rekening}})</option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                
                <br><br>
            <center>
            <div class="form-group">
            
              <div class="col-lg-12">
                <input type="submit" class="form-control btn-success" value="Filter Data">
              </div>
              
            </div>
            </center>
          </div>


                </div>
              </div>
                    </form>
                    <hr><br>

									<div class="table-responsive">
                  <table id="labarugi_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Keterangan</th>
                              <th>Kas Masuk</th>
                              <th>Kas Keluar</th>
                              <th>Saldo Kas</th>
                              <th>Admin</th>
                          </tr>
                      </thead>

                      <tbody>
                        <?php $no=1; $jumlah=0; foreach ($kasdibank as $key => $value): ?>
                          <tr>
                            <td>{{tanggal($value->tgl_transaksi)}}</td>
                            <td>{{$value->keterangan}}</td>
                            <td align="right">
                              <?php if ($value->jenis == "in"): $jumlah += $value->jumlah;?>
                                {{ribuan($value->jumlah)}}
                              <?php endif; ?>
                            </td>
                            <td align="right">
                              <?php if ($value->jenis == "out"): $jumlah -= $value->jumlah;?>
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
                        <?php $no++; endforeach;
                        echo '<script type="text/javascript">',
                             '
                             document.getElementById("saldo").value = '.'"'.ribuan($jumlah).'"'.'
                             ',
                             '</script>'
                             ;
                        ?>
                      </tbody>

              </table>
            </div>

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
      //new AutoNumeric('#in_jumlah', "euroPos");
      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    
      function cekchange(){
          var val = document.getElementById("catatan").value;
          if (val == "Pindah rekening bank"){
              document.getElementById("kerekening").hidden = false;
          }else{
              document.getElementById("kode_bank_transfer").value = "Pilih Rekening";
              document.getElementById("kerekening").hidden = true;
          }
      }
    
      function validateForm() {
        var jenis_transaksi = document.getElementById("jenis").value;
        if (jenis_transaksi == "out") {
          var saldo = document.getElementById("saldo").value;
          saldo = saldo.split(".").join("");
          var in_saldo = document.getElementById("nominal").value;
          in_saldo = in_saldo.split(".").join("");
          if(Number(in_saldo) < 1){
            Swal.fire({
                title: 'Saldo Tidak Mencukupi',
                icon: 'info',
            });
            return false;
          }else if (Number(saldo) >= Number(in_saldo)) {
            return true;
          }else{
            Swal.fire({
                title: 'Saldo Tidak Mencukupi',
                icon: 'info',
            });
            return false;
          }
        }else{
          return true;
        }

      }

      function Catatan(){
      document.getElementById("kode_bank_transfer").value = "Pilih Rekening";
      document.getElementById("kerekening").hidden = true;
              
        var cek = document.getElementById("jenis").value;
        if (cek == "out") {
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x = document.createElement("OPTION");
          var t = document.createTextNode("Pengadaan Barang");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);

          var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Beban Operasional");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);

          var x3 = document.createElement("OPTION");
          var t3 = document.createTextNode("Penarikan Investasi");
          x3.appendChild(t3);
          document.getElementById("catatan").appendChild(x3);

          var x4 = document.createElement("OPTION");
          var t4 = document.createTextNode("Insentif Non Gaji");
          x4.appendChild(t4);
          document.getElementById("catatan").appendChild(x4);

          var x5 = document.createElement("OPTION");
          var t5 = document.createTextNode("Prive Modal");
          x5.appendChild(t5);
          document.getElementById("catatan").appendChild(x5);

          var x6 = document.createElement("OPTION");
          var t6 = document.createTextNode("Bon Karyawan");
          x6.appendChild(t6);
          document.getElementById("catatan").appendChild(x6);

          var x7 = document.createElement("OPTION");
          var t7 = document.createTextNode("Pengeluaran Lain - Lain");
          x7.appendChild(t7);
          document.getElementById("catatan").appendChild(x7);

          var x8 = document.createElement("OPTION");
          var t8 = document.createTextNode("Penarikan Saldo");
          x8.appendChild(t8);
          document.getElementById("catatan").appendChild(x8);
          
          var x9 = document.createElement("OPTION");
          var t9 = document.createTextNode("Pindah rekening bank");
          x9.appendChild(t9);
          document.getElementById("catatan").appendChild(x9);
          
          var x10 = document.createElement("OPTION");
          var t10 = document.createTextNode("Bayar PPN");
          x10.appendChild(t10);
          document.getElementById("catatan").appendChild(x10);
          
          var x11 = document.createElement("OPTION");
          var t11 = document.createTextNode("Revisi");
          x11.appendChild(t11);
          document.getElementById("catatan").appendChild(x11);

        }else{
          var select = document.getElementById("catatan");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }
          var x = document.createElement("OPTION");
          var t = document.createTextNode("Modal");
          x.appendChild(t);
          document.getElementById("catatan").appendChild(x);

          var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Pembiayaan");
          x2.appendChild(t2);
          document.getElementById("catatan").appendChild(x2);

          var x3 = document.createElement("OPTION");
          var t3 = document.createTextNode("Setoran Penjualan");
          x3.appendChild(t3);
          document.getElementById("catatan").appendChild(x3);

          var x4 = document.createElement("OPTION");
          var t4 = document.createTextNode("Setoran Jasa");
          x4.appendChild(t4);
          document.getElementById("catatan").appendChild(x4);

          var x5 = document.createElement("OPTION");
          var t5 = document.createTextNode("Pemasukan Lain - Lain");
          x5.appendChild(t5);
          document.getElementById("catatan").appendChild(x5);

          var x6 = document.createElement("OPTION");
          var t6 = document.createTextNode("Deposit Saldo");
          x6.appendChild(t6);
          document.getElementById("catatan").appendChild(x6);
          
          var x7 = document.createElement("OPTION");
          var t7 = document.createTextNode("PPN");
          x7.appendChild(t7);
          document.getElementById("catatan").appendChild(x7);
          
          var x8 = document.createElement("OPTION");
          var t8 = document.createTextNode("Revisi");
          x8.appendChild(t8);
          document.getElementById("catatan").appendChild(x8);
        }
      }

      function CatatanFilter(){
        var cek = document.getElementById("jenis_filter").value;
        if (cek == "out") {
          var select = document.getElementById("catatan_filter");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x0 = document.createElement("OPTION");
          var t0 = document.createTextNode("Semua");
          x0.appendChild(t0);
          document.getElementById("catatan_filter").appendChild(x0);

          var x = document.createElement("OPTION");
          var t = document.createTextNode("Pengadaan Barang");
          x.appendChild(t);
          document.getElementById("catatan_filter").appendChild(x);

          var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Beban Operasional");
          x2.appendChild(t2);
          document.getElementById("catatan_filter").appendChild(x2);

          var x3 = document.createElement("OPTION");
          var t3 = document.createTextNode("Penarikan Investasi");
          x3.appendChild(t3);
          document.getElementById("catatan_filter").appendChild(x3);

          var x4 = document.createElement("OPTION");
          var t4 = document.createTextNode("Insentif Non Gaji");
          x4.appendChild(t4);
          document.getElementById("catatan_filter").appendChild(x4);

          var x5 = document.createElement("OPTION");
          var t5 = document.createTextNode("Prive Modal");
          x5.appendChild(t5);
          document.getElementById("catatan_filter").appendChild(x5);

          var x6 = document.createElement("OPTION");
          var t6 = document.createTextNode("Bon Karyawan");
          x6.appendChild(t6);
          document.getElementById("catatan_filter").appendChild(x6);

          var x7 = document.createElement("OPTION");
          var t7 = document.createTextNode("Pengeluaran Lain - Lain");
          x7.appendChild(t7);
          document.getElementById("catatan_filter").appendChild(x7);

          var x8 = document.createElement("OPTION");
          var t8 = document.createTextNode("Penarikan Saldo");
          x8.appendChild(t8);
          document.getElementById("catatan_filter").appendChild(x8);
          
          var x9 = document.createElement("OPTION");
          var t9 = document.createTextNode("Pindah rekening bank");
          x9.appendChild(t9);
          document.getElementById("catatan_filter").appendChild(x9);
          
          var x10 = document.createElement("OPTION");
          var t10 = document.createTextNode("Bayar PPN");
          x10.appendChild(t10);
          document.getElementById("catatan_filter").appendChild(x10);
          
          var x11 = document.createElement("OPTION");
          var t11 = document.createTextNode("Revisi");
          x11.appendChild(t11);
          document.getElementById("catatan_filter").appendChild(x11);
          
        }else{
          var select = document.getElementById("catatan_filter");
          var length = select.options.length;
          for (i = length-1; i >= 0; i--) {
          select.options[i] = null;
          }

          var x0 = document.createElement("OPTION");
          var t0 = document.createTextNode("Semua");
          x0.appendChild(t0);
          document.getElementById("catatan_filter").appendChild(x0);

          var x = document.createElement("OPTION");
          var t = document.createTextNode("Modal");
          x.appendChild(t);
          document.getElementById("catatan_filter").appendChild(x);

          var x2 = document.createElement("OPTION");
          var t2 = document.createTextNode("Pembiayaan");
          x2.appendChild(t2);
          document.getElementById("catatan_filter").appendChild(x2);

          var x3 = document.createElement("OPTION");
          var t3 = document.createTextNode("Setoran Penjualan");
          x3.appendChild(t3);
          document.getElementById("catatan_filter").appendChild(x3);

          var x4 = document.createElement("OPTION");
          var t4 = document.createTextNode("Setoran Jasa");
          x4.appendChild(t4);
          document.getElementById("catatan_filter").appendChild(x4);

          var x5 = document.createElement("OPTION");
          var t5 = document.createTextNode("Pemasukan Lain - Lain");
          x5.appendChild(t5);
          document.getElementById("catatan_filter").appendChild(x5);

          var x6 = document.createElement("OPTION");
          var t6 = document.createTextNode("Deposit Saldo");
          x6.appendChild(t6);
          document.getElementById("catatan_filter").appendChild(x6);
          
          var x7 = document.createElement("OPTION");
          var t7 = document.createTextNode("PPN");
          x7.appendChild(t7);
          document.getElementById("catatan_filter").appendChild(x7);
          
          var x8 = document.createElement("OPTION");
          var t8 = document.createTextNode("Revisi");
          x8.appendChild(t8);
          document.getElementById("catatan_filter").appendChild(x8);
        }
      }
      </script>

      <script>
          $("#labarugi_table").DataTable(
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
