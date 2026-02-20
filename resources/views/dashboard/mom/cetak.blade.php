
<link href="{{URL::asset('template/back/css/style.css')}}" rel="stylesheet">
<style>
    table { border-collapse: collapse; font-size: 14px; }
    .cetak-mom-wrap { width: 100%; max-width: 100%; overflow: hidden; box-sizing: border-box; }
    .cetak-mom-wrap * { box-sizing: border-box; }
    .right-align { text-align: right; }
    .page { page-break-before: always; }
    .page:first-child { page-break-before: avoid; }
    /* Gambar di deskripsi/remarks cetak: 300px */
    .cetak-mom-wrap #ckeditor5konten img,
    .cetak-mom-wrap .card-body img,
    #ckeditor5konten img,
    .cetak-mom-wrap figure img {
        width: 300px !important;
        height: 300px !important;
        object-fit: contain !important;
    }
    #ckeditor5konten { max-width: 100%; overflow: hidden; word-wrap: break-word; overflow-wrap: break-word; }
    /* Tabel tugas: teks wrap di semua sel (termasuk Catatan/remarks) */
    .cetak-mom-wrap .table { table-layout: fixed; width: 100%; }
    .cetak-mom-wrap .table td,
    .cetak-mom-wrap .table th { word-wrap: break-word; overflow-wrap: break-word; word-break: break-word; }
    @media print {
        @page { size: A4; margin: 15mm; }
        html, body { color: black; width: 100% !important; max-width: 100% !important; overflow-x: hidden; }
        .cetak-mom-wrap { width: 100% !important; max-width: 100% !important; overflow: hidden !important; }
        .cetak-mom-wrap #ckeditor5konten img,
        #ckeditor5konten img,
        .cetak-mom-wrap td img,
        .cetak-mom-wrap figure img { width: 300px !important; height: 300px !important; object-fit: contain !important; }
        #ckeditor5konten { word-wrap: break-word !important; overflow-wrap: break-word !important; }
        .cetak-mom-wrap .table { table-layout: fixed !important; width: 100% !important; }
        .cetak-mom-wrap .table td,
        .cetak-mom-wrap .table th { word-wrap: break-word !important; overflow-wrap: break-word !important; }
    }
</style>
<div class="card-body cetak-mom-wrap">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <p class="judulsurat">{{$lihat_moms->judul_moms.' ('.$lihat_moms->kategori_moms.')'}}</p>
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
                    <th width="50px">Ditujukan Kepada</th>
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
                                                        ->leftJoin('master_status_prioritas','status_prioritas_id','=','master_status_prioritas.id_status_prioritas')
														->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
														->where('moms_id',$lihat_moms->id_moms)
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
        <div class="col-sm-12" style="max-width:100%;overflow:hidden;">
            <h4>Deskripsi</h4>
            <br/>
            <div id="ckeditor5konten" style="max-width:100%;overflow:hidden;">{!! $lihat_moms->deskripsi_moms !!}</div>
        </div>
        <div class="col-sm-12">
            @php($lihat_tugas = \App\Models\Mom_user::join('users','users_id','=','users.id')
                                                            ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                            ->leftJoin('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
                                                            ->leftJoin('master_status_prioritas','status_prioritas_id','=','master_status_prioritas.id_status_prioritas')
                                                            ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                            ->where('moms_id',$lihat_moms->id_moms)
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
                                <th>Prioritas</th>
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
                                    <td>{{$tugas->nama_status_prioritas}}</td>
                                    <td>{{$tugas->nama_status_tugas}}</td>
                                    <td>{!! nl2br($tugas->catatan_mom_users ?? '') !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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