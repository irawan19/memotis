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
			<div class="col-sm-6">
				<div class="card" style="min-height: 225px;background-color: white">
				    <div class="card-body">
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
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/buat_surat')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-plus')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">
										<svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-open')}}"></use>
					                    </svg>
									</div>
					                <div class="textnotifberanda">Buat Surat</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/list_surat')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-closed')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">List Surat</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/surat')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-envelope-letter')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">Surat Masuk</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/disposisi')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-sync')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">Disposisi</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/arsip')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-file')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">Arsip</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
					<div class="col-sm-4">
					    <a href="{{URL('dashboard/mom')}}" class="nonstyle">
					        <div class="card" style="height: 100px; background-color: #fff; color: #000;">
					            <div class="card-body pb-0">
					                <div class="btn-group float-right">
					                    <svg class="c-icon">
					                        <use xlink:href="{{URL::asset('template/back/assets/icons/coreui/free.svg#cil-file')}}"></use>
					                    </svg>
					                </div>
					                <div class="text-value-lg">{{General::konversiNilai(0)}} <span>{{General::konversiNilaiString(0)}}</span></div>
					                <div class="textnotifberanda">MOM</div>
					            </div>
					            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
					        </div>
					    </a>
					</div>
				</div>
			</div>
		    	
			<div class="col-md-12">
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
		</div>
	</div>

	<link href="{{URL::asset('template/back/vendors/fullcalendar/main.css')}}" rel="stylesheet">
    <script src="{{URL::asset('template/back/vendors/fullcalendar/main.js')}}"></script>
    <script src="{{URL::asset('template/back/vendors/fullcalendar/locales/id.js')}}"></script>
	
    <script type="text/javascript">
	    document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
    		var calendar = new FullCalendar.Calendar(calendarEl, {
				locale: 'id',
				height:485,
				dayMaxEvents: false,
      			businessHours: true,
				editable: false,
				droppable: false,
				eventClick: function(info) {
	                swal({
	                    title: info.event.title,
	                    text: info.event.extendedProps.description,
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
	});
	</script>


@endsection