<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title><?=aplikasi()[0]->nama?></title>
    <meta name="description" content="<?=aplikasi()[0]->deskripsi_index?>" />
    <!-- Scripts -->
    <script src="{{ asset('system/js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="gambar/<?=aplikasi()[0]->favicon?>" sizes="32x32" />
    <!-- Styles -->
    <link href="{{ asset('system/css/app.css') }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
     body {
    width: 100%;height:100vh;
    background: url({{ asset('system/footer-jakarta.webp') }}) center bottom repeat-x #d1ecfb;
    }

    .card{background-color: transparent;}
    .awan{
  width: 100%;
  height: auto;
  background:transparent;
  border-radius: 300px;
  position: relative;
}

  .awan:before,
  .awan:after{
    content: ' ';
    position: absolute;
    background: transparent;
    width: 100%;
    height: auto;
    position: absolute;
    top: 0;
    left: 10px;
    border-radius:300px;
    text-transform: rotate(30deg);
  }

  .awan:after{
    width: 100%;
    height: auto;
    top: 0;
    left: auto;
    right: 15px;
  }


.no1{
  top: 10px;
  -webkit-animation: jalankanawan 25s linear infinite;
  -moz-animation: jalankanawan 25s linear infinite;
  -ms-animation: jalankanawan 25s linear infinite;
  -o-animation: jalankanawan 25s linear infinite;
  animation: jalankanawan 25s linear infinite;
}

.no2{
  left: 100px;
  top: 10px;
  position: absolute;
  -webkit-animation: jalankanawan 35s linear infinite;
  -moz-animation: jalankanawan 35s linear infinite;
  -ms-animation: jalankanawan 35s linear infinite;
  -o-animation: jalankanawan 35s linear infinite;
  animation: jalankanawan 35s linear infinite;
}


@-webkit-keyframes jalankanawan{
  0% { margin-left: 1280px;}
  100%{margin-left: -1280px;}
}
@-moz-keyframes jalankanawan{
  0% { margin-left: 1280px;}
  100%{margin-left: -1280px;}
}
@-o-keyframes jalankanawan{
  0% { margin-left: 1280px;}
  100%{margin-left: -1280px;}
}
    @media (max-width: 900px) {
     body {
    width: 100%;height:100%;
    background: #d1ecfb;
    }
    .card{border: none;}
    .awan{display:none}
    }
    .footer{padding:0;max-width:1200px;margin:0 auto;position:relative;z-index:1;}
    .copyright{color:#eee;margin-top:0px}
    .copyright h5{color:#fff}
    .waarea {
    position: fixed;
    z-index: 601;
    width: 50px;
    height: 50px;
    bottom: 20px;
    right: 20px;
    display: table;
    font-size: 13px;

    }

    .wabutton {
    color: #fff;
    background: #24be5b;
    text-align: center;
    vertical-align: middle;
    display: table-cell;
    border-radius:50px;
    width: 50px;
    height: 50px;
    }
    .copyright a {color:#ffffff}
    @media only screen and (max-width: 450px){
    .footer{padding:0;margin:0 auto;position:relative;z-index:1;}
    .copyright{color:#444;margin-top:0px;}
    .copyright a{color:#444;}
    }
    #whatsapp-chat {
    position: fixed;
    background: #fff;
    width: 350px;
    border-radius: 10px;
    box-shadow: 0 1px 15px rgba(32,33,36,.28);
    bottom: 90px;
    right: 30px;
    overflow: hidden;
    z-index: 10;
    animation-name: showchat;
    animation-duration: 1s;
    transform: scale(1);
}

a.blantershow-chat {
    background: linear-gradient(to right top,#25D366,#128C7E);
    color: #fff;
    position: fixed;
    z-index: 10;
    bottom: 20px;
    right: 20px;
    font-size: 15px;
    padding: 10px;
    border-radius: 50px;
    box-shadow: 0 1px 15px rgba(32,33,36,.28);
    text-decoration: none;
}

a.blantershow-chat i {
    transform: scale(1.2);
    margin: 0 10px 0 0;
}

.header-chat {
    background: linear-gradient(to right top,#25D366,#128C7E);
    color: #fff;
    padding: 20px;
}

.header-chat h3 {
    margin: 0 0 10px;
}

.header-chat p {
    font-size: 14px;
    line-height: 1.7;
    margin: 0;
}

.info-avatar {
    position: relative;
}

.info-avatar img {
    border-radius: 100%;
    width: 50px;
    height: 50px;
    float: left;
    margin: 0 10px 0 0;
}
.info-avatar:before {
    content: '';
    z-index: 10;
    font-family: "Font Awesome 5 Brands";
    background: #23ab23;
    color: #fff;
    padding: 4px 4px;
    border-radius: 100%;
    position: absolute;
    top: 30px;
    right: 30px;
}

a.informasi {
    padding: 20px;
    display: block;
    overflow: hidden;
    animation-name: showhide;
    animation-duration: 2.5s;
    text-decoration: none;
}

a.informasi:hover {
    background: #f1f1f1;
}

.info-chat span {
    display: block;
}


#get-label,span.chat-label {
    font-size: 15px;
    color: #888;
}

#get-nama,span.chat-nama {
    margin: 5px 0 0;
    font-size: 10px;
    font-weight: 500;
    color: #25D366;
}


#get-nama {
    color: #fff;
    font-size: 12px;
    font-weight: 300;
}

#get-label {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
}
#get-avatar {
    float:left;
    width:50px;
    height:50px;
    border:1px solid #eee;
    border-radius:50%;
    margin:5px;
}
#get-avatar img{
    width:49px;
    height:49px;
    border-radius:50%;
}
span.my-number {
    display: none;
}

.blanter-msg {
    color: #444;
    padding: 20px;
    font-size: 12.5px;
    text-align: center;
    border-top: 1px solid #ddd;
}

textarea#chat-input {
    border: none;
    font-family: 'Arial',sans-serif;
    width: 100%;
    height: 30px;
    font-size:15px;
    outline: none;
    resize: none;
}

a#send-it {
    color: #555;
    width: 40px;
    margin: -5px 0 0 5px;
    font-weight: 700;
    padding: 10px;
    background: #eee;
    border-radius: 50%;
}

.first-msg {
    background-image: url("../toko/public/aset/wa/wa-back.jpg");
    padding: 20px;
    text-align: left;
    height:200px;
}

.wabubble1{
    background: #fff;
    position: relative;
    padding: 5px 10px;
    margin-left: 10px;
    margin-bottom: 3px;
    font-size: 14px;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    display: table;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 15%);
    text-decoration: none;
}

.wabubble1:after {
    content: '';
    position: absolute;
    display: block;
    top: 0;
    right: 100%;
    width: 0;
    height: 0;
    width: 0;
    height: 0;
    border-bottom: 10px solid transparent;
    border-right: 10px solid #fff;
}
.start-chat .blanter-msg {
    display: flex;
}

#get-number {
    display: none;
}

a.close-chat {
    position: absolute;
    top: 5px;
    right: 15px;
    color: #fff;
    font-size: 30px;
    text-decoration: none;
}

@keyframes showhide {
    from {
        transform: scale(1);
        opacity: 0;
    };
}

@keyframes showchat {
    from {
        transform: scale(1);
        opacity: 0;
    };
}

@media screen and (max-width:480px) {
    #whatsapp-chat {
        width: auto;
        left: 5%;
        right: 5%;
        font-size: 80%;
    };
}

.hide {
    display: none;
    animation-name: showhide;
    animation-duration: 1.5s;
    transform: scale(1);
    opacity: 1;
}

.showing {
    display: block;
    animation-name: showhide;
    animation-duration: 1.5s;
    transform: scale(1);
    opacity: 1;
}

    </style>
</head>
<body>
    <div id="app">
    <div style="width:100%;position:absolute;overflow:hidden">
    <div class="simply-scroll simply-scroll-container"><div class="simply-scroll-clip"><ul id="scroller" class="simply-scroll-list" width="auto">
    <div class="awan no1"><img width="900" height="300" src="system/awan.webp"></div>
    <div class="awan no2"><img width="900" height="300" src="system/awan.webp"></div>
    </ul></div></div>
    </div>
        <main class="py-4" style="height:90vh">
            @yield('content')
        </main>
    </div>
    <div class="footer">
        <div class="copyright">
        <div class="text-center p-3">
            <script>
                document.write(unescape('%3C%73%74%72%6F%6E%67%3E%53%54%4F%4B%49%53%2E%41%50%50%3C%2F%73%74%72%6F%6E%67%3E%20%2D%20%56%33%20%2D'))
            </script>
        <?php echo env("VERSION"); ?>
        </div>
        </div>
<!--Start of Chat Script-->
<div id='whatsapp-chat' class='hide'>
<div class='header-chat'>
<div class='head-home'><b><img width="30" height="30" src="../../admin/gambar/wa-icon.webp"> Chat via Whatsapp</b></div>
<div class='get-new hide'><div id='get-avatar'></div><div id='get-label'></div><div id='get-nama'></div></div></div>
<div class='home-chat'>
<!-- Info Contact Start -->
<a class='informasi' href='javascript:void' title='Chat Whatsapp'>
<div class='info-avatar'><img src='<?php echo asset("gambar/".aplikasi()[0]->foto); ?>'/></div>
<div class='info-chat'>
<span class='chat-label'><?=aplikasi()[0]->cs?></span>
<span class='chat-nama small'>online</span>
</div><span class='my-number'><?=aplikasi()[0]->no_hp?></span>
</a>
<!-- Info Contact End -->

</div>
<div class='start-chat hide'>
<div class='first-msg'>
<div class="wabubble1" style="display: table;">
					<span class="minifont"><script type="text/javascript">
                                //<![CDATA[
                                var h=(new Date()).getHours();
                                var m=(new Date()).getMinutes();
                                var s=(new Date()).getSeconds();
                                if (h >= 4 && h < 10) document.writeln("Selamat pagi, apa yang ingin ditanyakan?");
                                if (h >= 10 && h < 15) document.writeln("Selamat siang, apa yang ingin ditanyakan?");
                                if (h >= 15 && h < 18) document.writeln("Selamat sore, apa yang ingin ditanyakan?");
                                if (h >= 18 || h < 4) document.writeln("Selamat malam, apa yang ingin ditanyakan?");
                                //]]>
                                </script>
                                </span>
					<div style="font-size:10px;text-align:right;color:#CCC;">baru saja</div>
				</div>


</div>
<div class='blanter-msg'><textarea id='chat-input' placeholder='Ketik pertanyaan Anda' maxlength='120' ></textarea>
<a href='javascript:void;' id='send-it'><svg viewBox="0 0 448 448"><path d="M.213 32L0 181.333 320 224 0 266.667.213 416 448 224z"/></svg></a></div></div>
<div id='get-number'></div><a class='close-chat' href='javascript:void'>×</a>
</div>
<a class='blantershow-chat' href='javascript:void' title='Showing Chat'><img width="30" height="30" src="../../admin/gambar/wa-icon.webp"></a>
<script>
   $(document).on("click","#send-it",function() {
    var a=document.getElementById("chat-input");
    if(""!=a.value){var b=$("#get-number").text(),c=document.getElementById("chat-input").value,d="https://web.whatsapp.com/send",e=b,f="&text="+c;
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    var d="whatsapp://send";var g=d+"?phone="+e+f;window.open(g, '_blank');
    }}),
    $(document).on("click",".informasi",function() {
    document.getElementById("get-number").innerHTML=$(this).children(".my-number").text(),
    $(".start-chat,.get-new").addClass("showing").removeClass("hide"),$(".home-chat,.head-home").addClass("hide").removeClass("showing"),
    document.getElementById("get-nama").innerHTML=$(this).children(".info-chat").children(".chat-nama").text(),
    document.getElementById("get-label").innerHTML=$(this).children(".info-chat").children(".chat-label").text();
    }),
    $(document).on("click",".close-chat",function() {
    $("#whatsapp-chat").addClass("hide").removeClass("showing");
    }),
    $(document).on("click",".blantershow-chat",function() {
    $("#whatsapp-chat").addClass("showing").removeClass("hide");
});
    var img = document.createElement("img");
    img.src = "<?php echo asset("gambar/".aplikasi()[0]->foto); ?>";

    var div = document.getElementById("get-avatar");
    div.appendChild(img);
</script>


<!--End of Chat Script-->
    </div>

</body>
</html>
