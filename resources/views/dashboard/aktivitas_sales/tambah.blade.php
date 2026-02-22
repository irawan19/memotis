@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/aktivitas_sales/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Aktivitas Sales</strong>
					</div>
					<div class="card-body">
						<p class="text-muted small mb-3">Label form mengacu ke kolom di tabel Aktivitas Sales (COMPANY, DATE, STATUS, NETT REVENUE, PIC, CONTACT, RESULT, dll.).</p>
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="row">
							<div class="col-md-6">
								@if(Auth::user()->level_sistems_id == 1)
									<div class="form-group">
										<label class="form-col-form-label" for="users_id">USER <b style="color:red">*</b></label>
										<select class="form-control select2" id="users_id" name="users_id">
											@foreach($tambah_users as $users)
												@php($nama = $users->nama_level_sistems.' - '.$users->name)
												@if(!empty($users->id_divisis))
													@php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
												@endif
												<option value="{{$users->id}}" {{ Request::old('users_id') == $users->id ? $select='selected' : $select='' }}>{{$nama}}</option>
											@endforeach
										</select>
										{{General::pesanErrorForm($errors->first('users_id'))}}
									</div>
								@endif
								<div class="form-group">
									<label class="form-col-form-label" for="kegiatan_sales_id">SALES (Kegiatan) <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="kegiatan_sales_id" name="kegiatan_sales_id">
				                    	@foreach($tambah_kegiatan_sales as $kegiatan_sales)
										    <option value="{{$kegiatan_sales->id_kegiatan_sales}}" {{ Request::old('kegiatan_sales_id') == $kegiatan_sales->id_kegiatan_sales ? $select='selected' : $select='' }}>{{$kegiatan_sales->nama_kegiatan_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('kegiatan_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="segmentasi_sales_id">SEGMENTATION <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="segmentasi_sales_id" name="segmentasi_sales_id">
				                    	@foreach($tambah_segmentasi_sales as $segmentasi_sales)
										    <option value="{{$segmentasi_sales->id_segmentasi_sales}}" {{ Request::old('segmentasi_sales_id') == $segmentasi_sales->id_segmentasi_sales ? $select='selected' : $select='' }}>{{$segmentasi_sales->nama_segmentasi_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('segmentasi_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_aktivitas_sales">DATE (Tanggal) <b style="color:red">*</b></label>
									<input readonly class="form-control {{ General::validForm($errors->first('tanggal_aktivitas_sales')) }} getDate" id="tanggal_aktivitas_sales" type="text" name="tanggal_aktivitas_sales" value="{{Request::old('tanggal_aktivitas_sales') == '' ? General::ubahDBKeTanggal(date('Y-m-d')) : Request::old('tanggal_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('tanggal_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="alamat_aktivitas_sales">Alamat <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('alamat_aktivitas_sales')) }}" id="alamat_aktivitas_sales" type="text" name="alamat_aktivitas_sales" value="{{Request::old('alamat_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('alamat_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="kontak_personal_aktivitas_sales">CONTACT (Kontak personal)</label>
									<input class="form-control {{ General::validForm($errors->first('kontak_personal_aktivitas_sales')) }}" id="kontak_personal_aktivitas_sales" type="text" name="kontak_personal_aktivitas_sales" value="{{Request::old('kontak_personal_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('kontak_personal_aktivitas_sales'))}}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-col-form-label" for="project_sales_id">Project <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="project_sales_id" name="project_sales_id">
				                    	@foreach($tambah_project_sales as $project_sales)
										    <option value="{{$project_sales->id_project_sales}}" {{ Request::old('project_sales_id') == $project_sales->id_project_sales ? $select='selected' : $select='' }}>{{$project_sales->nama_project_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('project_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="status_sales_id">STATUS <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="status_sales_id" name="status_sales_id">
				                    	@foreach($tambah_status_sales as $status_sales)
										    <option value="{{$status_sales->id_status_sales}}" {{ Request::old('status_sales_id') == $status_sales->id_status_sales ? $select='selected' : $select='' }}>{{$status_sales->nama_status_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('status_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="nama_aktivitas_sales">COMPANY (Nama perusahaan/kegiatan) <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('nama_aktivitas_sales')) }}" id="nama_aktivitas_sales" type="text" name="nama_aktivitas_sales" value="{{Request::old('nama_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('nama_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="pic_aktivitas_sales">PIC <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('pic_aktivitas_sales')) }}" id="pic_aktivitas_sales" type="text" name="pic_aktivitas_sales" value="{{Request::old('pic_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('pic_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="jangka_waktu_aktivitas_sales">Jangka Waktu</label>
									<input class="form-control {{ General::validForm($errors->first('jangka_waktu_aktivitas_sales')) }}" id="jangka_waktu_aktivitas_sales" type="text" name="jangka_waktu_aktivitas_sales" value="{{Request::old('jangka_waktu_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('jangka_waktu_aktivitas_sales'))}}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-col-form-label" for="total_aktivitas_sales">NETT REVENUE (Total) <b style="color:red">*</b></label>
									<input class="form-control right-align priceformat {{ General::validForm($errors->first('total_aktivitas_sales')) }}" id="total_aktivitas_sales" type="text" name="total_aktivitas_sales" value="{{Request::old('total_aktivitas_sales') == '' ? General::ubahDBKeHarga(0) : Request::old('total_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('total_aktivitas_sales'))}}
								</div>
								<div class="form-group">
                                    <label class="form-col-form-label" for="catatan_aktivitas_sales">RESULT (Catatan)</label>
                                    <textarea class="form-control {{ General::validForm($errors->first('catatan_aktivitas_sales')) }}" id="catatan_aktivitas_sales" name="catatan_aktivitas_sales" rows="5">{{Request::old('catatan_aktivitas_sales')}}</textarea>
                                    {{General::pesanErrorForm($errors->first('catatan_aktivitas_sales'))}}
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
	                    	@php($ambil_kembali = URL('dashboard/aktivitas_sales'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection