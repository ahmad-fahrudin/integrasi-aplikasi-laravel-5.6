@extends('template/nav')
@section('content')
<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card"  style="height:100vh">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                             <li class="breadcrumb-item text-muted" aria-current="page">Katalog Produk > <a href="https://stokis.app/?s=edit+katalog+produk" target="_blank">Edit Katalog Produk</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
					<div class="table-responsive">
                    <nav class="navbar-dark bg-white">
                    <h3 class="card-title text-left d-flex">
                    <ul class="nav nav-tabs border-0" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link show" href="{{url('inputkatalog')}}" target="_blank" ><i data-feather="edit" class="feather-icon"></i> Input Katalog Baru</a>
                    </li>
                    </ul>
                     
                    <a href="{{url('kategoriproduk')}}" target="_blank" class="btn text-danger"><i data-feather="folder-plus" class="feather-icon"></i> Kategori</a>
                    <a href="{{url('kategorikatalog')}}" target="_blank" class="btn text-danger"><i data-feather="folder" class="feather-icon"></i> Sub Kategori</a>
                    <a href="{{url('brand')}}" target="_blank" class="btn text-danger"><i data-feather="award" class="feather-icon"></i> Brand</a>
                    <a href="{{url('color')}}" target="_blank" class="btn text-danger"><i data-feather="sun" class="feather-icon"></i> Warna</a>
                    <a hidden href="{{url('label')}}" target="_blank" class="btn text-danger"><i data-feather="tag" class="feather-icon"></i> Label</a>
                    <a href="{{url('datakatalog')}}" target="_blank" class="btn text-warning"><i data-feather="edit-3" class="feather-icon"></i> Edit Katalog</a>
                    </h3>

                    </nav>
                    <hr>
                    <br>
                    <div class="input-group col-md-6" id="brg1">
                      <input id="nama_barang" type="text" class="form-control" placeholder="Pilih Nama Katalog Produk" readonly style="background:#fff">
                      <div class="input-group-append">
                          <button class="btn btn-outline-secondary" onclick="carikatalog()" type="button"><i class="fas fa-folder-open"></i></button>
                      </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="single">
                          <div class="col-md-6 m-auto">
                          <form action="{{url('updatekatalog')}}" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <hr>
                            <br>
                            <br>
                            Pilih Barang:
                            <div class="input-group">
                              <input id="nama_barang_single"  type="text" name="nama_barang" class="form-control" placeholder="Pilih Barang">
                              <div class="input-group-append">
                                  <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <br>
                            <input id="id_barang" type="hidden" name="barang" class="form-control">
                            <input id="id_barang_old" type="hidden" name="barang_old" class="form-control">
                            Berat Produk:
                            <input id="berat" name="berat" type="number" step="0.1" class="form-control" placeholder="dalam kg">
                            <input id="id_single" name="id" type="hidden" class="form-control">
                            <br>

                            Kategori Produk:
                            <select id="kategori" name="kategori" class="form-control">
                                <option disabled selected> -- Pilih Kategori -- </option>
                                <?php foreach ($kategori as $key => $value): ?>
                                  <option value="{{$value->id}}">{{strtoupper($value->nama_kategori)}}</option>
                                <?php endforeach; ?>
                            </select>

                            <br>
                            Brand:
                            <select id="brand" name="brand" class="form-control">
                              <option disabled selected> -- Pilih Brand -- </option>
                              <?php foreach ($brand as $key => $value): ?>
                                <option value="{{$value->id}}">{{strtoupper($value->nama_brand)}}</option>
                              <?php endforeach; ?>
                            </select>

                            <br>
                            Pilih Warna:
                            <?php $i=1; foreach ($color as $key => $value): ?>
                              <fieldset class="checkbox">
                                  <label><input type="checkbox" name="warna{{$i}}" id="{{$value->hex}}" value="{{$value->hex}}" style="width: 15px; height: 15px;"> {{strtoupper($value->warna)}}</label>
                              </fieldset>
                            <?php $i++; endforeach; ?>

                            <br>
                            Deskripsi Produk:
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="10"></textarea>

                            <br>
                            <!--Label:-->
                            <!--select id="label" name="label" class="form-control">
                              <option selected> -- Pilih Brand -- </option>
                              <?php foreach ($label as $key => $value): ?>
                                <option value="{{$value->id}}">{{strtoupper($value->nama)}}</option>
                              <?php endforeach; ?>
                            </select-->
                            <br>
                            Gambar:
                            <div id="display_gambar"></div>
                            <div class="input-group" id="gambar1">
                              <input type="file" name="gambar1" class="form-control">
                              <div class="input-group-append">
                                  <button class="btn btn-outline-danger" onclick="DeleteGambar('gambar1')" type="button"><i class="fas fa-trash"></i></button>
                              </div>
                            </div>
                            <input type="hidden" name="jumlah_warna" id="jumlah_warna" value="{{$i}}">
                            <input type="hidden" name="jumlah" id="jumlah" value="1">
                            <div id="gbr"></div>
                            <br><a onclick="AddImage()" class="btn btn-primary btn-sm" style="color:white;">tambah gambar</a>
                            <br><br>
                            <input type="submit" value="Simpan" class="btn btn-success form-control">
                          </form>
                          </div>
                        </div>



                        <div class="tab-pane" id="multiple">
                          <div class="tab-pane show active" id="home-b2">
                            <div class="col-md-6 m-auto">
                            <form action="{{url('updatekatalogmultiple')}}" enctype="multipart/form-data" method="post">
                              {{csrf_field()}}
                              <hr>
                              <br>
                              <br>

                              <div id="multi">
                                Pilih Barang:
                                <!--div class="input-group" id="brg1">
                                  <input id="nama_barang1" name="nama_barang1"  type="text" class="form-control" placeholder="Pilih Barang">
                                  <input id="id_barang1" name="barang1" type="hidden" class="form-control">
                                  <div class="input-group-append">
                                      <button class="btn btn-outline-secondary" onclick="caribarang2('1')" type="button"><i class="fas fa-search"></i></button>
                                      <button class="btn btn-outline-secondary" onclick="DeleteGambar('brg1')" type="button"><i class="fas fa-trash"></i></button>
                                  </div>
                                </div-->
                              </div>
                              <br>
                              <a onclick="Tambah()" class="btn btn-primary" style="color:white;">Tambah</a>

                              <br><br>
                              Nama Produk:
                              <input name="nama_barang" id="nama_barang_multiple" type="text" class="form-control">

                              <br>
                              <input id="id_multiple" name="id" type="hidden" class="form-control">
                              <br>
                              Kategori Produk:
                              <select name="kategori" id="kategori_multiple" class="form-control">
                                  <option disabled selected> -- Pilih Kategori -- </option>
                                  <?php foreach ($kategori as $key => $value): ?>
                                    <option value="{{$value->id}}">{{strtoupper($value->nama_kategori)}}</option>
                                  <?php endforeach; ?>
                              </select>

                              <br>
                              Brand:
                              <select name="brand" id="brand_multiple" class="form-control">
                                <option disabled selected> -- Pilih Brand -- </option>
                                <?php foreach ($brand as $key => $value): ?>
                                  <option value="{{$value->id}}">{{strtoupper($value->nama_brand)}}</option>
                                <?php endforeach; ?>
                              </select>

                              <br>
                              Pilih Warna:
                              <?php $a=1; foreach ($color as $key => $value): ?>
                                <fieldset class="checkbox">
                                    <label><input type="checkbox" id="{{$value->hex}}multiple" name="warna_multiple{{$a}}" value="{{$value->hex}}" style="width: 15px; height: 15px;"> {{strtoupper($value->warna)}}</label>
                                </fieldset>
                              <?php $a++; endforeach; ?>

                              <br>
                              Deskripsi Produk:
                              <textarea class="form-control" name="deskripsi" id="deskripsi_multiple" rows="10"></textarea>

                              <br>
                              <!--Label:
                              <select name="label" id="label_multiple" class="form-control">
                                <option selected> -- Pilih Brand -- </option>
                                <?php foreach ($label as $key => $value): ?>
                                  <option value="{{$value->id}}">{{strtoupper($value->nama)}}</option>
                                <?php endforeach; ?>
                              </select>
                              <br-->
                              Gambar:
                              <div id="display_gambar_multiple"></div>
                              <div class="input-group" id="gambar_multiple1">
                                <input type="file" name="gambar1" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" onclick="DeleteGambar('gambar_multiple1')" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                              </div>
                              <input type="hidden" name="jumlah_warna" id="jumlah_warna" value="{{$a}}">
                              <input type="hidden" name="jumlah_gambar" id="jumlah2" value="1">
                              <input type="hidden" name="jumlah_produk" id="jumlah3" value="1">
                              <div id="gbr2"></div>
                              <br><a onclick="AddImage2()" class="btn btn-primary btn-sm" style="color:white;">tambah gambar</a>
                              <br><br>
                              <input type="submit" value="Simpan" class="btn btn-success form-control">

                            </form>
                            </div>
                          </div>

                        </div>
                    </div>

								  </div>
              </div>
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
                          <th>No</th>
                          <th>Nama Barang</th>
                          <th>Brand</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;foreach ($katalog as $value){ ?>
                      <tr onclick="pilihkatalog('{{$value->id}}','{{$value->nama_barang}}')">
                          <td>{{$no}}</td>
                          <td>{{$value->nama_barang}}</td>
                          <td>{{$databrand[$value->brand]}}</td>
                      </tr>
                     <?php $no++; } ?>
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

      <div class="modal fade" id="modelbarang3" role="dialog">
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
                            <th>No SKU</th>
                            <th>Nama</th>
                            <th>Harga Net</th>
                            <th>Harga Retail</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($barang as $value){ ?>
                        <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_retail}}')">
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
                          <tr onclick="pilihbarang2('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_retail}}')">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
      var konten = document.getElementById("deskripsi");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;

      var konten2 = document.getElementById("deskripsi_multiple");
        CKEDITOR.replace(konten2,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;

    </script>

    <script>
    var jumlahwarna = Number({{$i}});
    var gambar = 1;
    var gambar2 = 1;
    var brg = 1;
    var tujuan = 0;

    function caribarang(){
      $('#modelbarang3').modal('show');
    }

    function caribarang2(id){
      tujuan = id;
      $('#modelbarang2').modal('show');
    }

    function pilihbarang(barang,id,nama,harga,harga_retail){
      $('#modelbarang3').modal('hide');
      document.getElementById("id_barang").value = barang;
      document.getElementById("nama_barang_single").value = nama;
    }

    function pilihbarang2(barang,id,nama,harga,harga_retail){
      $('#modelbarang2').modal('hide');
      document.getElementById("id_barang"+tujuan).value = barang;
      document.getElementById("nama_barang"+tujuan).value = nama;
    }

    function carikatalog(){
      $('#modelbarang').modal('show');
    }
    function pilihkatalog(id,nama){
      location.href = "{{url('editkatalogproduk')}}/"+id;
      document.getElementById("nama_barang").value = nama;
      /*$.ajax({
         url: 'detailKatalog/'+id,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           for (var i = 1; i < jumlahwarna; i++) {
             document.getElementsByName("warna"+i)[0].checked = false;
             document.getElementsByName("warna_multiple"+i)[0].checked = false;
           }
            $('#modelbarang').modal('hide');
            console.log(response);
            if (response[0]['jenis'] == "single") {
              var element = document.getElementById("single");
              element.classList.add("show");
              element.classList.add("active");
              var elements = document.getElementById("multiple");
              elements.classList.remove("show");
              elements.classList.remove("active");

              document.getElementById("id_single").value = response[0]['id_katalog'];
              document.getElementById("nama_barang_single").value = response[0]['nama_barang'];
              document.getElementById("id_barang").value = response[0]['barang'];
              document.getElementById("id_barang_old").value = response[0]['barang'];
              document.getElementById("berat").value = response[0]['berat'];
              document.getElementById("kategori").value = response[0]['kategori'];
              document.getElementById("brand").value = response[0]['brand'];
              CKEDITOR.instances['deskripsi'].setData(response[0]['deskripsi']);
              //document.getElementById("deskripsi").value = response[0]['deskripsi'];
              document.getElementById("label").value = response[0]['label'];

              var loop = response[0]['warna'].split(",");
              for (var i = 0; i < loop.length; i++) {
                if (loop[i] != "") {
                  document.getElementById(loop[i]).checked = true;
                }
              }

              $.ajax({
                 url: 'detailImage/'+id,
                 type: 'get',
                 dataType: 'json',
                 async: false,
                 success: function(responses){
                   var gbbr = document.getElementById("display_gambar");
                   gbbr.innerHTML = "";
                   for (var i = 0; i < responses.length; i++) {
                     var img = responses[i]['nama_file'];
                     var id = responses[i]['id'];
                     var nama = '"'+img+'"';
                     gbbr.innerHTML += "<img src='{{asset('gambar/product/')}}"+"/"+img+"' id="+nama+" width='100' ondblclick='DeleteImage("+id+","+nama+")'>";
                   }
                 }
               });

            }else{
              var element = document.getElementById("multiple");
              element.classList.add("show");
              element.classList.add("active");
              var elements = document.getElementById("single");
              elements.classList.remove("show");
              elements.classList.remove("active");

              document.getElementById("id_multiple").value = response[0]['id_katalog'];
              document.getElementById("nama_barang_multiple").value = response[0]['nama_barang'];
              //document.getElementById("berat_multiple").value = response[0]['berat_multiple'];
              document.getElementById("kategori_multiple").value = response[0]['kategori'];
              document.getElementById("brand_multiple").value = response[0]['brand'];
              CKEDITOR.instances['deskripsi_multiple'].setData(response[0]['deskripsi']);
              //document.getElementById("deskripsi_multiple").value = response[0]['deskripsi'];
              document.getElementById("label_multiple").value = response[0]['label'];

              var loop = response[0]['warna'].split(",");
              for (var i = 0; i < loop.length; i++) {
                if (loop[i] != "") {
                  document.getElementById(loop[i]+"multiple").checked = true;
                }
              }
              document.getElementById("multi").innerHTML="";
              for (var i = 0; i < response.length; i++) {
                brg = Number(brg)+1;
                document.getElementById("jumlah3").value = brg;
                var ids = "'brg"+brg+"'";
                var panel = document.getElementById("multi");
                panel.innerHTML += '<div class="input-group" id="brg'+brg+'"><input id="nama_barang'+brg+'" value="'+response[i]['nama_barang_detail']+'" name="nama_barang'+brg+'" type="text" class="form-control" placeholder="Pilih Gudang"><input id="berat_multi'+brg+'" name="berat_multi'+brg+'" type="number" class="form-control" step="0.1" value="'+response[i]['berat_multiple']+'"><input id="id_barang'+brg+'" name="barang'+brg+'" type="hidden" value="'+response[i]['barang_multi']+'" class="form-control"><div class="input-group-append"><button class="btn btn-outline-secondary" onclick="caribarang2('+brg+')" type="button"><i class="fas fa-search"></i></button><button class="btn btn-outline-secondary" onclick="DeleteGambar('+ids+')" type="button"><i class="fas fa-trash"></i></button></div></div>';
              }

              $.ajax({
                 url: 'detailImage/'+id,
                 type: 'get',
                 dataType: 'json',
                 async: false,
                 success: function(responses){
                   var gbbr = document.getElementById("display_gambar_multiple");
                   gbbr.innerHTML = "";
                   for (var i = 0; i < responses.length; i++) {
                     var img = responses[i]['nama_file'];
                     var id = responses[i]['id'];
                     var nama = '"'+img+'"';
                     gbbr.innerHTML += "<img src='{{asset('gambar/product/')}}"+"/"+img+"' id="+nama+" width='100' ondblclick='DeleteImage("+id+","+nama+")'>";
                     //gbbr.innerHTML += "<img src='{{asset('gambar/product/')}}"+"/"+img+"' width='100' ondblclick='DeleteImage("+id+","+nama+")'>";
                   }
                 }
               });


            }
         }
       });*/
    }

    function DeleteImage(id,img){
      Swal.fire(
        'Delete Gambar: \n'+img+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          $.ajax({
             url: 'deleteGambarProduk/'+id,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(responses){
               document.getElementById(img).remove();
             }
           });

          //location.href="{{url('/deleteGambarProduk/')}}"+"/"+id;
        }
      });
    }

    function DeleteGambar(id){
      var rmv = document.getElementById(id);
      rmv.remove();
    }

    function AddImage(){
      gambar = Number(gambar)+1;
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
      b.setAttribute("placeholder", "Pilih Barang");
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
      z.setAttribute("placeholder", "Berat Produk, ex: 1.5");
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
      f.classList.add("fa-search");

      var g = document.createElement("BUTTON");
      g.classList.add("btn");
      g.classList.add("btn-outline-secondary");
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

    </script>
@endsection
