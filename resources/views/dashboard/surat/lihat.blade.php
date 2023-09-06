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

					@php($ambil_surat_users = \App\Models\Surat_user::where('surats_id',$surats->id_surats)
																->where('users_id',Auth::user()->id)
																->first())
					@php($statusbacacolor = 'style=color:black;font-weight:bold')
					@if(!empty($ambil_surat_users))
						@if($ambil_surat_users->status_baca_surat_users == 1)
							@php($statusbacacolor = '')
						@endif
					@endif

					@if(General::hakAkses('surat', 'baca') == 'true')
						<div class="card" style="height: auto; background-color: {{$backcolor}}; color: #000;">
							<div class="card-body pb-0">
								<div class="row">
									<div class="col-sm-12" style="margin-bottom:10px">
										@if($surats->status_selesai_surats == 0)
											@php($statuscss = 'statusbelumselesai')
											@php($status_selesai_surats = 'Belum Selesai')
										@else
											@php($statuscss = 'statusselesai')
											@php($status_selesai_surats = 'Selesai')
										@endif
										<div class="titleeventcard {{$statuscss}}">
											{{$status_selesai_surats}}
										</div>
									</div>
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
									{{General::detailCard($link_surat, $surats->id_surats)}}
									@if(!empty($ambil_surat_users))
										@if($ambil_surat_users->status_selesai_surat_users == 0)
											@php($cek_level_users = \App\Models\User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
																					->where('master_level_sistems.level_sistems_id',Auth::user()->level_sistems_id)
																					->count())
											@if($cek_level_users != 0)
												{{General::disposisi($link_surat,'dashboard/surat/disposisi/'.$surats->id_surats)}}
											@endif
											{{General::selesai($link_surat,'dashboard/surat/selesai/'.$surats->id_surats)}}
										@endif
									@endif
									{{General::cetak($link_surat,'dashboard/surat/cetak/'.$surats->id_surats)}}
									@if( $surats->users_id == Auth::user()->id || Auth::user()->level_sistems_id == 1)
										@php($cek_disposisi = \App\Models\Surat_disposisi::join('surat_users','surat_users.id_surat_users','=','surat_disposisis.surat_users_id')
																				->where('surat_users.surats_id',$surats->id_surats)
																				->count())
										@if($cek_disposisi == 0 || $surats->status_selesai_surats == 0)
											{{General::editButton($link_surat,'dashboard/surat/edit/'.$surats->id_surats)}}
										@endif
										{{General::hapusButton($link_surat,'dashboard/surat/hapus/'.$surats->id_surats)}}
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
												<table width="100%">
													<tr>
														<th colspan="3">Asal Surat</th>
														<th colspan="3" class="right-align">Ditujukan Kepada</th>
													</tr>
													<tr>
														<td colspan="3">{{$surats->asal_surats}}</td>
														<td colspan="3" class="right-align">
															@php($surat_users = \App\Models\Surat_user::join('users','users_id','=','users.id')
																										->where('surats_id',$surats->id_surats)
																										->orderBy('id_surat_users','asc')
																										->first())
															{{$surat_users->name}}
														</td>
													</tr>
													<tr>
														<td width="50px">Tanggal</td>
														<td width="1px">:</td>
														<td>
															@if($surats->tanggal_asal_surats != '')
																{{General::ubahDBKeTanggal($surats->tanggal_asal_surats)}}
															@endif
														</td>
													</tr>
													<tr>
														<td>No</td>
														<td>:</td>
														<td>{{$surats->no_asal_surats}}</td>
													</tr>
													<tr>
														<td>Hal</td>
														<td>:</td>
														<td>{{$surats->perihal_surats}}</td>
													</tr>
												</table>
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Ringkasan</h4>
												<br/>
												{!! $surats->ringkasan_surats !!}	
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Keterangan</h4>
												<br/>
												{!! $surats->keterangan_surats !!}	
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<h4>Lampiran</h4>
												<br/>
												@php($ambil_surat_lampirans = \App\Models\Surat_lampiran::where('surats_id',$surats->id_surats)->get())
												@foreach($ambil_surat_lampirans as $surat_lampirans)
													<a href="{{URL::asset('storage/'.$surat_lampirans->file_surat_lampirans)}}" target="_blank">Klik Disini</a>
												@endforeach
											</div>
											<div class="col-sm-12">
												<hr/>
											</div>
											<div class="col-sm-12">
												<table width="100%">
													<tr>
														<td width="100px">Agendakan</td>
														<td width="2px">:</td>
														<td>
															@if($surats->status_agendakan_surats == 0)
																Tidak
															@else
																Ya
															@endif
														</td>
														<td width="100px">Klasifikasi</td>
														<td width="2px">:</td>
														<td>{{$surats->nama_klasifikasi_surats}}</td>
													</tr>
													<tr>
														<td>Mulai</td>
														<td>:</td>
														<td>{{General::ubahDBKeTanggal($surats->tanggal_mulai_surats)}}</td>
														<td>Derajat</td>
														<td>:</td>
														<td>{{$surats->nama_derajat_surats}}</td>
													</tr>
													<tr>
														<td>Selesai</td>
														<td>:</td>
														<td>{{General::ubahDBKeTanggal($surats->tanggal_selesai_surats)}}</td>
														<td>Sifat</td>
														<td>:</td>
														<td>{{$surats->nama_sifat_surats}}</td>
													</tr>
												</table>
											</div>

											@php($ambil_disposisi_surats = \App\Models\Surat_disposisi::join('surat_users','surat_disposisis.surat_users_id','=','surat_users.id_surat_users')
																											->join('surats','surat_users.surats_id','=','surats.id_surats')
																											->join('users','surat_users.users_id','=','users.id')
																											->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
																											->leftJoin('master_divisis','master_level_sistems.divisis_id','=','master_divisis.id_divisis')
																											->where('surats.id_surats',$surats->id_surats)
																											->groupBy('users.id')
																											->get())
											@if(!$ambil_disposisi_surats->isEmpty())
												<div class="col-sm-12">
													<hr/>
												</div>
												<div class="col-sm-12">
													<h4>Disposisi</h4>
													<br/>
													<table class="table table-responsive-sm table-bordered table-striped table-sm">
														<tr>
															<th>Nama</th>
															<th>Status</th>
															<th>Lampiran</th>
															<th>Keterangan</th>
														</tr>
														@foreach($ambil_disposisi_surats as $disposisi_surats)
															@php($nama = $disposisi_surats->nama_level_sistems.' - '.$disposisi_surats->name)
															@if(!empty($disposisi_surats->id_divisis))
																@php($nama = $disposisi_surats->nama_level_sistems.' - '.$disposisi_surats->nama_divisis.' - '.$disposisi_surats->name)
															@endif
															@if($disposisi_surats->status_selesai_surat_users == 0)
																@php($status = 'belum selesai')
															@else
																@php($status = 'selesai')
															@endif
															<tr>
																<td>{{$nama}}</td>
																<td>{{$status}}</td>
																<td>
																	@php($ambil_surat_selesai = \App\Models\Surat_selesai::where('surat_users_id',$disposisi_surats->id_surat_users)
																													->get())
																	@if(!$ambil_surat_selesai->isEmpty())
																		@php($noselesai = 1)
																		@foreach($ambil_surat_selesai as $surat_selesai)
																			{{$noselesai++}} <a href="{{URL::asset('storage/'.$surat_selesai->file_surat_selesais)}}" target="_blank">Klik Disini</a><br/>
																		@endforeach
																	@endif
																</td>
																<td>
																	@php($ambil_keterangan_selesai = \App\Models\Surat_selesai::where('surat_users_id',$disposisi_surats->id_surat_users)
																														->first())
																	@if(!empty($ambil_keterangan_selesai))
																		{!! nl2br($ambil_keterangan_selesai->keterangan_surat_selesais) !!}
																	@endif
																</td>
															</tr>
														@endforeach
													</table>
												</div>
											@endif
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
											url: '{{URL("dashboard/surat/detail/".$surats->id_surats)}}',
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
						<div class="card" style="height: auto; background-color: {{$backcolor}}; color: #000;">
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