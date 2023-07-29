
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
</style>
<div class="card-body">
	<div class="row">
		<div class="col-sm-12 right-align">
			<button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close" style="all:unset; cursor:pointer;">
				<i class="icon icon-2xl mt-5 mb-2 cil-x"></i>
			</button>
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
					<td>{{General::ubahDBKeTanggal($lihat_surats->tanggal_asal_surats)}}</td>
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