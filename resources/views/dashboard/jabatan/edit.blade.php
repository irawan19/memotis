@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/jabatan/prosesedit/'.$edit_jabatans->id_jabatans) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Jabatan</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_jabatans">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_jabatans')) }}" id="nama_jabatans" type="text" name="nama_jabatans" value="{{Request::old('nama_jabatans') == '' ? $edit_jabatans->nama_jabatans : Request::old('nama_jabatans')}}">
							{{General::pesanErrorForm($errors->first('nama_jabatans'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/jabatan'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection