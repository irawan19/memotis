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
					    	{!! $lihat_surats->keterangan_disposisi_surats !!}	
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
					    			<td width="100px">Disposisi</td>
					    			<td width="2px">:</td>
					    			<td>{{$lihat_surats->nama_disposisi_surats}}</td>
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
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/surat/prosesdisposisi/'.$lihat_surats->id_surats) }}" method="POST">
					{{ csrf_field() }}
                    <div class="card-header">
                        <strong>Disposisi</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    @foreach($lihat_users as $users)
										@php($nama = $users->nama_level_sistems.' - '.$users->name)
										@if(!empty($users->id_divisis))
											@php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
										@endif
										@php($checked = '')
										@if(Request::old('users_id.'.$users->id) == $users->id)
											@php($checked = 'checked')
										@endif
                                        <div class="form-group">
                                            <div class="form-check checkbox">
                                                <input {{$checked}} class="form-check-input" id="users_id{{$users->id}}" type="checkbox" name="users_id[{{$users->id}}]" value="{{$users->id}}">
                                                <label class="form-check-label" for="users_id{{$users->id}}">{{$nama}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{General::pesanErrorForm($errors->first('users_id'))}}
                                </div>
                                <div class="col-sm-6">
                                    @foreach($lihat_disposisi_surats as $disposisi_surats)
										@php($checked = '')
										@if(Request::old('disposisi_surats_id.'.$disposisi_surats->id_disposisi_surats) == $disposisi_surats->id_disposisi_surats)
											@php($checked = 'checked')
										@endif
                                        <div class="form-group">
                                            <div class="form-check checkbox">
                                                <input {{$checked}} class="form-check-input" id="disposisi_surats_id{{$disposisi_surats->id_disposisi_surats}}" type="checkbox" name="disposisi_surats_id[{{$disposisi_surats->id_disposisi_surats}}]" value="{{$disposisi_surats->id_disposisi_surats}}">
                                                <label class="form-check-label" for="disposisi_surats_id{{$disposisi_surats->id_disposisi_surats}}">{{$disposisi_surats->nama_disposisi_surats}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{General::pesanErrorForm($errors->first('disposisi_surats_id'))}}
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="keterangan_disposisi_surats">Keterangan </label>
                                        <textarea class="form-control {{ General::validForm($errors->first('keterangan_disposisi_surats')) }}" id="keterangan_disposisi_surats" name="keterangan_disposisi_surats" rows="5">{{Request::old('keterangan_disposisi_surats')}}</textarea>
                                        {{General::pesanErrorForm($errors->first('keterangan_disposisi_surats'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer right-align">
                        {{General::prosesdisposisi($link_surat)}}
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