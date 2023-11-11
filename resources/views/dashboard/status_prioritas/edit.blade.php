@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/status_prioritas/prosesedit/'.$edit_status_prioritas->id_status_prioritas) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Status Prioritas</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_status_prioritas">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_status_prioritas')) }}" id="nama_status_prioritas" type="text" name="nama_status_prioritas" value="{{Request::old('nama_status_prioritas') == '' ? $edit_status_prioritas->nama_status_prioritas : Request::old('nama_status_prioritas')}}">
							{{General::pesanErrorForm($errors->first('nama_status_prioritas'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/status_prioritas'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection