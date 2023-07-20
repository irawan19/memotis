@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/disposisi_surat/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Disposisi Surat</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="nama_disposisi_surats">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_disposisi_surats')) }}" id="nama_disposisi_surats" type="text" name="nama_disposisi_surats" value="{{Request::old('nama_disposisi_surats')}}">
							{{General::pesanErrorForm($errors->first('nama_disposisi_surats'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::simpan()}}
						{{General::simpankembali()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/disposisi_surat'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection