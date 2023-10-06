@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/status_karyawan/prosesedit/'.$edit_status_karyawans->id_status_karyawans) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Status Karyawan</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_status_karyawans">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_status_karyawans')) }}" id="nama_status_karyawans" type="text" name="nama_status_karyawans" value="{{Request::old('nama_status_karyawans') == '' ? $edit_status_karyawans->nama_status_karyawans : Request::old('nama_status_karyawans')}}">
							{{General::pesanErrorForm($errors->first('nama_status_karyawans'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/status_karyawan'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection