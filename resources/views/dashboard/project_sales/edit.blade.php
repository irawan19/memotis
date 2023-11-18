@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/project_sales/prosesedit/'.$edit_project_sales->id_project_sales) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Project Sales</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_project_sales">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_project_sales')) }}" id="nama_project_sales" type="text" name="nama_project_sales" value="{{Request::old('nama_project_sales') == '' ? $edit_project_sales->nama_project_sales : Request::old('nama_project_sales')}}">
							{{General::pesanErrorForm($errors->first('nama_project_sales'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/project_sales'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection