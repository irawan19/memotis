
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
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <p class="judulsurat">{{$lihat_moms->judul_moms.' ('.$moms->kategori_moms.')'}}</p>
                </div>
                <div class="col-sm-6 right-align">
                    <p class="judultanggal">{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_moms)}}</p>
                    <p class="nosurat">{{$lihat_moms->no_moms}}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <table class="table table-responsive-sm">
                <tr>
                    <th>Dari</th>
                    <th>:</th>
                    <td>{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_mulai_moms)}}</td>
                </tr>
                <tr>
                    <th>Sampai</th>
                    <th>:</th>
                    <td>{{General::ubahDBKeTanggalwaktu($lihat_moms->tanggal_selesai_moms)}}</td>
                </tr>
                <tr>
                    <th width="50px">Venue</th>
                    <th width="1px">:</th>
                    <td>{{$lihat_moms->venue_moms}}</td>
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
														->where('moms_id',$lihat_moms->id_moms)
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

			@php($lihat_peserta_externals = \App\Models\Mom_user_external::where('moms_id',$lihat_moms->id_moms)
																->get())
			@if(!$lihat_peserta_externals->isEmpty())
				@foreach($lihat_peserta_externals as $peserta_externals)
					- {{$peserta_externals->nama_user_externals}}
				@endforeach
			@endif
        </div>
        <div class="col-sm-12">
            <hr/>
        </div>
        <div class="col-sm-12">
            <h4>Deskripsi</h4>
            <br/>
            {!! $lihat_moms->deskripsi_moms !!}	
        </div>
        <div class="col-sm-12">
			<table class="table table-responsive-sm table-bordered table-striped table-sm">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Tugas</th>
						<th>Status</th>
						<th>Catatan</th>
					</tr>
				</thead>
				<tbody>
					@if(!$lihat_pesertas->isEmpty())
						@foreach($lihat_pesertas as $pesertas)
							@php($nama = $pesertas->nama_level_sistems.' - '.$pesertas->name)
							@if(!empty($pesertas->id_divisis))
								@php($nama = $pesertas->nama_level_sistems.' - '.$pesertas->nama_divisis.' - '.$pesertas->name)
							@endif
							<tr>
								<td>{{$nama}}</td>
								<td>{!! nl2br($pesertas->tugas_mom_users) !!}</td>
								<td>{{$pesertas->nama_status_tugas}}</td>
								<td>{!! nl2br($pesertas->catatan_mom_users) !!}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
    </div>
</div>
<script type="text/javascript">
	window.onload=function(){
		window.print();
		setTimeout(function(){
			window.close(window.location = "{{URL('/dashboard/mom')}}");
		}, 1);
		return false;
	}
</script>