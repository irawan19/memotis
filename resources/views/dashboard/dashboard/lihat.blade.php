@extends('dashboard.layouts.app')
@section('content')

	<style type="text/css">
		.bg-custom{
			background-color: #fff;
		    border: 1px solid #c8ced3;
		    border-radius: 0.25rem;
		}
		.card-custom{
			position: relative;
		    display: -ms-flexbox;
		    display: flex;
		    -ms-flex-direction: column;
		    flex-direction: column;
		    min-width: 0;
		    word-wrap: break-word;
		    background-color: #fff;
		    background-clip: border-box;
		    margin-bottom: 5px;
		}
		.card-header{
			color: #000
		}
		.text-muted {
		    color: #0e2f44 !important;
		}
	</style>

	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-8">
				<div class="card" style="min-height: 225px;background-color: white">
				    <div class="card-body pb-0">
				    	<div class="row">
				    		<div class="col-sm-12">
					        	<div style="text-align: center;">
					        		<img src="{{URL::asset('storage/'.$lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}">
					        	</div>
					        </div>
				    		<div class="col-sm-12">
				    			<div class="center-align">
				        			<p style="font-weight: bold; font-size: 20px; margin-bottom: 5px">Halo, {{Auth::user()->name}}</p>
				        			<p style="font-size: 16px">Selamat Datang di halaman dashboard {{$lihat_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</p>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-6">
					    <a href="{{URL('dashboard/swara_nusvantara')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-newspaper')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">Swara Nusvantara</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
				</div>
			</div>
		</div>


		@php($id_user               = Auth::user()->id)
		@php($ambil_menus           = \App\Models\Master_menu::where('menus_id',null)
		                                                ->orderBy('order_menus')
		                                                ->get())
		@foreach($ambil_menus as $menus)
		    @if($loop->last)
		    	@php($style = 'style=padding-bottom:30px')
		    @else
		    	@php($style = '')
		    @endif
			@php($id_menus          = $menus->id_menus)
		    @php($ambil_sub_menus   = \App\Models\Master_menu::join('master_fiturs','master_menus.id_menus','=','master_fiturs.menus_id')
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
		    	<div class="card" style="margin-bottom: 10px; border-radius: 0">
		    		<div class="card-header">
		    			<strong>
		    				<svg class="c-sidebar-nav-icon" style="width: 50px">
							  	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$menus->icon_menus)}}"></use>
							</svg>{{$menus->nama_menus}}
		    			</strong>
		    		</div>
		    		<div class="card-body">
		    			<div class="row">
		    				@foreach($ambil_sub_menus as $sub_menus)
			    				<div class="col-sm-3">
			    					<a href="{{URL('dashboard/'.$sub_menus->link_menus)}}" style="color:black; text-decoration: none; cursor: pointer">
				    					<div class="card-custom">
					        				<div class="card-body p-2 d-flex align-items-center">
										        <svg class="c-sidebar-nav-icon">
											      	<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#'.$sub_menus->icon_menus)}}"></use>
											    </svg>
					                      		<div>
					                        		<div class="text-muted text-uppercase font-weight-bold small">{{$sub_menus->nama_menus}}</div>
					                      		</div>
					                    	</div>
					                    </div>
					                </a>
				                </div>
				            @endforeach
				    	</div>
					</div>
				</div>
		   	@endif
		@endforeach
	</div>

@endsection