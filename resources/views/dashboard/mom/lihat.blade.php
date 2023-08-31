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
							<strong>MOM</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::buat($link_mom,'dashboard/mom/tambah', 'MOM') }}
							</div>
						</div>
					</div>
				</div>
				<form method="GET" action="{{ URL('dashboard/mom/cari') }}">
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
				@if(!$lihat_moms->isEmpty())
				@php($no = 0)
				@foreach($lihat_moms as $moms)
					@php($backcolor = '#fac8ec')
					@if($no % 2 == 0)
						@php($backcolor = '#c5fcb6')
					@endif

					@php($ambil_mom_users = \App\Models\Mom_user::where('moms_id',$moms->id_moms)
																->where('users_id',Auth::user()->id)
																->first())
					@php($statusbacacolor = 'style=color:black;font-weight:bold')
					@if(!empty($ambil_mom_users))
						@if($ambil_mom_users->status_baca_mom_users == 1)
							@php($statusbacacolor = '')
						@endif
					@endif

					@if(General::hakAkses('mom', 'baca') == 'true')
						<div class="card" style="height: auto; background-color: {{$backcolor}}; color: #000;">
							<div class="card-body pb-0">
								<div class="row">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-6 left-align">
												<p class="nosurat">{{$moms->no_moms}}</p>
											</div>
											<div class="col-sm-6 right-align">
												<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="titleeventcard" {{$statusbacacolor}}>{{$moms->judul_moms.' ('.$moms->kategori_moms.')'}}</div>
								<div class="titlevenuecard text-muted">venue : {{$moms->venue_moms}}</div>
								<div class="buttoncetakmom">
									{{General::detailCard($link_mom, $moms->id_moms)}}
									{{General::cetak($link_mom,'dashboard/mom/cetak/'.$moms->id_moms)}}
									@if($moms->users_id == Auth::user()->id)
										{{General::editButton($link_mom,'dashboard/mom/edit/'.$moms->id_moms)}}
										{{General::editTugasButton($link_mom, 'dashboard/mom/tugas/'.$moms->id_moms)}}
										{{General::hapusButton($link_mom,'dashboard/mom/hapus/'.$moms->id_moms)}}
									@endif
								</div>
							</div>
						</div>

						<div id="modaldetailmoms{{$moms->id_moms}}" class="modal" tabindex="-1">
							<div class="modal-dialog modal-xl" style="max-width:1400px !important">
								<div class="modal-content">
									<div class="card-body">
										<div class="row">
											<div class="col-sm-12 right-align">
												<button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close" style="all:unset; cursor:pointer;">
													<i class="icon icon-2xl mt-5 mb-2 cil-x"></i>
												</button>
											</div>
											<div class="col-sm-6">
												<p class="judulsurat">{{$moms->judul_moms.' ('.$moms->kategori_moms.')'}}</p>
											</div>
											<div class="col-sm-6 right-align">
												<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
												<p class="nosurat">{{$moms->no_moms}}</p>
											</div>
											<div class="col-sm-12">
												<table width="100%">
													<tr>
														<th width="150px">Dari</th>
														<th width="1px">:</th>
														<td>{{General::ubahDBKeTanggalwaktu($moms->tanggal_mulai_moms)}}</td>
													</tr>
													<tr>
														<th>Sampai</th>
														<th>:</th>
														<td>{{General::ubahDBKeTanggalwaktu($moms->tanggal_selesai_moms)}}</td>
													</tr>
													<tr>
														<th>Ditujukan Kepada</th>
														<th>:</th>
														<td>{{$moms->venue_moms}}</td>
													</tr>
												</table>
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Peserta</h4>
												@php($lihat_pesertas = \App\Models\Mom_user::join('users','users_id','=','users.id')
																							->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
																							->leftJoin('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
																							->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
																							->where('moms_id',$moms->id_moms)
																							->groupBy('mom_users.users_id')
																							->orderBy('users.name')
																							->get())
												@if(!$lihat_pesertas->isEmpty())
													@foreach($lihat_pesertas as $pesertas)
														@php($nama = $pesertas->nama_level_sistems.' - '.$pesertas->name)
														@if(!empty($pesertas->id_divisis))
															@php($nama = $pesertas->nama_level_sistems.' - '.$pesertas->nama_divisis.' - '.$pesertas->name)
														@endif
														- {{$nama}}<br/>
													@endforeach
												@endif

												@php($lihat_peserta_externals = \App\Models\Mom_user_external::where('moms_id',$moms->id_moms)
																									->get())
												@if(!$lihat_peserta_externals->isEmpty())
													@foreach($lihat_peserta_externals as $peserta_externals)
														- {{$peserta_externals->nama_user_externals}}<br/>
													@endforeach
												@endif
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Deskripsi</h4>
												<br/>
												{!! $moms->deskripsi_moms !!}	
											</div>
											@php($lihat_tugas = \App\Models\Mom_user::join('users','users_id','=','users.id')
																							->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
																							->leftJoin('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
																							->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
																							->where('moms_id',$moms->id_moms)
																							->orderBy('proyek_mom_users')
																							->orderBy('users.name')
																							->get())
											@if(!$lihat_tugas->isEmpty())
												<div class="col-sm-12">
													<table class="table table-responsive-sm table-bordered table-striped table-sm">
														<thead>
															<tr>
																<th>Proyek</th>
																<th>Tugas</th>
																<th>Ditugaskan</th>
																<th>Tenggat Waktu</th>
																<th>Dikirimkan</th>
																<th>Status</th>
																<th>Catatan</th>
															</tr>
														</thead>
														<tbody>
															@foreach($lihat_tugas as $tugas)
																@php($nama = $tugas->nama_level_sistems.' - '.$tugas->name)
																@if(!empty($tugas->id_divisis))
																	@php($nama = $tugas->nama_level_sistems.' - '.$tugas->nama_divisis.' - '.$tugas->name)
																@endif
																<tr>
																	<td>{!! nl2br($tugas->proyek_mom_users) !!}</td>
																	<td>{!! nl2br($tugas->tugas_mom_users) !!}</td>
																	<td>{{$nama}}</td>
																	<td>
																		@if($tugas->tenggat_waktu_mom_users != null)
																			{{General::ubahDBKeTanggal($tugas->tenggat_waktu_mom_users)}}
																		@endif
																	</td>
																	<td>{{$tugas->dikirimkan_mom_users}}</td>
																	<td>{{$tugas->nama_status_tugas}}</td>
																	<td>{!! nl2br($tugas->catatan_mom_users) !!}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							$('.linkmodal{{$moms->id_moms}}').on('click', async function() {
								var headerRequest = {
												'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
											};
								$.ajax({
											url: '{{URL("dashboard/eventcalendar/mom/detail/".$moms->id_moms)}}',
											type: "GET",
											dataType: 'JSON',
											headers: headerRequest,
											success: function(data)
											{
												$("#modaldetailmoms{{$moms->id_moms}}").modal('show');
											},
											error: function(data) {
												console.log(data);
											}
									});
							});

							$('.btn-close').on('click', function(){
								$('.titleeventcard').css('font-weight','normal');
								$("#modaldetailmoms{{$moms->id_moms}}").modal('hide');
							});
						</script>
					@else
						<div class="card" style="height: auto; background-color: {{$backcolor}}; color: #000;">
							<div class="card-body pb-0">
								<div class="btn-group float-right">
									<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
								</div>
								<div class="text-value-lg">
									<p class="nosurat">{{$moms->no_moms}}</p>
								</div>
								<div class="titleeventcard">{{$moms->judul_moms.' ('.$moms->kategori_moms.')'}}</div>
							</div>
						</div>
					@endif
					@php($no++)
				@endforeach
			@else
				<div class="card" style="height: 65px; background-color: #fac8ec; color: #000;">
					<div class="card-body pb-0">
						<div class="titleeventcardempty">Tidak ada MOM di bulan ini</div>
					</div>
				</div>
			@endif
					<div class="col-sm-12">
						{{ $lihat_moms->appends(Request::except('page'))->links('vendor.pagination.custom') }}
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