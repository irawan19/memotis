@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/aktivitas_sales/prosesedit/'.$edit_aktivitas_sales->id_aktivitas_sales) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Aktivitas Sales</strong>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-col-form-label" for="kegiatan_sales_id">Kegiatan <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="kegiatan_sales_id" name="kegiatan_sales_id">
				                    	@foreach($edit_kegiatan_sales as $kegiatan_sales)
                                            @php($selected = '')
                                            @if(Request::old('kegiatan_sales_id') == '')
                                                @if($kegiatan_sales->id_kegiatan_sales == $edit_aktivitas_sales->kegiatan_sales_id)
                                                    @php($selected = 'selected')
                                                @endif
                                                @else
                                                    @if($kegiatan_sales->id_kegiatan_sales == Request::old('kegiatan_sales_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
										    <option value="{{$kegiatan_sales->id_kegiatan_sales}}" {{ $selected }}>{{$kegiatan_sales->nama_kegiatan_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('kegiatan_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="segmentasi_sales_id">Segmentasi <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="segmentasi_sales_id" name="segmentasi_sales_id">
				                    	@foreach($edit_segmentasi_sales as $segmentasi_sales)
                                            @php($selected = '')
                                            @if(Request::old('segmentasi_sales_id') == '')
                                                @if($segmentasi_sales->id_segmentasi_sales == $edit_aktivitas_sales->segmentasi_sales_id)
                                                    @php($selected = 'selected')
                                                @endif
                                                @else
                                                    @if($segmentasi_sales->id_segmentasi_sales == Request::old('segmentasi_sales_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
										    <option value="{{$segmentasi_sales->id_segmentasi_sales}}" {{ $selected }}>{{$segmentasi_sales->nama_segmentasi_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('segmentasi_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="tanggal_aktivitas_sales">Tanggal <b style="color:red">*</b></label>
									<input readonly class="form-control {{ General::validForm($errors->first('tanggal_aktivitas_sales')) }} getDate" id="tanggal_aktivitas_sales" type="text" name="tanggal_aktivitas_sales" value="{{Request::old('tanggal_aktivitas_sales') == '' ? General::ubahDBKeTanggal(date($edit_aktivitas_sales->tanggal_aktivitas_sales)) : Request::old('tanggal_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('tanggal_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="alamat_aktivitas_sales">Alamat <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('alamat_aktivitas_sales')) }}" id="alamat_aktivitas_sales" type="text" name="alamat_aktivitas_sales" value="{{Request::old('alamat_aktivitas_sales') == '' ? $edit_aktivitas_sales->alamat_aktivitas_sales : Request::old('alamat_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('alamat_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="kontak_personal_aktivitas_sales">Kontak Personal</label>
									<input class="form-control {{ General::validForm($errors->first('kontak_personal_aktivitas_sales')) }}" id="kontak_personal_aktivitas_sales" type="text" name="kontak_personal_aktivitas_sales" value="{{Request::old('kontak_personal_aktivitas_sales') == '' ? $edit_aktivitas_sales->kontak_personal_aktivitas_sales : Request::old('kontak_personal_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('kontak_personal_aktivitas_sales'))}}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-col-form-label" for="project_sales_id">Project <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="project_sales_id" name="project_sales_id">
				                    	@foreach($edit_project_sales as $project_sales)
                                            @php($selected = '')
                                            @if(Request::old('project_sales_id') == '')
                                                @if($project_sales->id_project_sales == $edit_aktivitas_sales->project_sales_id)
                                                    @php($selected = 'selected')
                                                @endif
                                                @else
                                                    @if($project_sales->id_project_sales == Request::old('project_sales_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
										    <option value="{{$project_sales->id_project_sales}}" {{ $project_sales }}>{{$project_sales->nama_project_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('project_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="status_sales_id">Status <b style="color:red">*</b></label>
				                    <select class="form-control select2" id="status_sales_id" name="status_sales_id">
				                    	@foreach($edit_status_sales as $status_sales)
                                            @php($selected = '')
                                            @if(Request::old('status_sales_id') == '')
                                                @if($status_sales->id_status_sales == $edit_aktivitas_sales->status_sales_id)
                                                    @php($selected = 'selected')
                                                @endif
                                                @else
                                                    @if($status_sales->id_status_sales == Request::old('status_sales_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
										    <option value="{{$status_sales->id_status_sales}}" {{ $status_sales }}>{{$status_sales->nama_status_sales}}</option>
				                    	@endforeach
				                    </select>
									{{General::pesanErrorForm($errors->first('status_sales_id'))}}
		                      	</div>
								<div class="form-group">
									<label class="form-col-form-label" for="nama_aktivitas_sales">Nama <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('nama_aktivitas_sales')) }}" id="nama_aktivitas_sales" type="text" name="nama_aktivitas_sales" value="{{Request::old('nama_aktivitas_sales') == '' ? $edit_aktivitas_sales->nama_aktivitas_sales : Request::old('nama_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('nama_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="pic_aktivitas_sales">PIC <b style="color:red">*</b></label>
									<input class="form-control {{ General::validForm($errors->first('pic_aktivitas_sales')) }}" id="pic_aktivitas_sales" type="text" name="pic_aktivitas_sales" value="{{Request::old('pic_aktivitas_sales') == '' ? $edit_aktivitas_sales->pic_aktivitas_sales : Request::old('pic_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('pic_aktivitas_sales'))}}
								</div>
								<div class="form-group">
									<label class="form-col-form-label" for="jangka_waktu_aktivitas_sales">Jangka Waktu</label>
									<input class="form-control {{ General::validForm($errors->first('jangka_waktu_aktivitas_sales')) }}" id="jangka_waktu_aktivitas_sales" type="text" name="jangka_waktu_aktivitas_sales" value="{{Request::old('jangka_waktu_aktivitas_sales') == '' ? $edit_aktivitas_sales->jangka_waktu_aktivitas_sales : Request::old('jangka_waktu_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('jangka_waktu_aktivitas_sales'))}}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-col-form-label" for="total_aktivitas_sales">Total <b style="color:red">*</b></label>
									<input class="form-control right-align priceformat {{ General::validForm($errors->first('total_aktivitas_sales')) }}" id="total_aktivitas_sales" type="text" name="total_aktivitas_sales" value="{{Request::old('total_aktivitas_sales') == '' ? General::ubahDBKeHarga($edit_aktivitas_sales->total_aktivitas_sales) : Request::old('total_aktivitas_sales')}}">
									{{General::pesanErrorForm($errors->first('total_aktivitas_sales'))}}
								</div>
								<div class="form-group">
                                    <label class="form-col-form-label" for="catatan_aktivitas_sales">Catatan</label>
                                    <textarea class="form-control {{ General::validForm($errors->first('catatan_aktivitas_sales')) }}" id="catatan_aktivitas_sales" name="catatan_aktivitas_sales" rows="5">{{Request::old('catatan_aktivitas_sales') == '' ? $edit_aktivitas_sales->catatan_aktivitas_sales : Request::old('catatan_aktivitas_sales')}}</textarea>
                                    {{General::pesanErrorForm($errors->first('catatan_aktivitas_sales'))}}
                                </div>
							</div>
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
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