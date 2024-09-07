@extends('template/master')
@section('main-content')
    <style>
        .badges {
            position: absolute;
            left: -15px;
            padding: 1px 10px;
            border-radius: 50%;
            background: red;
            color: white;
        }

        .badges2 {
            right: 10px;
            position: absolute;
            padding: 5px 15px;
            border-radius: 50%;
            background: red;
            color: white;
        }
    </style>

    <body>

        @if ($message = Session::get('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
            <?php
            echo '<script>';
            echo "
                                                                                                                                                                                                                    setTimeout(function() {
                                                                                                                                                                                                                    Swal.fire({
                                                                                                                                                                                                                    type: 'success',
                                                                                                                                                                                                                    title: 'Berhasil',
                                                                                                                                                                                                                    showConfirmButton: false,
                                                                                                                                                                                                                    timer: 1500
                                                                                                                                                                                                                    }, function() {
                                                                                                                                                                                                                        window.location = '';
                                                                                                                                                                                                                    });
                                                                                                                                                                                                                    }, 1000);
                                                                                                                                                                                                                    ";
            echo '</script>';
            ?>
        @elseif ($message = Session::get('error'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
            <?php
            echo '<script>';
            echo "
                                                                                                                                                                                                                    setTimeout(function() {
                                                                                                                                                                                                                    Swal.fire({
                                                                                                                                                                                                                    type: 'error',
                                                                                                                                                                                                                    title: 'Gagal,
                                                                                                                                                                                                                    showConfirmButton: false,
                                                                                                                                                                                                                    timer: 1500
                                                                                                                                                                                                                    }, function() {
                                                                                                                                                                                                                        window.location = '';
                                                                                                                                                                                                                    });
                                                                                                                                                                                                                    }, 1000);
                                                                                                                                                                                                                    ";
            echo '</script>';
            ?>
        @endif

        @if ($errors->any())
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
            <?php
            echo '<script>';
            echo "
                                                                                                                                                                                                                    setTimeout(function() {
                                                                                                                                                                                                                    Swal.fire({
                                                                                                                                                                                                                    type: 'error',
                                                                                                                                                                                                                    title: 'Gagal!',
                                                                                                                                                                                                                    showConfirmButton: false,
                                                                                                                                                                                                                    timer: 1500
                                                                                                                                                                                                                    }, function() {
                                                                                                                                                                                                                        window.location = '';
                                                                                                                                                                                                                    });
                                                                                                                                                                                                                    }, 1000);
                                                                                                                                                                                                                    ";
            echo '</script>';
            ?>
        @endif

        <?php
        reloadpromo();
        prosespengadaaninvestasi();
        ?>

        <style>
            #editmodal {
                overflow-y: scroll;
            }
        </style>

        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

            <header class="topbar" data-navbarbg="skin6">
                <nav class="navbar top-navbar navbar-expand-md">
                    <div class="navbar-header" data-logobg="skin6">
                        <!-- This is for the sidebar toggle which is visible on mobile only -->
                        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close"></i></a>
                        <!-- ============================================================== -->
                        <!-- Logo -->
                        <!-- ============================================================== -->
                        <div class="navbar-brand">
                            <center><a href="<?= aplikasi()[0]->toko ?>"><img src="<?php echo asset('gambar/' . aplikasi()[0]->icon); ?>" width="210"
                                        alt="homepage" /></a></center>
                        </div>
                        <!-- ============================================================== -->
                        <!-- End Logo -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Toggle which is visible on mobile only -->
                        <!-- ============================================================== -->
                        <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                            data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="ti-more"></i></a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <!-- ============================================================== -->
                        <!-- toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav float-left mr-auto ml-3 pl-1">

                        </ul>
                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav float-right">
                            <!-- ============================================================== -->
                            <!-- Search -->
                            <!-- ============================================================== -->
                            <li class="nav-item d-none d-md-block">
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo asset('system/profile-pic.jpg'); ?>" alt="user" class="rounded-circle" width="40">
                                    <span class="ml-2 d-lg-inline-block"><span>
                                            <script type="text/javascript">
                                                //<![CDATA[
                                                var h = (new Date()).getHours();
                                                var m = (new Date()).getMinutes();
                                                var s = (new Date()).getSeconds();
                                                if (h >= 4 && h < 10) document.writeln("Selamat pagi,");
                                                if (h >= 10 && h < 15) document.writeln("Selamat siang,");
                                                if (h >= 15 && h < 18) document.writeln("Selamat sore,");
                                                if (h >= 18 || h < 4) document.writeln("Selamat malam,");
                                                //]]>
                                            </script>
                                        </span> <span class="text-dark">{{ Auth::user()->username }}</span> <i
                                            data-feather="chevron-down" class="svg-icon"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                    <?php if (Auth::user()->level == "6"){ ?>
                                    <b class="dropdown-item"><i data-feather="dollar-sign" class="svg-icon mr-2 ml-1"></i>
                                        Saldo Investasi<br>&emsp;&emsp;<a
                                            href="{{ url('datatransaksi') }}"><?php echo 'Rp ' . ribuan(saldo()) . ',-'; ?></a></b>
                                    <div class="dropdown-divider"></div>

                                    <?php if (cekpengembanginvestor() > 0): ?>
                                    <b class="dropdown-item"><i data-feather="dollar-sign" class="svg-icon mr-2 ml-1"></i>
                                        Saldo Insentif<br>&emsp;&emsp;<a
                                            href="{{ url('datainsentif') }}"><?php echo 'Rp ' . ribuan(saldokaryawan()) . ',-'; ?></a></b>
                                    <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <?php }else{ ?>
                                    <b class="dropdown-item"><i data-feather="dollar-sign" class="svg-icon mr-2 ml-1"></i>
                                        Saldo Investasi<br>&emsp;&emsp;<a
                                            href="{{ url('datatransaksi') }}"><?php echo 'Rp ' . ribuan(saldo()) . ',-'; ?></a></b>
                                    <div class="dropdown-divider"></div>

                                    <b class="dropdown-item"><i data-feather="dollar-sign" class="svg-icon mr-2 ml-1"></i>
                                        <?php if (cekmyid_karyawan() == '22') { ?>
                                        Saldo Insentif<br>&emsp;&emsp;<a
                                            href="{{ url('datainsentif') }}"><?php echo 'Rp ' . ribuan(saldomas()) . ',-'; ?></a></b>
                                    <?php }else{ ?>
                                    Saldo Insentif<br>&emsp;&emsp;<a
                                        href="{{ url('datainsentif') }}"><?php echo 'Rp ' . ribuan(saldokaryawan()) . ',-'; ?></a></b>
                                    <?php } ?>
                                    <div class="dropdown-divider"></div>
                                    <?php } ?>

                                    <a class="dropdown-item" href="{{ url('profile') }}"><i data-feather="user"
                                            class="svg-icon mr-2 ml-1"></i>
                                        Ganti Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" aria-expanded="false"
                                        onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                        <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    </div>
                </nav>
            </header>
            <?php if (Auth::user()->level == "1"): ?>
            <aside class="left-sidebar text-dark" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/') }}"
                                    aria-expanded="false"><i data-feather="bar-chart-2" class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="shopping-bag" class="feather-icon"></i>
                                    <span class="hide-menu">Where House Manage</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="database" class="feather-icon"></i>
                                            <span class="hide-menu">Master</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ route('all.product') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Product </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="arrow-right" class="feather-icon"></i>
                                            <span class="hide-menu">Inbound</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ route('all.purchase') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Purchase
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="package" class="feather-icon"></i>
                                            <span class="hide-menu">Inventory</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ route('location') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Location
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="arrow-left" class="feather-icon"></i>
                                            <span class="hide-menu">Outbound</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ route('all.order') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Order
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="star" class="feather-icon"></i>
                                            <span class="hide-menu">Special</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ route('all.reporting') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Reporting
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="tag" class="feather-icon"></i>
                                    <span class="hide-menu">Pemasaran</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">


                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('/kasir') }}" aria-expanded="false"><i
                                                data-feather="shopping-bag" class="feather-icon"></i>
                                            <span class="hide-menu">POS Kasir Toko</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('inputorderbaru') }}" aria-expanded="false"><i
                                                data-feather="shopping-cart" class="feather-icon"></i>
                                            <span class="hide-menu">Sales Taking Order</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('katalog') }}" aria-expanded="false"><i data-feather="image"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Katalog Produk</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i>
                                            <span class="hide-menu">Pricelist</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pricelist') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Harga </span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('priceupdate') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Update Harga </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="percent" class="feather-icon"></i>
                                            <span class="hide-menu">Promo Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputpromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Buat Periode Promo
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Promo </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="scissors" class="feather-icon"></i>
                                            <span class="hide-menu">Voucher Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputvoucher') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Buat Kode Voucher
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datavoucher') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Voucher </span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="award" class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if (cek_penukaranhadiah() > 0): ?>
                                                <span class="badges2">{{ cek_penukaranhadiah() }}</span>
                                                <?php endif; ?>
                                                Poin Hadiah</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Riwayat Poin</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('hadiah') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Hadiah</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('penukaranpoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Tukar Poin
                                                        <?php if (cek_penukaranhadiah() > 0): ?>
                                                        <span class="badges">{{ cek_penukaranhadiah() }}</span>
                                                        <?php endif; ?>
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                                    <span class="hide-menu">Gudang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="grid" class="feather-icon"></i>
                                            <span class="hide-menu">Barang Masuk</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('barangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputbarangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="package" class="feather-icon"></i>
                                            <span class="hide-menu">Stok Gudang Barang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('stokgudang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Stok Barang
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('historybarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> History Data Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="send" class="feather-icon"></i>
                                            <span class="hide-menu">Transfer Stok</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputorderstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Order Stok
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarorderstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Order Stok
                                                    </span></a></li>
                                            <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                                    href="javascript:void(0)" aria-expanded="false"><span
                                                        class="hide-menu">Proses Transfer Stok</span></a>
                                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('pengiriman') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Pengiriman</span></a>
                                                    </li>
                                                    <li class="sidebar-item"><a href="{{ url('penerimaan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Penerimaan</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datatransferstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Transfer Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="external-link"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Reject Stok</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputriject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Reject</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datareject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Reject</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="chrome" class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if ((jumlahorderanonlineshop()+jumlahinputresi()) > 0): ?>
                                                <span
                                                    class="badges2">{{ jumlahorderanonlineshop() + jumlahinputresi() }}</span>
                                                <?php endif; ?>
                                                Orderan Webstore
                                            </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarolshop') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahorderanonlineshop() > 0): ?>
                                                        <span class="badges">{{ jumlahorderanonlineshop() }}</span>
                                                        <?php endif; ?>
                                                        Order Pending</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('daftarpengiriman') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Proses</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('inputresi') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahinputresi() > 0): ?>
                                                        <span class="badges">{{ jumlahinputresi() }}</span>
                                                        <?php endif; ?>
                                                        Input Resi Pengiriman</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('penjualanselesai') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Terkirim</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="printer" class="feather-icon"></i>
                                            <span class="hide-menu">Orderan Gudang</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">


                                            <li class="sidebar-item"><a href="{{ url('daftarorderbaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Order Masuk</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('dikirim') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Proses Dikirim<br>(Buat Nota)</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="truck" class="feather-icon"></i>
                                            <span class="hide-menu">Trip Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtrip') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Trip</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tripengiriman') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Pengelompokan Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('perhitunganinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu">Cek Perhitungan Trip
                                                        Kiriman</span></a></li>

                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="user-check" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('terkirim') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Proses Terkirim</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('dataorderpenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Barang Keluar</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="repeat" class="feather-icon"></i>
                                            <span class="hide-menu">Retur Penjualan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputreturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Retur</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datareturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Retur</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="check-circle"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Validasi Stok Kembali</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('verifikasipenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Batal</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('validretur') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Retur</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('verifikasipengembalian') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Transfer Batal</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('daftariject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Stok Reject</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="umbrella" class="feather-icon"></i>
                                            <span class="hide-menu">Inventaris</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data
                                                        Inventaris</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputinventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Input
                                                        Inventaris</span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="star" class="feather-icon"></i>
                                    <span class="hide-menu">Layanan Jasa</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('kasirjasa') }}" aria-expanded="false"><i
                                                data-feather="shopping-bag" class="feather-icon"></i>
                                            <span class="hide-menu">POS Kasir Jasa</span></a>
                                    </li>

                                    <li hidden class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Service</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('bookingservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Booking
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarservicemasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu">Dafar Service
                                                        <br>Masuk</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesservices') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Service</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('daftarprosesservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Daftar Proses
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Final
                                                        <br>Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Final
                                                        <br>Service</span></a></li>
                                            <hr>
                                            <li class="sidebar-item"><a href="{{ url('dataservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Service</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="coffee" class="feather-icon"></i>
                                            <span class="hide-menu">Layanan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('datalayananjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Layanan Jasa</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputjasabaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Tambah Layanan Jasa</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('kategorijasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Kategori Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false"><i data-feather="link-2" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Laporan</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tripengirimanjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Pengelompokan Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('perhitunganinsentifjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Cek Perhitungan Lap.
                                                        Jasa</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('datapenjualanjasa') }}" aria-expanded="false"><i
                                                data-feather="activity" class="feather-icon"></i>
                                            <span class="hide-menu">Data Penjualan Jasa</span></a></a>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i>
                                    <span class="hide-menu">Keuangan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('kasditangan') }}"
                                            class="sidebar-link"><span class="hide-menu">Kas di Tangan</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('kasdibank') }}" class="sidebar-link"><span
                                                class="hide-menu">Kas di Bank</span></a></li>

                                    <li class="sidebar-item"><a href="{{ url('daftarpembayaranmanual') }}"
                                            class="sidebar-link">
                                            <span class="hide-menu">
                                                <?php if (jumlahmanualpayment() > 0): ?>
                                                <span class="badges">{{ jumlahmanualpayment() }}</span>
                                                <?php endif; ?>
                                                Konfirmasi Pembayaran</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">Laporan Harian / Trip</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputtripinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Simpan Trip
                                                        Kiriman</span></a></li>
                                            <hr>
                                            <li class="sidebar-item"><a href="{{ url('daftartripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputtripinsentifjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Simpan Lap.
                                                        Jasa</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if (cek_insentif('Pengambilan Insentif') > 0 || cek_insentifmas('Pengambilan Insentif') > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_insentif('Pengambilan Insentif') + cek_insentifmas('Pengambilan Insentif') }}</span>
                                                <?php endif; ?>
                                                Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Insentif</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Penarikan Insentif
                                                        <?php if (cek_insentif('Pengambilan Insentif') > 0 || cek_insentifmas('Pengambilan Insentif') > 0): ?>
                                                        <span
                                                            class="badges">{{ cek_insentif('Pengambilan Insentif') + cek_insentifmas('Pengambilan Insentif') }}</span>
                                                        <?php endif; ?>
                                                    </span></a></li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">Hutang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarhutang') }}"
                                                    class="sidebar-link"><span class="hide-menu">Daftar Hutang</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('prosespembayaranhutang') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Bayar</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Piutang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualan') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                    <li class="sidebar-item"><a href="{{ url('prosespembayaran') }}"
                                                            class="sidebar-link"><span class="hide-menu">Proses
                                                                Bayar</span></a></li>
                                                </ul>
                                            </li>

                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Layanan Jasa</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualanjasa') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                    <li class="sidebar-item"><a href="{{ url('prosespembayaranjasa') }}"
                                                            class="sidebar-link"><span class="hide-menu">Proses
                                                                Bayar</span></a></li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Data Pembayaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapembayaran') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datapembayaranjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Layanan Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if ((cek_notif('in')+cek_notif('out')+cek_bagi_lock()) > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_notif('in') + cek_notif('out') + cek_bagi_lock() }}</span>
                                                <?php endif; ?>
                                                Investasi</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <!--li class="sidebar-item"><a href="{{ url('inputtransaksi') }}" class="sidebar-link"><span class="hide-menu"> Input Investasi </span></a></li-->
                                            <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_notif('in') > 0): ?>
                                                        <span class="badges">{{ cek_notif('in') }}</span>
                                                        <?php endif; ?>
                                                        Deposit Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_bagi_lock() > 0): ?>
                                                        <span class="badges">{{ cek_bagi_lock() }}</span>
                                                        <?php endif; ?>
                                                        Lock Investasi</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_notif('out') > 0): ?>
                                                        <span class="badges">{{ cek_notif('out') }}</span>
                                                        <?php endif; ?>
                                                        Penarikan Investasi</span></a></li>

                                            <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Transaksi</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                <?php endif; ?>
                                                Projek Pengadaan <br>Barang</span></a>

                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputpengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Posting
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                        <span
                                                            class="badges">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                        <?php endif; ?>
                                                        Data Transaksi Projek </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('dataomset') }}"
                                            class="sidebar-link"><span class="hide-menu">Data Omset</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('labarugi') }}" class="sidebar-link"><span
                                                class="hide-menu">Data Laba Rugi</span></a></li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i data-feather="users" class="feather-icon"></i>
                                    <span class="hide-menu">SDM</span></a>
                                <ul aria-expanded="false" class="collapse first-level base-level-line">

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Karyawan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Karyawan</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Karyawan</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('tomemberonlinekaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Buat Akun <br>Member</span></a>
                                            </li>
                                            <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                                    href="javascript:void(0)" aria-expanded="false"><span
                                                        class="hide-menu">Absensi</span></a>
                                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                                    <li class="sidebar-item"><a
                                                            href="{{ url('input_absensi_karyawan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Input Absensi</span></a>
                                                    </li>

                                                    <li class="sidebar-item"><a
                                                            href="{{ url('daftar_absensi_karyawan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Daftar Absensi</span></a>
                                                    </li>

                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Member</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('tomemberonline') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Buat Akun <br>Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('pengajuanakun') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Pengajuan <br>Naik Level</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li hidden class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Investor</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainvestor') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Investor</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputinvestor') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Investor</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Supplier Barang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datasuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Supplier</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputsuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Supplier</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}" class="sidebar-link"><span
                                                class="hide-menu">Profil Saya</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('user') }}" class="sidebar-link"><span
                                                class="hide-menu">User Admin</span></a></li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Master Barang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputbarangbaru') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Nama Barang
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('databarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Edit Data
                                                        Barang</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('gudang') }}" class="sidebar-link"><span
                                                class="hide-menu">Cabang / Gudang</span></a></li>
                                    <!--li class="sidebar-item"><a href="{{ url('previllagegudang') }}" class="sidebar-link"><span class="hide-menu">Kategori Gudang</span></a></li-->
                                    <li class="sidebar-item"><a href="{{ url('manager') }}" class="sidebar-link"><span
                                                class="hide-menu">Pembagian Area</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('jabatan') }}" class="sidebar-link"><span
                                                class="hide-menu">Jabatan Karyawan</span></a>
                                    </li>
                                    <li hidden class="sidebar-item"><a href="{{ url('kategori') }}"
                                            class="sidebar-link"><span class="hide-menu">Kategori Member</span></a></li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)"
                                            aria-expanded="false"><span class="hide-menu">Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('fee') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Membership<br>Network </span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('feesales') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Sales Marketing</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('feejasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Layanan Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"><a href="{{ url('bagihasilinvestor') }}"
                                            class="sidebar-link"><span class="hide-menu">Bagi Hasil Investor</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('inputkatalog') }}"
                                            class="sidebar-link"><span class="hide-menu">Katalog Produk</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('edt') }}"
                                            class="sidebar-link"><span class="hide-menu">Web Store</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('pengiriman_khusus') }}"
                                            class="sidebar-link"><span class="hide-menu">Pengiriman Lokal
                                                Area</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('rekening') }}"
                                            class="sidebar-link"><span class="hide-menu">Akun Bank Perusahaan</span></a>
                                    </li>

                                    <li class="sidebar-item"><a href="{{ url('backup') }}"
                                            class="sidebar-link"><span class="hide-menu">Backup Database</span></a></li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            <?php if (Auth::user()->level == "2"): ?>
            <aside class="left-sidebar" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="{{ url('/') }}" aria-expanded="false"><i data-feather="bar-chart-2"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="tag" class="feather-icon"></i>
                                    <span class="hide-menu">Pemasaran</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">


                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('/kasir') }}" aria-expanded="false"><i
                                                data-feather="shopping-bag" class="feather-icon"></i>
                                            <span class="hide-menu">POS Kasir Toko</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('inputorderbaru') }}" aria-expanded="false"><i
                                                data-feather="shopping-cart" class="feather-icon"></i>
                                            <span class="hide-menu">Sales Taking Order</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('katalog') }}" aria-expanded="false"><i
                                                data-feather="image" class="feather-icon"></i>
                                            <span class="hide-menu">Katalog Produk</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="file-text" class="feather-icon"></i>
                                            <span class="hide-menu">Pricelist</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pricelist') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Harga
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="percent"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Promo Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Promo </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="scissors"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Voucher Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datavoucher') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Voucher
                                                    </span></a></li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="award"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                Poin Hadiah</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Riwayat
                                                        Poin</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('hadiah') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar
                                                        Hadiah</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('penukaranpoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Tukar Poin </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                                    <span class="hide-menu">Gudang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="grid"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Barang Masuk</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('barangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="package"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Stok Gudang Barang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('stokgudang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Stok Barang
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <?php if ( Auth::user()->level == "2" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="chrome"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                Orderan Webstore
                                            </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarolshop') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahorderanonlineshop() > 0): ?>
                                                        <span class="badges">{{ jumlahorderanonlineshop() }}</span>
                                                        <?php endif; ?>
                                                        Order Pending</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('daftarpengiriman') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Proses</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('penjualanselesai') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Terkirim</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="printer"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Orderan Gudang</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarorderbaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Order Masuk</span></a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="truck"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Trip Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtrip') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Trip</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>

                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="user-check" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('dataorderpenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Barang Keluar</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Retur Penjualan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datareturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Retur</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="star" class="feather-icon"></i>
                                    <span class="hide-menu">Layanan Jasa</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li hidden class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Service</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('bookingservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Booking
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarservicemasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu">Dafar Service
                                                        <br>Masuk</span></a></li>
                                            <hr>
                                            <li class="sidebar-item"><a href="{{ url('dataservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Service</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="coffee"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Layanan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('datalayananjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Layanan Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="link-2"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Laporan</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Lap.
                                                        Jasa</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('datapenjualanjasa') }}" aria-expanded="false"><i
                                                data-feather="activity" class="feather-icon"></i>
                                            <span class="hide-menu">Data Penjualan Jasa</span></a></a>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i>
                                    <span class="hide-menu">Keuangan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Insentif</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Penarikan Insentif
                                                    </span></a></li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Piutang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualan') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Data Pembayaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapembayaran') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Investasi</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <!--li class="sidebar-item"><a href="{{ url('inputtransaksi') }}" class="sidebar-link"><span class="hide-menu"> Input Investasi </span></a></li-->
                                            <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Deposit Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Investasi</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Penarikan Investasi</span></a></li>

                                            <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Transaksi</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Projek Pengadaan <br>Barang</span></a>

                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Data Transaksi Projek </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i data-feather="users" class="feather-icon"></i>
                                    <span class="hide-menu">SDM</span></a>
                                <ul aria-expanded="false" class="collapse first-level base-level-line">

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Karyawan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Karyawan</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Member</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Member</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}"
                                            class="sidebar-link"><span class="hide-menu">Profil Saya</span></a></li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            <?php if (Auth::user()->level == "3"): ?>
            <aside class="left-sidebar" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="{{ url('/') }}" aria-expanded="false"><i data-feather="bar-chart-2"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="tag" class="feather-icon"></i>
                                    <span class="hide-menu">Pemasaran</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">


                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('/kasir') }}" aria-expanded="false"><i
                                                data-feather="shopping-bag" class="feather-icon"></i>
                                            <span class="hide-menu">POS Kasir Toko</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('inputorderbaru') }}" aria-expanded="false"><i
                                                data-feather="shopping-cart" class="feather-icon"></i>
                                            <span class="hide-menu">Sales Taking Order</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('katalog') }}" aria-expanded="false"><i
                                                data-feather="image" class="feather-icon"></i>
                                            <span class="hide-menu">Katalog Produk</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="file-text" class="feather-icon"></i>
                                            <span class="hide-menu">Pricelist</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pricelist') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Harga
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="percent"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Promo Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Promo </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="scissors"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Voucher Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datavoucher') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Voucher
                                                    </span></a></li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="award"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if (cek_penukaranhadiah() > 0): ?>
                                                <span class="badges2">{{ cek_penukaranhadiah() }}</span>
                                                <?php endif; ?>
                                                Poin Hadiah</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Riwayat
                                                        Poin</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('hadiah') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar
                                                        Hadiah</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('penukaranpoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Tukar Poin
                                                        <?php if (cek_penukaranhadiah() > 0): ?>
                                                        <span class="badges">{{ cek_penukaranhadiah() }}</span>
                                                        <?php endif; ?>
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                                    <span class="hide-menu">Gudang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="grid"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Barang Masuk</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('barangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                            <?php if ( Auth::user()->gudang == "1"): ?>
                                            <li class="sidebar-item"><a href="{{ url('inputbarangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="package"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Stok Gudang Barang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('stokgudang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Stok Barang
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('historybarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> History Data Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="send"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Transfer Stok</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputorderstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Order Stok
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarorderstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Order Stok
                                                    </span></a></li>
                                            <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                                    href="javascript:void(0)" aria-expanded="false"><span
                                                        class="hide-menu">Proses Transfer Stok</span></a>
                                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('pengiriman') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Pengiriman</span></a>
                                                    </li>
                                                    <li class="sidebar-item"><a href="{{ url('penerimaan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Penerimaan</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datatransferstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Transfer Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="external-link" class="feather-icon"></i>
                                            <span class="hide-menu">Reject Stok</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputriject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Reject</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datareject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Reject</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php if ( Auth::user()->level == "3" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="chrome"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if ((jumlahorderanonlineshop()+jumlahinputresi()) > 0): ?>
                                                <span
                                                    class="badges2">{{ jumlahorderanonlineshop() + jumlahinputresi() }}</span>
                                                <?php endif; ?>
                                                Orderan Webstore
                                            </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarolshop') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahorderanonlineshop() > 0): ?>
                                                        <span class="badges">{{ jumlahorderanonlineshop() }}</span>
                                                        <?php endif; ?>
                                                        Order Pending</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('daftarpengiriman') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Proses</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('inputresi') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahinputresi() > 0): ?>
                                                        <span class="badges">{{ jumlahinputresi() }}</span>
                                                        <?php endif; ?>
                                                        Input Resi Pengiriman</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('penjualanselesai') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Terkirim</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="printer"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Orderan Gudang</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">


                                            <li class="sidebar-item"><a href="{{ url('daftarorderbaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Order Masuk</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('dikirim') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Proses Dikirim<br>(Buat Nota)</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="truck"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Trip Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtrip') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Trip</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tripengiriman') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Pengelompokan Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>

                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="user-check" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('terkirim') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Proses Terkirim</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('dataorderpenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Barang Keluar</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Retur Penjualan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputreturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Retur</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datareturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Retur</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="check-circle" class="feather-icon"></i>
                                            <span class="hide-menu">Validasi Stok Kembali</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('verifikasipenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Batal</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('validretur') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Retur</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('verifikasipengembalian') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Transfer Batal</span></a>
                                            </li>
                                            <?php if (Auth::user()->gudang == "1"): ?>
                                            <li class="sidebar-item"><a href="{{ url('daftariject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Stok Reject</span></a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="umbrella"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Inventaris</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data
                                                        Inventaris</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputinventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Input
                                                        Inventaris</span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="star" class="feather-icon"></i>
                                    <span class="hide-menu">Layanan Jasa</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('kasirjasa') }}" aria-expanded="false"><i
                                                data-feather="shopping-bag" class="feather-icon"></i>
                                            <span class="hide-menu">POS Kasir Jasa</span></a>
                                    </li>

                                    <li hidden class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Service</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('bookingservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Booking
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarservicemasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu">Dafar Service
                                                        <br>Masuk</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesservices') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarprosesservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Daftar Proses
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Final
                                                        <br>Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Final
                                                        <br>Service</span></a></li>
                                            <hr>
                                            <li class="sidebar-item"><a href="{{ url('dataservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Service</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="coffee"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Layanan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('datalayananjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Layanan Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="link-2"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Laporan</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tripengirimanjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Pengelompokan Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Lap.
                                                        Jasa</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('datapenjualanjasa') }}" aria-expanded="false"><i
                                                data-feather="activity" class="feather-icon"></i>
                                            <span class="hide-menu">Data Penjualan Jasa</span></a></a>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i>
                                    <span class="hide-menu">Keuangan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Insentif</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Penarikan Insentif
                                                    </span></a></li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Piutang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualan') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Data Pembayaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapembayaran') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Investasi</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <!--li class="sidebar-item"><a href="{{ url('inputtransaksi') }}" class="sidebar-link"><span class="hide-menu"> Input Investasi </span></a></li-->
                                            <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Deposit Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Investasi</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Penarikan Investasi</span></a></li>

                                            <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Transaksi</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Projek Pengadaan <br>Barang</span></a>

                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Data Transaksi Projek </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i data-feather="users" class="feather-icon"></i>
                                    <span class="hide-menu">SDM</span></a>
                                <ul aria-expanded="false" class="collapse first-level base-level-line">

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Karyawan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Karyawan</span></a>
                                            </li>
                                            <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                                    href="javascript:void(0)" aria-expanded="false"><span
                                                        class="hide-menu">Absensi</span></a>
                                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                                    <li class="sidebar-item"><a
                                                            href="{{ url('daftar_absensi_karyawan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Daftar Absensi</span></a>
                                                    </li>

                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Member</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Member</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <?php if ( Auth::user()->level == "3" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Supplier Barang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datasuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Supplier</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputsuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Supplier</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}"
                                            class="sidebar-link"><span class="hide-menu">Profil Saya</span></a></li>
                                    <?php if ( Auth::user()->level == "3" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Master Barang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('inputbarangbaru') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Input Nama Barang
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('databarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Edit Data
                                                        Barang</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('inputkatalog') }}"
                                            class="sidebar-link"><span class="hide-menu">Katalog Produk</span></a></li>
                                    <?php }?>

                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            <?php if (Auth::user()->level == "4"): ?>
            <aside class="left-sidebar" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="{{ url('/') }}" aria-expanded="false"><i data-feather="bar-chart-2"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="tag" class="feather-icon"></i>
                                    <span class="hide-menu">Pemasaran</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('inputorderbaru') }}" aria-expanded="false"><i
                                                data-feather="shopping-cart" class="feather-icon"></i>
                                            <span class="hide-menu">Sales Taking Order</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('katalog') }}" aria-expanded="false"><i
                                                data-feather="image" class="feather-icon"></i>
                                            <span class="hide-menu">Katalog Produk</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="file-text" class="feather-icon"></i>
                                            <span class="hide-menu">Pricelist</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pricelist') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Harga
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="percent"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Promo Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Promo </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="scissors"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Voucher Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datavoucher') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Voucher
                                                    </span></a></li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="award"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if (cek_penukaranhadiah() > 0): ?>
                                                <span class="badges2">{{ cek_penukaranhadiah() }}</span>
                                                <?php endif; ?>
                                                Poin Hadiah</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Riwayat
                                                        Poin</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('hadiah') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar
                                                        Hadiah</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('penukaranpoin') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Tukar Poin
                                                        <?php if (cek_penukaranhadiah() > 0): ?>
                                                        <span class="badges">{{ cek_penukaranhadiah() }}</span>
                                                        <?php endif; ?>
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                                    <span class="hide-menu">Gudang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="grid"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Barang Masuk</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('barangmasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Barang
                                                        Masuk<br>dari Pembelian </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="package"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Stok Gudang Barang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('stokgudang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Stok Barang
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('historybarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> History Data Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="send"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Transfer Stok</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarorderstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Order Stok
                                                    </span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datatransferstok') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Transfer Stok
                                                    </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="external-link" class="feather-icon"></i>
                                            <span class="hide-menu">Reject Stok</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datareject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Reject</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="chrome"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">
                                                <?php if ((jumlahorderanonlineshop()+jumlahinputresi()) > 0): ?>
                                                <span
                                                    class="badges2">{{ jumlahorderanonlineshop() + jumlahinputresi() }}</span>
                                                <?php endif; ?>
                                                Orderan Webstore
                                            </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarolshop') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">
                                                        <?php if (jumlahorderanonlineshop() > 0): ?>
                                                        <span class="badges">{{ jumlahorderanonlineshop() }}</span>
                                                        <?php endif; ?>
                                                        Order Pending</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('daftarpengiriman') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Proses</span></a>
                                            </li>

                                            <li class="sidebar-item"><a href="{{ url('penjualanselesai') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Order Terkirim</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="printer"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Orderan Gudang</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">


                                            <li class="sidebar-item"><a href="{{ url('daftarorderbaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Order Masuk</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="truck"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Trip Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtrip') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Trip</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('perhitunganinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu">Cek Perhitungan Trip
                                                        Kiriman</span></a></li>

                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="user-check" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('dataorderpenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Barang Keluar</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Retur Penjualan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datareturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Retur</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="check-circle" class="feather-icon"></i>
                                            <span class="hide-menu">Validasi Stok Kembali</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftariject') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Stok Reject</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="umbrella"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Inventaris</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data
                                                        Inventaris</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputinventaris') }}"
                                                    class="sidebar-link"><span class="hide-menu">Input
                                                        Inventaris</span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="star" class="feather-icon"></i>
                                    <span class="hide-menu">Layanan Jasa</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li hidden class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Service</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('bookingservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Booking
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarservicemasuk') }}"
                                                    class="sidebar-link"><span class="hide-menu">Dafar Service
                                                        <br>Masuk</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesservices') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarprosesservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Daftar Proses
                                                        Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosesfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Final
                                                        <br>Service</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftarfinalservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Final
                                                        <br>Service</span></a></li>
                                            <hr>
                                            <li class="sidebar-item"><a href="{{ url('dataservice') }}"
                                                    class="sidebar-link"><span class="hide-menu">Data Service</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="coffee"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Layanan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datalayananjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Layanan Jasa</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="link-2"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Jasa</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarpendingtripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Nota Belum
                                                        Laporan</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tripengirimanjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Pengelompokan Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('daftartripjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Lap.
                                                        Jasa</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('perhitunganinsentifjasa') }}"
                                                    class="sidebar-link"><span class="hide-menu">Cek Perhitungan Lap.
                                                        Jasa</span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('datapenjualanjasa') }}" aria-expanded="false"><i
                                                data-feather="activity" class="feather-icon"></i>
                                            <span class="hide-menu">Data Penjualan Jasa</span></a></a>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i>
                                    <span class="hide-menu">Keuangan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('kasditangan') }}"
                                            class="sidebar-link"><span class="hide-menu">Kas di Tangan</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('kasdibank') }}"
                                            class="sidebar-link"><span class="hide-menu">Kas di Bank</span></a></li>
                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"><a href="{{ url('daftarpembayaranmanual') }}"
                                            class="sidebar-link">
                                            <span class="hide-menu">
                                                <?php if (jumlahmanualpayment() > 0): ?>
                                                <span class="badges">{{ jumlahmanualpayment() }}</span>
                                                <?php endif; ?>
                                                Konfirmasi Pembayaran</span></a>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">Laporan Harian / Trip</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftartrip') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Trip
                                                        Kiriman</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('inputtripinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Simpan Trip
                                                        Kiriman</span></a></li>

                                        </ul>
                                    </li>
                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if (cek_insentif('Pengambilan Insentif') > 0 || cek_insentifmas('Pengambilan Insentif') > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_insentif('Pengambilan Insentif') + cek_insentifmas('Pengambilan Insentif') }}</span>
                                                <?php endif; ?>
                                                Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Insentif</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Penarikan Insentif
                                                        <?php if (cek_insentif('Pengambilan Insentif') > 0 || cek_insentifmas('Pengambilan Insentif') > 0): ?>
                                                        <span
                                                            class="badges">{{ cek_insentif('Pengambilan Insentif') + cek_insentifmas('Pengambilan Insentif') }}</span>
                                                        <?php endif; ?>
                                                    </span></a></li>

                                        </ul>
                                    </li>
                                    <?php }?>
                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">Hutang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('daftarhutang') }}"
                                                    class="sidebar-link"><span class="hide-menu">Daftar
                                                        Hutang</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('prosespembayaranhutang') }}"
                                                    class="sidebar-link"><span class="hide-menu">Proses Bayar</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Piutang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualan') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                    <li class="sidebar-item"><a href="{{ url('prosespembayaran') }}"
                                                            class="sidebar-link"><span class="hide-menu">Proses
                                                                Bayar</span></a></li>
                                                </ul>
                                            </li>

                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Layanan Jasa</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a
                                                            href="{{ url('daftarpenjualanjasa') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                    <li class="sidebar-item"><a
                                                            href="{{ url('prosespembayaranjasa') }}"
                                                            class="sidebar-link"><span class="hide-menu">Proses
                                                                Bayar</span></a></li>

                                                </ul>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Data Pembayaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapembayaran') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('datapembayaranjasa') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Layanan Jasa</span></a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if ((cek_notif('in')+cek_notif('out')+cek_bagi_lock()) > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_notif('in') + cek_notif('out') + cek_bagi_lock() }}</span>
                                                <?php endif; ?>
                                                Investasi</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <!--li class="sidebar-item"><a href="{{ url('inputtransaksi') }}" class="sidebar-link"><span class="hide-menu"> Input Investasi </span></a></li-->
                                            <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_notif('in') > 0): ?>
                                                        <span class="badges">{{ cek_notif('in') }}</span>
                                                        <?php endif; ?>
                                                        Deposit Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_bagi_lock() > 0): ?>
                                                        <span class="badges">{{ cek_bagi_lock() }}</span>
                                                        <?php endif; ?>
                                                        Lock Investasi</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if (cek_notif('out') > 0): ?>
                                                        <span class="badges">{{ cek_notif('out') }}</span>
                                                        <?php endif; ?>
                                                        Penarikan Investasi</span></a></li>

                                            <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Transaksi</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                <?php endif; ?>
                                                Projek Pengadaan <br>Barang</span></a>

                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                            <li class="sidebar-item"><a href="{{ url('inputpengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Posting
                                                        Projek</span></a></li>
                                            <?php }?>
                                            <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                        <span
                                                            class="badges">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                        <?php endif; ?>
                                                        Data Transaksi Projek </span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('dataomset') }}"
                                            class="sidebar-link"><span class="hide-menu">Data Omset</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('labarugi') }}"
                                            class="sidebar-link"><span class="hide-menu">Data Laba Rugi</span></a></li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i data-feather="users" class="feather-icon"></i>
                                    <span class="hide-menu">SDM</span></a>
                                <ul aria-expanded="false" class="collapse first-level base-level-line">

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Karyawan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Karyawan</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Karyawan</span></a>
                                            </li>
                                            <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                            <li class="sidebar-item"><a href="{{ url('tomemberonlinekaryawan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Buat Akun <br>Member</span></a>
                                            </li>
                                            <?php }?>
                                            <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                                    href="javascript:void(0)" aria-expanded="false"><span
                                                        class="hide-menu">Absensi</span></a>
                                                <ul aria-expanded="false" class="collapse second-level base-level-line">
                                                    <li class="sidebar-item"><a
                                                            href="{{ url('input_absensi_karyawan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Input Absensi</span></a>
                                                    </li>

                                                    <li class="sidebar-item"><a
                                                            href="{{ url('daftar_absensi_karyawan') }}"
                                                            class="sidebar-link">
                                                            <span class="hide-menu">Daftar Absensi</span></a>
                                                    </li>

                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Member</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Member</span></a>
                                            </li>
                                            <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                            <li class="sidebar-item"><a href="{{ url('tomemberonline') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Buat Akun <br>Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('pengajuanakun') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Pengajuan <br>Naik Level</span></a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </li>

                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li hidden class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Investor</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainvestor') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Investor</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputinvestor') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Investor</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php }?>
                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Supplier Barang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datasuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Supplier</span></a>
                                            </li>
                                            <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                            <li class="sidebar-item"><a href="{{ url('inputsuplayer') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Supplier</span></a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </li>


                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}"
                                            class="sidebar-link"><span class="hide-menu">Profil Saya</span></a></li>
                                    <?php if ( Auth::user()->level == "4" && Auth::user()->gudang == "1"){ ?>
                                    <li class="sidebar-item"><a href="{{ url('jabatan') }}"
                                            class="sidebar-link"><span class="hide-menu">Jabatan Karyawan</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('rekening') }}"
                                            class="sidebar-link"><span class="hide-menu">Akun Bank Perusahaan</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('backup') }}"
                                            class="sidebar-link"><span class="hide-menu">Backup Database</span></a></li>
                                    <?php }?>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            <?php if (Auth::user()->level == "5"): ?>
            <aside class="left-sidebar" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="{{ url('/') }}" aria-expanded="false"><i data-feather="bar-chart-2"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="tag" class="feather-icon"></i>
                                    <span class="hide-menu">Pemasaran</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('inputorderbaru') }}" aria-expanded="false"><i
                                                data-feather="shopping-cart" class="feather-icon"></i>
                                            <span class="hide-menu">Sales Taking Order</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                            href="{{ url('katalog') }}" aria-expanded="false"><i
                                                data-feather="image" class="feather-icon"></i>
                                            <span class="hide-menu">Katalog Produk</span></a>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="file-text" class="feather-icon"></i>
                                            <span class="hide-menu">Pricelist</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pricelist') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar Harga
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="percent"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Promo Diskon</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapromo') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Promo </span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="award"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">

                                                Poin Hadiah</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('hadiah') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Daftar
                                                        Hadiah</span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                                    <span class="hide-menu">Gudang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="package"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Stok Gudang Barang</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('stokgudang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data Stok Barang
                                                    </span></a></li>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="printer"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Orderan Gudang</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">

                                            <li class="sidebar-item"><a href="{{ url('daftarorderbaru') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Daftar Order Masuk</span></a>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                                data-feather="user-check" class="feather-icon"></i>
                                            <span class="hide-menu">Laporan Kiriman</span></a>
                                        <ul aria-expanded="false" class="collapse first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('dataorderpenjualan') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Barang Keluar</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false"><i data-feather="repeat"
                                                class="feather-icon"></i>
                                            <span class="hide-menu">Retur Penjualan</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datareturn') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Retur</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i>
                                    <span class="hide-menu">Keuangan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Insentif Pemasaran</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Insentif</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Penarikan Insentif
                                                    </span></a></li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Piutang</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                                    href="javascript:void(0)" aria-expanded="false">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                                    <li class="sidebar-item"><a href="{{ url('daftarpenjualan') }}"
                                                            class="sidebar-link"><span class="hide-menu">Daftar
                                                                Piutang</span></a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Data Pembayaran</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datapembayaran') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Penjualan Produk</span></a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                Investasi</span></a>
                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <!--li class="sidebar-item"><a href="{{ url('inputtransaksi') }}" class="sidebar-link"><span class="hide-menu"> Input Investasi </span></a></li-->
                                            <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Deposit Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Saldo</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Lock Investasi</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        Penarikan Investasi</span></a></li>

                                            <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Data
                                                        Transaksi</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <span class="hide-menu">
                                                <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                <span
                                                    class="badges2">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                <?php endif; ?>
                                                Projek Pengadaan <br>Barang</span></a>

                                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                        Projek</span></a></li>
                                            <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                                    class="sidebar-link"><span class="hide-menu">
                                                        <?php if ((cek_investasi_lokal_pending()+cek_investasi_lokal_selesai()) > 0): ?>
                                                        <span
                                                            class="badges">{{ cek_investasi_lokal_pending() + cek_investasi_lokal_selesai() }}</span>
                                                        <?php endif; ?>
                                                        Data Transaksi Projek </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <i data-feather="users" class="feather-icon"></i>
                                    <span class="hide-menu">SDM</span></a>
                                <ul aria-expanded="false" class="collapse first-level base-level-line">

                                    <li class="sidebar-item"> <a class="has-arrow sidebar-link"
                                            href="javascript:void(0)" aria-expanded="false"><span
                                                class="hide-menu">Member</span></a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                                            <li class="sidebar-item"><a href="{{ url('datakonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Data Member</span></a>
                                            </li>
                                            <li class="sidebar-item"><a href="{{ url('inputkonsumen') }}"
                                                    class="sidebar-link">
                                                    <span class="hide-menu">Input Member</span></a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}"
                                            class="sidebar-link"><span class="hide-menu">Profil Saya</span></a></li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            <?php if (Auth::user()->level == "6"): ?>
            <aside class="left-sidebar" data-sidebarbg="skin6" style="z-index:11">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar" data-sidebarbg="skin6">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="{{ url('/') }}" aria-expanded="false"><i data-feather="bar-chart-2"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Dashboard</span></a>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                    href="<?= aplikasi()[0]->toko ?>" aria-expanded="false"><i data-feather="monitor"
                                        class="feather-icon"></i>
                                    <span class="hide-menu">Web Store</span></a>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="briefcase" class="feather-icon"></i>
                                    <span class="hide-menu">Projek Pengadaan Barang</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('pengadaanbarang') }}"
                                            class="sidebar-link"><span class="hide-menu"> Ambil & Danai
                                                Projek</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('datapengadaanbarang') }}"
                                            class="sidebar-link"><span class="hide-menu"> Data Transaksi Projek
                                            </span></a></li>
                                </ul>
                            </li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="file-plus" class="feather-icon"></i>
                                    <span class="hide-menu">Investasi</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('inputinvestasi') }}"
                                            class="sidebar-link"><span class="hide-menu"> Deposit Saldo</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('lockinvestasinonbagi') }}"
                                            class="sidebar-link"><span class="hide-menu">Lock Saldo</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('lockinvestasi') }}"
                                            class="sidebar-link"><span class="hide-menu">Lock Investasi</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('tariktransaksi') }}"
                                            class="sidebar-link"><span class="hide-menu"> Tarik Investasi</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="{{ url('datatransaksi') }}"
                                            class="sidebar-link"><span class="hide-menu"> Data Transaksi</span></a></li>
                                </ul>
                            </li>

                            <?php if (cekpengembanginvestor() > 0): ?>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="dollar-sign" class="feather-icon"></i>
                                    <span class="hide-menu">Insentif</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('ambilinsentif') }}"
                                            class="sidebar-link"><span class="hide-menu"> Tarik Insentif</span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('datainsentif') }}"
                                            class="sidebar-link"><span class="hide-menu"> Data Insentif</span></a></li>
                                    <!--li class="sidebar-item"><a href="{{ url('danapengambangan') }}" class="sidebar-link"><span class="hide-menu"> Dana Pengembangan</span></a></li-->
                                </ul>
                            </li>
                            <?php endif; ?>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                    aria-expanded="false"><i data-feather="settings" class="feather-icon"></i>
                                    <span class="hide-menu">Pengaturan</span></a>
                                <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item"><a href="{{ url('profile') }}"
                                            class="sidebar-link"><span class="hide-menu">Edit Profil Saya</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                    aria-expanded="false"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    <i data-feather="power" class="feather-icon"></i>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <?php endif; ?>

            @yield('content')
        </div>
    @endsection
