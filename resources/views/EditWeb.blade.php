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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=pengaturan+web+store" target="_blank">Web Store</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('saveaplikasi')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Nama Perusahaan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="nama"class="form-control" value="{{$apl[0]->nama}}" placeholder="Ketik nama perusahaan Anda...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Deskripsi</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea type="text" name="deskripsi_index"class="form-control" value="{{$apl[0]->deskripsi_index}}" placeholder="Ketik deskripsi singkat tentang perusahaan..."><?php echo $apl[0]->deskripsi_index; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Keyword SEO</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea type="text" name="keyword_index"class="form-control" value="{{$apl[0]->keyword_index}}" placeholder="Ketik kata kunci untuk seo..."><?php echo $apl[0]->keyword_index; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Logo Perusahaan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>" width="200px"><br><br>
                                      <input type="file" name="icon" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Icon Perusahaan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->favicon); ?>" width="150px"><br><br>
                                      <input type="file" name="favicon" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Barner Slider #1</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->barner1); ?>" width="500px"><br><br>
                                      <input type="file" name="barner1" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Barner Slider #2</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->barner2); ?>" width="500px"><br><br>
                                      <input type="file" name="barner2" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Barner Slider #3</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->barner3); ?>" width="500px"><br><br>
                                      <input type="file" name="barner3" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat Kantor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="alamat" class="form-control" value="{{$apl[0]->alamat}}" placeholder="isi alamat lengkap Anda">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Peta Google Maps</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="gmaps" class="form-control" value="{{$apl[0]->gmaps}}" placeholder="https://www.google.com/maps/embed?xxxxxxxx">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama CS</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="cs" class="form-control" value="{{$apl[0]->cs}}" placeholder="isi nama CS">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Foto CS</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->foto); ?>" width="150px"><br><br>
                                      <input type="file" name="foto" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Whatsapp CS</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="no_hp" class="form-control" value="{{$apl[0]->no_hp}}" placeholder="ex: 628xxxxxxxx">
                                  </div>
                              </div>
                          </div>
                        </div>
                         <br>
                        <div class="row">
                          <label class="col-lg-3">Google Webmaster</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="console" class="form-control" value="{{$apl[0]->console}}" placeholder="ID Content Google Webmaster">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Site Key Google Rechaptca</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="rechaptca" class="form-control" value="{{$apl[0]->rechaptca}}" placeholder="Site Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Secret Key Google Rechaptca</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="secretkey" class="form-control" value="{{$apl[0]->secretkey}}" placeholder="Secret Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">SandBox Server</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="sandbox_server" class="form-control" value="{{$apl[0]->sandbox_server}}" placeholder="Secret Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">SandBox Client</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="sandbox_client" class="form-control" value="{{$apl[0]->sandbox_client}}" placeholder="Secret Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Production Server</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="production_server" class="form-control" value="{{$apl[0]->production_server}}" placeholder="Secret Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Production Client</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="production_client" class="form-control" value="{{$apl[0]->production_client}}" placeholder="Secret Key Google Rechaptca">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Opsi Payment Gateway</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <input type="radio" name="develop" value="sandbox" <?php if ($apl[0]->develop == "sandbox"): ?>checked<?php endif; ?>> Sandbox &emsp;&emsp;&emsp;
                                    <input type="radio" name="develop" value="production" <?php if ($apl[0]->develop == "production"): ?>checked<?php endif; ?>> Production
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Google Analystics</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="analystics" class="form-control" value="{{$apl[0]->analystics}}" placeholder="ID Google Analystics">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Link Webstore</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="toko" class="form-control" value="{{$apl[0]->toko}}" placeholder="https://domain.com">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Link Playstore</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="apk" class="form-control" value="{{$apl[0]->apk}}" placeholder="https://play.google.com/store/apps/...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Email CS</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="email" class="form-control" value="{{$apl[0]->email}}" placeholder="ex: cs@domain.com">
                                  </div>
                              </div>
                          </div>
                        </div>
                         <br>
                        <div class="row">
                          <label class="col-lg-3">Facebook</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="facebook" class="form-control" value="{{$apl[0]->facebook}}" placeholder="ex: https://facebook.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Instagram</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="instagram" class="form-control" value="{{$apl[0]->instagram}}" placeholder="ex: https://instagram.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Youtube</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="youtube" class="form-control" value="{{$apl[0]->youtube}}" placeholder="ex: https://youtube.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Shopee</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="shopee" class="form-control" value="{{$apl[0]->shopee}}" placeholder="ex: https://shopee.co.id/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Tokopedia</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="tokopedia" class="form-control" value="{{$apl[0]->tokopedia}}" placeholder="ex: https://tokopedia.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Lazada</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="lazada" class="form-control" value="{{$apl[0]->lazada}}" placeholder="ex: https://lazada.co.id/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Blibli</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="blibli" class="form-control" value="{{$apl[0]->blibli}}" placeholder="ex: https://blibli.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-3">Tiktok Shop</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" name="tiktok" class="form-control" value="{{$apl[0]->tiktok}}" placeholder="ex: https://tiktok.com/nama">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Perhitungan Ongkir</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="radio" name="ongkir" value="aktif" <?php if ($apl[0]->ongkir == "aktif"): ?>checked<?php endif; ?>> Aktif &emsp;&emsp;&emsp;
                                      <input type="radio" name="ongkir" value="non aktif" <?php if ($apl[0]->ongkir == "non aktif"): ?>checked<?php endif; ?>> Non Aktif
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Widget Jasa</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="radio" name="booking" value="aktif" <?php if ($apl[0]->booking == "aktif"): ?>checked<?php endif; ?>> Aktif &emsp;&emsp;&emsp;
                                      <input type="radio" name="booking" value="non aktif" <?php if ($apl[0]->booking == "non aktif"): ?>checked<?php endif; ?>> Non Aktif
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Gambar Jasa</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <img src="<?php echo asset('gambar/'.aplikasi()[0]->gbr_booking); ?>" width="200px"><br><br>
                                      <input type="file" name="gbr_booking" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Judul Jasa</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea type="text" name="jdl_booking"class="form-control" value="{{$apl[0]->jdl_booking}}" placeholder="Ketik judul widget resevasi..."><?php echo $apl[0]->jdl_booking; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Deskripsi Jasa</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea type="text" name="text_booking"class="form-control" value="{{$apl[0]->text_booking}}" placeholder="Ketik deskripsi widget reservasi..."><?php echo $apl[0]->text_booking; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                       </form>
                      </div>
                    </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
