<!DOCTYPE html>
<html dir="ltr" lang="id-ID">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title><?= aplikasi()[0]->nama ?></title>
    <link rel="icon" href="gambar/<?= aplikasi()[0]->favicon ?>" sizes="32x32" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('system/script/css/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('system/script/css/buttons.dataTables.min.css'); ?>">
    <!--link href="<?php echo asset('aset/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"-->
    <!--link href="<?php echo asset('aset/css/simple-sidebar.css'); ?>" rel="stylesheet"-->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/dataTables.buttons.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.flash.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/jszip.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/pdfmake.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/vfs_fonts.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.html5.min.js'); ?>"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset('system/script/js/buttons.print.min.js'); ?>"></script>
    <script src="<?php echo asset('system/autoNumeric.min.js'); ?>"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= aplikasi()[0]->analystics ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '<?= aplikasi()[0]->analystics ?>');
    </script>
    <script type="text/javascript" class="init">
        <?php	if (isset($nama_download)){ ?>
        var namadon = "{{ $nama_download }}";
        <?php }else{ ?>
        var namadon = "belum dinamai";
        <?php } ?>

        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 12) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 15) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#printing').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        pageSize: 'A4',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '17pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');

                            var last = null;
                            var current = null;
                            var bod = [];

                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName(
                                    'head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }

                            head.appendChild(style);

                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 12) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 15) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#dop').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 4) {
                                        var temp = data.split("<p>").join("");
                                        temp = temp.split("</p>").join("");
                                        return temp;
                                    }
                                    if (column === 12) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 15) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 16) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 17) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 18) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 19) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 20) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 21) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    }
                                    if (column === 22) {
                                        return data.split(".").join("");
                                        //return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 7
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#kulakan').DataTable({
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 2) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 1) {
                                        var temp = data.split("                                  ")
                                            .join("");
                                        temp = temp.split("<br>").join("-");
                                        temp = temp.split(
                                                '<button class="btn btn-default" onclick="Load(')
                                            .join("");
                                        temp = temp.split(')">').join("");
                                        temp = temp.split('</button>').join("");
                                        var res = temp.split("'");
                                        if (res.length > 1) {
                                            temp = res[0] + res[2];
                                        }
                                        return temp;
                                    }
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 4) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 12) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 15) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#kulakan2').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ],
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 2) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 1) {
                                        var temp = data.split("                                  ")
                                            .join("");
                                        temp = temp.split("<br>").join("-");
                                        temp = temp.split(
                                                '<button class="btn btn-default" onclick="Load(')
                                            .join("");
                                        temp = temp.split(')">').join("");
                                        temp = temp.split('</button>').join("");
                                        var res = temp.split("'");
                                        if (res.length > 1) {
                                            temp = res[0] + res[2];
                                        }
                                        return temp;
                                    }
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 4) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 12) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");

                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 9
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#insentif').DataTable({
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        columns: [0, 1, 2, 3],
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 2) {
                                        var temp = data.split("<br>").join("\n");
                                        return temp;
                                    }
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#dp').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 4) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 5) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 6) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#dr').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 9) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 10) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 11) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#prc').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 2) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 4) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 5) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 6) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 7) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 8) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 9) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 9
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            /*.prepend(
                            		'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );*/

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {
                        extend: 'excel',
                        title: namadon
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: namadon,
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#printinsentif').DataTable({
                "ordering": false,
                "iDisplayLength": 25,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        pageSize: 'F4',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');

                            var last = null;
                            var current = null;
                            var bod = [];

                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName(
                                    'head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }

                            head.appendChild(style);

                        }
                    },
                    {

                        extend: 'excel',
                        title: namadon,
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 1) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 2) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 3) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 4) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 5) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 6) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 7) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 8) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 9) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 10) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 11) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 12) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 13) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 14) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 15) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 16) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 17) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 18) {
                                        return data.split(".").join("");
                                    }
                                    if (column === 19) {
                                        return data.split(".").join("");
                                    } else {
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
                        customize: function(win) {
                            win.defaultStyle.fontSize = 10
                        }
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#examples').DataTable({});
        });
        $(document).ready(function() {
            $('#examples1').DataTable({});
        });
        $(document).ready(function() {
            $('#examples2').DataTable({});
        });
        $(document).ready(function() {
            $('#examples3').DataTable({
                "ordering": false
            });
        });
        $(document).ready(function() {
            $('#examples4').DataTable({});
        });
        $(document).ready(function() {
            $('#examples5').DataTable({});
        });
        $(document).ready(function() {
            $('#examples6').DataTable({});
        });
    </script>

    <link href="<?php echo asset('system/src/dist/css/style.css?ver=1.8'); ?>" rel="stylesheet">
    <link href="<?php echo asset('system/src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('system/src/highlights/highlight.min.css'); ?>">

    <style>
        .plugin-details {
            display: none;
        }

        .plugin-details-active {
            display: block;
        }

        html {
            zoom: 75%;
        }

        .modal-backdrop {
            width: 100% !important;
            height: 100% !important;
        }

        @media only screen and (max-width:432px) {
            html {
                zoom: 90%;
            }

            .modal-backdrop {
                width: 100% !important;
                height: 100% !important;
            }
        }
    </style>
</head>

@yield('main-content')


<!--script src="<?php echo asset('aset/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script-->
<script src="<?php echo asset('system/src/assets/libs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/app-style-switcher.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/feather.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/sidebarmenu.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/custom.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/highlights/highlight.min.js'); ?>"></script>
<script src="<?php echo asset('system/src/dist/js/pages/datatable/datatable-basic.init.js'); ?>"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
<script>
    <?php if(env("sistem") == "production"){ ?>
    document.addEventListener('contextmenu', (e) => {
        e.preventDefault();
    });
    document.onkeydown = function(e) {
        if (event.keyCode == 123) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
            return false;
        }
    }
    <?php } ?>

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
</body>

</html>
