@extends('template/nav')
@section('content')
    <script src="{{ asset('system/assets/ckeditor/ckeditor.js') }}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb ">
                                        <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a
                                                href="https://stokis.app/?s=tambah+gudang+cabang" target="_blank">Cabang &
                                                Gudang</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ url('insertgudang') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <label class="col-lg-6"><strong>Tambah Cabang Baru</strong></label>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">Nama Cabang</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <input required type="text" name="nama_gudang"
                                                            class="form-control" placeholder="Ketik nama cabang baru...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">Kepala Cabang</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <input required type="text" class="form-control"
                                                            name="kepala_gudang" id="nama_kepala"
                                                            placeholder="Ketik dan pilih nama pimpinan cabang baru..."
                                                            onkeyup="showResult(this.value)">
                                                        <input type="hidden" class="form-control" id="id_kepala"
                                                            name="karyawan">
                                                        <div id="livesearch"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">Provinsi</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <select required id="provinsis" name="provinsi" class="form-control"
                                                            onchange="CProvinsi('kotas')">
                                                            <option disabled selected>Pilih Provinsi</option>
                                                            <?php foreach ($provinsi as $key => $value): ?>
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">Kabupaten / Kota:</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <select name="kabupaten" class="form-control" id="kotas"
                                                            onchange="CKabupaten('kecamatans')">
                                                            <option>Pilih Kabupaten/Kota</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">Kecamatan:</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <select id="kecamatans" name="kecamatan" class="form-control">
                                                            <option>Pilih Kecamatan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>


                                        <div class="row">
                                            <label class="col-lg-3">Nama Jalan, Desa, RT/RW</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <textarea id="konten" class="form-control" name="alamat" rows="10" cols="50"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-lg-3">No. Telepon</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <input required name="no_hp" type="text" class="form-control"
                                                            placeholder="Ketik Nomor Telepon cabang baru...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <center>
                                                    <button class="btn btn-primary btn-lg"> Tambah </button>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            <br><br>
                            <hr><br>
                            <label><strong>
                                    <h3>Data Cabang</h3>
                                </strong></label>
                            <div class="table-responsive">
                                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Cabang</th>
                                            <th>Kepala Cabang</th>
                                            <th>No. Telepon</th>
                                            <th>Alamat</th>
                                            <th>Kecamatan</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Provinsi</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1;foreach ($gudang as $value) {?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $value->nama_gudang }}</td>
                                            <td>{{ $value->kepala_gudang }}</td>
                                            <td>{{ $value->no_hp }}</td>
                                            <td><?php echo $value->alamat; ?></td>
                                            <td><?php if (isset($data_kecamatan[$value->kecamatan])) {
                                                echo $data_kecamatan[$value->kecamatan];
                                            } ?></td>
                                            <td><?php if (isset($data_kabupaten[$value->kabupaten])) {
                                                echo $data_kabupaten[$value->kabupaten];
                                            } ?></td>
                                            <td><?php if (isset($data_provinsi[$value->provinsi])) {
                                                echo $data_provinsi[$value->provinsi];
                                            } ?></td>
                                            <td>
                                                <button class="btn btn-default" onclick="edit('{{ $value->id }}')"><i
                                                        class="icon-pencil"></i></button>
                                                <button class="btn btn-default"
                                                    onclick="Deleted('{{ $value->nama_gudang }}','{{ $value->id }}')"><i
                                                        class="icon-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php $no++;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editmodal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('updategudang') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id">
                        Nama Cabang:
                        <input required id="nama_gudang" name="nama_gudang" type="text" class="form-control">
                        Kepala Gudang:
                        <input required id="kepala_gudang" name="kepala_gudang" type="text" class="form-control"
                            onkeyup="showResults2(this.value)">
                        <input type="hidden" class="form-control" id="id_kepala2" name="karyawan">
                        <div id="livesearch2"></div>
                        Provinsi:
                        <select required id="provinsiss" name="provinsi" class="form-control"
                            onchange="CProvinsis('kotass')">
                            <option value="plh" disabled>Pilih Provinsi</option>
                            <?php foreach ($provinsi as $key => $value): ?>
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            <?php endforeach; ?>
                        </select>
                        Kabupaten / Kota:
                        <select name="kabupaten" class="form-control" id="kotass"
                            onchange="CKabupatens('kecamatanss')">
                            <option>Pilih Kabupaten/Kota</option>
                        </select>
                        Kecamatan:
                        <select id="kecamatanss" name="kecamatan" class="form-control">
                            <option>Pilih Kecamatan</option>
                        </select>
                        Alamat:
                        <textarea required id="konten2" class="form-control" name="alamat" rows="10" cols="50"></textarea>
                        No. Telepon:
                        <input required id="no_hp" name="no_hp" type="text" class="form-control">
                        <br>
                        <center><input type="submit" class="btn btn-primary" value="Update"></center>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var konten = document.getElementById("konten");
        CKEDITOR.replace(konten, {
            language: 'en-gb'
        });
        CKEDITOR.config.allowedContent = true;
    </script>
    <script>
        var konten = document.getElementById("konten2");
        CKEDITOR.replace(konten, {
            language: 'en-gb'
        });
        CKEDITOR.config.allowedContent = true;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        function edit(value) {
            $.ajax({
                url: 'editGudang/' + value,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    document.getElementById("id").value = response['gudang'][0]['id'];
                    document.getElementById("nama_gudang").value = response['gudang'][0]['nama_gudang'];
                    document.getElementById("kepala_gudang").value = response['gudang'][0]['kepala_gudang'];
                    if (response['gudang'][0]['provinsi'] == null) {
                        document.getElementById("provinsiss").value = "plh";
                    } else {
                        document.getElementById("provinsiss").value = response['gudang'][0]['provinsi'];
                    }
                    CKEDITOR.instances['konten2'].setData(response['gudang'][0]['alamat']);
                    document.getElementById("no_hp").value = response['gudang'][0]['no_hp'];
                    $('#editmodal').modal('show');

                    document.getElementById("kotass").innerHTML = "";
                    var y = document.getElementById("kotass");
                    var options = document.createElement("option");
                    options.text = "Pilih Kabupaten";
                    y.add(options);
                    for (j = 0; j < response['kabupaten'].length; j++) {
                        var x = document.getElementById("kotass");
                        var option = document.createElement("option");
                        option.text = response['kabupaten'][j]['name'];
                        option.value = response['kabupaten'][j]['id'];
                        if (response['kabupaten'][j]['id'] == response['gudang'][0]['kabupaten']) {
                            option.selected = true;
                        }
                        x.add(option);
                    }

                    document.getElementById("kecamatanss").innerHTML = "";
                    var z = document.getElementById("kecamatanss");
                    var options = document.createElement("option");
                    options.text = "Pilih Kecamatan";
                    z.add(options);
                    for (k = 0; k < response['kecamatan'].length; k++) {
                        var v = document.getElementById("kecamatanss");
                        var option = document.createElement("option");
                        option.text = response['kecamatan'][k]['name'];
                        option.value = response['kecamatan'][k]['id'];
                        if (response['kecamatan'][k]['id'] == response['gudang'][0]['kecamatan']) {
                            option.selected = true;
                        }
                        v.add(option);
                    }

                }
            });
        }

        function Deleted(name, value) {
            Swal.fire(
                'Delete ' + name + '?',
                'Apakah Anda Yakin?',
                'question'
            ).then((result) => {
                if (result.value) {
                    location.href = "{{ url('/deletegudang/') }}" + "/" + value;
                }
            });
        }


        function CProvinsi(key) {
            var val = document.getElementById("provinsis").value;
            $.ajax({
                url: 'getkabupatens/' + val,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    document.getElementById(key).innerHTML = "";
                    var y = document.getElementById(key);
                    var options = document.createElement("option");
                    options.text = "Pilih Kabupaten";
                    y.add(options);
                    for (var i = 0; i < response.length; i++) {
                        var x = document.getElementById(key);
                        var option = document.createElement("option");
                        option.text = response[i]['name'];
                        option.value = response[i]['id'];
                        x.add(option);
                    }
                }
            });
        }

        function CKabupaten(key) {
            var val = document.getElementById("kotas").value;
            $.ajax({
                url: 'getkecamatans/' + val,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    document.getElementById(key).innerHTML = "";

                    var y = document.getElementById(key);
                    var options = document.createElement("option");
                    options.text = "Pilih Kecamatan";
                    y.add(options);

                    for (var i = 0; i < response.length; i++) {
                        var x = document.getElementById(key);
                        var option = document.createElement("option");
                        option.text = response[i]['name'];
                        option.value = response[i]['id'];
                        x.add(option);
                    }
                }
            });
        }

        function CProvinsis(key) {
            var val = document.getElementById("provinsiss").value;
            $.ajax({
                url: 'getkabupatens/' + val,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    document.getElementById(key).innerHTML = "";
                    var y = document.getElementById(key);
                    var options = document.createElement("option");
                    options.text = "Pilih Kabupaten";
                    y.add(options);
                    for (var i = 0; i < response.length; i++) {
                        var x = document.getElementById(key);
                        var option = document.createElement("option");
                        option.text = response[i]['name'];
                        option.value = response[i]['id'];
                        x.add(option);
                    }
                }
            });
        }

        function CKabupatens(key) {
            var val = document.getElementById("kotass").value;
            $.ajax({
                url: 'getkecamatans/' + val,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    document.getElementById(key).innerHTML = "";

                    var y = document.getElementById(key);
                    var options = document.createElement("option");
                    options.text = "Pilih Kecamatan";
                    y.add(options);

                    for (var i = 0; i < response.length; i++) {
                        var x = document.getElementById(key);
                        var option = document.createElement("option");
                        option.text = response[i]['name'];
                        option.value = response[i]['id'];
                        x.add(option);
                    }
                }
            });
        }


        function showResult(str) {
            if (str != "") {
                $.ajax({
                    url: 'caridetailkaryawan/' + str,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        document.getElementById("livesearch").innerHTML = "";
                        if (response.length > 0) {
                            for (var i = 0; i < response.length; i++) {
                                var temp = response[i]['id'] + "," + '"' + response[i]['nama'] + '"';
                                document.getElementById("livesearch").innerHTML +=
                                    "<button class='btn btn-default' type='button' onclick='PilihOrg(" + temp +
                                    ")'>" + response[i]['nama'] + "</button>" + "<br>";
                            }
                        } else {
                            document.getElementById("livesearch").innerHTML = "";
                        }
                    }
                });
            }
        }

        function showResults2(str) {
            if (str != "") {
                $.ajax({
                    url: 'caridetailkaryawan/' + str,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        document.getElementById("livesearch2").innerHTML = "";
                        if (response.length > 0) {
                            for (var i = 0; i < response.length; i++) {
                                var temp = response[i]['id'] + "," + '"' + response[i]['nama'] + '"';
                                document.getElementById("livesearch2").innerHTML +=
                                    "<button class='btn btn-default' type='button' onclick='PilihOrg2(" + temp +
                                    ")'>" + response[i]['nama'] + "</button>" + "<br>";
                            }
                        } else {
                            document.getElementById("livesearch2").innerHTML = "";
                        }
                    }
                });
            }
        }

        function PilihOrg(id, nama) {
            document.getElementById("id_kepala").value = id;
            document.getElementById("nama_kepala").value = nama;
            document.getElementById("livesearch").innerHTML = "";
        }

        function PilihOrg2(id, nama) {
            document.getElementById("id_kepala2").value = id;
            document.getElementById("kepala_gudang").value = nama;
            document.getElementById("livesearch2").innerHTML = "";
        }
    </script>
@endsection
