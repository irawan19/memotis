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
		#loading{
			text-align:center;
			margin: 0 auto;
		}

		.fc-direction-ltr .fc-daygrid-event.fc-event-end, .fc-direction-rtl .fc-daygrid-event.fc-event-start{
            cursor:pointer !important;
        }
        .fc-direction-ltr .fc-daygrid-event.fc-event-start, .fc-direction-rtl .fc-daygrid-event.fc-event-end{
            cursor: pointer !important;
        }
		.nonstyle{
			text-decoration:none;
			cursor:pointer;
		}
		a:hover{
			text-decoration:none !important;
			cursor:pointer;
		}
	</style>

	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-7">
				<div class="card" style="min-height: 225px;background-color: white">
				    <div class="card-body">
				    	<div class="row" style="margin-top:30px !important;">
				    		<div class="col-sm-12">
					        	<div style="text-align: center;">
					        		<img src="{{URL::asset('storage/'.$lihat_konfigurasi_aplikasis->logo_text_konfigurasi_aplikasis)}}" width="100%" style="max-width:256px">
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

				<div class="card">
					<div class="card-header">
						<strong>
							<svg class="c-sidebar-nav-icon" style="width: 50px">
								<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-calendar')}}"></use>
							</svg>Kalender
						</strong>
					</div>
					<div class="card-body center-align">
						<div id='loading' class="spinner-border" role="status">
							<span class="visually-hidden"></span>
						</div>
						<div id="calendar"></div>
					</div>
				</div>
			</div>

			<div class="col-sm-5">

				<div class="row">
					{{-- @foreach($lihat_status_tugas as $status_tugas)
						@php($ambil_divisis = \App\Models\Master_level_sistem::where('id_level_sistems',Auth::user()->level_sistems_id)
																			->first())
						@if(Auth::user()->level_sistems_id == 1 || $ambil_divisis->divisis_id == null)
						@php($ambil_mom_users = DB::select("SELECT COUNT(*) as total
																FROM (
																	SELECT MAX(mom_users.moms_id)
																	FROM mom_users
																	WHERE status_tugas_id = ".$status_tugas->id_status_tugas."
																	GROUP BY tugas_mom_users
																) as total_tugas
															"))
						@else
							@php($ambil_mom_users = DB::select("SELECT COUNT(*) as total
																FROM (
																	SELECT MAX(mom_users.moms_id)
																	FROM mom_users
																	WHERE status_tugas_id = ".$status_tugas->id_status_tugas."
																	AND mom_users.users_id= ".Auth::user()->id."
																	GROUP BY tugas_mom_users
																) as total_tugas
															"))
						@endif
						<div class="col-sm-4">
							<a href="{{URL('dashboard/tugas/'.$status_tugas->id_status_tugas)}}" class="nonstyle">
								<div class="card" style="height: 106px; background-color: #fff; color: #000;">
									<div class="card-body pb-0">
										<div class="btn-group float-right">
											<svg class="c-icon">
												<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-task')}}"></use>
											</svg>
										</div>
										<div class="text-value-lg">{{General::konversiNilai($ambil_mom_users[0]->total)}} <span>{{General::konversiNilaiString($ambil_mom_users[0]->total)}}</span></div>
										<div class="textnotifberanda">{{$status_tugas->nama_status_tugas}}</div>
									</div>
									<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
								</div>
							</a>
						</div>
					@endforeach --}}

					<div class="col-sm-6">
						<a href="{{URL('dashboard/surat')}}" class="nonstyle">
							<div class="card" style="height: 106px; background-color: #fff; color: #000;">
								<div class="card-body pb-0">
									<div class="btn-group float-right">
										<svg class="c-icon">
											<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-open')}}"></use>
										</svg>
									</div>
									<div class="text-value-lg">{{General::konversiNilai($total_surats)}} <span>{{General::konversiNilaiString($total_surats)}}</span></div>
									<div class="textnotifberanda">Surat</div>
								</div>
								<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
							</div>
						</a>
					</div>

					<div class="col-sm-6">
						<a href="{{URL('dashboard/surat')}}" class="nonstyle">
							<div class="card" style="height: 106px; background-color: #fff; color: #000;">
								<div class="card-body pb-0">
									<div class="btn-group float-right">
										<svg class="c-icon">
											<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-open')}}"></use>
										</svg>
									</div>
									<div class="text-value-lg">{{General::konversiNilai($total_surat_selesais)}} <span>{{General::konversiNilaiString($total_surat_selesais)}}</span></div>
									<div class="textnotifberanda">Surat Selesai</div>
								</div>
								<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
							</div>
						</a>
					</div>

					<div class="col-sm-6">
						<a href="{{URL('dashboard/surat')}}" class="nonstyle">
							<div class="card" style="height: 106px; background-color: #fff; color: #000;">
								<div class="card-body pb-0">
									<div class="btn-group float-right">
										<svg class="c-icon">
											<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-open')}}"></use>
										</svg>
									</div>
									<div class="text-value-lg">{{General::konversiNilai($total_surat_belum_selesais)}} <span>{{General::konversiNilaiString($total_surat_belum_selesais)}}</span></div>
									<div class="textnotifberanda">Surat Belum Selesai</div>
								</div>
								<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
							</div>
						</a>
					</div>

					<div class="col-sm-6">
						<a href="{{URL('dashboard/mom')}}" class="nonstyle">
							<div class="card" style="height: 106px; background-color: #fff; color: #000;">
								<div class="card-body pb-0">
									<div class="btn-group float-right">
										<svg class="c-icon">
											<use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-notes')}}"></use>
										</svg>
									</div>
									<div class="text-value-lg">{{General::konversiNilai($total_moms)}} <span>{{General::konversiNilaiString($total_moms)}}</span></div>
									<div class="textnotifberanda">MOM</div>
								</div>
								<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
							</div>
						</a>
					</div>

					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="cardeventcalendar"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>

	<link href="{{URL::asset('template/back/vendors/fullcalendar/main.css')}}" rel="stylesheet">
    <script src="{{URL::asset('template/back/vendors/fullcalendar/main.js')}}"></script>
    <script src="{{URL::asset('template/back/vendors/fullcalendar/locales/id.js')}}"></script>
	
    <script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
  				initialView: 'timeGridWeek',
				locale: 'id',
				height:'auto',
				dayMaxEvents: false,
				businessHours: true,
				editable: false,
				droppable: false,
				eventClick: function(info) {
					swal({
						title: info.event.title,
						html: info.event.extendedProps.description,
						type: "info",
					});
				},
				events: {
					url: '{{URL("dashboard/eventcalendar")}}'
				},
				loading: function(bool) {
					document.getElementById('loading').style.display =
					bool ? 'block' : 'none';
				}
			});
			calendar.render();

			var date = calendar.getDate();
			var formatdate = moment(date).format('YYYY-MM-DD');
			$('.cardeventcalendar').load('{{URL("dashboard/eventcalendar/mom/card")}}/'+formatdate);


			$('body').on('click', 'button.fc-prev-button', function () {
				var date = calendar.getDate();
				var formatdate = moment(date).format('YYYY-MM-DD');
				$('.cardeventcalendar').load('{{URL("dashboard/eventcalendar/mom/card")}}/'+formatdate);
            });

			$('body').on('click', 'button.fc-next-button', function () {
				var date = calendar.getDate();
				var formatdate = moment(date).format('YYYY-MM-DD');
				$('.cardeventcalendar').load('{{URL("dashboard/eventcalendar/mom/card")}}/'+formatdate);
            });

			$('body').on('click', 'button.fc-today-button', function () {
				var date = calendar.getDate();
				var formatdate = moment(date).format('YYYY-MM-DD');
				$('.cardeventcalendar').load('{{URL("dashboard/eventcalendar/mom/card")}}/'+formatdate);
			});
		});

	</script>


@endsection