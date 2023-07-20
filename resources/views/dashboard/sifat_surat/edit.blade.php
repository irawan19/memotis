@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/sifat_surat/prosesedit/'.$edit_sifat_surats->id_sifat_surats) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Sifat Surat</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="nama_sifat_surats">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_sifat_surats')) }}" id="nama_sifat_surats" type="text" name="nama_sifat_surats" value="{{Request::old('nama_sifat_surats') == '' ? $edit_sifat_surats->nama_sifat_surats : Request::old('nama_sifat_surats')}}">
							{{General::pesanErrorForm($errors->first('nama_sifat_surats'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/sifat_surat'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection