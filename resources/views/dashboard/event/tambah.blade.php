@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/event/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Event</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
						<div class="form-group">
							<label class="form-col-form-label" for="tanggal_events">Tanggal <b style="color:red">*</b></label>
							<input readonly class="form-control {{ General::validForm($errors->first('tanggal_events')) }} getStartEndDateTime" id="tanggal_events" type="text" name="tanggal_events" value="{{Request::old('tanggal_events')}}">
							{{General::pesanErrorForm($errors->first('tanggal_events'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="nama_events">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_events')) }}" id="nama_events" type="text" name="nama_events" value="{{Request::old('nama_events')}}">
							{{General::pesanErrorForm($errors->first('nama_events'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::simpan()}}
						{{General::simpankembali()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/event'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection