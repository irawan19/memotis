
@foreach($lihat_event_moms as $event_moms)
	@if(General::hakAkses('mom', 'baca') == 'true')
		<a data-target="#modaldetailmoms{{$event_moms->id_moms}}" href="#modaldetailmoms{{$event_moms->id_moms}}" data-toggle="modal" class="nonstyle">
			<div class="card" style="height: 100px; background-color: #fff; color: #000;">
				<div class="card-body pb-0">
					<div class="btn-group float-right">
						<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
					</div>
					<div class="text-value-lg">
						<p class="nosurat">{{$event_moms->no_moms}}</p>
					</div>
					<div class="textnotifberanda">{{$event_moms->judul_moms}}</div>
				</div>
				<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
			</div>
		</a>

		<div id="modaldetailmoms{{$event_moms->id_moms}}" class="modal" tabindex="-1">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<p class="judulsurat">{{$event_moms->judul_moms}}</p>
							</div>
							<div class="col-sm-6 right-align">
								<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
								<p class="nosurat">{{$event_moms->no_moms}}</p>
							</div>
							<div class="col-sm-12">
								<table class="table table-responsive-sm">
									<tr>
										<th>Dari</th>
										<th>:</th>
										<td>{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_mulai_moms)}}</td>
									</tr>
									<tr>
										<th>Sampai</th>
										<th>:</th>
										<td>{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_selesai_moms)}}</td>
									</tr>
									<tr>
										<th width="50px">Venue</th>
										<th width="1px">:</th>
										<td>{{$event_moms->venue_moms}}</td>
									</tr>
								</table>
							</div>
							<div class="col-sm-12">
								<hr/>
							</div>
							<div class="col-sm-12">
								<h4>Peserta</h4>
								@php($lihat_pesertas = \App\Models\Mom_user::join('users','users_id','=','users.id')
																			->where('moms_id',$event_moms->id_moms)
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
								{!! $event_moms->deskripsi_moms !!}	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="card" style="height: 100px; background-color: #fff; color: #000;">
			<div class="card-body pb-0">
				<div class="btn-group float-right">
					<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
				</div>
				<div class="text-value-lg">
					<p class="nosurat">{{$event_moms->no_moms}}</p>
				</div>
				<div class="textnotifberanda">{{$event_moms->judul_moms}}</div>
			</div>
			<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"></div>
		</div>
	@endif
@endforeach