@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" enctype="multipart/form-data" action="{{ URL('dashboard/karyawan/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Karyawan</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="userfile_foto_karyawan">Foto</label>
									<br/>
			                        <input id="userfile_foto_karyawan" type="file" name="userfile_foto_karyawan">
			                    </div>
								<div class="form-group">
									<label class="form-col-form-label" for="nama_karyawans">Nama <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('nama_karyawans')) }}" id="nama_karyawans" type="text" name="nama_karyawans" value="{{Request::old('nama_karyawans')}}">
									{{General::pesanErrorForm($errors->first('nama_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="jabatans_id">Jabatan <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="jabatans_id" name="jabatans_id">
				                    	@foreach($tambah_jabatans as $jabatans)
										    <option value="{{$jabatans->id_jabatans}}" {{ Request::old('jabatans_id') == $jabatans->id_jabatans ? $select='selected' : $select='' }}>{{$jabatans->nama_jabatans}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('jabatans_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="status_karyawans_id">Status Karyawan <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="status_karyawans_id" name="status_karyawans_id">
				                    	@foreach($tambah_status_karyawans as $status_karyawans)
										    <option value="{{$status_karyawans->id_status_karyawans}}" {{ Request::old('status_karyawans_id') == $status_karyawans->id_status_karyawans ? $select='selected' : $select='' }}>{{$status_karyawans->nama_status_karyawans}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('status_karyawans_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="unit_kerjas_id">Unit Kerja <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="unit_kerjas_id" name="unit_kerjas_id">
				                    	@foreach($tambah_unit_kerjas as $unit_kerjas)
										    <option value="{{$unit_kerjas->id_unit_kerjas}}" {{ Request::old('unit_kerjas_id') == $unit_kerjas->id_unit_kerjas ? $select='selected' : $select='' }}>{{$unit_kerjas->nama_unit_kerjas}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('unit_kerjas_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="lokasi_unit_kerjas">Lokasi Kerja</label>
									<textarea readonly class="form-control {{ General::validForm($errors->first('lokasi_unit_kerjas')) }}" id="lokasi_unit_kerjas" name="lokasi_unit_kerjas" rows="5">{{Request::old('lokasi_unit_kerjas')}}</textarea>
									{{General::pesanErrorForm($errors->first('lokasi_unit_kerjas'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="nik_gys_karyawans">NIK GYS</label>
									<input class="form-control {{ General::validForm($errors->first('nik_gys_karyawans')) }}" id="nik_gys_karyawans" type="text" name="nik_gys_karyawans" value="{{Request::old('nik_gys_karyawans')}}">
									{{General::pesanErrorForm($errors->first('nik_gys_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="nik_tg_karyawans">NIK TG</label>
									<input class="form-control {{ General::validForm($errors->first('nik_tg_karyawans')) }}" id="nik_tg_karyawans" type="text" name="nik_tg_karyawans" value="{{Request::old('nik_tg_karyawans')}}">
									{{General::pesanErrorForm($errors->first('nik_tg_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="band_posisi_karyawans">Band Posisi</label>
									<input class="form-control {{ General::validForm($errors->first('band_posisi_karyawans')) }}" id="band_posisi_karyawans" type="text" name="band_posisi_karyawans" value="{{Request::old('band_posisi_karyawans')}}">
									{{General::pesanErrorForm($errors->first('band_posisi_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_bergabung_karyawans">Tanggal Bergabung <b style="color:red">*</b></label>
									<input readonly class="form-control {{ General::validForm($errors->first('tanggal_bergabung_karyawans')) }} getDate" id="tanggal_bergabung_karyawans" type="text" name="tanggal_bergabung_karyawans" value="{{Request::old('tanggal_bergabung_karyawans') == '' ? General::ubahDBKeTanggal(date('Y-m-d')) : Request::old('tanggal_bergabung_karyawans')}}">
									{{General::pesanErrorForm($errors->first('tanggal_bergabung_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_keluar_karyawans">Tanggal Keluar</label>
									<div class="input-group">
										<input readonly class="form-control {{ General::validForm($errors->first('tanggal_keluar_karyawans')) }} getDate" id="tanggal_keluar_karyawans" type="text" name="tanggal_keluar_karyawans" value="{{Request::old('tanggal_keluar_karyawans')}}">
										<span class="input-group-append">
											<button class="btn btn-danger" type="button" onclick="$('#tanggal_keluar_karyawans').val('')"> Kosongkan</button>
										</span>
										{{General::pesanErrorForm($errors->first('tanggal_keluar_karyawans'))}}
									</div>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="ktp_karyawans">No Identitas (KTP) <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('ktp_karyawans')) }}" id="ktp_karyawans" type="text" name="ktp_karyawans" value="{{Request::old('ktp_karyawans')}}">
									{{General::pesanErrorForm($errors->first('ktp_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="npwp_karyawans">Nomor NPWP</label>
									<input class="form-control {{ General::validForm($errors->first('npwp_karyawans')) }}" id="npwp_karyawans" type="text" name="npwp_karyawans" value="{{Request::old('npwp_karyawans')}}">
									{{General::pesanErrorForm($errors->first('npwp_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="email_karyawans">Email</label>
									<input class="form-control {{ General::validForm($errors->first('email_karyawans')) }}" id="email_karyawans" type="email" name="email_karyawans" value="{{Request::old('email_karyawans')}}">
									{{General::pesanErrorForm($errors->first('email_karyawans'))}}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_lahir_karyawans">Tanggal Lahir</label>
									<div class="input-group">
										<input readonly class="form-control {{ General::validForm($errors->first('tanggal_lahir_karyawans')) }} getDate" id="tanggal_lahir_karyawans" type="text" name="tanggal_lahir_karyawans" value="{{Request::old('tanggal_lahir_karyawans')}}">
										<span class="input-group-append">
											<button class="btn btn-danger" type="button" onclick="$('#tanggal_lahir_karyawans').val('')"> Kosongkan</button>
										</span>
										{{General::pesanErrorForm($errors->first('tanggal_lahir_karyawans'))}}
									</div>
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tempat_lahir_karyawans">Tempat Lahir</label>
									<input class="form-control {{ General::validForm($errors->first('tempat_lahir_karyawans')) }}" id="tempat_lahir_karyawans" type="text" name="tempat_lahir_karyawans" value="{{Request::old('tempat_lahir_karyawans')}}">
									{{General::pesanErrorForm($errors->first('tempat_lahir_karyawans'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="jenis_kelamins_id">Jenis Kelamin <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="jenis_kelamins_id" name="jenis_kelamins_id">
				                    	@foreach($tambah_jenis_kelamins as $jenis_kelamins)
										    <option value="{{$jenis_kelamins->id_jenis_kelamins}}" {{ Request::old('jenis_kelamins_id') == $jenis_kelamins->id_jenis_kelamins ? $select='selected' : $select='' }}>{{$jenis_kelamins->nama_jenis_kelamins}}</option>
				                    	@endforeach
				                    </select>
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="agamas_id">Agama <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="agamas_id" name="agamas_id">
				                    	@foreach($tambah_agamas as $agamas)
										    <option value="{{$agamas->id_agamas}}" {{ Request::old('agamas_id') == $agamas->id_agamas ? $select='selected' : $select='' }}>{{$agamas->nama_agamas}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('agamas_id'))}}
		                      	</div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="alamat_domisili_karyawans">Alamat Domisili</label>
                                    <textarea class="form-control {{ General::validForm($errors->first('alamat_domisili_karyawans')) }}" id="alamat_domisili_karyawans" name="alamat_domisili_karyawans" rows="5">{{Request::old('alamat_domisili_karyawans')}}</textarea>
                                    {{General::pesanErrorForm($errors->first('alamat_domisili_karyawans'))}}
                                </div>
								<div class="form-group">
									<label class="form-col-form-label" for="status_kawins_id">Status Kawin <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="status_kawins_id" name="status_kawins_id">
				                    	@foreach($tambah_status_kawins as $status_kawins)
										    <option value="{{$status_kawins->id_status_kawins}}" {{ Request::old('status_kawins_id') == $status_kawins->id_status_kawins ? $select='selected' : $select='' }}>{{$status_kawins->nama_status_kawins}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('status_kawins_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="pendidikans_id">Pendidikan <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="pendidikans_id" name="pendidikans_id">
				                    	@foreach($tambah_pendidikans as $pendidikans)
										    <option value="{{$pendidikans->id_pendidikans}}" {{ Request::old('pendidikans_id') == $pendidikans->id_pendidikans ? $select='selected' : $select='' }}>{{$pendidikans->nama_pendidikans}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('pendidikans_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="institusi_karyawans">Nama Institusi</label>
									<input class="form-control {{ General::validForm($errors->first('institusi_karyawans')) }}" id="institusi_karyawans" type="text" name="institusi_karyawans" value="{{Request::old('institusi_karyawans')}}">
									{{General::pesanErrorForm($errors->first('institusi_karyawans'))}}
								</div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="hobi_karyawans">Hobi</label>
                                    <textarea class="form-control {{ General::validForm($errors->first('hobi_karyawans')) }}" id="hobi_karyawans" name="hobi_karyawans" rows="5">{{Request::old('hobi_karyawans')}}</textarea>
                                    {{General::pesanErrorForm($errors->first('hobi_karyawans'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="keahlian_khusus_karyawans">Keahlian Khusus</label>
                                    <textarea class="form-control {{ General::validForm($errors->first('keahlian_khusus_karyawans')) }}" id="keahlian_khusus_karyawans" name="keahlian_khusus_karyawans" rows="5">{{Request::old('keahlian_khusus_karyawans')}}</textarea>
                                    {{General::pesanErrorForm($errors->first('keahlian_khusus_karyawans'))}}
                                </div>
								<div class="form-group">
									<label class="form-col-form-label" for="no_hp_karyawans">No HP</label>
									<input class="form-control {{ General::validForm($errors->first('no_hp_karyawans')) }}" id="no_hp_karyawans" type="text" name="no_hp_karyawans" value="{{Request::old('no_hp_karyawans')}}">
									{{General::pesanErrorForm($errors->first('no_hp_karyawans'))}}
								</div>
							</div>
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::simpan()}}
						{{General::simpankembali()}}
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

	<script type="text/javascript">
        $(document).ready(function(){
			var idunitkerja = $(this).find(':selected').val();
			var headerRequest = {
							'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
						};
			$.ajax({
					url: '{{URL("dashboard/unit_kerja/lokasi")}}/'+idunitkerja,
					type: "GET",
					dataType: 'JSON',
					headers: headerRequest,
					success: function(data)
					{
						$('#lokasi_unit_kerjas').val(data);
					},
					error: function(data) {
						console.log(data);
					}
			});

            $('#unit_kerjas_id').on('change',function(){
				var idunitkerja = $(this).find(':selected').val();
				var headerRequest = {
								'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
							};
				$.ajax({
						url: '{{URL("dashboard/unit_kerja/lokasi")}}/'+idunitkerja,
						type: "GET",
						dataType: 'JSON',
						headers: headerRequest,
						success: function(data)
						{
							$('#lokasi_unit_kerjas').val(data);
						},
						error: function(data) {
							console.log(data);
						}
				});

            });
        });
    </script>

@endsection