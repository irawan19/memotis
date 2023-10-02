@extends('dashboard.layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/karyawan/prosesedit/'.$edit_karyawans->id_karyawans) }}" method="POST">
                {{ csrf_field() }}
                <div class="card-header">
                    <strong>Edit Karyawan</strong>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="userfile_foto_karyawan">Foto</label>
                                <br />
                                <div class="form-group center-align">
                                    <a data-fancybox="gallery" href="{{URL::asset('storage/'.$edit_karyawans->foto_karyawans)}}">
                                        <img src="{{URL::asset('storage/'.$edit_karyawans->foto_karyawans)}}" width="108">
                                    </a>
                                </div>
                                <input id="userfile_foto_karyawan" type="file" name="userfile_foto_karyawan">
                            </div>
                            {{General::pesanErrorFormFile($errors->first('userfile_foto_karyawan'))}}
                            <div class="form-group">
                                <label class="form-col-form-label" for="nama_karyawans">Nama <b style="color:red">*</b></label>
                                <input class="form-control {{ General::validForm($errors->first('nama_karyawans')) }}" id="nama_karyawans" type="text" name="nama_karyawans" value="{{Request::old('nama_karyawans') == '' ? $edit_karyawans->nama_karyawans : Request::old('nama_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('nama_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="jabatans_id">Jabatan <b style="color:red">*</b></label>
                                <select class="form-control select2" id="jabatans_id" name="jabatans_id">
                                    @foreach($edit_jabatans as $jabatans)
				                    	@php($selected = '')
					                    @if(Request::old('karyawans_id') == '')
					                    	@if($jabatans->id_jabatans == $edit_karyawans->karyawans_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($jabatans->id_jabatans == Request::old('karyawans_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$jabatans->id_jabatans}}" {{ $selected }}>{{$jabatans->nama_jabatans}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('jabatans_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="unit_kerjas_id">Unit Kerja <b style="color:red">*</b></label>
                                <select class="form-control select2" id="unit_kerjas_id" name="unit_kerjas_id">
                                    @foreach($edit_unit_kerjas as $unit_kerjas)
				                    	@php($selected = '')
					                    @if(Request::old('unit_kerjas_id') == '')
					                    	@if($unit_kerjas->id_unit_kerjas == $edit_karyawans->unit_kerjas_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($unit_kerjas->id_unit_kerjas == Request::old('unit_kerjas_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$unit_kerjas->id_unit_kerjas}}" {{ $selected }}>{{$unit_kerjas->nama_unit_kerjas}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('unit_kerjas_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="nik_gys_karyawans">NIK GYS</label>
                                <input class="form-control {{ General::validForm($errors->first('nik_gys_karyawans')) }}" id="nik_gys_karyawans" type="text" name="nik_gys_karyawans" value="{{Request::old('nik_gys_karyawans') == '' ? $edit_karyawans->nik_gys_karyawans : Request::old('nik_gys_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('nik_gys_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="nik_tg_karyawans">NIK TG</label>
                                <input class="form-control {{ General::validForm($errors->first('nik_tg_karyawans')) }}" id="nik_tg_karyawans" type="text" name="nik_tg_karyawans" value="{{Request::old('nik_tg_karyawans') == '' ? $edit_karyawans->nik_tg_karyawans : Request::old('nik_tg_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('nik_tg_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="band_posisi_karyawans">Band Posisi</label>
                                <input class="form-control {{ General::validForm($errors->first('band_posisi_karyawans')) }}" id="band_posisi_karyawans" type="text" name="band_posisi_karyawans" value="{{Request::old('band_posisi_karyawans') == '' ? $edit_karyawans->band_posisi_karyawans : Request::old('band_posisi_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('band_posisi_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="tanggal_bergabung_karyawans">Tanggal Bergabung <b style="color:red">*</b></label>
                                <input readonly class="form-control {{ General::validForm($errors->first('tanggal_bergabung_karyawans')) }} getDate" id="tanggal_bergabung_karyawans" type="text" name="tanggal_bergabung_karyawans" value="{{Request::old('tanggal_bergabung_karyawans') == '' ? General::ubahDBKeTanggal(date($edit_karyawans->tanggal_bergabung_karyawans)) : Request::old('tanggal_bergabung_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('tanggal_bergabung_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="tanggal_keluar_karyawans">Tanggal Keluar</label>
                                @php($tanggal_keluar_karyawans = '')
                                @if(!empty($edit_karyawans->tanggal_keluar_karyawans))
                                    @php($tanggal_keluar_karyawans = General::ubahDBKeTanggal($edit_karyawans->tanggal_keluar_karyawans))
                                @endif
                                <input class="form-control {{ General::validForm($errors->first('tanggal_keluar_karyawans')) }} getDate" id="tanggal_keluar_karyawans" type="text" name="tanggal_keluar_karyawans" value="{{Request::old('tanggal_keluar_karyawans') == '' ? $tanggal_keluar_karyawans : Request::old('tanggal_keluar_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('tanggal_keluar_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="ktp_karyawans">No Identitas (KTP) <b style="color:red">*</b></label>
                                <input class="form-control {{ General::validForm($errors->first('ktp_karyawans')) }}" id="ktp_karyawans" type="text" name="ktp_karyawans" value="{{Request::old('ktp_karyawans') == '' ? $edit_karyawans->ktp_karyawans : Request::old('ktp_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('ktp_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="tanggal_lahir_karyawans">Tanggal Lahir</label>
                                @php($tanggal_lahir_karyawans = '')
                                @if(!empty($edit_karyawans->tanggal_lahir_karyawans))
                                    @php($tanggal_lahir_karyawans = General::ubahDBKeTanggal($edit_karyawans->tanggal_lahir_karyawans))
                                @endif
                                <input class="form-control {{ General::validForm($errors->first('tanggal_lahir_karyawans')) }} getDate" id="tanggal_lahir_karyawans" type="text" name="tanggal_lahir_karyawans" value="{{Request::old('tanggal_lahir_karyawans') == '' ? $tanggal_lahir_karyawans : Request::old('tanggal_lahir_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('tanggal_lahir_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="tempat_lahir_karyawans">Tempat Lahir</label>
                                <input class="form-control {{ General::validForm($errors->first('tempat_lahir_karyawans')) }}" id="tempat_lahir_karyawans" type="text" name="tempat_lahir_karyawans" value="{{Request::old('tempat_lahir_karyawans') == '' ? $edit_karyawans->tempat_lahir_karyawans : Request::old('tempat_lahir_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('tempat_lahir_karyawans'))}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-col-form-label" for="jenis_kelamins_id">Jenis Kelamin <b style="color:red">*</b></label>
                                <select class="form-control select2" id="jenis_kelamins_id" name="jenis_kelamins_id">
                                    @foreach($edit_jenis_kelamins as $jenis_kelamins)
				                    	@php($selected = '')
					                    @if(Request::old('jenis_kelamins_id') == '')
					                    	@if($jenis_kelamins->id_jenis_kelamins == $edit_karyawans->jenis_kelamins_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($jenis_kelamins->id_jenis_kelamins == Request::old('jenis_kelamins_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$jenis_kelamins->id_jenis_kelamins}}" {{ $selected }}>{{$jenis_kelamins->nama_jenis_kelamins}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('jenis_kelamins_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="agamas_id">Agama <b style="color:red">*</b></label>
                                <select class="form-control select2" id="agamas_id" name="agamas_id">
                                    @foreach($edit_agamas as $agamas)
				                    	@php($selected = '')
					                    @if(Request::old('agamas_id') == '')
					                    	@if($agamas->id_agamas == $edit_karyawans->agamas_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($agamas->id_agamas == Request::old('agamas_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$agamas->id_agamas}}" {{ $selected }}>{{$agamas->nama_agamas}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('agamas_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="alamat_rumah_karyawans">Alamat Rumah</label>
                                <textarea class="form-control {{ General::validForm($errors->first('alamat_rumah_karyawans')) }}" id="alamat_rumah_karyawans" name="alamat_rumah_karyawans" rows="5">{{Request::old('alamat_rumah_karyawans') == '' ? $edit_karyawans->alamat_rumah_karyawans : Request::old('alamat_rumah_karyawans')}}</textarea>
                                {{General::pesanErrorForm($errors->first('alamat_rumah_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="status_kawins_id">Status Kawin <b style="color:red">*</b></label>
                                <select class="form-control select2" id="status_kawins_id" name="status_kawins_id">
                                    @foreach($edit_status_kawins as $status_kawins)
				                    	@php($selected = '')
					                    @if(Request::old('status_kawins_id') == '')
					                    	@if($status_kawins->id_status_kawins == $edit_karyawans->status_kawins_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($status_kawins->id_status_kawins == Request::old('status_kawins_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$status_kawins->id_status_kawins}}" {{ $selected }}>{{$status_kawins->nama_status_kawins}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('status_kawins_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="pendidikans_id">Pendidikan <b style="color:red">*</b></label>
                                <select class="form-control select2" id="pendidikans_id" name="pendidikans_id">
                                    @foreach($edit_pendidikans as $pendidikans)
				                    	@php($selected = '')
					                    @if(Request::old('pendidikans_id') == '')
					                    	@if($pendidikans->id_pendidikans == $edit_karyawans->pendidikans_id)
					                    		@php($selected = 'selected')
					                    	@endif
					                    @else
					                    	@if($pendidikans->id_pendidikans == Request::old('pendidikans_id'))
					                    		@php($selected = 'selected')
					                    	@endif
					                    @endif
                                        <option value="{{$pendidikans->id_pendidikans}}" {{ $selected }}>{{$pendidikans->nama_pendidikans}}</option>
                                    @endforeach
                                </select>
						        {{General::pesanErrorForm($errors->first('pendidikans_id'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="institusi_karyawans">Nama Institusi</label>
                                <input class="form-control {{ General::validForm($errors->first('institusi_karyawans')) }}" id="institusi_karyawans" type="text" name="institusi_karyawans" value="{{Request::old('institusi_karyawans') == '' ? $edit_karyawans->institusi_karyawans : Request::old('institusi_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('institusi_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="hobi_karyawans">Hobi</label>
                                <textarea class="form-control {{ General::validForm($errors->first('hobi_karyawans')) }}" id="hobi_karyawans" name="hobi_karyawans" rows="5">{{Request::old('hobi_karyawans') == '' ? $edit_karyawans->hobi_karyawans : Request::old('hobi_karyawans')}}</textarea>
                                {{General::pesanErrorForm($errors->first('hobi_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="keahlian_khusus_karyawans">Keahlian Khusus</label>
                                <textarea class="form-control {{ General::validForm($errors->first('keahlian_khusus_karyawans')) }}" id="keahlian_khusus_karyawans" name="keahlian_khusus_karyawans" rows="5">{{Request::old('keahlian_khusus_karyawans') == '' ? $edit_karyawans->keahlian_khusus_karyawans : Request::old('keahlian_karyawans')}}</textarea>
                                {{General::pesanErrorForm($errors->first('keahlian_khusus_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="no_hp_karyawans">No HP</label>
                                <input class="form-control {{ General::validForm($errors->first('no_hp_karyawans')) }}" id="no_hp_karyawans" type="text" name="no_hp_karyawans" value="{{Request::old('no_hp_karyawans') == '' ? $edit_karyawans->no_hp_karyawans : Request::old('no_hp_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('no_hp_karyawans'))}}
                            </div>
                            <div class="form-group">
                                <label class="form-col-form-label" for="email_karyawans">Email</label>
                                <input class="form-control {{ General::validForm($errors->first('email_karyawans')) }}" id="email_karyawans" type="email" name="email_karyawans" value="{{Request::old('email_karyawans') == '' ? $edit_karyawans->email_karyawans : Request::old('email_karyawans')}}">
                                {{General::pesanErrorForm($errors->first('email_karyawans'))}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer right-align">
                        {{General::perbarui()}}
                        @if(request()->session()->get('halaman') != '')
                        @php($ambil_kembali = request()->session()->get('halaman'))
                        @else
                        @php($ambil_kembali = URL('dashboard/karyawan'))
                        @endif
                        {{General::batal($ambil_kembali)}}
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
