@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/segmentasi_sales/prosesedit/'.$edit_segmentasi_sales->id_segmentasi_sales) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Segmentasi Sales</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_segmentasi_sales">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_segmentasi_sales')) }}" id="nama_segmentasi_sales" type="text" name="nama_segmentasi_sales" value="{{Request::old('nama_segmentasi_sales') == '' ? $edit_segmentasi_sales->nama_segmentasi_sales : Request::old('nama_segmentasi_sales')}}">
							{{General::pesanErrorForm($errors->first('nama_segmentasi_sales'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/segmentasi_sales'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection