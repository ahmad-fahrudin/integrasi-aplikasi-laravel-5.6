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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Laporan Kiriman > <a href="https://stokis.app/?s=cara+proses+laporan+penjualan+terkirim+dan+batal+setelah+proses+pengiriman" target="_blank">Proses Terkirim (Penerimaan Laporan Pengiriman)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id" type="hidden" class="form-control">
                                    <input id="no_kwitansi" type="text" class="form-control" placeholder="Pilih No. Kwitansi" readonly style="background:#fff">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripenjualan()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Kiriman</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_proses" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama_gudang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>  
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Kiriman</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="status_order" class="form-control">
                                        <option value="terkirim">Terkirim</option>
                                        <option value="kirim ulang">Kirim Ulang</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Tanggal Terkirim</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly id="tanggal_terkirim" value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Data Member</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Member</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="id_konsumen" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Kategori</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="kategori" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <p class="form-control1" id="alamat" style="height:auto;padding-bottom:30px"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div hidden class="row">
                          <label class="col-lg-3">No. Telepon</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="no_hp" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="pengembang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                       <br> 
                      </div>

                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Sales</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="sales" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="leader" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="manager" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div hidden class="row">
                          <label class="col-lg-3">Admin(P)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_p" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Admin Gudang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_g" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">QC Gudang</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="qc" type="text" class="form-control" placeholder="Pilih QC Gudang" readonly style="background:#fff">
                                    <input id="id_qc" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Dropper</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="dropper" type="text" class="form-control" placeholder="Pilih Droper Pengirim" readonly style="background:#fff">
                                    <input id="id_dropper" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caridropper()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengirim</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="pengirim" type="text" class="form-control" placeholder="Pilih Driver Kiriman" readonly style="background:#fff">
                                    <input id="id_pengirim" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripengirim()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Helper</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="helper" type="text" class="form-control" placeholder="Pilih Helper Kiriman" readonly style="background:#fff">
                                    <input id="id_helper" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="carihelper()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Admin(V)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_g" type="text" value="{{Auth::user()->username}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <label class="col-lg-3">Ongkos Kirim</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="ongkos_kirim" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                    </div>


                  <br><hr>
				<div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr style="background:#f5f5f5">
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Jumlah Order</th>
                              <th>Jumlah Proses</th>
                              <th>Jumlah Batal</th>
                              <th>Jumlah Terkirim</th>
                              <th>Harga Jual</th>
                              <th>Potongan</th>
                              <th>Jumlah Harga</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                  <h3 align="right">Total Bayar = Rp. <b id="total_bayar">0</b>,-</h3>
								</div>
                <hr><br>
                <center>

                
                  <?php if (Auth::user()->level == "1" ||Auth::user()->level == "4"): ?>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-4 text-left">
                        Status Pembayaran :
                      </div>
                      <div class="col-md-8">
                        <select id="status_pembayaran" class="form-control" onchange="pembayaran_terkirim()">
                          <option>Tempo</option>
                          <option>Titip</option>
                          <option>Lunas</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row" id="panel_pembayaran" hidden>
                      <div class="col-md-4 text-left">
                        Jumlah Pembayaran :
                      </div>
                      <div class="col-md-8">
                        <input type="number" id="jumlah_pembayaran" class="form-control" data-a-sign="" data-a-dec="," data-a-pad="false" data-a-sep="." value="">
                      </div>

                      <br>
                      <div class="col-md-4 text-left">
                        Metode Pembayaran:
                      </div>
                    <div class="col-md-8">
                      <select class="form-control" id="jenis_pembayaran" onchange="CekBankAktif()">
                            <option>Tunai</option>
                            <option>Transfer</option>
                        </select>
                        
                        <select class="form-control" id="no_rekening_bank" hidden="">
                            <option>--Pilih Rekening Bank--</option>
                            <?php foreach($rekening as $key => $value){ ?>
                            <option value="{{$value->id}}">{{$value->nama}} - {{$value->no_rekening}}</option>
                            <?php } ?>
                        </select>
                    </div>
                    
                  </div>
                  <?php endif; ?>
                  <br><br>
                  <button class="btn btn-success btn-lg" id="save" onclick="Simpan()">Simpan</button>
                  <!--button class="btn btn-danger btn-lg">Batal</button-->
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="transfer" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No. Kwitansi</th>
                          <th>Nama Konsumen</th>
                          <th>Cabang</th>
                          <th>Tanggal Order</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transfer as $value){
                      //dd($value);
                      if (isset($value->pengembang)) {
                        if(isset($karyawan[$value->pengembang])){
                          $pengembang = $karyawan[$value->pengembang]['nama'];
                        }else{
                          $pengembang = $konsumen[$value->pengembang]['nama_pemilik'];
                        }
                      }else{
                        $pengembang = "";
                      }

                      if (isset($value->leader)) {
                        if(isset($karyawan[$value->leader])){
                          $leader = $karyawan[$value->leader]['nama'];
                        }else{
                          $leader = $konsumen[$value->leader]['nama_pemilik'];
                        }
                      }else{
                        $leader = "";
                      }

                        if(isset($kategori[$value->kategori])){
                          $kategoria = $kategori[$value->kategori]['nama_kategori'];
                        }else{
                          $kategoria = $value->kategori;
                        }

                        if (isset($konsumen[$value->id_konsumen]['nama_pemilik'])) {
                          $konsm = $konsumen[$value->id_konsumen]['nama_pemilik'];
                          $konsm_al = $konsumen[$value->id_konsumen]['alamat'];
                          $konsm_hp = $konsumen[$value->id_konsumen]['no_hp'];
                          $kategori_konsumen = $konsumen[$value->id_konsumen]['kategori_konsumen'];
                        }else{
                          $konsm = $karyawan[$value->id_konsumen]['nama'];
                          $konsm_al = $karyawan[$value->id_konsumen]['alamat'];
                          $konsm_hp = $karyawan[$value->id_konsumen]['no_hp'];
                          $kategori_konsumen = "Non PKP";
                        }

                        if(isset($konsumen[$value->id_konsumen])){
                          $id_kons = $konsumen[$value->id_konsumen]['id_konsumen'];
                          $kategoria = $kategori[$konsumen[$value->id_konsumen]['kategori']]['nama_kategori'];
                        }else{
                          $id_kons = $value->id_konsumen;
                          $kategoria = $value->kategori;
                        }

                        if(isset($karyawan[$value->manager])){
                          $mngr = $karyawan[$value->manager]['nama'];
                        }else{
                          $mngr = "";
                        }

                        if(isset($karyawan[$value->qc])){
                          $qcv = $karyawan[$value->qc]['nama'];
                        }else{
                          $qcv = "";
                        }

                        if(isset($karyawan[$value->dropper])){
                          $dropperv = $karyawan[$value->dropper]['nama'];
                        }else{
                          $dropperv = "";
                        }

                        if(isset($karyawan[$value->pengirim])){
                          $pengirimv = $karyawan[$value->pengirim]['nama'];
                        }else{
                          $pengirimv = "";
                        }

                        if(isset($karyawan[$value->helper])){
                          $helperv = $karyawan[$value->helper]['nama'];
                        }else{
                          $helperv = "";
                        }


                      ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_proses}}','{{$id_kons}}',
                                                '{{$konsm}}','{{$konsm_al}}','{{$konsm_hp}}',
                                                '{{$gudang[$value->id_gudang]['nama_gudang']}}','{{$karyawan[$value->sales]['nama']}}',
                                                '{{$pengembang}}','{{$leader}}','{{$mngr}}','{{$users[$value->admin_p]['name']}}','{{$kategoria}}',
                                                '{{$qcv}}','{{$dropperv}}','{{$pengirimv}}','{{$users[$value->admin_g]['name']}}','{{$value->qc}}','{{$value->dropper}}','{{$value->pengirim}}',
                                                '{{$value->helper}}','{{$helperv}}','{{$value->ongkos_kirim}}','{{$kategori_konsumen}}'
                                                )">
                          <td>{{$value->no_kwitansi}}</td>
                          <td>{{$konsm}}</td>
                          <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                          <td>{{$value->tanggal_order}}</td>
                      </tr>
                     <?php } ?>
                     <?php foreach ($transfer2 as $value){ $kategori_konsumen = "Non PKP";?>
                       <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_proses}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}',
                                                 '{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama_gudang}}','{{$value->sales}}',
                                                 '{{$value->pengembang}}','{{$value->leader}}','{{$value->manager}}','{{$value->admin_p}}','{{$value->kategori}}',
                                                 '{{$value->qc}}','{{$value->dropper}}','{{$value->pengirim}}','{{$value->admin_g}}','{{$value->id_qc}}','{{$value->id_dropper}}','{{$value->id_pengirim}}',
                                                 '{{$value->id_helper}}','{{$value->helper}}','{{$value->ongkos_kirim}}','{{$kategori_konsumen}}'
                                                 )">
                           <td>{{$value->no_kwitansi}}</td>
                           <td>{{$value->nama_pemilik}}</td>
                           <td>{{$value->nama_gudang}}</td>
                           <td>{{$value->tanggal_order}}</td>
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

      <div class="modal fade" id="qcs" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                  <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th hidden>NIK</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>No. Telepon</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($qc as $value){ ?>
                          <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
                              <td hidden>{{$value->nik}}</td>
                              <td>{{$value->nama}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td>{{$value->no_hp}}</td
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

        <div class="modal fade" id="droppers" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                  <div class="table-responsive">
                    <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th hidden>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No.Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dropper as $value){ ?>
                            <tr onclick="pilihdropper('{{$value->id}}','{{$value->nama}}')">
                                <td hidden>{{$value->nik}}</td>
                                <td>{{$value->nama}}</td>
                                <td><?php echo $value->alamat; ?></td>
                                <td>{{$value->no_hp}}</td
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

          <div class="modal fade" id="pengirims" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">

                    <div class="table-responsive">
                      <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                          <thead>
                              <tr>
                                  <th hidden>NIK</th>
                                  <th>Nama</th>
                                  <th>Alamat</th>
                                  <th>No. Telepon</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($pengirim as $value){ ?>
                              <tr onclick="pilihpengirim('{{$value->id}}','{{$value->nama}}')">
                                  <td hidden>{{$value->nik}}</td>
                                  <td>{{$value->nama}}</td>
                                  <td><?php echo $value->alamat; ?></td>
                                  <td>{{$value->no_hp}}</td
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

            <div class="modal fade" id="helpers" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                      <div class="table-responsive">
                        <table id="examples4" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th hidden>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($pengirim as $value){ ?>
                                <tr onclick="pilihhelper('{{$value->id}}','{{$value->nama}}')">
                                    <td hidden>{{$value->nik}}</td>
                                    <td>{{$value->nama}}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{$value->no_hp}}</td
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

      <div class="modal fade" id="edit" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Nama Sparepart :</label>
                  </div>
                  <div class="col-md-4" readonly>
                    <p id="jumlah"></p>
                  </div>
                </div>
                <br>
                
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Jumlah Proses :</label>
                  </div>
                  <div class="col-md-4">
                    <input type="number" readonly id="proses" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Jumlah Diterima :</label>
                  </div>
                  <div class="col-md-4">
                    <input type="hidden" readonly id="id_detail" class="form-control">
                    <input type="number" id="terkirim" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                    <label>Potongan Harga (Subtotal):</label>
                  </div>
                  <div class="col-md-4">
                    <input id="potongan" value="0" class="form-control" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                  </div>
                </div>
                <br>
                <center><button onclick="rubah()" class="btn btn-primary">Update</button></center>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    new AutoNumeric('#potongan', "euroPos");
    new AutoNumeric('#jumlah_pembayaran', "euroPos");
    var tempid = [];
    var tempid_barang = [];
    var gudang = [];
    
    function pembayaran_terkirim(){
      var cek = document.getElementById("status_pembayaran").value;
      if (cek == "Titip" || cek == "Lunas") {
        document.getElementById("panel_pembayaran").hidden = false;
      }else if(cek == "Tempo"){
        document.getElementById("panel_pembayaran").hidden = true;
      }
    }

    
    function CekBankAktif(){
      var cek = document.getElementById("jenis_pembayaran").value;
      if (cek == "Transfer") {
        document.getElementById("no_rekening_bank").hidden = false;
      }else{
        document.getElementById("no_rekening_bank").hidden = true;
      }
    }

    function caripenjualan(){
      $('#transfer').modal('show');
    }

    function cariqc(){
      $('#qcs').modal('show');
    }

    function pilihqc(id,nama){
      $('#qcs').modal('hide');
      document.getElementById("id_qc").value = id;
      document.getElementById("qc").value = nama;
    }

    function caridropper(){
      $('#droppers').modal('show');
    }

    function pilihdropper(id,nama){
      $('#droppers').modal('hide');
      document.getElementById("id_dropper").value = id;
      document.getElementById("dropper").value = nama;
    }

    function caripengirim(){
      $('#pengirims').modal('show');
    }

    function pilihpengirim(id,nama){
      $('#pengirims').modal('hide');
      document.getElementById("id_pengirim").value = id;
      document.getElementById("pengirim").value = nama;
    }

    function carihelper(){
      $('#helpers').modal('show');
    }

    function pilihhelper(id,nama){
      $('#helpers').modal('hide');
      document.getElementById("id_helper").value = id;
      document.getElementById("helper").value = nama;
    }
    var kat_kon = "";
    function pilihbarang(id,no_kwitansi,tanggal_proses,id_konsumen,nama_pemilik,alamat,no_hp,nama_gudang,sales,
      pengembang,leader,manager,admin_p,kategori,qc,dropper,pengirim,admin_g,id_qc,id_dropper,id_pengirim,id_helper,helper,ongkos_kirim,kategori_konsumen){
      $('#transfer').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("no_kwitansi").value = no_kwitansi;
      document.getElementById("tanggal_proses").value = tanggal_proses;
      document.getElementById("id_konsumen").value = id_konsumen;
      document.getElementById("kategori").value = kategori;
      document.getElementById("nama").value = nama_pemilik;
      document.getElementById("alamat").innerHTML = alamat;
      document.getElementById("no_hp").value = no_hp;
      document.getElementById("nama_gudang").value = nama_gudang;
      document.getElementById("sales").value = sales;
      document.getElementById("pengembang").value = pengembang;
      document.getElementById("leader").value = leader;
      document.getElementById("manager").value = manager;
      document.getElementById("admin_p").value = admin_p;
      document.getElementById("qc").value = qc;
      document.getElementById("dropper").value = dropper;
      document.getElementById("pengirim").value = pengirim;
      document.getElementById("helper").value = helper;
      document.getElementById("admin_g").value = admin_g;
      document.getElementById("id_qc").value = id_qc;
      document.getElementById("id_dropper").value = id_dropper;
      document.getElementById("id_pengirim").value = id_pengirim;
      document.getElementById("id_helper").value = id_helper;
      document.getElementById("ongkos_kirim").value = numberWithCommas(ongkos_kirim);
      kat_kon = kategori_konsumen;

      $.ajax({
         url: 'pilihbarangkeluarterkirim/'+no_kwitansi,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("cart");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }

           tempid = [];
           tempid_barang = [];
           gudang = [];

           for (var i = 0; i < response['barang'].length; i++) {
             var table = document.getElementById("cart");
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
             var cell8 = row.insertCell(7);
             var cell9 = row.insertCell(8);
             var cell10 = row.insertCell(9);
             var cell11 = row.insertCell(10);

             if (response['barang'][i]['proses'] == null) {
               response['barang'][i]['proses'] = 0;
             }
             if (response['barang'][i]['return'] == null) {
               response['barang'][i]['return'] = 0;
             }
             if (response['barang'][i]['terkirim'] == null) {
               response['barang'][i]['terkirim'] = 0;
             }

             tempid[i] = response['barang'][i]['key'];
             tempid_barang[i] = response['barang'][i]['id_barang'];
             gudang[i] = response['barang'][i]['id_gudang'];

             cell1.innerHTML = response['barang'][i]['no_sku'];
             cell2.innerHTML = response['barang'][i]['nama_barang'];
             cell3.innerHTML = response['barang'][i]['part_number'];
             cell4.innerHTML = response['barang'][i]['jumlah'];
             cell5.innerHTML = "<p id=proses"+response['barang'][i]['key']+">"+response['barang'][i]['proses']+"</p>";
             cell6.innerHTML = "<p id=retur"+response['barang'][i]['key']+">"+response['barang'][i]['return']+"</p>";

             var temppot = 0;

             //tambahan
             cell7.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['terkirim']+"</p>";
             temppot = response['barang'][i]['terkirim'];
             //endtambahan
             /*if (response['barang'][i]['terkirim'] > 0) {
                cell6.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['terkirim']+"</p>";
                temppot = response['barang'][i]['terkirim'];
             }else{
                $.ajax({
                   url: 'updateterkirim/'+response['barang'][i]['proses']+"/"+response['barang'][i]['proses']+"/"+response['barang'][i]['key']+"/"+response['barang'][i]['sub_potongan'],
                   type: 'get',
                   dataType: 'json',
                   async: false,
                   success: function(responses){
                      temppot = response['barang'][i]['proses'];
                      cell6.innerHTML = "<p id=terkirim"+response['barang'][i]['key']+">"+response['barang'][i]['proses']+"</p>";
                   }
                 });
             }*/
             var hj = Number(response['barang'][i]['harga_jual']);
             cell8.innerHTML = numberWithCommas(hj);

            if (temppot < 1) {
              temppot = 1;
            }
             var pott = Number(response['barang'][i]['sub_potongan']) / Number(temppot) + Number(response['barang'][i]['potongan']);
             cell9.innerHTML = "<p id=potongan"+response['barang'][i]['key']+">"+numberWithCommas(pott)+"</p>";
             cell10.innerHTML = "<p id=sub_total"+response['barang'][i]['key']+">"+numberWithCommas(response['barang'][i]['sub_total'])+"</p>";
             var a = '<button class="btn btn-default" onclick="editJumlah('+response['barang'][i]['key']+','+response['barang'][i]['proses']+','+response['barang'][i]['terkirim']+','+response['barang'][i]['sub_potongan'];
             var b = ')"><i class="icon-pencil"></i></button>';
             cell11.innerHTML = a+",'"+response['barang'][i]['nama_barang']+"'"+b;
           }

           var newtotal = 0;
           for (var i = 0; i < tempid.length; i++) {
             var oldtotal = document.getElementById("sub_total"+tempid[i]).innerHTML;
             oldtotal = oldtotal.split(".").join("");
             newtotal += Number(oldtotal);
           }
           var totbay = Number(newtotal)+Number(ongkos_kirim);
           document.getElementById("total_bayar").innerHTML = numberWithCommas(totbay);

         }
       });
    }

    function editJumlah(key,proses,terkirim,subpotongan,nama){
      $.ajax({
         url: 'detailBK/'+key,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
            document.getElementById("jumlah").innerHTML = nama;
            document.getElementById("id_detail").value = key;
            document.getElementById("proses").value = proses;
            document.getElementById("terkirim").value = terkirim;
            document.getElementById("terkirim").max = proses;
            AutoNumeric.set('#potongan',response[0]['sub_potongan']);
            //document.getElementById("potongan").value = 0;
            $('#edit').modal('show');
        }
      });
    }

    function rubah(){
      var proses = document.getElementById("proses").value;
      var terkirim = document.getElementById("terkirim").value;
      var potongan = document.getElementById("potongan").value;
      potongan = potongan.split(".").join("");
      var id_detail = document.getElementById("id_detail").value;

      if ((Number(terkirim) <= Number(proses))) {
        if (Number(terkirim) == 0 && Number(potongan) > 0) {
          alert('Tidak dapat mengisi potongan saat barang terkirim 0 !');
        }else{
          $.ajax({
             url: 'updateterkirim/'+proses+"/"+terkirim+"/"+id_detail+"/"+potongan,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               document.getElementById("retur"+response[0]['id']).innerHTML = response[0]['return'];
               document.getElementById("terkirim"+response[0]['id']).innerHTML = response[0]['terkirim'];
               if (Number(response[0]['terkirim']) < 1) {
                document.getElementById("potongan"+response[0]['id']).innerHTML = "0";
               }else{
                document.getElementById("potongan"+response[0]['id']).innerHTML = numberWithCommas(Number(response[0]['sub_potongan']) / Number(response[0]['terkirim']) + Number(response[0]['potongan']));
               }
               //var prevsub = document.getElementById("sub_total"+response['id']).innerHTML;
               var newsub = Number(response[0]['terkirim']) *( Number(response[0]['harga_jual']) - Number(response[0]['potongan'])) - Number(response[0]['sub_potongan']);
               document.getElementById("sub_total"+response[0]['id']).innerHTML = numberWithCommas(newsub);

               var newtotal = 0;
               for (var i = 0; i < tempid.length; i++) {
                 var oldtotal = document.getElementById("sub_total"+tempid[i]).innerHTML;
                 oldtotal = oldtotal.split(".").join("");
                 newtotal += Number(oldtotal);
               }
               var ongkos_kirim = document.getElementById("ongkos_kirim").value;
               ongkos_kirim = ongkos_kirim.split(".").join("");
               var totbay = Number(newtotal)+Number(ongkos_kirim);
               document.getElementById("total_bayar").innerHTML = numberWithCommas(totbay);

               $('#edit').modal('hide');
             }
           });
        }
       }else{
         alert('Melebihi yang dikirim!');
       }
    }

    function Simpan(){
      //document.getElementById("save").disabled = true;
      var no_kwitansis = document.getElementById("no_kwitansi").value;
      var status_barangs = document.getElementById("status_order").value;
      var tanggal_terkirims = document.getElementById("tanggal_terkirim").value;
      var id_qc = document.getElementById("id_qc").value;
      var id_dropper = document.getElementById("id_dropper").value;
      var id_pengirim = document.getElementById("id_pengirim").value;
      var id_helper = document.getElementById("id_helper").value;
      
      var status_pembayaran = document.getElementById("status_pembayaran").value;
      var jumlah_pembayaran = document.getElementById("jumlah_pembayaran").value;
      var jenis_pembayaran = document.getElementById("jenis_pembayaran").value;
      var no_rekening_bank = document.getElementById("no_rekening_bank").value;
      var total_tagihan = document.getElementById("total_bayar").innerHTML;
      
      var nama_pembeli = document.getElementById("nama").value;
      var pembayaran = jumlah_pembayaran;
      var nama_penyetor = nama_pembeli;
      var tanggal_bayar = tanggal_terkirims;
      var tagihan = total_tagihan;
      
      
      if (no_kwitansis != "" && status_barangs != "" && tanggal_terkirims != "") {
        $.post("penerimaanbarangkeluar",
          {nama_pembeli:nama_pembeli,pembayaran:pembayaran,nama_penyetor:nama_penyetor,tanggal_bayar:tanggal_bayar,tagihan:tagihan,kat_kon:kat_kon,
          status_pembayaran:status_pembayaran,jumlah_pembayaran:jumlah_pembayaran,jenis_pembayaran:jenis_pembayaran,no_rekening_bank:no_rekening_bank,total_tagihan:total_tagihan,
          no_kwitansi:no_kwitansis,status_barang:status_barangs,qc:id_qc,dropper:id_dropper,pengirim:id_pengirim,helper:id_helper, tanggal_terkirim:tanggal_terkirims, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                  }).then((result) => {
                    location.href="{{url('/terkirim/')}}";
                  });

              }).fail(function(jqXHR, textStatus, errorThrown)
          {
              alert(textStatus);
          });

          //location.href="{{url('/terkirim/')}}";

      }else{
        alert("Isi dahulu semuanya");
      }

    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    </script>
@endsection
