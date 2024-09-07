@extends('template/nav')
@section('content')
<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=input+setting+katalog+produk" target="_blank">Katalog Produk</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                    <div class="form-group">
                        
                    <nav class="navbar-dark bg-white">
                    <h3 class="card-title text-left d-flex">
                    <ul class="nav nav-tabs border-0" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active show" href="#single" role="tab" data-toggle="tab"><i data-feather="edit" class="feather-icon"></i> Single Produk</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#multiple" role="tab" data-toggle="tab"><i data-feather="edit" class="feather-icon"></i> Multi Produk</a>
                    </li>
                    </ul>
                     
                    <a href="{{url('kategoriproduk')}}" target="_blank" class="btn text-danger"><i data-feather="folder-plus" class="feather-icon"></i> Main Kategori</a>
                    <a href="{{url('kategorikatalog')}}" target="_blank" class="btn text-danger"><i data-feather="folder" class="feather-icon"></i> Sub Kategori</a>
                    <a href="{{url('brand')}}" target="_blank" class="btn text-danger"><i data-feather="award" class="feather-icon"></i> Brand</a>
                    <a href="{{url('color')}}" target="_blank" class="btn text-danger"><i data-feather="sun" class="feather-icon"></i> Warna</a>
                    <a hidden href="{{url('label')}}" target="_blank" class="btn text-danger"><i data-feather="tag" class="feather-icon"></i> Label</a>
                    <a href="{{url('datakatalog')}}" target="_blank" class="btn text-danger"><i data-feather="edit-3" class="feather-icon"></i> Edit Katalog</a>
                    </h3>

                    </nav>
                    <hr>
                       <div class="tab-content">
                                    <div class="tab-pane show active" id="single">
                                        <br>
                                        <h4>Input Katalog Single Produk</h4>
                                        <br>
                                    <form action="{{url('uploadkatalog')}}" enctype="multipart/form-data" method="post">
                                      <div class="row">

                                        {{csrf_field()}}
                                        <div class="col-md-6">

                                        Pilih Produk:
                                        <div class="input-group">
                                          <input id="nama_barang"  type="text" name="nama_barang" class="form-control" placeholder="Pilih Nama Produk" readonly style="background:#fff">
                                          <input id="id_barang" type="hidden" name="barang" class="form-control">
                                          <div class="input-group-append">
                                              <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                          </div>
                                        </div>
                                        <input hidden id="harga_net" name="harga_net" type="text" class="form-control" readonly>
                                        <input hidden id="harga_retail" name="harga_retail" type="text" class="form-control" readonly>

                                        <br>
                                        Berat Produk:
                                        <input id="berat" name="berat" type="decimal" step="0.1" class="form-control" required placeholder="Berat Produk (Kg), ex: 1.5">

                                        <br>
                                        Kategori Produk:
                                        <input type="text" class="form-control" maxlength="15" required placeholder="Ketik dan pilih nama yang muncul..." id="mainkategori" size="30" onkeyup="showResultMainKategori(this.value)">
                                        <input type="hidden" class="form-control" id="val_mainkategori" required name="main_kategori">
                                        <div id="mainkategorisearch"></div>
                                        <br>
                                        Sub Kategori Produk:
                                        <input type="text" class="form-control" maxlength="15" placeholder="Ketik dan pilih nama yang muncul..." id="kategori" size="30" required onkeyup="showResultKategori(this.value)">
                                        <input type="hidden" class="form-control" id="val_kategori" required name="kategori">
                                        <div id="kategorisearch"></div>
                                        <!--select id="kategori" name="kategori" class="form-control">
                                            <option disabled selected> -- Pilih Kategori -- </option>
                                            <?php foreach ($kategori as $key => $value): ?>
                                              <option value="{{$value->id}}">{{strtoupper($value->nama_kategori)}}</option>
                                            <?php endforeach; ?>
                                        </select-->

                                        <br>
                                        Brand:
                                        <input type="text" class="form-control" maxlength="15" placeholder="Ketik dan pilih nama yang muncul..." id="brand" size="30" onkeyup="showResult(this.value)" required>
                                        <input type="hidden" class="form-control" id="val_brand" name="brand" required>
                                        <div id="livesearch"></div>
                                        <!--select id="brand" name="brand" class="form-control">
                                          <option disabled selected> -- Pilih Brand -- </option>
                                          <?php foreach ($brand as $key => $value): ?>
                                            <option value="{{$value->id}}">{{strtoupper($value->nama_brand)}}</option>
                                          <?php endforeach; ?>
                                        </select-->


                                        <br>
                                       
                                        Pilih Warna (Opsional) :
                                        <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Checklist Pilihan Warna" readonly style="background:#fff">
                                          <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#navbarWarna" aria-controls="navbarWarna" aria-expanded="false" aria-label="Toggle navigation">
                                            <i data-feather="plus" class="feather-icon"></i>
                                            </button>
                                          </div>
                                          
                                        </div>
                                        <br>
                                        <div class="collapse" id="navbarWarna">
                                        <?php $i=1; foreach ($color as $key => $value): ?>
                                          <fieldset class="checkbox duatiga">
                                              <label><input type="checkbox" name="warna{{$i}}" value="{{$value->hex}}" style="width: 15px; height: 15px;"> {{strtoupper($value->warna)}}</label>
                                          </fieldset>
                                        <?php $i++; endforeach; ?>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                        Deskripsi Produk:
                                        <textarea maxlength="1000" name="deskripsi" id="deskripsi_single" class="form-control" rows="10"></textarea>
                                        <span style="color:#ddd"><i data-feather="alert-circle" class="feather-icon"></i> Jika ingin <b>Paste</b> copyan deskripsi dari tempat lain silahkan klik <b>CTR + V</b>.</span>
                                        <br>
                                        <br>
                                        Deskripsi SEO:
                                          <textarea name="deskripsi_seo" maxlength="150" id="deskripsi_seo" class="form-control" placeholder="Ketik deskripsi yang akan ditampilkan pada laman search engine"></textarea>

                                          <br>
                                        Keyword SEO:
                                          <textarea name="keyword_seo" maxlength="150" id="keyword_seo" class="form-control" placeholder="Ketik beberapa kata kunci yang sering dicari (,)"></textarea>

                                        <select hidden id="label" name="label" class="form-control">
                                          <option selected value="none"> -- Pilih Label -- </option>
                                          <?php foreach ($label as $key => $value): ?>
                                            <option value="{{$value->id}}">{{strtoupper($value->nama)}}</option>
                                          <?php endforeach; ?>
                                        </select>
                                        <br>
                                        Gambar Produk:
                                        <div class="input-group" id="gambar1">
                                          <input type="file" name="gambar1" class="form-control">
                                          <div class="input-group-append">
                                              <button hidden class="btn btn-outline-danger" onclick="DeleteGambar('gambar1')" type="button"><i class="fas fa-trash"></i></button>
                                          </div>
                                          <a onclick="AddImage()" class="btn btn-primary btn-sm" style="color:white;"><i data-feather="plus" class="feather-icon"></i></a>
                                        </div>
                                        <input type="hidden" name="jumlah_warna" id="jumlah_warna" value="{{$i}}">
                                        <input type="hidden" name="jumlah" id="jumlah" value="1">
                                        <div id="gbr"></div>
                                        <br><br>
                                        <center>
                                        <input type="submit" value="Simpan" class="btn btn-success btn-lg">
                                        </center>
                                      
                                      </div>
                                      </div>
                                      </form>
                                      </div>
  
                                    <div class="tab-pane" id="multiple">

                                      <div class="tab-pane show active" id="home-b2">
                                        <br>
                                          <h4>Input Katalog Multi Produk</h4>
                                         <br>
                                        <form action="{{url('uploadkatalogmultiple')}}" enctype="multipart/form-data" method="post">
                                          <div class="row">
                                          {{csrf_field()}}
                                          <div class="col-md-6">
                                           Nama Produk:
                                          <input name="nama_barang" maxlength="40" type="text" class="form-control" placeholder="Ketik nama utama produk...">

                                          <br>

                                          <div id="multi">
                                            Pilih Barang:
                                            <div class="input-group" id="brg1">
                                              <input id="nama_barang1" name="nama_barang1"  type="text" class="form-control" placeholder="Pilih Type Barang" readonly style="background:#fff">
                                              <input id="id_barang1" name="barang1" type="hidden" class="form-control">
                                              <input id="berat_multi1" name="berat_multi1" type="number" class="form-control" step="0.1" required placeholder="Ketik Berat Produk (Kg), ex: 1.5">
                                              <div class="input-group-append">
                                                  <button class="btn btn-outline-secondary" onclick="caribarang2('1')" type="button"><i class="fas fa-folder-open"></i></button>
                                                  <a onclick="Tambah()" class="btn btn-primary btm-sm" style="color:white;"><i data-feather="plus" class="feather-icon"></i></a>
                                              </div>
                                            </div>
                                          </div>
                                          <br>
  
                                         
                                          Kategori Produk:
                                          <input type="text" required maxlength="15" class="form-control" placeholder="Ketik dan pilih nama yang muncul..." id="mainkategoris" size="30" onkeyup="showResultMainKategoris(this.value)">
                                          <input type="hidden" class="form-control" id="val_mainkategoris" name="main_kategori" required>
                                          <div id="mainkategorisearchs"></div>

                                          <br>
                                          Sub Kategori Produk:
                                          <input type="text" required class="form-control" maxlength="15" placeholder="Ketik dan pilih nama yang muncul..." id="kategoris" size="30" onkeyup="showResultKategoris(this.value)">
                                          <input type="hidden" class="form-control" id="val_kategoris" name="kategori" required>
                                          <div id="kategorisearchs"></div>
                                          <!--select name="kategori" class="form-control">
                                              <option disabled selected> -- Pilih Kategori -- </option>
                                              <?php foreach ($kategori as $key => $value): ?>
                                                <option value="{{$value->id}}">{{strtoupper($value->nama_kategori)}}</option>
                                              <?php endforeach; ?>
                                          </select-->

                                          <br>
                                          Brand:
                                          <input type="text" class="form-control" maxlength="15" placeholder="Ketik dan pilih nama yang muncul..." id="brands" size="30" onkeyup="showResults(this.value)">
                                          <input type="hidden" class="form-control" id="val_brands" name="brand">
                                          <div id="livesearchs"></div>

                                          <!--select name="brand" class="form-control">
                                            <option disabled selected> -- Pilih Brand -- </option>
                                            <?php foreach ($brand as $key => $value): ?>
                                              <option value="{{$value->id}}">{{strtoupper($value->nama_brand)}}</option>
                                            <?php endforeach; ?>
                                          </select-->
                                         
                                          

                                          <br>
                                          Pilih Warna (Opsional):
                                          <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Checklist Pilihan Warna" readonly style="background:#fff">
                                          <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#navbarWarna2" aria-controls="navbarWarna2" aria-expanded="false" aria-label="Toggle navigation">
                                            <i data-feather="plus" class="feather-icon"></i>
                                            </button>
                                          </div>
                                          
                                        </div>
                                        <br>
                                        <div class="collapse" id="navbarWarna2">
                                          <?php $a=1; foreach ($color as $key => $value): ?>
                                            <fieldset class="checkbox duatiga">
                                                <label><input type="checkbox" name="warna{{$a}}" value="{{$value->hex}}" style="width: 15px; height: 15px;"> {{strtoupper($value->warna)}}</label>
                                            </fieldset>
                                          <?php $a++; endforeach; ?>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                          <br>
                                          Deskripsi Produk:
                                          <textarea id="deskripsi_multi" maxlength="1000" class="form-control" name="deskripsi" rows="10"></textarea>
                                           <span style="color:#ddd"><i data-feather="alert-circle" class="feather-icon"></i> Jika ingin <b>Paste</b> copyan deskripsi dari tempat lain silahkan klik <b>CTR + V</b>.</span>
                                          <br>

                                          <br>
                                          Deskripsi SEO:
                                          <textarea name="deskripsi_seo" maxlength="150" id="deskripsi_seo" class="form-control" placeholder="Ketik deskripsi yang akan ditampilkan pada laman search engine"></textarea>
                                         
                                          <br>
                                          Keyword SEO:
                                          <textarea name="keyword_seo" maxlength="150" id="keyword_seo" class="form-control" placeholder="Ketik beberapa kata kunci yang sering dicari (,)"></textarea>

                                          <select hidden name="label" id="label2" class="form-control">
                                            <option value="none" selected> -- Pilih Label -- </option>
                                            <?php foreach ($label as $key => $value): ?>
                                              <option value="{{$value->id}}">{{strtoupper($value->nama)}}</option>
                                            <?php endforeach; ?>
                                          </select>
                                          <br>
                                          Gambar Produk:
                                          <div class="input-group" id="gambar_multiple1">
                                            <input type="file" name="gambar1" class="form-control">
                                            <div class="input-group-append">
                                                <button hidden class="btn btn-outline-danger" onclick="DeleteGambar('gambar_multiple1')" type="button"><i class="fas fa-trash"></i></button>
                                            </div>
                                            <a onclick="AddImage2()" class="btn btn-primary btn-sm" style="color:white;"><i data-feather="plus" class="feather-icon"></i></a>
                                          </div>
                                          <input type="hidden" name="jumlah_warna" id="jumlah_warna" value="{{$a}}">
                                          <input type="hidden" name="jumlah_gambar" id="jumlah2" value="1">
                                          <input type="hidden" name="jumlah_produk" id="jumlah3" value="1">
                                          <div id="gbr2"></div>
                                          
                                          <br><br>
                                          <center>
                                          <input type="submit" value="Simpan" class="btn btn-success btn-lg">
                                          </center>
                                            </div>
                                            </div>
                                        </form>
                                        </div>
                                      </div>

                                    </div>
                                </div>
                        </div> <!-- end card-->

              </div>
            </div>
          </div>
        </div>
      </div>


    <div class="modal fade" id="modelbarang" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples5" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>No SKU</th>
                          <th>Nama</th>
                          <th>Harga Net</th>
                          <th>Harga Retail</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($barang as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_retail}}','{{$value->label}}')">
                          <td>{{$value->no_sku}}</td>
                          <td>{{$value->nama_barang}}</td>
                          <td>{{$value->harga}}</td>
                          <td>{{$value->harga_retail}}</td>
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

      <div class="modal fade" id="modelbarang2" role="dialog">
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
                            <th>No SKU</th>
                            <th>Nama</th>
                            <th>Harga Net</th>
                            <th>Harga Retail</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($barang as $value){ ?>
                        <tr onclick="pilihbarang2('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_retail}}','{{$value->label}}')">
                            <td>{{$value->no_sku}}</td>
                            <td>{{$value->nama_barang}}</td>
                            <td>{{$value->harga}}</td>
                            <td>{{$value->harga_retail}}</td>
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
        
        <style>
            .duatiga {width:30%;float:left}
            @media only screen and (max-width: 600px) {
                .duatiga {width:50%;float:left}
                }
        </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
      var konten = document.getElementById("deskripsi_single");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;

      var konten2 = document.getElementById("deskripsi_multi");
        CKEDITOR.replace(konten2,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;

    </script>

    <script>
    var gambar = 1;
    var gambar2 = 1;
    var brg = 1;
    var tujuan = 0;

    function caribarang(){
      $('#modelbarang').modal('show');
    }

    function caribarang2(id){
      tujuan = id;
      $('#modelbarang2').modal('show');
    }

    function pilihbarang(barang,id,nama,harga,harga_retail,label){
      $('#modelbarang').modal('hide');
      document.getElementById("id_barang").value = barang;
      document.getElementById("nama_barang").value = nama;
      document.getElementById("harga_net").value = numberWithCommas(harga);
      document.getElementById("harga_retail").value = numberWithCommas(harga_retail);
      if (label !="" && label !="0") {
        document.getElementById("label").value = label;
      }else{
        document.getElementById("label").selectedIndex = "0";
      }
    }

    function pilihbarang2(barang,id,nama,harga,harga_retail,label){
      $('#modelbarang2').modal('hide');
      document.getElementById("id_barang"+tujuan).value = barang;
      document.getElementById("nama_barang"+tujuan).value = nama;
      if (label !="" && label !="0") {
        document.getElementById("label2").value = label;
      }else{
        document.getElementById("label2").selectedIndex = "0";
      }
    }

    function Tambah(){
      brg = Number(brg)+1;
      document.getElementById("jumlah3").value = brg;
      var id = "'brg"+brg+"'";
      var panel = document.getElementById("multi");

      var a = document.createElement("DIV");
      a.id = "brg"+brg;
      a.classList.add("input-group");

      var b = document.createElement("INPUT");
      b.id = "nama_barang"+brg;
      b.setAttribute("type", "text");
      b.setAttribute("name", "nama_barang"+brg);
      b.setAttribute("placeholder", "Pilih Type Barang");
      b.classList.add("form-control");

      var c = document.createElement("INPUT");
      c.id = "id_barang"+brg;
      c.setAttribute("type", "hidden");
      c.setAttribute("name", "barang"+brg);
      c.classList.add("form-control");

      var z = document.createElement("INPUT");
      z.id = "berat_multi"+brg;
      z.setAttribute("type", "number");
      z.setAttribute("step", "0.1");
      z.setAttribute("placeholder", "Ketik Berat Produk (Kg), ex: 1.5");
      z.setAttribute("name", "berat_multi"+brg);
      z.classList.add("form-control");

      var d = document.createElement("DIV");
      d.classList.add("input-group-append");

      var e = document.createElement("BUTTON");
      e.classList.add("btn");
      e.classList.add("btn-outline-secondary");
      e.setAttribute("type", "BUTTON");
      e.setAttribute("onclick","caribarang2("+brg+")");

      var f = document.createElement("I");
      f.classList.add("fas");
      f.classList.add("fa-folder-open");

      var g = document.createElement("BUTTON");
      g.classList.add("btn");
      g.classList.add("btn-outline-danger");
      g.setAttribute("type", "BUTTON");
      g.setAttribute("onclick","DeleteGambar("+id+")");

      var h = document.createElement("I");
      h.classList.add("fas");
      h.classList.add("fa-trash");

      a.appendChild(b);
      a.appendChild(c);
      a.appendChild(z);
      a.appendChild(d);
      d.appendChild(e);
      e.appendChild(f);
      d.appendChild(g);
      g.appendChild(h);

      panel.appendChild(a);
      //panel.innerHTML += '<div class="input-group" id="brg'+brg+'"><input id="nama_barang'+brg+'" name="nama_barang'+brg+'" type="text" class="form-control" placeholder="Pilih Gudang"><input id="id_barang'+brg+'" name="barang'+brg+'" type="hidden" class="form-control"><div class="input-group-append"><button class="btn btn-outline-secondary" onclick="caribarang2('+brg+')" type="button"><i class="fas fa-search"></i></button><button class="btn btn-outline-secondary" onclick="DeleteGambar('+id+')" type="button"><i class="fas fa-trash"></i></button></div></div>';
    }

    function AddImage(){
      gambar = Number(gambar)+1;
      console.log(gambar);
      document.getElementById("jumlah").value = gambar;
      var id = "'gambar"+gambar+"'";
      var panelgambar = document.getElementById("gbr");

      var a = document.createElement("DIV");
      a.id = "gambar"+gambar;
      a.classList.add("input-group");

      var b = document.createElement("INPUT");
      b.setAttribute("type", "file");
      b.setAttribute("name", "gambar"+gambar);
      b.classList.add("form-control");

      var c = document.createElement("DIV");
      c.classList.add("input-group-append");

      var d = document.createElement("BUTTON");
      d.classList.add("btn");
      d.classList.add("btn-outline-danger");
      d.setAttribute("type", "BUTTON");
      d.setAttribute("onclick","DeleteGambar("+id+")");

      var e = document.createElement("I");
      e.classList.add("fas");
      e.classList.add("fa-trash");

      a.appendChild(b);
      a.appendChild(c);
      c.appendChild(d);
      d.appendChild(e);

      panelgambar.appendChild(a);
      //panelgambar.innerHTML += '<div class="input-group" id="gambar'+gambar+'"><input type="file" name="gambar'+gambar+'" class="form-control"><div class="input-group-append"><button class="btn btn-outline-danger" onclick="DeleteGambar('+id+')" type="button"><i class="fas fa-trash"></i></button></div></div>';
    }

    function AddImage2(){
      gambar2 = Number(gambar2)+1;
      document.getElementById("jumlah2").value = gambar2;
      var id = "'gambar_multi"+gambar2+"'";
      var panelgambar = document.getElementById("gbr2");

      var a = document.createElement("DIV");
      a.id = "gambar_multi"+gambar2;
      a.classList.add("input-group");

      var b = document.createElement("INPUT");
      b.setAttribute("type", "file");
      b.setAttribute("name", "gambar"+gambar2);
      b.classList.add("form-control");

      var c = document.createElement("DIV");
      c.classList.add("input-group-append");

      var d = document.createElement("BUTTON");
      d.classList.add("btn");
      d.classList.add("btn-outline-danger");
      d.setAttribute("type", "BUTTON");
      d.setAttribute("onclick","DeleteGambar("+id+")");

      var e = document.createElement("I");
      e.classList.add("fas");
      e.classList.add("fa-trash");

      a.appendChild(b);
      a.appendChild(c);
      c.appendChild(d);
      d.appendChild(e);

      panelgambar.appendChild(a);
      //panelgambar.innerHTML += '<div class="input-group" id="gambar'+gambar2+'"><input type="file" name="gambar'+gambar2+'" class="form-control"><div class="input-group-append"><button class="btn btn-outline-danger" onclick="DeleteGambar('+id+')" type="button"><i class="fas fa-trash"></i></button></div></div>';
    }

    function DeleteGambar(id){
      var rmv = document.getElementById(id);
      rmv.remove();
    }

    function PilihBrand(id,nama){
      document.getElementById("val_brand").value = id;
      document.getElementById("brand").value = nama;
      document.getElementById("livesearch").innerHTML = "";
    }

    function PilihBrands(id,nama){
      document.getElementById("val_brands").value = id;
      document.getElementById("brands").value = nama;
      document.getElementById("livesearchs").innerHTML = "";
    }

    function PilihKategori(id,nama){
      document.getElementById("val_kategori").value = id;
      document.getElementById("kategori").value = nama;
      document.getElementById("kategorisearch").innerHTML = "";
    }

    function PilihMainKategori(id,nama){
      document.getElementById("val_mainkategori").value = id;
      document.getElementById("mainkategori").value = nama;
      document.getElementById("mainkategorisearch").innerHTML = "";
    }

    function PilihMainKategoris(id,nama){
      document.getElementById("val_mainkategoris").value = id;
      document.getElementById("mainkategoris").value = nama;
      document.getElementById("mainkategorisearchs").innerHTML = "";
    }

    function PilihKategoris(id,nama){
      document.getElementById("val_kategoris").value = id;
      document.getElementById("kategoris").value = nama;
      document.getElementById("kategorisearchs").innerHTML = "";
    }

    function showResult(str) {
      if(str != ""){
        $.ajax({
           url: 'caribrand/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("livesearch").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_brand']+'"';
                 document.getElementById("livesearch").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihBrand("+temp+")'>"+response[i]['nama_brand']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("livesearch").innerHTML = "";
             }
           }
         });
      }
    }

    function showResults(str) {
      if(str != ""){
        $.ajax({
           url: 'caribrand/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("livesearchs").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_brand']+'"';
                 document.getElementById("livesearchs").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihBrands("+temp+")'>"+response[i]['nama_brand']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("livesearchs").innerHTML = "";
             }
           }
         });
      }
    }

    function showResultKategori(str) {
      var mainkat = document.getElementById("val_mainkategori").value;
      if(str != ""){
        $.ajax({
           url: 'carikategori/'+str+'/'+mainkat,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("kategorisearch").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_kategori']+'"';
                 document.getElementById("kategorisearch").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihKategori("+temp+")'>"+response[i]['nama_kategori']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("kategorisearch").innerHTML = "";
             }
           }
         });
      }
    }

    function showResultMainKategori(str) {
      if(str != ""){
        $.ajax({
           url: 'carimainkategori/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("mainkategorisearch").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_main_kategori']+'"';
                 document.getElementById("mainkategorisearch").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihMainKategori("+temp+")'>"+response[i]['nama_main_kategori']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("mainkategorisearch").innerHTML = "";
             }
           }
         });
      }
    }

    function showResultMainKategoris(str) {
      if(str != ""){
        $.ajax({
           url: 'carimainkategori/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("mainkategorisearchs").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_main_kategori']+'"';
                 document.getElementById("mainkategorisearchs").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihMainKategoris("+temp+")'>"+response[i]['nama_main_kategori']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("mainkategorisearchs").innerHTML = "";
             }
           }
         });
      }
    }

    function showResultKategoris(str) {
      var mainkat = document.getElementById("val_mainkategoris").value;
      if(str != ""){
        $.ajax({
           url: 'carikategori/'+str+'/'+mainkat,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("kategorisearchs").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['nama_kategori']+'"';
                 document.getElementById("kategorisearchs").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihKategoris("+temp+")'>"+response[i]['nama_kategori']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("kategorisearchs").innerHTML = "";
             }
           }
         });
      }
    }
    </script>
@endsection
