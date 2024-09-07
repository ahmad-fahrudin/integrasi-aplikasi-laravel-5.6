<?php

use App\Http\Controllers\Wms\ClientController;
use App\Http\Controllers\Wms\OrderController;
use App\Http\Controllers\Wms\ProductController;
use App\Http\Controllers\Wms\PurcahseController;
use App\Http\Controllers\Wms\ReportingController;
use App\Http\Controllers\Wms\StockController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/downloadkatalog', 'KatalogController@downloadkatalog')->name('downloadkatalog');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@home')->name('home');

    //inventaris
    Route::get('/inputinventaris', 'Inventaris@inputinventaris')->name('Input Inventaris');
    Route::post('/postinventaris', 'Inventaris@postinventaris')->name('Input Inventaris');
    Route::post('/postinventarisdetail', 'Inventaris@postinventarisdetail')->name('Input Inventaris');
    Route::get('/getstokbar/{id}/{gd}', 'Inventaris@getstokbar')->name('Data Inventaris');
    Route::get('/datainventaris', 'Inventaris@datainventaris')->name('Data Inventaris');
    Route::get('/spbinventaris/{id}', 'Surat@spbinventaris')->name('Data Inventaris');


    //Barang Masuk

    Route::get('/barangmasuk', 'BarangController@index')->name('databarangmasuk');
    Route::post('/barangmasuk', 'BarangController@barangmasuk')->name('databarangmasuk');
    //Route::get('/barangmasuks', 'BarangController@indexs');
    Route::get('/inputbarangmasuk', 'BarangController@inputbarangmasuk')->name('inputbarangmasuk');
    Route::get('/editBarangMasuk/{id}', 'BarangController@editBarangMasuk')->name('inputbarangmasuk');
    Route::get('/cekhargabarangmasuk/{id}', 'BarangController@cekhargabarangmasuk')->name('cekhargabarangmasuk');
    Route::get('/updatehargahpmasuk/{id}/{harga}', 'BarangController@updatehargahpmasuk')->name('updatehargahpmasuk');
    Route::post('/updatebarangmasuk', 'BarangController@updatebarangmasuk')->name('inputbarangmasuk');
    Route::get('/deleteBarangMasuk/{id}', 'BarangController@deleteBarangMasuk')->name('inputbarangmasuk');
    Route::get('/getBarangMasukBarcode/{id}', 'BarangController@getBarangMasukBarcode')->name('getBarangMasukBarcode');
    Route::get('/caribarangbykodeBardode/{id}', 'BarangController@caribarangbykodeBarcode')->name('inputbarangmasuk');


    Route::get('/pengiriman_khusus', 'BarangController@pengiriman_khusus')->name('pengiriman_khusus');
    Route::post('/simpankurirlokal', 'BarangController@simpankurirlokal')->name('simpankurirlokal');
    Route::get('/deletekabupaten/{id}', 'BarangController@deletekabupaten')->name('deletekabupaten');
    Route::post('/simpanhargakurirlokal', 'BarangController@simpanhargakurirlokal')->name('simpanhargakurirlokal');


    //stokgudang
    Route::get('/stokgudang', 'BarangController@stokgudang')->name('datastokgudang');
    Route::post('/stokgudang', 'BarangController@stokgudangs')->name('datastokgudang');
    Route::post('/insertbarang', 'BarangController@insertbarang')->name('inputbarangbaru');
    Route::get('/inputbarangbaru', 'BarangController@inputbarangbaru')->name('inputbarangbaru');
    Route::get('/databarang', 'BarangController@databarang')->name('databarang');
    Route::get('/editBarang/{id}', 'BarangController@editBarang')->name('editBarang');
    Route::post('/updatebarang', 'BarangController@updatebarang')->name('updatebarang');
    Route::get('/deleteBarang/{id}', 'BarangController@deleteBarang')->name('deleteBarang');

    Route::get('/getSuplayer', 'HumanController@getSuplayer')->name('stokgudang.read');
    Route::post('/postbarangmasuk', 'BarangController@postbarangmasuk')->name('stokgudang.create');

    //pricelist
    Route::get('/pricelist', 'PriceController@index')->name('daftarharga');
    Route::get('/priceupdate', 'PriceController@updateprice')->name('updatedaftarharga');
    Route::post('/priceupdate', 'PriceController@updateprices')->name('updatedaftarharga');
    Route::post('/pricelist', 'PriceController@indexs')->name('daftarharga');
    Route::get('/historybarang', 'PriceController@historybarang')->name('historybarang');
    Route::post('/historybarang', 'PriceController@historybarangs')->name('historybarang');

    //transfer stok
    Route::get('/inputorderstok', 'BarangController@inputorderstok')->name('inputorderstok');
    Route::post('/posttransferstok', 'BarangController@posttransferstok')->name('orderstok.create');
    Route::post('/postdetailtransferstok', 'BarangController@postdetailtransferstok')->name('orderstok.create');
    Route::post('/postdetailtransferpenerimaan', 'BarangController@postdetailtransferpenerimaan')->name('orderstok.create');
    Route::get('/detailTransferStok/{id}', 'BarangController@detailTransferStok')->name('orderstok.read');
    Route::get('/pengiriman', 'BarangController@pengiriman')->name('prosestransferstokdikirim');
    Route::get('/pilihtransfer/{id}', 'BarangController@pilihtransfer')->name('orderstok.create');
    Route::get('/pilihtransfer2/{id}', 'BarangController@pilihtransfer2')->name('orderstok.create');
    Route::get('/updateproses/{id}/{ids}/{order}', 'BarangController@updateproses')->name('orderstok.create');
    Route::get('/updatetransferstok/{no_transfer}/{driver}/{qc}', 'BarangController@updatetransferstok')->name('orderstok.create');
    Route::get('/updatedetailtransferstok/{id_barang}/{id_gudang}/{value}', 'BarangController@updatedetailtransferstok')->name('orderstok.create');
    Route::get('/penerimaan', 'BarangController@penerimaan')->name('prosestransferstokditerima');
    Route::get('/updatepenerimaan/{value}/{value1}/{id}', 'BarangController@updatepenerimaan')->name('orderstok.create');
    Route::get('/updatetransferstokpenerimaan/{no_transfer}/{status}', 'BarangController@updatetransferstokpenerimaan')->name('orderstok.create');
    Route::get('/updatedetailtransferstokpenerimaan/{id_barang}/{id_gudang}/{value}/{value1}/{gudang_retur}', 'BarangController@updatedetailtransferstokpenerimaan')->name('orderstok.create');
    Route::get('/daftarorderstok', 'BarangController@daftarorderstok')->name('daftarorderstok');
    Route::post('/daftarorderstok', 'BarangController@daftarorderstoks')->name('daftarorderstok');
    Route::get('/datatransferstok', 'BarangController@datatransferstok')->name('datatransferstok');
    Route::post('/datatransferstok', 'BarangController@datatransferstoks')->name('datatransferstok');
    Route::post('/datatransferstokbyname', 'BarangController@datatransferstokbyname')->name('datatransferstokbyname');
    Route::get('/detailBarang/{to}/{from}', 'BarangController@detailBarang')->name('orderstok.create');
    Route::get('/deleteOrderStok/{id}', 'BarangController@deleteOrderStok')->name('orderstok.create');
    Route::get('/deleteitemtransfer/{id}', 'BarangController@deleteitemtransfer')->name('orderstok.create');
    Route::get('/verifikasipengembalian', 'BarangController@verifikasipengembalian')->name('verifikasipengembalian');
    Route::get('/verifikasiretur/{id}', 'BarangController@verifikasiretur')->name('verifikasiretur');
    Route::get('/verifikasireturreject/{id}', 'BarangController@verifikasireturreject')->name('verifikasireturreject');

    //penjualan
    Route::post('/postbarangkeluar', 'BarangController@postbarangkeluar')->name('barangkeluar.create');
    Route::post('/postdetailbarangkeluar', 'BarangController@postdetailbarangkeluar')->name('barangkeluar.create');
    Route::get('/detailBarangKeluar/{id}', 'BarangController@detailBarangKeluar')->name('orderstok.read');
    Route::get('/deleteitempenjualan/{id}', 'BarangController@deleteitempenjualan')->name('orderstok.read');
    Route::get('/detailBarangTerkirim/{id}', 'BarangController@detailBarangTerkirim')->name('orderstok.read');
    Route::get('/detailBarangTerkirim2/{id}', 'BarangController@detailBarangTerkirim2')->name('orderstok.read');
    Route::get('/detailBarangTerkirim3/{id}', 'BarangController@detailBarangTerkirim3')->name('orderstok.read');
    Route::get('/inputorderbaru', 'BarangController@inputorderbaru')->name('inputorderbarangkeluar'); //
    Route::get('/daftarorderbaru', 'BarangController@daftarorderbaru')->name('daftarorderbarangkeluar'); //
    Route::post('/daftarorderbaru', 'BarangController@daftarorderbarus')->name('daftarorderbarangkeluar');
    Route::get('/dikirim', 'BarangController@dikirim')->name('prosesorderbarangdikirim');
    Route::get('/pilihbarangkeluar/{id}', 'BarangController@pilihbarangkeluar')->name('penjualan.create');
    Route::get('/cekhutang/{id}', 'BarangController@cekhutang')->name('penjualan.create');
    Route::get('/pilihbarangkeluarterkirim/{id}', 'BarangController@pilihbarangkeluarterkirim')->name('penjualan.create');
    Route::get('/detailBK/{id}', 'BarangController@detailBK')->name('penjualan.create');
    Route::get('/verifikasipenjualan', 'BarangController@verifikasipenjualan')->name('verifikasipenjualan');
    Route::get('/verifikasireturpenjualan/{id}', 'BarangController@verifikasireturpenjualan')->name('verifikasireturpenjualan');
    Route::get('/cancelreturpenjualan/{id}', 'BarangController@cancelreturpenjualan')->name('cancelreturpenjualan');

    Route::get('/updatedikirim/{proses}/{jumlah}/{id}', 'BarangController@updatedikirim')->name('penjualan.create');
    Route::get('/updatedikirims/{proses}/{jumlah}/{id}/{hargajual}/{idbarang}', 'BarangController@updatedikirims')->name('penjualan.create');
    Route::post('/updatebarangkeluar', 'BarangController@updatebarangkeluar')->name('penjualan.read');
    Route::get('/deleteOrderBaru/{id}', 'BarangController@deleteOrderBaru')->name('orderstok.create');
    Route::get('/cariKaryawan/{id}/{status}', 'BarangController@cariKaryawan')->name('orderstok.create');
    Route::get('/pilihstokbaru/{gudang}/{id}', 'BarangController@pilihstokbaru')->name('orderstok.create');
    Route::get('/editbarangkeluardikirim/{id}/{gudang}', 'BarangController@editbarangkeluardikirim')->name('orderstok.create');
    Route::get('/getrejectdata/{id_barang}/{gudang}', 'BarangController@getrejectdata')->name('orderstok.create');

    //Riject
    Route::get('/inputriject', 'RijectController@inputriject')->name('inputriject'); //
    Route::post('/postbarangriject', 'RijectController@postbarangriject')->name('penjualan.read');
    Route::post('/postdetailbarangriject', 'RijectController@postdetailbarangriject')->name('penjualan.read');
    Route::get('/datareject', 'RijectController@datareject')->name('inputriject');
    Route::get('/daftariject', 'RijectController@daftariject')->name('daftariject');
    Route::get('/validasiriject/{id}', 'RijectController@validasiriject')->name('validasiriject');
    Route::get('/batalriject/{id}', 'RijectController@batalriject')->name('batalriject');
    Route::post('/datareject', 'RijectController@datarejects')->name('inputriject');
    Route::get('/cekstok/{gudang}/{id}', 'RijectController@cekstok')->name('penjualan.create');

    //return
    Route::get('/inputreturn', 'ReturnController@inputreturn')->name('inputreturn');
    Route::post('/postreturnbarang', 'ReturnController@postreturnbarang')->name('penjualan.read');
    Route::post('/postpendingretur', 'ReturnController@postpendingretur')->name('penjualan.read');
    Route::get('/datareturn', 'ReturnController@datareturn')->name('datareturn');
    Route::post('/datareturn', 'ReturnController@datareturns')->name('datareturn');
    Route::get('/validretur', 'ReturnController@validretur')->name('validretur');
    Route::get('/cancelretur/{id}', 'ReturnController@cancelretur')->name('cancelretur');

    Route::get('/updins/{id}', 'InsentifController@updins')->name('updins');

    Route::get('/detailKwitansi/{id}', 'BarangController@detailKwitansi')->name('orderstok.create');
    Route::post('/simpantransferstok', 'BarangController@simpantransferstok')->name('orderstok.read');

    Route::get('/terkirim', 'BarangController@terkirim')->name('prosesorderbarangterkirim');
    Route::get('/updateterkirim/{proses}/{terkirim}/{id}/{potongan}', 'BarangController@updateterkirim')->name('penjualan.create');
    Route::post('/penerimaanbarangkeluar', 'BarangController@penerimaanbarangkeluar')->name('penjualan.read');

    Route::get('/dataorderpenjualan', 'BarangController@dataorderpenjualan')->name('databarangkeluar');
    Route::get('/dataorderpenjualan/{bulan}', 'BarangController@dataorderpenjualanbulan')->name('databarangkeluar');
    Route::post('/dataorderpenjualan', 'BarangController@dataorderpenjualans')->name('databarangkeluar');
    Route::post('/caridatapenjualan', 'BarangController@caridatapenjualan')->name('databarangkeluar');
    Route::post('/caridatapenjualanbyname', 'BarangController@caridatapenjualanbyname')->name('databarangkeluar');
    Route::get('/inputbarangkeluar', 'BarangController@inputbarangkeluar')->name('nonpenjualan.create');
    Route::get('/daftarbarangkeluar', 'BarangController@daftarbarangkeluar')->name('nonpenjualan.read');
    Route::get('/databarangkeluar', 'BarangController@databarangkeluar')->name('nonpenjualan.read');
    Route::get('/daftarpenjualan', 'BarangController@daftarpenjualan')->name('daftarpenjualanterkirim');
    Route::post('/daftarpenjualan', 'BarangController@daftarpenjualans')->name('daftarpenjualanterkirim');
    Route::get('/daftarhutang', 'BarangController@daftarhutang')->name('daftarhutang');
    Route::get('/detailBarangMasuk/{id}', 'BarangController@detailBarangMasuk')->name('detailBarangMasuk');
    Route::get('/detailBarangMasuk2/{id}', 'BarangController@detailBarangMasuk2')->name('detailBarangMasuk2');

    Route::get('/daftarpenjualanjasa', 'JasaController@daftarpenjualanjasa')->name('daftarpenjualanterkirim');
    Route::post('/daftarpenjualanjasa', 'JasaController@daftarpenjualanjasas')->name('daftarpenjualanterkirim');
    Route::get('/prosespembayaranjasa', 'JasaController@prosespembayaranjasa')->name('prosespembayaran');
    Route::get('/datapembayaranjasa', 'JasaController@datapembayaranjasa')->name('datapembayaran');
    Route::post('/datapembayaranjasa', 'JasaController@datapembayaranjasas')->name('datapembayaran');
    Route::post('/caridatapembayaranjasa', 'JasaController@caridatapembayaranjasa')->name('datapembayaran');

    Route::get('/prosespembayaran', 'BarangController@prosespembayaran')->name('prosespembayaran');
    Route::get('/prosespembayaranhutang', 'BarangController@prosespembayaranhutang')->name('prosespembayaranhutang');
    Route::post('/pembayaranhutang', 'BarangController@pembayaranhutang')->name('pembayaranhutang');
    Route::get('/pilihbarangmasuk/{id}', 'BarangController@pilihbarangmasuk')->name('pilihbarangmasuk');
    Route::get('/datapembayaran', 'BarangController@datapembayaran')->name('datapembayaran');
    Route::post('/datapembayaran', 'BarangController@datapembayarans')->name('datapembayaran');
    Route::post('/caridatapembayaran', 'BarangController@caridatapembayaran')->name('datapembayaran');
    Route::get('/datapembayaran/{id}', 'BarangController@datapembayaranbulan')->name('datapembayaran');
    Route::post('/pembayaran', 'BarangController@pembayaran')->name('pembayaran.read');
    Route::get('/getHuman/{id}', 'BarangController@getHuman')->name('penjualan.create');

    //Suplayer
    Route::get('/datasuplayer', 'HumanController@datasuplayer')->name('datasuplayer');
    Route::post('/datasuplayer', 'HumanController@datasuplayers')->name('datasuplayer');
    Route::get('/inputsuplayer', 'HumanController@inputsuplayer')->name('inputsuplayerbaru');
    Route::post('/inputsuplayeract', 'HumanController@inputsuplayeract')->name('suplayer.create');
    Route::get('/deleteSuplayer/{id}', 'HumanController@deleteSuplayer')->name('suplayer.delete');
    Route::get('/editSuplayer/{id}', 'HumanController@editSuplayer')->name('suplayer.update');
    Route::post('/updatesuplayer', 'HumanController@updatesuplayer')->name('suplayer.update');

    //Konsumen
    Route::get('/datakonsumen', 'HumanController@datakonsumen')->name('datakonsumen');
    Route::post('/datakonsumen', 'HumanController@datakonsumens')->name('datakonsumen');
    Route::get('/inputkonsumen', 'HumanController@inputkonsumen')->name('inputkonsumenbaru');
    Route::post('/inputkonsumenact', 'HumanController@inputkonsumenact')->name('konsumen.create');
    Route::get('/deleteKonsumen/{id}/{no_hp}', 'HumanController@deleteKonsumen')->name('konsumen.delete');
    Route::get('/editKonsumen/{id}', 'HumanController@editKonsumen')->name('konsumen.update');
    Route::post('/updatekonsumen', 'HumanController@updatekonsumen')->name('konsumen.update');

    //Karyawan
    Route::get('/datakaryawan', 'HumanController@datakaryawan')->name('datakaryawan');
    Route::get('/inputkaryawan', 'HumanController@inputkaryawan')->name('inpukaryawanbaru');
    Route::post('/inputkaryawanact', 'HumanController@inputkaryawanact')->name('karyawan.create');
    Route::get('/deleteKaryawan/{id}/{no_hp}', 'HumanController@deleteKaryawan')->name('karyawan.delete');
    Route::get('/editKaryawan/{id}', 'HumanController@editKaryawan')->name('karyawan.update');
    Route::post('/updatekaryawan', 'HumanController@updatekaryawan')->name('karyawan.update');
    Route::get('/inputkaryawaninvestor', 'HumanController@inputkaryawaninvestor')->name('inputkaryawaninvestor');
    Route::post('/simpansebagaiinvestor', 'HumanController@simpansebagaiinvestor')->name('simpansebagaiinvestor');

    Route::get('/rekening', 'PengaturanController@rekening')->name('rekening');
    Route::post('/insertrekening', 'PengaturanController@insertrekening')->name('insertrekening');
    Route::post('/updaterekening', 'PengaturanController@updaterekening')->name('updaterekening');
    Route::get('/deleterekening/{id}', 'PengaturanController@deleterekening')->name('deleterekening');

    //user
    Route::get('/user', 'PengaturanController@user')->name('user');
    Route::post('/insertuser', 'PengaturanController@insertuser')->name('user.create');
    Route::get('/deleteuser/{id}', 'PengaturanController@deleteuser')->name('user.delete');
    Route::get('/editUser/{id}', 'PengaturanController@edituser')->name('user.update');
    Route::post('/updateuser', 'PengaturanController@updateuser')->name('user.update');
    Route::get('/resetuser/{id}', 'PengaturanController@resetuser')->name('user.update');
    Route::get('/cekcabang/{id}', 'PengaturanController@cekcabang')->name('User Admin');

    //Password
    Route::get('/profile', 'PengaturanController@profile')->name('password');
    Route::post('/changepassword', 'PengaturanController@changepassword')->name('profile.update');
    Route::post('/updatekaryawanonly', 'PengaturanController@updatekaryawan')->name('gudang.update');

    //gudang
    Route::get('/gudang', 'PengaturanController@gudang')->name('gudang');
    Route::post('/insertgudang', 'PengaturanController@insertgudang')->name('gudang.create');
    Route::get('/deletegudang/{id}', 'PengaturanController@deletegudang')->name('gudang.delete');
    Route::get('/editGudang/{id}', 'PengaturanController@editgudang')->name('gudang.update');
    Route::post('/updategudang', 'PengaturanController@updategudang')->name('gudang.update');
    Route::get('/previllagegudang', 'PengaturanController@previllagegudang')->name('previllagegudang');
    Route::get('/addprevillage/{id}', 'PengaturanController@addprevillage')->name('gudang.delete');
    Route::get('/deleteprevillage/{id}', 'PengaturanController@deleteprevillage')->name('gudang.delete');

    //jabatan
    Route::get('/jabatan', 'PengaturanController@jabatan')->name('jabatan');
    Route::get('/editJabatan/{id}', 'PengaturanController@editJabatan')->name('jabatan.update');
    Route::post('/updatejabatan', 'PengaturanController@updatejabatan')->name('jabatan.update');
    Route::get('/deleteJabatan/{id}', 'PengaturanController@deletejabatan')->name('jabatan.delete');
    Route::post('/postjabatan', 'PengaturanController@postjabatan')->name('jabatan.create');

    //kategori
    Route::get('/kategori', 'PengaturanController@kategori')->name('kategori');
    Route::get('/editKategori/{id}', 'PengaturanController@editKategori')->name('kategori.update');
    Route::post('/updatekategori', 'PengaturanController@updatekategori')->name('kategori.update');
    Route::get('/deleteKategori/{id}', 'PengaturanController@deletekategori')->name('kategori.delete');
    Route::post('/postkategori', 'PengaturanController@postkategori')->name('kategori.create');

    //kategori Jasa
    Route::get('/kategorijasa', 'PengaturanController@kategorijasa')->name('kategorijasa');
    Route::get('/editkategorijasa/{id}', 'PengaturanController@editkategorijasa')->name('kategorijasa.update');
    Route::post('/updatekategorijasa', 'PengaturanController@updatekategorijasa')->name('kategorijasa.update');
    Route::get('/deletekategorijasa/{id}', 'PengaturanController@deletekategorijasa')->name('kategorijasa.delete');
    Route::post('/addkategorijasa', 'PengaturanController@addkategorijasa')->name('kategorijasa.create');

    //surat
    Route::get('/surat/{id}', 'PengaturanController@surat')->name('surat.read');
    Route::get('/surattransfer/{id}', 'PengaturanController@surattransfer')->name('surattransfer.read');
    Route::get('/printdetailbarang/{id}', 'PengaturanController@printdetailbarang')->name('surat.read');
    Route::get('/printdetailbarangkeluar/{id}', 'PengaturanController@printdetailbarangkeluar')->name('surat.read');

    Route::get('/kwitansi/{id}', 'PengaturanController@kwitansi')->name('kwitansi.read');
    Route::get('/kwitansidp/{id}', 'PengaturanController@kwitansidp')->name('kwitansidp.read');
    Route::get('/tagihan/{id}', 'PengaturanController@tagihan')->name('tagihan.read');

    Route::get('/manager', 'PengaturanController@manager')->name('manager.read');
    Route::post('/inputmanager', 'PengaturanController@inputmanager')->name('manager.update');
    Route::post('/updatemanager', 'PengaturanController@updatemanager')->name('manager.update');
    Route::get('/deleteManager/{id}', 'PengaturanController@deletemanager')->name('manager.read');
    Route::get('/carikota/{id}', 'PengaturanController@carikota')->name('carikota.read');
    Route::get('/carimanager/{id}', 'PengaturanController@carimanager')->name('manager.read');
    Route::get('/carimanagerbyid/{id}', 'PengaturanController@carimanagerbyid')->name('manager.read');

    Route::get('/printdetailbarangkeluarall/{from}/{to}/{status}/{gudang}/{sales}/{pengembang}/{kota}', 'PengaturanController@printdetailbarangkeluarall')->name('surat.read');
    Route::get('/printdetailorderstok/{from}/{to}/{dari}', 'PengaturanController@printdetailorderstok')->name('surat.read');

    Route::get('/backup', 'PengaturanController@backup')->name('backup');
    Route::post('/import/import_excel', 'PengaturanController@import')->name('backup');
    Route::post('/import/import_konsumen', 'PengaturanController@import_konsumen')->name('backup');

    Route::get('/download_database', 'PengaturanController@download_database')->name('backup');
    Route::get('/penjualanterbaik/{id}', 'PengaturanController@penjualanterbaik')->name('surat.read');
    Route::get('/penjualanterlaris/{id}', 'PengaturanController@penjualanterlaris')->name('surat.read');
    Route::get('/penjualanterbanyak/{id}', 'PengaturanController@penjualanterbanyak')->name('surat.read');

    Route::get('/daftarpembelian', 'PembelianController@daftarpembelian')->name('daftarpembelian');
    Route::get('/cariKulakan/{id}', 'PembelianController@cariKulakan')->name('daftarpembelian');

    Route::get('/penjualterbaik', 'PengaturanController@penjualterbaik')->name('dashboard');
    Route::get('/penjualterlaris', 'PengaturanController@dashboard')->name('penjualterlaris');
    Route::get('/', 'PengaturanController@grafikpenjualan')->name('grafikpenjualan');
    Route::get('/pembelianterbanyak', 'PengaturanController@pembelianterbanyak')->name('pembelianterbanyak');

    Route::get('/pengadaanbarang', 'InvestasiController@pengadaanbarang')->name('pengadaanbarang');
    Route::get('/inputpengadaanbarang', 'InvestasiController@inputpengadaanbarang')->name('inputpengadaanbarang');
    Route::post('/simpanpengadaan', 'InvestasiController@simpanpengadaan')->name('simpanpengadaan');
    Route::get('/updateinves/{id}/{estimasi}', 'InvestasiController@updateinves')->name('surat.read');
    Route::get('/deleteinves/{id}', 'InvestasiController@deleteinves')->name('surat.read');
    Route::get('/deleteinvest/{id}', 'InvestasiController@deleteinvest')->name('surat.read');
    Route::get('/simpaninves/{id}', 'InvestasiController@simpaninves')->name('surat.read');
    Route::get('/datapengadaanbarang', 'InvestasiController@datapengadaanbarang')->name('datapengadaanbarang');
    Route::post('/datapengadaanbarang', 'InvestasiController@datapengadaanbarangs')->name('datapengadaanbarang');
    Route::get('/prosesinves/{id}/{status}', 'InvestasiController@prosesinves')->name('surat.read');
    Route::get('/simpaninvesbaru/{id}', 'InvestasiController@simpaninvesbaru')->name('simpaninvesbaru');

    Route::get('/inputtransaksi', 'TransaksiController@inputtransaksi')->name('inputtransaksi');
    Route::post('/inputsaldo', 'TransaksiController@inputsaldo')->name('inputsaldo');
    Route::get('/datatransaksi', 'TransaksiController@datatransaksi')->name('datatransaksi');
    Route::get('/tariktransaksi', 'TransaksiController@tariktransaksi')->name('tariktransaksi');
    Route::post('/penarikansaldo', 'TransaksiController@penarikansaldo')->name('penarikansaldo');
    Route::get('/inputinvestasi', 'TransaksiController@inputinvestasi')->name('inputinvestasi');
    Route::post('/pengisiansaldo', 'TransaksiController@pengisiansaldo')->name('pengisiansaldo');
    Route::post('/uploadbuktitransfer', 'TransaksiController@uploadbuktitransfer')->name('uploadbuktitransfer');
    Route::get('/verifikasitransfer/{id}', 'TransaksiController@verifikasitransfer')->name('verifikasitransfer');
    Route::get('/canceltransfer/{id}', 'TransaksiController@canceltransfer')->name('canceltransfer');
    Route::post('/verifikasitarik', 'TransaksiController@verifikasitarik')->name('verifikasitarik');
    Route::get('/batalkantarik/{id}', 'TransaksiController@batalkantarik')->name('batalkantarik');
    Route::post('/prosesinvestasi', 'TransaksiController@prosesinvestasi')->name('prosesinvestasi');


    Route::get('/daftarpembayaranmanual', 'OlshopController@daftarpembayaranmanual')->name('daftarpembayaranmanual');
    Route::get('/approvepembayaranmanual/{id}', 'OlshopController@approvepembayaranmanual')->name('approvepembayaranmanual');


    Route::get('/inputinsentif', 'InsentifController@inputinsentif')->name('inputinsentif');
    Route::post('/simpaninsentif', 'InsentifController@simpaninsentif')->name('simpaninsentif');
    Route::post('/simpaninsentifjasa', 'InsentifController@simpaninsentifjasa')->name('simpaninsentifjasa');
    Route::get('/datainsentif', 'InsentifController@datainsentif')->name('datainsentif');
    Route::get('/ambilinsentif', 'InsentifController@ambilinsentif')->name('ambilinsentif');
    Route::post('/penarikansaldoinsentif', 'InsentifController@penarikansaldo')->name('penarikansaldoinsentif');
    Route::post('/penarikansaldoinsentifmas', 'InsentifController@penarikansaldomas')->name('penarikansaldoinsentif');
    Route::post('/verifikasipenarikan', 'InsentifController@verifikasipenarikan')->name('verifikasipenarikan');
    Route::get('/bataltarik/{id}', 'InsentifController@bataltarik')->name('bataltarik');
    Route::get('/bataltarikmase/{id}', 'InsentifController@bataltarikmase')->name('bataltarik');
    Route::get('/potonganinsentif', 'InsentifController@potonganinsentif')->name('potonganinsentif');
    Route::post('/inputpotongan', 'InsentifController@inputpotongan')->name('inputpotongan');
    Route::get('/revisiinsentif', 'InsentifController@revisiinsentif')->name('revisiinsentif');
    Route::post('/inputrevisi', 'InsentifController@inputrevisi')->name('inputrevisi');
    Route::post('/prosesinsentif', 'InsentifController@prosesinsentif')->name('prosesinsentif');
    Route::get('/inputtripinsentif', 'InsentifController@inputtripinsentif')->name('inputtripinsentif');


    Route::get('/inputtripinsentifjasa', 'InsentifController@inputtripinsentifjasa')->name('inputtripinsentifjasa');


    Route::get('/labarugi', 'LabarugiController@labarugi')->name('labarugi');
    Route::post('/labarugi', 'LabarugiController@labarugis')->name('labarugi');
    Route::post('/proseslabarugi', 'LabarugiController@proseslabarugi')->name('proseslabarugi');
    Route::get('/pendingkwitansi/{id}', 'LabarugiController@pendingkwitansi')->name('pendingkwitansi');

    Route::get('/dataomset', 'OmsetController@dataomset')->name('dataomset');
    Route::post('/dataomset', 'OmsetController@dataomsets')->name('dataomset');

    Route::get('/pengadaanbarangjkt', 'InvestasiControllerJakarta@pengadaanbarangjakarta')->name('pengadaanbarangjakarta');
    Route::get('/inputpengadaanbarangjkt', 'InvestasiControllerJakarta@inputpengadaanbarang')->name('inputpengadaanbarangjkt');
    Route::post('/simpanpengadaanjakarta', 'InvestasiControllerJakarta@simpanpengadaanjakarta')->name('simpanpengadaan');
    Route::get('/updateinvesjkt/{id}/{estimasi}', 'InvestasiControllerJakarta@updateinves')->name('surat.read');
    Route::get('/deleteinvesjkt/{id}', 'InvestasiControllerJakarta@deleteinves')->name('surat.read');
    Route::get('/deleteinvestjkt/{id}', 'InvestasiControllerJakarta@deleteinvest')->name('surat.read');
    Route::get('/simpaninvesjkt/{id}', 'InvestasiControllerJakarta@simpaninves')->name('surat.read');
    Route::get('/datapengadaanbarangjkt', 'InvestasiControllerJakarta@datapengadaanbarang')->name('datapengadaanbarangjkt');
    Route::post('/datapengadaanbarangjkt', 'InvestasiControllerJakarta@datapengadaanbarangs')->name('datapengadaanbarangjkt');
    Route::get('/prosesinvesjkt/{id}/{status}', 'InvestasiControllerJakarta@prosesinves')->name('surat.read');

    Route::get('/inputinvestor', 'HumanController@inputinvestor')->name('inputinvestor');
    Route::post('/inputinvestoract', 'HumanController@inputinvestoract')->name('suplayer.create');
    Route::get('/datainvestor', 'HumanController@datainvestor')->name('datainvestor');
    Route::get('/editInvestor/{id}', 'HumanController@editInvestor')->name('suplayer.update');
    Route::post('/updateinvestor', 'HumanController@updateinvestor')->name('suplayer.update');
    Route::get('/deleteInvestor/{id}', 'HumanController@deleteInvestor')->name('suplayer.delete');
    Route::get('/investorpengembang', 'HumanController@investorpengembang')->name('investorpengembang');
    Route::post('/simpansebagaipengembang', 'HumanController@simpansebagaipengembang')->name('simpansebagaipengembang');

    Route::get('/lockinvestasi', 'LockController@lockinvestasi')->name('lockinvestasi');
    Route::get('/cektransaksipending/{id}', 'LockController@cektransaksipending')->name('cektransaksipending');
    Route::post('/simpanlock', 'LockController@simpanlock')->name('simpanlock');
    Route::get('/unlock/{id}', 'LockController@unlock')->name('unlock');
    Route::get('/lock/{id}', 'LockController@lock')->name('lock');
    Route::get('/deletelock/{id}', 'LockController@deletelock')->name('deletelock');
    Route::get('/verifikasi_lock_investasi/{id}', 'LockController@verifikasi_lock_investasi')->name('verifikasi_lock_investasi');

    Route::get('/lockinvestasinonbagi', 'LockController@lockinvestasinonbagi')->name('lockinvestasinonbagi');
    Route::post('/simpanlock2', 'LockController@simpanlock2')->name('simpanlock');
    Route::get('/unlock2/{id}', 'LockController@unlock2')->name('unlock2');
    Route::get('/deletelock2/{id}', 'LockController@deletelock2')->name('deletelock2');

    Route::get('/cetakrinciantrip/{id}', 'TripController@cetakrinciantrip')->name('cetakrinciantrip');
    Route::get('/tripengiriman', 'TripController@tripengiriman')->name('tripengiriman');
    Route::get('/tripengirimanjasa', 'TripController@tripengirimanjasa')->name('tripengirimanjasa');
    Route::post('/trippost', 'TripController@trippost')->name('suplayer.update');
    Route::get('/tripsurat/{id}', 'TripController@tripsurat')->name('suplayer.delete');

    Route::get('/tripsurat/{id}', 'TripController@tripsurat')->name('suplayer.delete');

    Route::get('/tripkwitansi/{id}', 'TripController@tripkwitansi')->name('suplayer.delete');
    Route::get('/daftartrip', 'TripController@daftartrip')->name('daftartrip');
    Route::post('/daftartrip', 'TripController@daftartrips')->name('suplayer.update');

    Route::get('/daftartripjasa', 'TripController@daftartripjasa')->name('daftartripjasa');
    Route::post('/daftartripjasa', 'TripController@daftartripjasas')->name('suplayer.update');

    Route::get('/daftarpendingtrip', 'TripController@daftarpendingtrip')->name('daftarpendingtrip');
    Route::get('/daftarpendingtripjasa', 'TripController@daftarpendingtripjasa')->name('daftarpendingtrip');
    Route::post('/caritrip', 'TripController@caritrip')->name('suplayer.update');
    Route::get('/detailTrip/{id}', 'TripController@detailTrip')->name('suplayer.delete');
    Route::get('/perhitunganinsentif', 'TripController@perhitunganinsentif')->name('perhitunganinsentif');
    Route::post('/perhitunganinsentif', 'TripController@actperhitunganinsentif')->name('suplayer.update');
    Route::get('/insentifsimpansession/{a}/{b}/{c}/{d}/{e}/{f}/{g}', 'TripController@insentifsimpansession')->name('insentifsimpansession');
    Route::get('/insentifsimpansessionjasa/{a}/{b}/{c}/{d}/{e}/{f}', 'TripController@insentifsimpansessionjasa')->name('insentifsimpansession');

    Route::get('/perhitunganinsentifjasa', 'TripController@perhitunganinsentifjasa')->name('perhitunganinsentifjasa');
    Route::post('/perhitunganinsentifjasa', 'TripController@actperhitunganinsentifjasa')->name('suplayer.update');

    Route::get('/searchkwitansi/{key}', 'TripController@searchkwitansi')->name('searchkwitansi');
    Route::get('/searchkwitansijasa/{key}', 'TripController@searchkwitansijasa')->name('searchkwitansi');
    Route::get('/searchkwitansireturn/{key}', 'ReturnController@searchkwitansireturn')->name('searchkwitansireturn');

    //Route::get('/cetakinsentifpenjualan/{id_trips}/{no_trips}/{tanggal_inputs}/{kategoris}/{id_gudangs}', 'TripController@printperhitunganinsentif')->name('suplayer.update');
    Route::get('/cetakinsentifpenjualan/{id_trips}/{no_trips}/{tanggal_inputs}/{kategoris}/{id_gudangs}/{operasional_kiriman}', 'TripController@printperhitunganinsentif')->name('suplayer.update');
    Route::get('/cetakinsentifpenjualanjasa/{no_trips}', 'TripController@printperhitunganinsentifjasa')->name('suplayer.update');


    Route::get('/inputkatalog', 'KatalogController@inputkatalog')->name('inputkatalog');
    Route::post('/uploadkatalog', 'KatalogController@uploadkatalog')->name('uploadkatalog');
    Route::post('/uploadkatalogmultiple', 'KatalogController@uploadkatalogmultiple')->name('uploadkatalogmultiple');
    Route::get('/datakatalog', 'KatalogController@datakatalog')->name('datakatalog');
    Route::get('/detailKatalog/{id}', 'KatalogController@detailKatalog')->name('detailKatalog');
    Route::get('/detailImage/{id}', 'KatalogController@detailImage')->name('detailImage');
    Route::get('/deleteGambarProduk/{id}', 'KatalogController@deleteGambarProduk')->name('deleteGambarProduk');
    Route::post('/updatekatalog', 'KatalogController@updatekatalog')->name('updatekatalog');
    Route::post('/updatekatalogmultiple', 'KatalogController@updatekatalogmultiple')->name('updatekatalogmultiple');
    Route::get('/katalog', 'KatalogController@katalog')->name('katalogproduk');
    Route::post('/katalog', 'KatalogController@katalogs')->name('katalogproduk');
    Route::get('/produk/{id}', 'KatalogController@produk')->name('produk');
    Route::get('/setkey/{id}', 'KatalogController@setkey')->name('setkey');
    Route::get('/getDetailProduk/{id}', 'KatalogController@getDetailProduk')->name('produk');
    Route::get('/editkatalogproduk/{id}', 'KatalogController@editkatalogproduk')->name('produk');

    Route::get('/changekategori/{id}', 'KatalogController@changekategori')->name('changekategori');


    Route::get('/brand', 'PengaturanCatalog@brand')->name('brand');
    Route::post('/addbrand', 'PengaturanCatalog@addbrand')->name('addbrand');
    Route::get('/editBrand/{id}', 'PengaturanCatalog@editBrand')->name('brand');
    Route::post('/updatebrand', 'PengaturanCatalog@updatebrand')->name('updatebrand');
    Route::get('/deleteBrand/{id}', 'PengaturanCatalog@deleteBrand')->name('deleteBrand');
    Route::get('/caribrand/{id}', 'PengaturanCatalog@caribrand')->name('caribrand');
    Route::get('/carikategori/{id}/{mainkat}', 'PengaturanCatalog@carikategori')->name('carikategori');
    Route::get('/carikategorijasa/{id}/{mainkat}', 'PengaturanCatalog@carikategorijasa')->name('carikategorijasa');
    Route::get('/carimainkategori/{id}', 'PengaturanCatalog@carimainkategori')->name('carimainkategori');


    Route::get('/caridetailkaryawan/{id}', 'HumanController@caridetailkaryawan')->name('caridetailkaryawan');


    Route::get('/color', 'PengaturanCatalog@color')->name('color');
    Route::post('/addcolor', 'PengaturanCatalog@addcolor')->name('addcolor');
    Route::get('/editColor/{id}', 'PengaturanCatalog@editColor')->name('color');
    Route::post('/updatecolor', 'PengaturanCatalog@updatecolor')->name('updatecolor');
    Route::get('/deleteColor/{id}', 'PengaturanCatalog@deleteColor')->name('deleteColor');

    Route::get('/kategorikatalog', 'PengaturanCatalog@kategorikatalog')->name('kategorikatalog');
    Route::get('/kategoriproduk', 'PengaturanCatalog@kategoriproduk')->name('kategoriproduk');
    Route::post('/addkategorikatalog', 'PengaturanCatalog@addkategorikatalog')->name('addkategorikatalog');
    Route::post('/addkategoriproduk', 'PengaturanCatalog@addkategoriproduk')->name('addkategoriproduk');
    Route::get('/editkategorikatalog/{id}', 'PengaturanCatalog@editkategorikatalog')->name('editkategorikatalog');
    Route::get('/editkategoriproduk/{id}', 'PengaturanCatalog@editkategoriproduk')->name('editkategoriproduk');
    Route::post('/updatekategorikatalog', 'PengaturanCatalog@updatekategorikatalog')->name('updatekategorikatalog');
    Route::post('/updatekategoriproduk', 'PengaturanCatalog@updatekategoriproduk')->name('updatekategoriproduk');
    Route::get('/deletekategorikatalog/{id}', 'PengaturanCatalog@deletekategorikatalog')->name('deletekategorikatalog');
    Route::get('/deletekategoriproduk/{id}', 'PengaturanCatalog@deletekategoriproduk')->name('deletekategoriproduk');

    Route::get('/label', 'PengaturanCatalog@label')->name('color');
    Route::post('/addlabel', 'PengaturanCatalog@addlabel')->name('addlabel');
    Route::get('/editlabel/{id}', 'PengaturanCatalog@editlabel')->name('editlabel');
    Route::post('/updatelabel', 'PengaturanCatalog@updatelabel')->name('updatelabel');
    Route::get('/deletelabel/{id}', 'PengaturanCatalog@deletelabel')->name('deletelabel');


    Route::get('/targethpp', 'TargetController@targethpp')->name('targethpp');
    Route::get('/targeting/{id}', 'TargetController@targeting')->name('targethpp');
    Route::post('/simpantambahantarget', 'TargetController@simpantambahantarget')->name('dataomset');


    Route::get('/daftarolshop', 'OlshopController@daftarolshop')->name('daftarolshop');
    Route::get('/prosesorderolshop/{id}', 'OlshopController@prosesorderolshop')->name('prosesorderolshop');
    Route::get('/inputresi', 'OlshopController@inputresi')->name('inputresi');
    Route::get('/daftarpengiriman', 'OlshopController@daftarpengiriman')->name('daftarpengiriman');
    Route::get('/penjualanselesai', 'OlshopController@penjualanselesai')->name('penjualanselesai');
    Route::post('/simpan_kurir', 'OlshopController@simpan_kurir')->name('simpan_kurir');
    Route::get('/lacak_kurir/{id}', 'OlshopController@lacak_kurir')->name('lacak_kurir');

    Route::get('/danapengambangan', 'InsentifController@danapengambangan')->name('danapengambangan');
    Route::post('/prosespengembangan', 'InsentifController@prosespengembangan')->name('prosespengembangan');
    Route::get('/ceksaldopengembang/{id}', 'InsentifController@ceksaldopengembang')->name('ceksaldopengembang');

    Route::get('/getkabupaten/{id}', 'HumanController@getkabupaten')->name('getkabupaten');
    Route::get('/getkecamatan/{id}', 'HumanController@getkecamatan')->name('getkecamatan');
    Route::get('/getkabupatens/{id}', 'HumanController@getkabupatens')->name('getkabupaten');
    Route::get('/getkecamatans/{id}', 'HumanController@getkecamatans')->name('getkecamatan');

    Route::get('/kasir', 'KasirController@kasir')->name('kasir');
    Route::get('/getBarangKasir/{id}', 'KasirController@getBarangKasir')->name('getBarangKasir');
    Route::get('/cekretail/{id}', 'KasirController@cekretail')->name('cekretail');
    Route::post('/postkasir', 'KasirController@postkasir')->name('postkasir');
    Route::post('/postkasirdetail', 'KasirController@postkasirdetail')->name('postkasirdetail');
    Route::get('/endsession', 'KasirController@endsession')->name('endsession');
    Route::post('/endsession', 'KasirController@endsessions')->name('endsession');
    Route::get('/endsessionjasa', 'KasirController@endsessionjasa')->name('endsessionjasa');
    Route::post('/endsessionjasa', 'KasirController@endsessionjasas')->name('endsessionjasa');
    Route::get('/detailOrderJasa/{id}', 'KasirController@detailOrderJasa')->name('detailOrderJasa');
    Route::get('/prosesendsession/{id}', 'KasirController@prosesendsession')->name('prosesendsession');
    Route::get('/prosesendsessionjasa/{id}', 'KasirController@prosesendsessionjasa')->name('prosesendsessionjasa');

    Route::get('/caribarangbykode/{id}', 'KasirController@caribarangbykode')->name('kasir');
    Route::get('/edt', 'PengaturanController@edt')->name('edt');
    Route::post('/saveaplikasi', 'PengaturanController@saveaplikasi')->name('saveaplikasi');
    Route::get('/printbytrip/{id}', 'KasirController@printbytrip')->name('printbytrip');

    Route::get('/fee', 'PengaturanController@fee')->name('fee');
    Route::post('/savepersenfee', 'PengaturanController@savepersenfee')->name('savepersenfee');
    Route::get('/feesales', 'PengaturanController@feesales')->name('feesales');
    Route::post('/savepersenfee1', 'PengaturanController@savepersenfee1')->name('savepersenfee1');
    Route::get('/feejasa', 'PengaturanController@feejasa')->name('feejasa');
    Route::post('/savepersenfee2', 'PengaturanController@savepersenfee2')->name('savepersenfee2');
    Route::get('/bagihasilinvestor', 'PengaturanController@bagihasilinvestor')->name('bagihasilinvestor');
    Route::post('/saveperseninvest', 'PengaturanController@saveperseninvest')->name('saveperseninvest');

    Route::get('/cetaknota/{id}', 'KasirController@cetaknota')->name('edt');
    Route::get('/cekstok/{gudang}/{id}', 'KasirController@cekstok')->name('cekstok');
    Route::get('/downloadbarcode/{id}', 'KasirController@downloadbarcode')->name('downloadbarcode');

    Route::get('/cetaklabel/{id}', 'PengaturanController@cetaklabel')->name('Dikirim');

    Route::post('/edit_kategori_penjualan', 'TripController@edit_kategori_penjualan')->name('edit_kategori_penjualan');


    Route::get('/datapoin', 'PoinController@datapoin')->name('edt');
    Route::get('/uppoin/{id}', 'PoinController@uppoin')->name('edt');
    Route::post('/prosespoin', 'PoinController@prosespoin')->name('edt');
    Route::get('/createkode', 'PoinController@createkode')->name('edt');
    Route::get('/hadiah', 'PoinController@hadiah')->name('edt');
    Route::post('/simpan_hadiah', 'PoinController@simpan_hadiah')->name('edt');
    Route::post('/updatehadiah', 'PoinController@updatehadiah')->name('edt');
    Route::get('/hapushadiah/{id}', 'PoinController@hapushadiah')->name('edt');
    Route::get('/penukaranpoin', 'PoinController@penukaranpoin')->name('edt');
    Route::get('/verifikasihadiah/{id}', 'PoinController@verifikasihadiah')->name('edt');
    Route::get('/batalhadiah/{id}', 'PoinController@batalhadiah')->name('edt');


    Route::get('/inputjasabaru', 'JasaController@inputjasabaru')->name('inputjasabaru');
    Route::get('/datalayananjasa', 'JasaController@datalayananjasa')->name('datalayananjasa');
    Route::post('/simpanjasa', 'JasaController@simpanjasa')->name('simpanjasa');
    Route::post('/updatejasa', 'JasaController@updatejasa')->name('updatejasa');
    Route::get('/deletejasa/{id}', 'JasaController@deletejasa')->name('deletejasa');
    Route::get('/kasirjasa', 'JasaController@kasirjasa')->name('kasirjasa');
    Route::post('/postorderjasa', 'JasaController@postorderjasa')->name('postorderjasa');
    Route::get('/cetaknotajasa/{id}', 'JasaController@cetaknotajasa')->name('cetaknotajasa');
    Route::get('/datapenjualanjasa', 'JasaController@datapenjualanjasa')->name('datapenjualanjasa');
    Route::post('/datapenjualanjasa', 'JasaController@datapenjualanjasas')->name('datapenjualanjasa');
    Route::get('/getHumans', 'JasaController@getHumans')->name('penjualan.create');
    Route::get('/detailJasaKonsumen/{id}', 'JasaController@detailJasaKonsumen')->name('detailJasaKonsumen');

    Route::post('/trippostjasa', 'TripController@trippostjasa')->name('suplayer.update');

    Route::get('/inputpromo', 'PromoController@inputpromo')->name('inputpromo');
    Route::post('/insertpromo', 'PromoController@insertpromo')->name('insertpromo');
    Route::get('/datapromo', 'PromoController@datapromo')->name('datapromo');
    Route::get('/getdetailpromo/{id}', 'PromoController@getdetailpromo')->name('getdetailpromo');
    Route::post('/simpanpromo', 'PromoController@simpanpromo')->name('simpanpromo');
    Route::get('/deletepromo/{id}', 'PromoController@deletepromo')->name('deletepromo');
    Route::get('/cekpotonganperusahaan/{id}', 'PromoController@cekpotonganperusahaan')->name('cekpotonganperusahaan');
    Route::get('/joinpengiriman', 'PromoController@joinpengiriman')->name('joinpengiriman');
    Route::get('/searchtriptujuan/{id}', 'PromoController@searchtriptujuan')->name('searchtriptujuan');
    Route::get('/gabungkantrip/{tujuan}/{target}', 'PromoController@gabungkantrip')->name('gabungkantrip');
    Route::get('/searchdetailtrip/{id}', 'PromoController@searchdetailtrip')->name('searchdetailtrip');

    Route::get('/inputvoucher', 'PromoController@inputvoucher')->name('inputvoucher');
    Route::post('/insertvoucher', 'PromoController@insertvoucher')->name('insertvoucher');
    Route::get('/datavoucher', 'PromoController@datavoucher')->name('datavoucher');
    Route::get('/getdetailvoucher/{id}', 'PromoController@getdetailvoucher')->name('getdetailvoucher');
    Route::post('/simpanvoucher', 'PromoController@simpanvoucher')->name('simpanvoucher');
    Route::get('/deletevoucher/{id}', 'PromoController@deletevoucher')->name('deletevoucher');

    Route::get('/kasditangan', 'KasController@kasditangan')->name('kasditangan');
    Route::post('/proseskasditangan', 'KasController@proseskasditangan')->name('proseskasditangan');
    Route::post('/kasditangan', 'KasController@kasditangans')->name('kasditangan');
    Route::get('/kasdibank', 'KasController@kasdibank')->name('kasdibank');
    Route::post('/proseskasdibank', 'KasController@proseskasdibank')->name('proseskasdibank');
    Route::post('/kasdibank', 'KasController@kasdibanks')->name('kasdibank');

    Route::post('/simpanpengadaanbaru', 'InvestasiController@simpanpengadaanbaru')->name('simpanpengadaanbaru');
    Route::get('/deletepengadaanbarangbaru/{id}', 'InvestasiController@deletepengadaanbarangbaru')->name('deletepengadaanbarangbaru');
    Route::get('/deleteinvestbaru/{id}', 'InvestasiController@deleteinvestbaru')->name('deleteinvestbaru');

    Route::get('/pengajuanakun', 'AkunController@pengajuanakun')->name('pengajuanakun');
    Route::get('/approvepengajuan/{id}/{level}', 'AkunController@approvepengajuan')->name('approvepengajuan');
    Route::get('/cancelpengajuan/{id}/{level}', 'AkunController@cancelpengajuan')->name('cancelpengajuan');

    Route::get('/tomemberonline', 'AkunController@tomemberonline')->name('tomemberonline');
    Route::post('/simpantomember', 'AkunController@simpantomember')->name('simpantomember');
    Route::get('/tomemberonlinekaryawan', 'AkunController@tomemberonlinekaryawan')->name('tomemberonlinekaryawan');
    Route::post('/simpantomemberkaryawan', 'AkunController@simpantomemberkaryawan')->name('simpantomemberkaryawan');
    Route::get('/cekemailava/{email}', 'AkunController@cekemailava')->name('cekemailava');

    Route::get('/getagenreseller/{id}', 'AkunController@getagenreseller')->name('getagenreseller');


    //Payroll
    Route::get('/input_absensi_karyawan', 'GenController@input_absensi_karyawan')->name('input_absensi_karyawan');
    Route::post('/tambah_absensi', 'GenController@tambah_absensi')->name('tambah_absensi');
    Route::get('/daftar_absensi_karyawan', 'GenController@daftar_absensi_karyawan')->name('daftar_absensi_karyawan');
    Route::post('/daftar_absensi_karyawan', 'GenController@daftar_absensi_karyawans')->name('daftar_absensi_karyawans');
    Route::get('/cekabsen/{tanggal}/{id_karyawan}', 'GenController@cekabsen')->name('cekabsen');

    Route::get('/daftar_nama_devisi', 'GenController@daftar_nama_devisi')->name('daftar_nama_devisi');
    Route::post('/tambah_nama_divisi', 'GenController@tambah_nama_divisi')->name('input_nama_divisi');
    Route::post('/simpan_divisi', 'GenController@simpan_divisi')->name('simpan_divisi');
    Route::get('/delete_divisi/{id}', 'GenController@delete_divisi')->name('delete_divisi');

    Route::get('/input_nama_pekerja', 'GenController@input_nama_pekerja')->name('input_nama_pekerja');
    Route::post('/tambah_nama_pekerjaan', 'GenController@tambah_nama_pekerjaan')->name('tambah_nama_pekerjaan');
    Route::get('/daftar_nama_pekerja', 'GenController@daftar_nama_pekerja')->name('daftar_nama_pekerja');
    Route::post('/simpan_pekerjaan', 'GenController@simpan_pekerjaan')->name('simpan_pekerjaan');
    Route::get('/delete_pekerjaan/{id}', 'GenController@delete_pekerjaan')->name('delete_pekerjaan');

    Route::get('/input_user_admin', 'GenController@input_user_admin')->name('input_user_admin');
    Route::post('/tambah_user_admin', 'GenController@tambah_user_admin')->name('tambah_user_admin');
    Route::get('/daftar_user_admin', 'GenController@daftar_user_admin')->name('daftar_user_admin');
    Route::post('/simpan_data_admin', 'GenController@simpan_data_admin')->name('simpan_data_admin');
    Route::get('/reset_admin/{id}', 'GenController@reset_admin')->name('reset_admin');
    Route::get('/delete_admin/{id}', 'GenController@delete_admin')->name('delete_admin');

    Route::get('/input_satuan_barang', 'GenController@input_satuan_barang')->name('input_satuan_barang');
    Route::post('/tambah_satuan_barang', 'GenController@tambah_satuan_barang')->name('tambah_satuan_barang');
    Route::get('/daftar_satuan_barang', 'GenController@daftar_satuan_barang')->name('daftar_satuan_barang');
    Route::post('/simpan_satuan_barang', 'GenController@simpan_satuan_barang')->name('simpan_satuan_barang');
    Route::get('/delete_satuan_barang/{id}', 'GenController@delete_satuan_barang')->name('delete_satuan_barang');

    Route::get('/input_per_kategori_kerja', 'GenController@input_per_kategori_kerja')->name('input_per_kategori_kerja');
    Route::post('/tambah_upah_kategori_kerja', 'GenController@tambah_upah_kategori_kerja')->name('tambah_upah_kategori_kerja');
    Route::get('/daftar_per_kategori_kerja', 'GenController@daftar_per_kategori_kerja')->name('daftar_per_kategori_kerja');
    Route::post('/simpan_upah_kategori_kerja', 'GenController@simpan_upah_kategori_kerja')->name('simpan_upah_kategori_kerja');
    Route::get('/delete_upah_kategori_kerja/{id}', 'GenController@delete_upah_kategori_kerja')->name('delete_upah_kategori_kerja');

    Route::get('/input_ketentuan_absensi', 'GenController@input_ketentuan_absensi')->name('input_ketentuan_absensi');
    Route::post('/tambah_ketentuan_absen', 'GenController@tambah_ketentuan_absen')->name('tambah_ketentuan_absen');
    Route::get('/daftar_ketentuan_absensi', 'GenController@daftar_ketentuan_absensi')->name('daftar_ketentuan_absensi');
    Route::post('/update_ketentuan_absen', 'GenController@update_ketentuan_absen')->name('update_ketentuan_absen');
    Route::get('/cekinsentifkinerja/{id}', 'GenController@cekinsentifkinerja')->name('cekinsentifkinerja');


    Route::get('/input_kinerja_karyawan', 'GenController@input_kinerja_karyawan')->name('input_kinerja_karyawan');
    Route::post('/postkinerjakaryawan', 'GenController@postkinerjakaryawan')->name('postkinerjakaryawan');
    Route::get('/data_penilaian_kinerja', 'GenController@data_penilaian_kinerja')->name('data_penilaian_kinerja');
    Route::post('/data_penilaian_kinerja', 'GenController@data_penilaian_kinerjas')->name('data_penilaian_kinerjas');
    Route::get('/edit_kinerja_karyawan/{no}/{bul}/{tah}', 'GenController@edit_kinerja_karyawan')->name('edit_kinerja_karyawan');
    Route::post('/savekinerjakaryawan', 'GenController@savekinerjakaryawan')->name('savekinerjakaryawan');
    Route::get('/delete_penilaian_kinerja/{id}', 'GenController@delete_penilaian_kinerja')->name('delete_penilaian_kinerja');


    Route::get('/input_perhitungan_upah', 'GenController@input_perhitungan_upah')->name('input_perhitungan_upah');
    Route::get('/getkinerja/{mulai}/{sampai}/{karyawan}', 'GenController@getkinerja')->name('input_perhitungan_upah');
    Route::post('/postperhitunganupah', 'GenController@postperhitunganupah')->name('postperhitunganupah');
    Route::get('/data_perhitungan_upah', 'GenController@data_perhitungan_upah')->name('data_perhitungan_upah');
    Route::post('/data_perhitungan_upah', 'GenController@data_perhitungan_upahs')->name('data_perhitungan_upah');


    Route::get('/buat_slip_gaji', 'GenController@buat_slip_gaji')->name('buat_slip_gaji');
    Route::get('/cekgaji/{urut}/{bl}/{th}', 'GenController@cekgaji')->name('buat_slip_gaji');
    Route::get('/cekabsensi/{id}/{mulai}/{selesai}', 'GenController@cekabsensi')->name('cekabsensi');
    Route::post('/postslipgaji', 'GenController@postslipgaji')->name('postslipgaji');
    Route::get('/cetakslipgaji/{no}', 'GenController@cetakslipgaji')->name('cetakslipgaji');
    Route::get('/data_slip_gaji', 'GenController@data_slip_gaji')->name('data_slip_gaji');
    Route::post('/data_slip_gaji', 'GenController@data_slip_gajis')->name('data_slip_gaji');
    Route::post('/postupdatedata', 'GenController@postupdatedata')->name('postupdatedata');

    Route::post('/getupahpekerjaan', 'GenController@getupahpekerjaan')->name('getupahpekerjaan');





    ////////////////////////////////////////// Where House System All Route ///////////////////////////////////////////

    Route::group(['prefix' => 'wherehouse'], function () {
        Route::get('/client', [ClientController::class, 'client'])->name('client');
        Route::get('/location', [ClientController::class, 'location'])->name('location');
        Route::get('/courier-detail', [ClientController::class, 'courier'])->name('courier');
        // Product
        Route::get('/all-product', [ProductController::class, 'allProduct'])->name('all.product');
        Route::get('/product/{product_code}/detail', [ProductController::class, 'ProductDetail'])->name('product.detail');
        Route::post('/product-stock', [ProductController::class, 'productStock'])->name('product.stock');


        // Puchase
        Route::get('/all-purchase', [PurcahseController::class, 'allPurchase'])->name('all.purchase');

        // Order
        Route::get('/all-order', [OrderController::class, 'allOrder'])->name('all.order');
        Route::get('/detail-order', [OrderController::class, 'detailOrder'])->name('detail_order');

        // Reporting
        Route::get('/all-reporting', [ReportingController::class, 'allReporting'])->name('all.reporting');
    });
});
