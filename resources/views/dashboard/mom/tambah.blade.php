@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/mom/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah MOM</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="tanggal_moms">Tanggal <b style="color:red">*</b></label>
							<input readonly class="form-control getStartEndDateTime {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms') == '' ? General::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s')).' sampai '.General::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s')) : Request::old('tanggal_moms')}}">
							{{General::pesanErrorForm($errors->first('tanggal_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="Judul_moms">Judul <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('Judul_moms')) }}" id="Judul_moms" type="text" name="Judul_moms" value="{{Request::old('Judul_moms')}}">
							{{General::pesanErrorForm($errors->first('Judul_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="venue_moms">Venue <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('venue_moms')) }}" id="venue_moms" type="text" name="venue_moms" value="{{Request::old('venue_moms')}}">
							{{General::pesanErrorForm($errors->first('venue_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="users_id">Peserta <b style="color:red">*</b></label>
				            <select class="form-control select2" id="users_id" name="users_id">
				            	@foreach($tambah_users as $users)
									@php($nama = $users->nama_level_sistems.' | '.$users->nama)
									@if(!empty($users->id_divisis))
										@php($nama = $users->nama_level_sistems.' | '.$users->nama_divisis.' | '.$users->name)
									@endif
								    <option value="{{$users->id}}" {{ Request::old('users_id') == $users->id ? $select='selected' : $select='' }}>{{$nama}}</option>
				            	@endforeach
				            </select>
		                </div>
						<div class="form-group">
							<label class="form-col-form-label" for="deskripsi_moms">Deskripsi <b style="color:red">*</b></label>
							<textarea class="form-control {{ General::validForm($errors->first('deskripsi_moms')) }}" id="editor1" name="deskripsi_moms" rows="5">{{Request::old('deskripsi_moms')}}</textarea>
							{{General::pesanErrorForm($errors->first('deskripsi_moms'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::kirim()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/mom'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection