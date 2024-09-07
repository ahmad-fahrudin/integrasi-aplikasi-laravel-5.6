@extends('template/nav')
@section('content')
  <script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    
        <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan ><a href="https://stokis.app/?s=profil+saya" target="_blank"> Profil Saya</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                        <div class="row">
                          <label class="col-lg-6"><strong>Profil Saya</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">NIK</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                    <input type="hidden" value="{{$profile[0]->id}}" required name="id" id="id" class="form-control">
                                    <input type="hidden" value="{{$profile[0]->nik}}" required name="old_nik" id="old_nik" class="form-control">
                                    <input type="text" readonly  value="{{$profile[0]->nik}}" required name="nik" id="nik" class="form-control">
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Username</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly value="{{$profile[0]->nama}}" required name="nama" id="nama" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Lengkap</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" maxlength="30" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $profile[0]->nama_lengkap; ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat (Jalan, Desa RT/RW)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <textarea id="konten2" maxlength="50" class="form-control"><?php echo $profile[0]->alamat; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" value="{{$profile[0]->no_hp}}" required name="password" id="no_hp" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Data Bank</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Bank</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" maxlength="20" value="{{$profile[0]->nama_bank}}" required name="password" id="nama_bank" class="form-control">
                                  </div>
                              </div>
                          </div>
                         </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No Rekening</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" maxlength="20" value="{{$profile[0]->no_rekening}}" required name="password" id="no_rekening"class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Rekening Atas Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" maxlength="30" value="{{$profile[0]->ats_bank}}" required name="password" id="ats_bank" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-12">
                            <center>
                           <div class="col-lg-3">
                            <button class="form-control btn btn-primary btn-lg" onclick="Simpan()"> Ubah Profil</button>
                            <br><br>
                            </div>
                            </center>
                        </div>
                        </div>
                    
                  </div>
                </div>
              </div>
            
              <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item text-muted" aria-current="page">Ubah Password</li>
                        </ol>
                    </nav>
                  </h4>
                  <hr>
                        <form action="{{url('changepassword')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-6"><strong>Ubah Password</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Password Lama</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                    <input type="password" required name="oldpass" class="form-control" placeholder="********">
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Password Baru</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                    <input type="password" required name="newpass" class="form-control" placeholder="********">
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Konfirmasi Ulang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="password" required name="newpass2" class="form-control" placeholder="Ketik ulang password baru Anda...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <div class="col-lg-12">
                            <center>
                            <button class="btn btn-primary btn-lg"> Simpan</button>
                            </center>
                          </div>
                        </div>

                      </form>

                      <br>
                  
            </div>
          </div>

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item text-muted" aria-current="page">Kode Refferal</li>
                        </ol>
                    </nav>
                  </h4>
                  <hr>

                      <div class="row">
                        <label class="col-lg-3">Kode Referral Saya</label>
                        <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-11">
                                  <input type="text" readonly class="form-control" value="{{$profile[0]->kode_referal}}">
                              </div>
                          </div>
                         </div>
                      </div>
                      <br>
                      <?php if (!isset($profile[0]->kode_referal)): ?>
                        <div class="row">
                          <div class="col-lg-12">
                            <center>
                            <button class="btn btn-primary btn-lg" onclick="Create()"> Buat Referal</button>
                            </center>
                          </div>
                        </div>
                      <?php endif; ?>
                  
            </div>
          </div>
        </div>
            </div>
            
        </div>
    </div>
    
    


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
      var konten = document.getElementById("konten2");
      CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;

      function Simpan(){
        var nama = document.getElementById("nama").value;
        var nik = document.getElementById("nik").value;
        var old_nik = document.getElementById("old_nik").value;
        var alamat = CKEDITOR.instances.konten2.getData();//document.getElementById("konten2").value;
        var no_hp = document.getElementById("no_hp").value;
        var id = document.getElementById("id").value;
        var cek = <?php echo Auth::user()->level; ?>;
        var no_rekening = document.getElementById("no_rekening").value;
        var ats_bank = document.getElementById("ats_bank").value;
        var nama_bank = document.getElementById("nama_bank").value;
        var nama_lengkap = document.getElementById("nama_lengkap").value;

        if (Number(cek) == "6") {
          $.post("updateinvestor",
            {id:id,old_nik:old_nik,nama_investor:nama,nama_lengkap:nama_lengkap,nik:nik,alamat:alamat,no_hp:no_hp,no_rekening:no_rekening,ats_bank:ats_bank,nama_bank:nama_bank
             , _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                {
                    Swal.fire({
                        title: 'Berhasil',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan!'
                      }).then((result) => {
                        if (result.value) {
                          location.href="{{url('/profile/')}}";
                        }else{
                          location.href="{{url('/profile/')}}";
                        }
                      });
                }).fail(function(jqXHR, textStatus, errorThrown)
            {
                alert(textStatus);
            });

        }else{
          $.post("updatekaryawanonly",
            {id:id,nama:nama,old_nik:old_nik,nik:nik,nama_lengkap:nama_lengkap,alamat:alamat,no_hp:no_hp,no_rekening:no_rekening,ats_bank:ats_bank,nama_bank:nama_bank
             , _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                {
                    Swal.fire({
                        title: 'Berhasil',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan!'
                      }).then((result) => {
                        if (result.value) {
                          location.href="{{url('/profile/')}}";
                        }
                      });
                }).fail(function(jqXHR, textStatus, errorThrown)
            {
                alert(textStatus);
            });
        }

      }
      function Create()
      {
        Swal.fire(
          'Buat Kode Referal ?',
          'Apakah Anda Yakin?',
          'question'
        ).then((result) => {
          if (result.value) {
            location.href="{{url('/createkode/')}}";
          }
        });
      }
    </script>
@endsection
