@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/unit_kerja/prosesedit/'.$edit_unit_kerjas->id_unit_kerjas) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Unit Kerja</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_unit_kerjas">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_unit_kerjas')) }}" id="nama_unit_kerjas" type="text" name="nama_unit_kerjas" value="{{Request::old('nama_unit_kerjas') == '' ? $edit_unit_kerjas->nama_unit_kerjas : Request::old('nama_unit_kerjas')}}">
							{{General::pesanErrorForm($errors->first('nama_unit_kerjas'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/unit_kerja'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection