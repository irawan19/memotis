@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<div class="card-header">
				    <strong>Surat</strong>
				</div>
				<div class="card-body">
				    <div class="row">
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
					    				@if($lihat_surats->tanggal_asal_surats != '')
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
					    	<h4>Lampiran</h4>
					    	<br/>
					    	@php($ambil_surat_lampirans = \App\Models\Surat_lampiran::where('surats_id',$lihat_surats->id_surats)->get())
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
			</div>
		</div>
        <div class="col-sm-6">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/surat/prosesselesai/'.$lihat_surats->id_surats) }}" method="POST">
					{{ csrf_field() }}
                    <div class="card-header">
                        <strong>Selesai</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="keterangan_selesai_surats">Keterangan <b style="color:red">*</b></label>
                                        <textarea class="form-control {{ General::validForm($errors->first('keterangan_selesai_surats')) }}" id="keterangan_selesai_surats" name="keterangan_selesai_surats" rows="5">{{Request::old('keterangan_selesai_surats')}}</textarea>
                                        {{General::pesanErrorForm($errors->first('keterangan_selesai_surats'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer right-align">
                        {{General::prosesselesai($link_surat)}}
                        @if(request()->session()->get('halaman') != '')
                            @php($ambil_kembali = request()->session()->get('halaman'))
                        @else
                            @php($ambil_kembali = URL('dashboard/surat'))
                        @endif
                        {{General::batal($ambil_kembali)}}
                    </div>
                </form>
			</div>
		</div>
	</div>

@endsection