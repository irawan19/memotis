@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/derajat_surat/prosesedit/'.$edit_derajat_surats->id_derajat_surats) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Derajat Surat</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_derajat_surats">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_derajat_surats')) }}" id="nama_derajat_surats" type="text" name="nama_derajat_surats" value="{{Request::old('nama_derajat_surats') == '' ? $edit_derajat_surats->nama_derajat_surats : Request::old('nama_derajat_surats')}}">
							{{General::pesanErrorForm($errors->first('nama_derajat_surats'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/derajat_surat'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection