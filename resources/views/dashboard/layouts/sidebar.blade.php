@php($nama_logo 			= 'Logo '.$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis)
@php($url_logo 				= $ambil_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)
@php($url_logo_minimized 	= $ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show c-sidebar-unfoldable" id="sidebar">
	<div class="c-sidebar-brand d-md-down-none">
		<a href="{{URL('/')}}" target="_blank">
			<img class="c-sidebar-brand-full" src="{{URL::asset('storage/'.$url_logo)}}" width="150" alt="{{$nama_logo}}">
			<img class="c-sidebar-brand-minimized" src="{{URL::asset('storage/'.$url_logo_minimized)}}" width="50" alt="{{$nama_logo}}">
		</a>
	</div>
	<ul class="c-sidebar-nav">
		<li class="c-sidebar-nav-item">
			<a class="c-sidebar-nav-link" href="{{URL('dashboard')}}">
	    		<svg class="c-sidebar-nav-icon"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Dashboard">
	      			<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-speedometer')}}"></use>
	    		</svg> Dashboard
	    	</a>
	  	</li>
	  	@php($id_user               = Auth::user()->id)
        @php($get_menus             = \App\Models\Master_menu::where('menus_id',null)
                                                        ->orderBy('order_menus')
                                                        ->get())
        @foreach($get_menus as $menus)
            @php($id_menus          = $menus->id_menus)
            @php($get_sub_menus     = \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
                                                        ->join('master_akses','master_fiturs.id_fiturs','=','master_akses.fiturs_id')
                                                        ->join('master_level_sistems','master_akses.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                        ->join('users','master_level_sistems.id_level_sistems','=','users.level_sistems_id')
                                                        ->where('master_menus.menus_id',$id_menus)
                                                        ->where('id',$id_user)
                                                        ->where('nama_fiturs','lihat')
                                                        ->groupBy('nama_menus')
                                                        ->orderBy('order_menus')
                                                        ->get())
            @php($total_sub_menus   = \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
                                                        ->join('master_akses','master_fiturs.id_fiturs','=','master_akses.fiturs_id')
                                                        ->join('master_level_sistems','master_akses.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                        ->join('users','master_level_sistems.id_level_sistems','=','users.level_sistems_id')
                                                        ->where('master_menus.menus_id',$id_menus)
                                                        ->where('id',$id_user)
                                                        ->where('nama_fiturs','lihat')
                                                        ->count())
            @if($total_sub_menus != 0)
                @php($cek_submenus = \App\Models\Master_menu::where('link_menus',Request::segment(2))
                                                            ->where('menus_id',$menus->id_menus)
                                                            ->count())
                @php($open_menus = '')
                @if($cek_submenus != 0)
                    @php($open_menus = 'c-show')
                @endif
			  	<li class="c-sidebar-nav-dropdown {{$open_menus}}">
				  	<a class="c-sidebar-nav-dropdown-toggle" href="#">
				        <svg class="c-sidebar-nav-icon"  data-toggle="tooltip" data-placement="right" title="" data-original-title="{{$menus->nama_menus}}">
				          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$menus->icon_menus)}}"></use>
				        </svg> {{$menus->nama_menus}}
				    </a>
				  	<ul class="c-sidebar-nav-dropdown-items">
				  		@foreach($get_sub_menus as $sub_menus)
                            @php($active_submenus = '')
                            @if(Request::segment(2) == $sub_menus->link_menus)
                                @php($active_submenus = 'c-active')
                            @endif
				  				<li class="c-sidebar-nav-item">
				  					<a class="c-sidebar-nav-link {{$active_submenus}}" href="{{URL('dashboard/'.$sub_menus->link_menus)}}">
				  						<svg class="c-sidebar-nav-icon {{$active_submenus}}" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{$sub_menus->nama_menus}}">
								          	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$sub_menus->icon_menus)}}"></use>
								        </svg> {{$sub_menus->nama_menus}}
				  					</a>
				  				</li>
				  		@endforeach
				  	</ul>
			  	</li>
			@endif
		@endforeach
		<li class="c-sidebar-nav-item" style="margin-bottom: 50px">
			<form method="POST" action="{{ route('logout') }}">
      		@csrf
				<a class="c-sidebar-nav-link" href="{{ URL('dashboard/logout') }}">
		    		<svg class="c-sidebar-nav-icon"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Logout">
		      			<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-account-logout')}}"></use>
		    		</svg> Logout
		    	</a>
	    	</form>
	  	</li>
	</ul>
		<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-unfoldable"></button>
</div>