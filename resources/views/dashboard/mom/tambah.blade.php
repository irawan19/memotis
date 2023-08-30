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
									<input readonly class="form-control getStartEndDateTime {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms')}}">
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
									<textarea class="form-control deskripsi_moms {{ General::validForm($errors->first('deskripsi_moms')) }}" id="editor1" name="deskripsi_moms" rows="10">{{Request::old('deskripsi_moms')}}</textarea>
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
							</div>
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::lanjutkan()}}
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
									// CKEDITOR.instances.editor1.setData(data.data.deskripsi_moms);
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