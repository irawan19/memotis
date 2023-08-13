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
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="sub_moms_id">Referensi MOM</label>
									<select class="form-control select2" id="sub_moms_id" name="sub_moms_id">
										<option value="">Tanpa Referensi</option>
										@foreach($edit_sub_moms as $sub_moms)
											@if(Request::old('sub_moms_id') == '')
					                        	@if($sub_moms->id_moms == $edit_moms->moms_id)
					                        		@php($selected = 'selected')
					                        	@endif
					                        @else
					                        	@if($sub_moms->id_moms == Request::old('sub_moms_id'))
					                        		@php($selected = 'selected')
					                        	@endif
					                        @endif
											<option value="{{$sub_moms->id_moms}}" {{ $selected }}>{{$sub_moms->no_moms}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_moms">Tanggal <b style="color:red">*</b></label>
									@php($tanggal_moms = General::ubahDBKeTanggalwaktu($edit_moms->tanggal_mulai_moms).' sampai '.General::ubaHDBKeTanggalwaktu($edit_moms->tanggal_selesai_moms))
									<input readonly class="form-control getStartEndDateTime {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms') == '' ? $tanggal_moms : Request::old('tanggal_moms')}}">
									{{General::pesanErrorForm($errors->first('tanggal_moms'))}}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="judul_moms">Judul <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('judul_moms')) }}" id="judul_moms" type="text" name="judul_moms" value="{{Request::old('judul_moms') == '' ? $edit_moms->judul_moms : Request::old('judul_moms')}}">
									{{General::pesanErrorForm($errors->first('judul_moms'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="venue_moms">Venue <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('venue_moms')) }}" id="venue_moms" type="text" name="venue_moms" value="{{Request::old('venue_moms') == '' ? $edit_moms->venue_moms : Request::old('venue_moms')}}">
									{{General::pesanErrorForm($errors->first('venue_moms'))}}
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label class="form-col-form-label" for="deskripsi_moms">Deskripsi <b style="color:red">*</b></label>
									<textarea class="form-control {{ General::validForm($errors->first('deskripsi_moms')) }}" id="editor1" name="deskripsi_moms" rows="5">{{Request::old('deskripsi_moms') == '' ? $edit_moms->deskripsi_moms : Request::old('deskripsi_moms')}}</textarea>
									{{General::pesanErrorForm($errors->first('deskripsi_moms'))}}
								</div>
								<div class="form-group">
									<div class="form-group">
										<label class="form-col-form-label" for="nama_user_externals">External</label>
										<select class="form-control select2creation" id="nama_user_externals" name="nama_user_externals[]" multiple="multiple">
											@foreach($edit_mom_user_externals as $mom_user_externals)
												@if(!empty(Request::old('nama_user_externals')))
													@if($mom_user_externals->nama_mom_user_externals == $edit_moms->moms_id)
														@php($selected = 'selected')
													@endif
												@else
													@if($mom_user_externals->nama_mom_user_externals == Request::old('nama_user_externals'))
														@php($selected = 'selected')
													@endif
												@endif
												<option value="{{$mom_user_externals->nama_mom_user_externals}}" {{ $selected }}>{{$mom_user_externals->nama_user_externals}}</option>
											@endforeach
										</select>
										{{General::pesanErrorForm($errors->first('nama_user_externals.*'))}}
									</div>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="users_id">Peserta <b style="color:red">*</b></label>
									@foreach($edit_users as $users)
										@php($nama = $users->nama_level_sistems.' - '.$users->name)
										@if(!empty($users->id_divisis))
											@php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
										@endif

										@php($ambil_mom_users = \App\Models\Mom_user::where('users_id',$users->id)
																								->where('moms_id',$edit_moms->id_moms)
																								->first())
										@php($id_user_moms 		= '')
										@php($tugas_mom_users 	= '')
										@php($status_tugas_id 	= '')
										@php($catatan_mom_users = '')
										@if(!empty($ambil_mom_users))
											@php($id_user_moms 		= $ambil_mom_users->users_id)
											@php($tugas_mom_users	= $ambil_mom_users->tugas_mom_users)
											@php($status_tugas_id 	= $ambil_mom_users->status_tugas_id)
											@php($catatan_mom_users = $ambil_mom_users->catatan_mom_users)
										@endif
										
										<div class="row" style="margin-bottom:10px">
											<div class="col-sm-4">
												@php($checked = '')
												@if(Request::old('users_id.'.$users->id) == '')
													@if($id_user_moms == $users->id)
														@php($checked = 'checked')
													@endif
												@else
													@if(Request::old('users_id.'.$users->id) == $users->id)
														@php($checked = 'checked')
													@endif
												@endif
												<div class="form-check checkbox">
													<input {{$checked}} class="form-check-input" id="users_id{{$users->id}}" type="checkbox" name="users_id[{{$users->id}}]" value="{{$users->id}}">
													<label class="form-check-label" for="users_id{{$users->id}}">{{$nama}}</label>
												</div>
												{{General::pesanErrorForm($errors->first('users_id.'.$users->id))}}
											</div>
											<div class="col-sm-3">
												<textarea placeholder="Masukkan tugas..." class="form-control {{ General::validForm($errors->first('tugas_mom_users.'.$users->id)) }}" id="tugas_mom_users" name="tugas_mom_users[{{$users->id}}]" rows="5">{{Request::old('tugas_mom_users.'.$users->id) == '' ? $tugas_mom_users : Request::old('tugas_mom_users')}}</textarea>
											</div>
											<div class="col-sm-2">
												<select class="form-control select2" id="status_tugas_id" name="status_tugas_id[{{$users->id}}]">
													<option value="">-</option>
													@foreach($edit_status_tugas as $status_tugas)
														@php($selected = '')
														@if(Request::old('status_tugas_id.'.$users->id) == '')
															@if($status_tugas_id == $status_tugas->id_status_tugas)
																@php($selected = 'selected')
															@endif
														@else
															@if(Request::old('status_tugas_id.'.$users->id) == $status_tugas->id_status_tugas)
																@php($selected = 'selected')
															@endif
														@endif
														<option value="{{$status_tugas->id_status_tugas}}" {{ $selected }}>{{$status_tugas->nama_status_tugas}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-sm-3">
												<textarea placeholder="Masukkan catatan..." class="form-control {{ General::validForm($errors->first('catatan_mom_users.'.$users->id)) }}" id="catatan_mom_users" name="catatan_mom_users[{{$users->id}}]" rows="5">{{Request::old('catatan_mom_users.'.$users->id) == '' ? $catatan_mom_users : Request::old('catatan_mom_users')}}</textarea>
											</div>
										</div>
									@endforeach
								</div>
							</div>
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