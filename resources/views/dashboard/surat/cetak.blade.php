
<link href="{{URL::asset('template/back/css/style.css')}}" rel="stylesheet">
<style>
    table {border-collapse: collapse;}
    @media print 
    {
        @page
        {
            size: A4;
			margin: 0;
        }
		html, body {
			color: black;
		}
    }
    table
    {
        border-collapse : collapse;
        font-size       : 14px;
    }
    .page {
        page-break-before: always;
    }
    .page:first-child {
        page-break-before: avoid;
    }
    .right-align{
        text-align:right;
    }
	.statuscss{
		float:right;
	}
</style>
<div class="card-body">
	<div class="row">
		<div class="col-sm-12" style="margin-bottom:10px">
			@if($lihat_surats->status_selesai_surats == 0)
				@php($status_selesai_surats = 'Belum Selesai')
			@else
				@php($status_selesai_surats = 'Selesai')
			@endif
			<div class="titleeventcard statuscss">
				{{$status_selesai_surats}}
			</div>
		</div>
		<div class="col-sm-6">
			<p class="judulsurat">{{$lihat_surats->judul_surats}}</p>
		</div>
		<div class="col-sm-6 right-align">
			<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($lihat_surats->tanggal_surats)}}</p>
			<p class="nosurat">{{$lihat_surats->no_surats}}</p>
		</div>
		<div class="col-sm-12">
			<table width="100%">
				<tr>
					<th colspan="3">Asal Surat</th>
					<th colspan="3" class="right-align">Ditujukan Kepada</th>
				</tr>
				<tr>
					<td colspan="3">{{$lihat_surats->asal_surats}}</td>
					<td colspan="3" class="right-align">
						@php($surat_users = \App\Models\Surat_user::join('users','users_id','=','users.id')
																	->where('surats_id',$lihat_surats->id_surats)
																	->orderBy('id_surat_users','asc')
																	->first())
						{{$surat_users->name}}
					</td>
				</tr>
				<tr>
					<td width="50px">Tanggal</td>
					<td width="1px">:</td>
					<td>
						@if($lihat_surats->tanggal_asal_surats != null)
							{{General::ubahDBKeTanggal($lihat_surats->tanggal_asal_surats)}}
						@endif					
					</td>
				</tr>
				<tr>
					<td>No</td>
					<td>:</td>
					<td>{{$lihat_surats->no_asal_surats}}</td>
				</tr>
				<tr>
					<td>Hal</td>
					<td>:</td>
					<td>{{$lihat_surats->perihal_surats}}</td>
				</tr>
			</table>
		</div>
		<div class="col-sm-12">
			<hr/>
		</div>
		<div class="col-sm-12">
			<h4>Ringkasan</h4>
			<br/>
			{!! $lihat_surats->ringkasan_surats !!}	
		</div>
		<div class="col-sm-12">
			<hr/>
		</div>
		<div class="col-sm-12">
			<h4>Keterangan</h4>
			<br/>
			{!! $lihat_surats->keterangan_surats !!}	
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
						@if($lihat_surats->status_agendakan_surats == 0)
							Tidak
						@else
							Ya
						@endif
					</td>
					<td width="100px">Klasifikasi</td>
					<td width="2px">:</td>
					<td>{{$lihat_surats->nama_klasifikasi_surats}}</td>
				</tr>
				<tr>
					<td>Mulai</td>
					<td>:</td>
					<td>{{General::ubahDBKeTanggal($lihat_surats->tanggal_mulai_surats)}}</td>
					<td>Derajat</td>
					<td>:</td>
					<td>{{$lihat_surats->nama_derajat_surats}}</td>
				</tr>
				<tr>
					<td>Selesai</td>
					<td>:</td>
					<td>{{General::ubahDBKeTanggal($lihat_surats->tanggal_selesai_surats)}}</td>
					<td>Sifat</td>
					<td>:</td>
					<td>{{$lihat_surats->nama_sifat_surats}}</td>
				</tr>
			</table>
		</div>
		@php($ambil_disposisi_surats = \App\Models\Surat_user::selectRaw('surats.created_at as tanggal_disposisi,
																												master_level_sistems.nama_level_sistems,
																												users.name,
																												master_divisis.nama_divisis,
																												surat_users.id_surat_users,
																												surat_users.status_selesai_surat_users,
																												surat_users.status_disposisi_surat_users
																												')
																									->join('surats','surat_users.surats_id','=','surats.id_surats')
																									->join('users','surat_users.users_id','=','users.id')
																									->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
																									->leftJoin('master_divisis','master_level_sistems.divisis_id','=','master_divisis.id_divisis')
																									->where('surats.id_surats',$lihat_surats->id_surats)
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
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Status</th>
						<th>Tanggal Selesai</th>
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
							@if($disposisi_surats->status_disposisi_surat_users == 0)
								@php($status = 'selesai mendisposisikan surat')
							@else
								@php($status = 'selesai')
							@endif
						@endif
						<tr>
							<td>{{ General::ubahDBKeTanggalwaktu($disposisi_surats->tanggal_disposisi) }}</td>
							<td>{{$nama}}</td>
							<td>{{$status}}</td>
							@php($ambil_keterangan_selesai = \App\Models\Surat_selesai::where('surat_users_id',$disposisi_surats->id_surat_users)
																				->first())
							<td>
								@if(!empty($ambil_keterangan_selesai))
									{{ General::ubahDBKeTanggalwaktu($ambil_keterangan_selesai->created_at) }}
								@endif
							</td>
							<td>
								@php($ambil_surat_selesai = \App\Models\Surat_selesai::where('surat_users_id',$disposisi_surats->id_surat_users)
																				->get())
								@if(!$ambil_surat_selesai->isEmpty())
									@php($noselesai = 1)
									@foreach($ambil_surat_selesai as $surat_selesai)
										@if(!empty($surat_selesai->file_surat_selesais))
											{{$noselesai++}} <a href="{{URL::asset('storage/'.$surat_selesai->file_surat_selesais)}}" target="_blank">Klik Disini</a><br/>
										@endif
									@endforeach
								@endif
							</td>
							<td>
								@if(!empty($ambil_keterangan_selesai))
									{!! nl2br($ambil_keterangan_selesai->keterangan_surat_selesais) !!}
								@endif
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		@endif
		@php($ambil_master_surat_disposisi = \App\Models\Surat_disposisi::join('master_disposisi_surats','surat_disposisis.surat_disposisis_id','=','master_disposisi_surats.id_disposisi_surats')
																			->join('surat_users','surat_disposisis.surat_users_id','=','surat_users.id_surat_users')
																			->join('surats','surat_users.surats_id','=','surats.id_surats')
																			->where('surats.id_surats',$lihat_surats->id_surats)
																			->groupBy('surat_disposisis_id')
																			->get())
		@if(!$ambil_master_surat_disposisi->isEmpty())
			<div class="col-sm-12">
				<hr/>
			</div>
			<div class="col-sm-12 mb-5">
				<h4>Keterangan Disposisi</h4>
				<br/>
				@foreach($ambil_master_surat_disposisi as $master_surat_disposisi)
					- {{$master_surat_disposisi->nama_disposisi_surats}}<br/>
				@endforeach
				<br/>
				{{$ambil_master_surat_disposisi[0]->keterangan_surat_disposisis}}
			</div>
		@endif
	</div>
</div>
<script type="text/javascript">
	window.onload=function(){
		window.print();
		setTimeout(function(){
			window.close(window.location = "{{URL('/dashboard/surat')}}");
		}, 1);
		return false;
	}
</script>