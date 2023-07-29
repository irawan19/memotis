@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/surat/prosestambah') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Buat Surat</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="no_asal_surats">No Asal Surat</label>
                                        <input class="form-control {{ General::validForm($errors->first('no_asal_surats')) }}" id="no_asal_surats" type="text" name="no_asal_surats" value="{{Request::old('no_asal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('no_asal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="tanggal_asal_surats">Tanggal Asal Surat</label>
                                        <input class="form-control getDate {{ General::validForm($errors->first('tanggal_asal_surats')) }}" id="tanggal_asal_surats" type="text" name="tanggal_asal_surats" value="{{Request::old('tanggal_asal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('tanggal_asal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="asal_surats">Asal Surat</label>
                                        <input class="form-control {{ General::validForm($errors->first('asal_surats')) }}" id="asal_surats" type="text" name="asal_surats" value="{{Request::old('asal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('asal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="perihal_surats">Perihal Surat <b style="color:red">*</b></label>
                                        <input class="form-control {{ General::validForm($errors->first('perihal_surats')) }}" id="perihal_surats" type="text" name="perihal_surats" value="{{Request::old('perihal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('perihal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="judul_surats">Judul <b style="color:red">*</b></label>
                                        <input class="form-control {{ General::validForm($errors->first('judul_surats')) }}" id="judul_surats" type="text" name="judul_surats" value="{{Request::old('judul_surats')}}">
                                        {{General::pesanErrorForm($errors->first('judul_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="ringkasan_surats">Ringkasan <b style="color:red">*</b></label>
                                        <textarea class="form-control {{ General::validForm($errors->first('ringkasan_surats')) }}" id="editor1" name="ringkasan_surats" rows="5">{{Request::old('ringkasan_surats')}}</textarea>
                                        {{General::pesanErrorForm($errors->first('ringkasan_surats'))}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="klasifikasi_surats_id">Klasifikasi <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="klasifikasi_surats_id" name="klasifikasi_surats_id">
                                            @foreach($tambah_klasifikasi_surats as $klasifikasi_surats)
                                                <option value="{{$klasifikasi_surats->id_klasifikasi_surats}}" {{ Request::old('klasifikasi_surats_id') == $klasifikasi_surats->id_klasifikasi_surats ? $select='selected' : $select='' }}>{{$klasifikasi_surats->nama_klasifikasi_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('klasifikasi_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="derajat_surats_id">Derajat <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="derajat_surats_id" name="derajat_surats_id">
                                            @foreach($tambah_derajat_surats as $derajat_surats)
                                                <option value="{{$derajat_surats->id_derajat_surats}}" {{ Request::old('derajat_surats_id') == $derajat_surats->id_derajat_surats ? $select='selected' : $select='' }}>{{$derajat_surats->nama_derajat_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('derajat_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="sifat_surats_id">Sifat <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="sifat_surats_id" name="sifat_surats_id">
                                            @foreach($tambah_sifat_surats as $sifat_surats)
                                                <option value="{{$sifat_surats->id_sifat_surats}}" {{ Request::old('sifat_surats_id') == $sifat_surats->id_sifat_surats ? $select='selected' : $select='' }}>{{$sifat_surats->nama_sifat_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('sifat_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="users_id">Ditujukan Kepada <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="users_id" name="users_id">
                                            <option value="" selected disabled="disabled">Silahkan pilih</option>
                                            @foreach($tambah_users as $users)
                                                <option value="{{$users->id}}" {{ Request::old('users_id') == $users->id ? $select='selected' : $select='' }}>{{$users->name}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('users_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="tanggal_surats">Tanggal</label>
                                        <input class="form-control getStartEndDate {{ General::validForm($errors->first('tanggal_surats')) }}" id="tanggal_surats" type="text" name="tanggal_surats" value="{{Request::old('tanggal_surats') == '' ? General::ubahDBKeTanggal(date('Y-m-d')).' sampai '.General::ubahDBKeTanggal(date('Y-m-d')) : Request::old('tanggal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('tanggal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="status_agendakan_surats">Agendakan <b style="color:red">*</b></label>
                                        <br/>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_agendakan_surats" id="inlineRadio1" value="1">
                                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_agendakan_surats" id="inlineRadio2" value="0" checked>
                                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="keterangan_surats">Keterangan <b style="color:red">*</b></label>
                                        <textarea class="form-control {{ General::validForm($errors->first('keterangan_surats')) }}" id="keterangan_surats" name="keterangan_surats" rows="5">{{Request::old('keterangan_surats')}}</textarea>
                                        {{General::pesanErrorForm($errors->first('keterangan_surats'))}}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr/>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group formdropzone">
                                        <label for="lampiran">Lampiran</label>
                                        <div class="needsclick dropzone" id="lampiran-dropzone">
                                        <div class="dz-message" data-dz-message><span>Klik / drag and drop untuk upload lampiran</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
			        <div class="card-footer right-align">
						{{General::kirim()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/surat'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>
	</div>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.lampiranDropzone = {
            url: "{{ url('dashboard/surat/lampiran/upload') }}",
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            type:"POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('.formdropzone').append('<input type="hidden" name="lampiran[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $.ajax({
                    url: "{{ url('dashboard/surat/lampiran/hapus') }}",
                    data: {'file' : name },
				    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
				    dataType: 'JSON',
				    success: function(data)
				    {
                        $('.formdropzone').find('input[name="lampiran[]"][value="' + name + '"]').remove();
				    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            },
            init: function () {
            @if(isset($project) && $project->lampiran)
                var files =
                {!! json_encode($project->lampiran) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('formdropzone').append('<input type="hidden" name="lampiran[]" value="' + file.file_name + '">')
                }
            @endif
            }
        }
    </script>

@endsection