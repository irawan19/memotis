@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/klasifikasi_surat/prosesedit/'.$edit_klasifikasi_surats->id_klasifikasi_surats) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Klasifikasi Surat</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_klasifikasi_surats">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_klasifikasi_surats')) }}" id="nama_klasifikasi_surats" type="text" name="nama_klasifikasi_surats" value="{{Request::old('nama_klasifikasi_surats') == '' ? $edit_klasifikasi_surats->nama_klasifikasi_surats : Request::old('nama_klasifikasi_surats')}}">
							{{General::pesanErrorForm($errors->first('nama_klasifikasi_surats'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/klasifikasi_surat'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection