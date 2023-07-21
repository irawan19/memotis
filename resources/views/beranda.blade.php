<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
	<meta name="keywords" content="{{$lihat_konfigurasi_aplikasis->keyword_konfigurasi_aplikasis}}">
	<meta name="description" content="{{$lihat_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
	<meta name="author" content="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<meta property="og:title" content="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<meta name="twitter:title" content="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<meta property="og:description" content="{{$lihat_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
	<meta name="twitter:description" content="{{$lihat_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
	<meta property="og:image" content="{{$lihat_konfigurasi_aplikasis->logo_konfigurasi_aplikasis}}">
	<meta name="twitter:image" content="{{$lihat_konfigurasi_aplikasis->logo_konfigurasi_aplikasis}}">
	<meta property="og:url" content="{{URL('/')}}">
	<meta property="og:site_name" content="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<meta name="twitter:image:alt" content="{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<link rel="shortcut icon" href="{{URL::asset('storage/'.$lihat_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" type="image/x-icon">
	<link rel="apple-touch-icon" href="{{URL::asset('storage/'.$lihat_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/front/css/style.css')}}" rel="stylesheet">
	<style type="text/css">
	body::before {
		content: "";
		position: fixed;
		background: #040404 url('{{"storage/".$lihat_konfigurasi_aplikasis->background_website_konfigurasi_aplikasis}}') top right no-repeat;
		background-size: cover;
		left: 0;
		right: 0;
		top: 0;
		height: 100vh;
		z-index: -1;
	}
	
	.errorform {
		color: #f57a7a;
		font-size: 13px;
	}
	
	.alert-success {
		background-color: #18d26e;
		color: white;
	}
	</style>
</head>

<body>
	<header id="header">
		<div class="container">
			<h1>
          <a href="{{URL('/')}}">{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</a>
        </h1>
			<h2>{!! $lihat_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis !!}</h2>
			<nav id="navbar" class="navbar">
				<ul>
					<li> <a class="nav-link active" href="#header">Beranda</a> </li>
					<li>
                        @php($url_menu  = 'login')
                        @php($nama_menu = 'Login')
                        @if(!empty(Auth::user()))
                            @php($url_menu = 'dashboard')
                            @php($nama_menu = 'Dashboard')
                        @endif
                        <a class="nav-link" href="{{$url_menu}}">{{$nama_menu}}</a>
                    </li>
				</ul> <i class="bi bi-list mobile-nav-toggle"></i> </nav>
			<div class="social-links">
                @foreach($lihat_sosial_medias as $sosial_medias)
                    <a target="_blank" href="{{$sosial_medias->url_sosial_medias}}" class="{{$sosial_medias->icon_sosial_medias}}">
                        <i class="bi bi-{{$sosial_medias->icon_sosial_medias}}"></i>
                    </a>
                @endforeach
            </div>
		</div>
	</header>
	<div class="credits"> © {{date("Y")}}, <a href="{{URL('/')}}">{{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</a> </div>
	<script src="{{URL::asset('template/front/vendor/purecounter/purecounter_vanilla.js')}}"></script>
	<script src="{{URL::asset('template/front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{URL::asset('template/front/vendor/glightbox/js/glightbox.min.js')}}"></script>
	<script src="{{URL::asset('template/front/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
	<script src="{{URL::asset('template/front/vendor/swiper/swiper-bundle.min.js')}}"></script>
	<script src="{{URL::asset('template/front/vendor/waypoints/noframework.waypoints.js')}}"></script>
	<script src="{{URL::asset('template/front/js/main.js')}}"></script>
</body>

</html>