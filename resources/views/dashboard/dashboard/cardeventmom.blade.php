@if(!$lihat_event_moms->isEmpty())
	@php($no = 0)
	@foreach($lihat_event_moms as $event_moms)
		@php($backcolor = '#fac8ec')
		@if($no % 2 == 0)
			@php($backcolor = '#c5fcb6')
		@endif

		@if(General::hakAkses('mom','tambah') == 'true')
			@php($ambil_mom_users = \App\Models\Mom_user::where('moms_id',$event_moms->id_moms)
														->first())
		@else
			@php($ambil_mom_users = \App\Models\Mom_user::where('moms_id',$event_moms->id_moms)
														->where('users_id',Auth::user()->id)
														->first())
		@endif
		
		@php($statusbacacolor = 'style=color:black;font-weight:bold')
		@if(!empty($ambil_mom_users))
			@if($ambil_mom_users->status_baca_mom_users == 1)
				@php($statusbacacolor = '')
			@endif
		@endif

		@if(General::hakAkses('mom', 'baca') == 'true')
			<div class="card linkmodal{{$event_moms->id_moms}}" style="height: 150px; background-color: {{$backcolor}}; color: #000; cursor: pointer">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6 left-align">
									<p class="nosurat">{{$event_moms->no_moms}}</p>
								</div>
								<div class="col-sm-6 right-align">
									<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="titleeventcard" {{$statusbacacolor}}>{{$event_moms->judul_moms}}</div>
					<div class="titlevenuecard text-muted">venue : {{$event_moms->venue_moms}}</div>
				</div>
			</div>

			<div id="modaldetailmoms{{$event_moms->id_moms}}" class="modal" tabindex="-1">
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
									<p class="judulsurat">{{$event_moms->judul_moms}}</p>
								</div>
								<div class="col-sm-6 right-align">
									<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
									<p class="nosurat">{{$event_moms->no_moms}}</p>
								</div>
								<div class="col-sm-12">
									<table width="100%">
										<tr>
											<th width="50px">Dari</th>
											<th width="1px">:</th>
											<td>{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_mulai_moms)}}</td>
										</tr>
										<tr>
											<th>Sampai</th>
											<th>:</th>
											<td>{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_selesai_moms)}}</td>
										</tr>
										<tr>
											<th>Venue</th>
											<th>:</th>
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

			<script type="text/javascript">
				$('.linkmodal{{$event_moms->id_moms}}').on('click', async function() {
					var headerRequest = {
									'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
								};
					$.ajax({
								url: '{{URL("dashboard/eventcalendar/mom/detail/".$event_moms->id_moms)}}',
								type: "GET",
								dataType: 'JSON',
								headers: headerRequest,
								success: function(data)
								{
									$("#modaldetailmoms{{$event_moms->id_moms}}").modal('show');
								},
								error: function(data) {
									console.log(data);
								}
						});
				});

				$('.btn-close').on('click', function(){
					$('.titleeventcard').css('font-weight','normal');
					$("#modaldetailmoms{{$event_moms->id_moms}}").modal('hide');
				});
			</script>
		@else
			<div class="card" style="height: 150px; background-color: {{$backcolor}}; color: #000;">
				<div class="card-body pb-0">
					<div class="btn-group float-right">
						<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($event_moms->tanggal_moms)}}</p>
					</div>
					<div class="text-value-lg">
						<p class="nosurat">{{$event_moms->no_moms}}</p>
					</div>
					<div class="titleeventcard">{{$event_moms->judul_moms}}</div>
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