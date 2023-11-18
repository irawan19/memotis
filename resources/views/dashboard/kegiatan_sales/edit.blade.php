@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/kegiatan_sales/prosesedit/'.$edit_kegiatan_sales->id_kegiatan_sales) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Kegiatan Sales</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_kegiatan_sales">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_kegiatan_sales')) }}" id="nama_kegiatan_sales" type="text" name="nama_kegiatan_sales" value="{{Request::old('nama_kegiatan_sales') == '' ? $edit_kegiatan_sales->nama_kegiatan_sales : Request::old('nama_kegiatan_sales')}}">
							{{General::pesanErrorForm($errors->first('nama_kegiatan_sales'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/kegiatan_sales'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection