@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/mom/prosesedit/'.$edit_moms->id_moms) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit MOM</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="tanggal_moms">Tanggal <b style="color:red">*</b></label>
                            @php($tanggal_moms = General::ubahDBKeTanggalwaktu($edit_moms->tanggal_mulai_moms.' sampai '.General::ubaHDBKeTanggalwaktu($edit_moms->tanggal_selesai_moms)))
							<input readonly class="form-control getStartEndDateTime {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms') == '' ? $tanggal_moms : Request::old('tanggal_moms')}}">
							{{General::pesanErrorForm($errors->first('tanggal_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="judul_moms">Judul <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('judul_moms')) }}" id="judul_moms" type="text" name="judul_moms" value="{{Request::old('judul_moms') == '' ? $edit_moms->judul_moms : Request::old('judul_moms')}}">
							{{General::pesanErrorForm($errors->first('judul_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="venue_moms">Venue <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('venue_moms')) }}" id="venue_moms" type="text" name="venue_moms" value="{{Request::old('venue_moms') == '' ? $edit_moms->venue_moms : Request::old('venue_moms') }}">
							{{General::pesanErrorForm($errors->first('venue_moms'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="users_id">Peserta <b style="color:red">*</b></label>
				            <select class="form-control select2" id="users_id" name="users_id[]" multiple="multiple">
				            	@foreach($edit_users as $users)
                                    @php($ambil_mom_users = \App\Models\Mom_user::where('users_id',$users->id)
                                                                                ->where('moms_id',$edit_moms->id_moms)
                                                                                ->count())
                                    @php($selected = '')
					                @if(Request::old('users_id') == '')
                                        @if($ambil_mom_users != 0)
                                            @php($selected = 'selected')
                                        @endif
					                @else
					                	@if($users->id == Request::old('users_id'))
					                		@php($selected = 'selected')
					                	@endif
					                @endif

									@php($nama = $users->nama_level_sistems.' | '.$users->name)
									@if(!empty($users->id_divisis))
										@php($nama = $users->nama_level_sistems.' | '.$users->nama_divisis.' | '.$users->name)
									@endif
								    <option value="{{$users->id}}" {{ $selected }}>{{$nama}}</option>
				            	@endforeach
				            </select>
							{{General::pesanErrorForm($errors->first('users_id.*'))}}
		                </div>
						<div class="form-group">
							<label class="form-col-form-label" for="deskripsi_moms">Deskripsi <b style="color:red">*</b></label>
							<textarea class="form-control {{ General::validForm($errors->first('deskripsi_moms')) }}" id="editor1" name="deskripsi_moms" rows="5">{{Request::old('deskripsi_moms') == '' ? $edit_moms->deskripsi_moms : Request::old('deskripsi_moms')}}</textarea>
							{{General::pesanErrorForm($errors->first('deskripsi_moms'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
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