@extends('dashboard.layouts.app')
@section('content')

	<style>
		.ui-datepicker-calendar {
			display: none;
		}
	</style>

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Surat</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::buat($link_surat,'dashboard/surat/tambah', 'Surat') }}
							</div>
						</div>
					</div>
				</div>
				<form method="GET" action="{{ URL('dashboard/surat/cari') }}">
					@csrf
					<div class="card-body">
						<div class="input-group">
							<input class="form-control" id="cari_kata" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
						</div>
					</div>
					<div class="card-footer right-align">
						{{General::reset()}}
						{{General::pencarian()}}
					</div>
				</form>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
				@if(!$lihat_surats->isEmpty())
				@php($no = 0)
				@foreach($lihat_surats as $surats)
					@php($backcolor = '#fac8ec')
					@if($no % 2 == 0)
						@php($backcolor = '#c5fcb6')
					@endif

					@if(General::hakAkses('surat','tambah') == 'true')
						@php($ambil_surat_users = \App\Models\Surat_user::where('surats_id',$surats->id_surats)
																	->first())
					@else
						@php($ambil_surat_users = \App\Models\Surat_user::where('surats_id',$surats->id_surats)
																	->where('users_id',Auth::user()->id)
																	->first())
					@endif
					
					@php($statusbacacolor = 'style=color:black;font-weight:bold')
					@if(!empty($ambil_surat_users))
						@if($ambil_surat_users->status_baca_surat_users == 1)
							@php($statusbacacolor = '')
						@endif
					@endif

					@if(General::hakAkses('surat', 'baca') == 'true')
						<div class="card linkmodal{{$surats->id_surats}}" style="height: 150px; background-color: {{$backcolor}}; color: #000; cursor: pointer">
							<div class="card-body pb-0">
								<div class="row">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-6 left-align">
												<p class="nosurat">{{$surats->no_surats}}</p>
											</div>
											<div class="col-sm-6 right-align">
												<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($surats->tanggal_surats)}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="titleeventcard" {{$statusbacacolor}}>{{$surats->judul_surats}}</div>
								<div class="buttoncetaksurat">
									{{General::cetak($link_surat,'dashboard/surat/cetak/'.$surats->id_surats)}}
									@if( strtotime($surats->tanggal_mulai_surats) > strtotime(date('Y-m-d')) )
										{{General::editButton($link_surat,'dashboard/surat/edit/'.$surats->id_surats)}}
										{{General::hapusButton($link_surat,'dashboard/surat/cetak/'.$surats->id_surats)}}
									@endif
								</div>
							</div>
						</div>

						<div id="modaldetailsurats{{$surats->id_surats}}" class="modal" tabindex="-1">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="card-body">
										<div class="row">
											<div class="col-sm-12 right-align">
												<button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close" style="all:unset; cursor:pointer;">
													<i class="icon icon-2xl mt-5 mb-2 cil-x"></i>
												</button>
											</div>
											<div class="col-sm-6">
												<p class="judulsurat">{{$surats->judul_surats}}</p>
											</div>
											<div class="col-sm-6 right-align">
												<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($surats->tanggal_surats)}}</p>
												<p class="nosurat">{{$surats->no_surats}}</p>
											</div>
											<div class="col-sm-12">
												<table class="table table-responsive-sm">
													<tr>
														<th>Dari</th>
														<th>:</th>
														<td>{{General::ubahDBKeTanggalwaktu($surats->tanggal_mulai_surats)}}</td>
													</tr>
													<tr>
														<th>Sampai</th>
														<th>:</th>
														<td>{{General::ubahDBKeTanggalwaktu($surats->tanggal_selesai_surats)}}</td>
													</tr>
													<tr>
														<th width="50px">Venue</th>
														<th width="1px">:</th>
														<td>{{$surats->venue_surats}}</td>
													</tr>
												</table>
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Peserta</h4>
												@php($lihat_pesertas = \App\Models\Surat_user::join('users','users_id','=','users.id')
																							->where('surats_id',$surats->id_surats)
																							->orderBy('users.name')
																							->get())
												@foreach($lihat_pesertas as $pesertas)
													- {{$pesertas->name}}<br/>
												@endforeach
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Deskripsi</h4>
												<br/>
												{!! $surats->deskripsi_surats !!}	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							$('.linkmodal{{$surats->id_surats}}').on('click', async function() {
								var headerRequest = {
												'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
											};
								$.ajax({
											url: '{{URL("dashboard/eventcalendar/surat/detail/".$surats->id_surats)}}',
											type: "GET",
											dataType: 'JSON',
											headers: headerRequest,
											success: function(data)
											{
												$("#modaldetailsurats{{$surats->id_surats}}").modal('show');
											},
											error: function(data) {
												console.log(data);
											}
									});
							});

							$('.btn-close').on('click', function(){
								$('.titleeventcard').css('font-weight','normal');
								$("#modaldetailsurats{{$surats->id_surats}}").modal('hide');
							});
						</script>
					@else
						<div class="card" style="height: 150px; background-color: {{$backcolor}}; color: #000;">
							<div class="card-body pb-0">
								<div class="btn-group float-right">
									<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($surats->tanggal_surats)}}</p>
								</div>
								<div class="text-value-lg">
									<p class="nosurat">{{$surats->no_surats}}</p>
								</div>
								<div class="titleeventcard">{{$surats->judul_surats}}</div>
							</div>
						</div>
					@endif
					@php($no++)
				@endforeach
			@else
				<div class="card" style="height: 65px; background-color: #fac8ec; color: #000;">
					<div class="card-body pb-0">
						<div class="titleeventcardempty">Tidak ada Surat di bulan ini</div>
					</div>
				</div>
			@endif
					<div class="col-sm-12">
						{{ $lihat_surats->appends(Request::except('page'))->links('vendor.pagination.custom') }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function () {
			$('.resetbutton').on('click', function() {
				$('#cari_kata').val('');
			});
		});
	</script>

@endsection