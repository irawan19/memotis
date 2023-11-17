@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/status_tugas/prosesedit/'.$edit_status_tugas->id_status_tugas) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Status Tugas</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_status_tugas">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_status_tugas')) }}" id="nama_status_tugas" type="text" name="nama_status_tugas" value="{{Request::old('nama_status_tugas') == '' ? $edit_status_tugas->nama_status_tugas : Request::old('nama_status_tugas')}}">
							{{General::pesanErrorForm($errors->first('nama_status_tugas'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/status_tugas'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection