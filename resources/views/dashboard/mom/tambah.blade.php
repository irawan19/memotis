@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/mom/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Buat MOM</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="sub_moms_id">Referensi MOM</label>
									<select class="form-control select2" id="sub_moms_id" name="sub_moms_id">
										<option value="">Tanpa Referensi</option>
										@foreach($tambah_sub_moms as $sub_moms)
											<option value="{{$sub_moms->id_moms}}" {{ Request::old('sub_moms_id') == $sub_moms->id_moms ? $select='selected' : $select='' }}>{{$sub_moms->no_moms}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_moms">Tanggal <b style="color:red">*</b></label>
									<input readonly class="form-control getStartEndDateTime {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms') == '' ? General::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s')).' sampai '.General::ubahDBKeTanggalwaktu(date('Y-m-d H:i:s')) : Request::old('tanggal_moms')}}">
									{{General::pesanErrorForm($errors->first('tanggal_moms'))}}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="judul_moms">Judul <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('judul_moms')) }}" id="judul_moms" type="text" name="judul_moms" value="{{Request::old('judul_moms')}}">
									{{General::pesanErrorForm($errors->first('judul_moms'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="venue_moms">Venue <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('venue_moms')) }}" id="venue_moms" type="text" name="venue_moms" value="{{Request::old('venue_moms')}}">
									{{General::pesanErrorForm($errors->first('venue_moms'))}}
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label class="form-col-form-label" for="deskripsi_moms">Deskripsi <b style="color:red">*</b></label>
									<textarea class="form-control deskripsi_moms {{ General::validForm($errors->first('deskripsi_moms')) }}" id="editor1" name="deskripsi_moms" rows="5">{{Request::old('deskripsi_moms')}}</textarea>
									{{General::pesanErrorForm($errors->first('deskripsi_moms'))}}
								</div>
								<div class="form-group">
									<div class="form-group">
										<label class="form-col-form-label" for="nama_user_externals">External</label>
										<select class="form-control select2creation" id="nama_user_externals" name="nama_user_externals[]" multiple="multiple">
											@foreach($tambah_mom_user_externals as $mom_user_externals)
												<option value="{{$mom_user_externals->nama_user_externals}}" {{ Request::old('nama_user_externals') == $mom_user_externals->nama_user_externals ? $select='selected' : $select='' }}>{{$mom_user_externals->nama_user_externals}}</option>
											@endforeach
										</select>
										{{General::pesanErrorForm($errors->first('nama_user_externals.*'))}}
									</div>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="users_id">Peserta <b style="color:red">*</b></label>
									@foreach($tambah_users as $users)
										@php($nama = $users->nama_level_sistems.' - '.$users->name)
										@if(!empty($users->id_divisis))
											@php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
										@endif
										<div class="row" style="margin-bottom:10px">
											<div class="col-sm-4">
												@if(Request::old('users_id.'.$users->id) == $users->id)
													@php($checked = 'checked')
												@else
													@php($checked = '')
												@endif
												<div class="form-check checkbox">
													<input {{$checked}} class="form-check-input" id="users_id{{$users->id}}" type="checkbox" name="users_id[{{$users->id}}]" value="{{$users->id}}">
													<label class="form-check-label" for="users_id{{$users->id}}">{{$nama}}</label>
												</div>
												{{General::pesanErrorForm($errors->first('users_id.'.$users->id))}}
											</div>
											<div class="col-sm-3">
												<textarea placeholder="Masukkan tugas..." class="form-control {{ General::validForm($errors->first('tugas_mom_users.'.$users->id)) }}" id="tugas_mom_users{{$users->id}}" name="tugas_mom_users[{{$users->id}}]" rows="5">{{Request::old('tugas_mom_users.'.$users->id)}}</textarea>
											</div>
											<div class="col-sm-2">
												<select class="form-control select2" id="status_tugas_id{{$users->id}}" name="status_tugas_id[{{$users->id}}]">
													<option value="">-</option>
													@foreach($tambah_status_tugas as $status_tugas)
														<option value="{{$status_tugas->id_status_tugas}}" {{ Request::old('status_tugas_id.'.$users->id) == $status_tugas->id_status_tugas ? $select='selected' : $select='' }}>{{$status_tugas->nama_status_tugas}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-sm-3">
												<textarea placeholder="Masukkan catatan..." class="form-control {{ General::validForm($errors->first('catatan_mom_users.'.$users->id)) }}" id="catatan_mom_users{{$users->id}}" name="catatan_mom_users[{{$users->id}}]" rows="5">{{Request::old('catatan_mom_users.'.$users->id)}}</textarea>
											</div>
										</div>
									@endforeach
								</div>
							</div>
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
	
	<script type="text/javascript">
		jQuery(document).ready(function () {
			$('#sub_moms_id').on('change', function() {
				idmoms = $(this).val();

				var headerRequest = {
								'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
							};
				//get moms
				$.ajax({
							url: '{{URL("dashboard/mom/ambilmom")}}/'+idmoms,
							type: "GET",
							dataType: 'JSON',
							headers: headerRequest,
							success: function(data)
							{
								if(data.pesan == 'sukses')
								{
									CKEDITOR.instances.editor1.setData(data.data.deskripsi_moms);
								}
							},
							error: function(data) {
								console.log(data);
							}
					});

				//get user internal
				$.ajax({
							url: '{{URL("dashboard/mom/momuser")}}/'+idmoms,
							type: "GET",
							dataType: 'JSON',
							headers: headerRequest,
							success: function(data)
							{
								if(data.pesan == 'sukses')
								{
									$.each( data.data, function(key, value) {
										$('#users_id'+value.users_id).prop('checked',true);
										$('#tugas_mom_users'+value.users_id).val(value.tugas_mom_users);
										$('#status_tugas_id'+value.users_id).val(value.status_tugas_id).trigger('change');
										$('#catatan_mom_users'+value.users_id).val(value.catatan_mom_users);
									});
								}
							},
							error: function(data) {
								console.log(data);
							}
					});

				//get user external
					$.ajax({
							url: '{{URL("dashboard/mom/momexternal")}}/'+idmoms,
							type: "GET",
							dataType: 'JSON',
							headers: headerRequest,
							success: function(data)
							{
								if(data.pesan == 'sukses')
								{
									$.each( data.data, function(key, value) {
										$('#nama_user_externals').val(value.nama_user_externals).trigger('change');
									});
								}
							},
							error: function(data) {
								console.log(data);
							}
					});
			});
		});
	</script>

@endsection