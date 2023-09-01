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
											@php($selected = '')
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
									<input readonly class="form-control getStartEndDateTimeEdit {{ General::validForm($errors->first('tanggal_moms')) }}" id="tanggal_moms" type="text" name="tanggal_moms" value="{{Request::old('tanggal_moms') == '' ? $tanggal_moms : Request::old('tanggal_moms')}}">
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
											@php($selected = '')
											@php($ambil_mom_user_externals = \App\Models\Mom_user_external::where('moms_id',$edit_moms->id_moms)->groupBy('nama_user_externals')->get())
											@if(!empty($ambil_mom_user_externals))
												@foreach($ambil_mom_user_externals as $mom_user_externals)
													<option value="{{$mom_user_externals->nama_user_externals}}" selected="selected">{{$mom_user_externals->nama_user_externals}}</option>
												@endforeach
											@endif
										</select>
										{{General::pesanErrorForm($errors->first('nama_user_externals.*'))}}
									</div>
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
	
	<script type="text/javascript">
		jQuery(document).ready(function () {
            $('.getStartEndDateTimeEdit').daterangepicker({
                separator 	: " sampai ",
                locale: {
                    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    cancelLabel: "Batal",
                    fromLabel: "Dari",
                    toLabel: "Sampai",
                    customRangeLabel: "Pilih Sendiri",
                    daysOfWeek: [
                                    "Mi",
                                    "Se",
                                    "Se",
                                    "Ra",
                                    "Ka",
                                    "Ju",
                                    "Sa"
                                ],
                },
                ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "showDropdowns": true,
                timePicker: true,
                timePickerSeconds: true,
                timePicker12Hour: false,
                timePickerIncrement: 1,
                format      : 'DD MMM YYYY HH:mm:ss'
            });

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
									const domEditableElement = document.querySelector( '.ck-editor__editable' );
									const editorInstance = domEditableElement.ckeditorInstance;
									editorInstance.setData(data.data.deskripsi_moms);
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