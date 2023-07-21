@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/sosial_media/prosesedit/'.$edit_sosial_medias->id_sosial_medias) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Sosial Media</strong>
					</div>
					<div class="card-body">
						<input type="hidden" name="id_sosial_medias" value="{{$edit_sosial_medias->id_sosial_medias}}">
						<div class="form-group">
							<label class="form-col-form-label" for="sosial_medias">Sosial Media <b style="color:red">*</b></label>
				            <select class="form-control select2" id="sosial_medias" name="sosial_medias">
				                 @foreach($edit_list_sosial_medias as $list_sosial_medias)
				                  	@php($selected = '')
				                     @if(Request::old('sosial_medias') == '')
				                         @if($list_sosial_medias['icon'].'_'.$list_sosial_medias['nama'] == $edit_sosial_medias->icon_sosial_medias.'_'.$edit_sosial_medias->nama_sosial_medias)
				                             @php($selected = 'selected')
				                         @endif
				                     @else
				                         @if($list_sosial_medias['icon'].'_'.$list_sosial_medias['nama'] == Request::old('sosial_medias'))
				                             @php($selected = 'selected')
				                         @endif
				                     @endif
				                     <option value="{{ $list_sosial_medias['icon'].'_'.$list_sosial_medias['nama'] }}" {{ $selected }}>{{ $list_sosial_medias['nama'] }}</option>
				                 @endforeach
	                         </select>
		                </div>
						<div class="form-group">
							<label class="form-col-form-label" for="url_sosial_medias">URL <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('url_sosial_medias')) }}" id="url_sosial_medias" type="text" name="url_sosial_medias" value="{{Request::old('url_sosial_medias') == '' ? $edit_sosial_medias->url_sosial_medias : Request::old('url_sosial_medias')}}">
							{{General::pesanErrorForm($errors->first('url_sosial_medias'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/sosial_media'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

@endsection