@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Mom</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::buat($link_mom,'dashboard/mom/tambah', 'MOM') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/mom/cari') }}">
						@csrf
	                	<div class="input-group">
	                		<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
	                		<span class="input-group-append">
	                		  	<button class="btn btn-primary" type="submit"> Cari</button>
	                		</span>
	                	</div>
	                </form>
				</div>
			</div>
		</div>

		@if(!$lihat_moms->isEmpty())
			@foreach($lihat_moms as $moms)
				<div class="col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="nav-tabs-boxed">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#home-{{$moms->id_moms}}" role="tab" aria-controls="home-{{$moms->id_moms}}" aria-selected="true">
													Mom
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#profile-{{$moms->id_moms}}" role="tab" aria-controls="profile-{{$moms->id_moms}}" aria-selected="false">
													Detail
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="home-{{$moms->id_moms}}" role="tabpanel">
												<div class="row">
													<div class="col-sm-6">
														<p class="judulsurat">{{$moms->judul_moms}}</p>
													</div>
													<div class="col-sm-6 right-align">
														<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
														<p class="nosurat">{{$moms->no_moms}}</p>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="profile-{{$moms->id_moms}}" role="tabpanel">
												@if(General::hakAkses($link_mom, 'baca') == 'true')
													<div class="row">
														<div class="col-sm-6">
															<p class="judulsurat">{{$moms->judul_moms}}</p>
														</div>
														<div class="col-sm-6 right-align">
															<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
															<p class="nosurat">{{$moms->no_moms}}</p>
														</div>
														<div class="col-sm-12">
															<table class="table table-responsive-sm">
																<tr>
																	<th>Dari</th>
																	<th>:</th>
																	<td>{{General::ubahDBKeTanggalwaktu($moms->tanggal_mulai_moms)}}</td>
																</tr>
																<tr>
																	<th>Sampai</th>
																	<th>:</th>
																	<td>{{General::ubahDBKeTanggalwaktu($moms->tanggal_selesai_moms)}}</td>
																</tr>
																<tr>
																	<th width="50px">Venue</th>
																	<th width="1px">:</th>
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
																										->where('moms_id',$moms->id_moms)
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
															{!! $moms->deskripsi_moms !!}	
														</div>
													</div>
												@endif
											</div>
										</div>
										<div class="buttoncetakmom">
											{{General::cetak($link_mom,'dashboard/mom/cetak/'.$moms->id_moms)}}
											@if( strtotime($moms->tanggal_mulai_moms) < strtotime(date('Y-m-d H:i:s')) )
												{{General::editButton($link_mom,'dashboard/mom/edit/'.$moms->id_moms)}}
												{{General::hapusButton($link_mom,'dashboard/mom/cetak/'.$moms->id_moms)}}
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@else

		@endif
		<div class="col-sm-12">
			{{ $lihat_moms->appends(Request::except('page'))->links('vendor.pagination.custom') }}
		</div>
	</div>

@endsection