@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/status_sales/prosesedit/'.$edit_status_sales->id_status_sales) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Status Sales</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_status_sales">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_status_sales')) }}" id="nama_status_sales" type="text" name="nama_status_sales" value="{{Request::old('nama_status_sales') == '' ? $edit_status_sales->nama_status_sales : Request::old('nama_status_sales')}}">
							{{General::pesanErrorForm($errors->first('nama_status_sales'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/status_sales'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection