@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/divisi/prosesedit/'.$edit_divisis->id_divisis) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Divisi</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_divisis">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_divisis')) }}" id="nama_divisis" type="text" name="nama_divisis" value="{{Request::old('nama_divisis') == '' ? $edit_divisis->nama_divisis : Request::old('nama_divisis')}}">
							{{General::pesanErrorForm($errors->first('nama_divisis'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/divisi'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection