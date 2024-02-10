@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/surat/prosesedit/'.$edit_surats->id_surats) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Surat</strong>
					</div>
					<div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="no_asal_surats">No Asal Surat</label>
                                        <input class="form-control {{ General::validForm($errors->first('no_asal_surats')) }}" id="no_asal_surats" type="text" name="no_asal_surats" value="{{Request::old('no_asal_surats') == '' ? $edit_surats->no_asal_surats : Request::old('no_asal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('no_asal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="tanggal_asal_surats">Tanggal Asal Surat</label>
                                        <div class="input-group">
                                            @php($tanggal_asal_surats = '')
                                            @if(!empty($edit_surats->tanggal_asal_surats))
                                                @php($tanggal_asal_surats = General::ubahDBKeTanggal($edit_surats->tanggal_asal_surats))
                                            @endif
                                            <input readonly class="form-control {{ General::validForm($errors->first('tanggal_asal_surats')) }} getDate" id="tanggal_asal_surats" type="text" name="tanggal_asal_surats" value="{{Request::old('tanggal_asal_surats') == '' ? $tanggal_asal_surats : Request::old('tanggal_asal_surats')}}">
                                            <span class="input-group-append">
                                                <button class="btn btn-danger" type="button" onclick="$('#tanggal_asal_surats').val('')"> Kosongkan</button>
                                            </span>
                                            {{General::pesanErrorForm($errors->first('tanggal_asal_surats'))}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="asal_surats">Asal Surat</label>
                                        <input class="form-control {{ General::validForm($errors->first('asal_surats')) }}" id="asal_surats" type="text" name="asal_surats" value="{{Request::old('asal_surats') == '' ? $edit_surats->asal_surats : Request::old('asal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('asal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="perihal_surats">Perihal Surat <b style="color:red">*</b></label>
                                        <input class="form-control {{ General::validForm($errors->first('perihal_surats')) }}" id="perihal_surats" type="text" name="perihal_surats" value="{{Request::old('perihal_surats') == '' ? $edit_surats->perihal_surats : Request::old('perihal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('perihal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="judul_surats">Judul <b style="color:red">*</b></label>
                                        <input class="form-control {{ General::validForm($errors->first('judul_surats')) }}" id="judul_surats" type="text" name="judul_surats" value="{{Request::old('judul_surats') == '' ? $edit_surats->judul_surats : Request::old('judul_surats')}}">
                                        {{General::pesanErrorForm($errors->first('judul_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="ringkasan_surats">Ringkasan <b style="color:red">*</b></label>
                                        <textarea class="form-control {{ General::validForm($errors->first('ringkasan_surats')) }}" id="editor1" name="ringkasan_surats" rows="5">{{Request::old('ringkasan_surats') == '' ? $edit_surats->ringkasan_surats : Request::old('ringkasan_surats')}}</textarea>
                                        {{General::pesanErrorForm($errors->first('ringkasan_surats'))}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="klasifikasi_surats_id">Klasifikasi <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="klasifikasi_surats_id" name="klasifikasi_surats_id">
                                            @foreach($edit_klasifikasi_surats as $klasifikasi_surats)
                                                @php($selected = '')
                                                @if(Request::old('klasifikasi_surats_id') == '')
                                                    @if($klasifikasi_surats->id_lasifikasi_surats == $edit_surats->klasifikasi_surats_id)
                                                        @php($selected = 'selected')
                                                    @endif
                                                @else
                                                    @if($klasifikasi_surats->id_lasifikasi_surats == Request::old('klasifikasi_surats_id'))
                                                        @php($selected = 'selected')
                                                    @endif
                                                @endif
                                                <option value="{{$klasifikasi_surats->id_klasifikasi_surats}}" {{ $selected }}>{{$klasifikasi_surats->nama_klasifikasi_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('klasifikasi_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="derajat_surats_id">Derajat <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="derajat_surats_id" name="derajat_surats_id">
                                            @foreach($edit_derajat_surats as $derajat_surats)
                                                @php($selected = '')
                                                @if(Request::old('derajat_surats_id') == '')
                                                    @if($derajat_surats->id_derajat_surats == $edit_surats->derajat_surats_id)
                                                        @php($selected = 'selected')
                                                    @endif
                                                @else
                                                    @if($derajat_surats->id_derajat_surats == Request::old('derajat_surats_id'))
                                                        @php($selected = 'selected')
                                                    @endif
                                                @endif
                                                <option value="{{$derajat_surats->id_derajat_surats}}" {{ $selected }}>{{$derajat_surats->nama_derajat_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('derajat_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="sifat_surats_id">Sifat <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="sifat_surats_id" name="sifat_surats_id">
                                            @foreach($edit_sifat_surats as $sifat_surats)
                                                @php($selected = '')
                                                @if(Request::old('sifat_surats_id') == '')
                                                    @if($sifat_surats->id_sifat_surats == $edit_surats->sifat_surats_id)
                                                        @php($selected = 'selected')
                                                    @endif
                                                @else
                                                    @if($sifat_surats->id_sifat_surats == Request::old('sifat_surats_id'))
                                                        @php($selected = 'selected')
                                                    @endif
                                                @endif
                                                <option value="{{$sifat_surats->id_sifat_surats}}" {{ $selected }}>{{$sifat_surats->nama_sifat_surats}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('sifat_surats_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="users_id">Ditujukan Kepada <b style="color:red">*</b></label>
                                        <select class="form-control select2" id="users_id" name="users_id">
                                            <option value="" selected disabled="disabled">Silahkan pilih</option>
                                            @foreach($edit_users as $users)
                                                @php($selected = '')
                                                @if(Request::old('users_id') == '')
                                                    @php($ambil_surat_users = \App\Models\Surat_user::where('surats_id',$edit_surats->id_surats)
                                                                                                    ->orderBy('id_surat_users','asc')
                                                                                                    ->first())
                                                    @if($users->id == $ambil_surat_users->users_id)
                                                        @php($selected = 'selected')
                                                    @endif
                                                @else
                                                    @if($users->id == Request::old('users_id'))
                                                        @php($selected = 'selected')
                                                    @endif
                                                @endif
                                                @php($nama = $users->nama_level_sistems.' - '.$users->name)
                                                @if(!empty($users->id_divisis))
                                                    @php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
                                                @endif
                                                <option value="{{$users->id}}" {{ $selected }}>{{$nama}}</option>
                                            @endforeach
                                        </select>
                                        {{General::pesanErrorForm($errors->first('users_id'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="tanggal_surats">Tanggal <b style="color:red">*</b></label>
                                        <input readonly class="form-control getStartEndDateEdit {{ General::validForm($errors->first('tanggal_surats')) }}" id="tanggal_surats" type="text" name="tanggal_surats" value="{{Request::old('tanggal_surats') == '' ? General::ubahDBKeTanggal($edit_surats->tanggal_mulai_surats).' sampai '.General::ubahDBKeTanggal($edit_surats->tanggal_selesai_surats) : Request::old('tanggal_surats')}}">
                                        {{General::pesanErrorForm($errors->first('tanggal_surats'))}}
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="status_agendakan_surats">Agendakan <b style="color:red">*</b></label>
                                        <br/>
                                        @if($edit_surats->status_agendakan_surats == 0)
                                            @php($checked_ya    = '')
                                            @php($checked_tidak = 'checked')
                                        @else
                                            @php($checked_ya    = 'checked')
                                            @php($checked_tidak = '')
                                        @endif
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_agendakan_surats" id="inlineRadio1" value="1" {{$checked_ya}}>
                                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_agendakan_surats" id="inlineRadio2" value="0" {{$checked_tidak}}>
                                            <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="keterangan_surats">Keterangan <b style="color:red">*</b></label>
                                        <textarea class="form-control {{ General::validForm($errors->first('keterangan_surats')) }}" id="keterangan_surats" name="keterangan_surats" rows="5">{{Request::old('keterangan_surats') == '' ? $edit_surats->keterangan_surats : Request::old('keterangan_surats')}}</textarea>
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
                                        <div class="dz-message" data-dz-message><span>Klik / drag and drop untuk upload lampiran (maks 512MB)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
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
            maxFilesize: 512, // MB
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
                } else if(uploadedDocumentMap[file.name] !== undefined) {
                    name = uploadedDocumentMap[file.name]
                }
                else {
                    name = uploadedDocumentMap['file.name']
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
                myDropzone = this;
                var files = {!! $edit_surat_lampirans !!}
                $.each(files, function (key, value) {
                    var mockFile = { name: value.nama_file_surat_lampirans, size: value.ukuran_file_surat_lampirans};
                    let callback = null;
                    let crossOrigin = null;
                    let resizeThumbnail = true;
                    if (value.tipe_file_surat_lampirans === 'png' || value.tipe_file_surat_lampirans === 'jpg' || value.tipe_file_surat_lampirans === 'jpeg' || value.tipe_file_surat_lampirans === 'svg')
                    {
                        var thumbnail = "{{URL::asset('storage')}}/"+value.file_surat_lampirans;
                    }
                    else
                    {
                        var thumbnail = "{{URL::asset('template/back/assets/img/file.png')}}";
                    }
                    myDropzone.displayExistingFile(mockFile, thumbnail, callback, crossOrigin, resizeThumbnail);
                    var file = files
                    $('.formdropzone').append('<input type="hidden" name="lampiran[]" value="' + value.nama_file_surat_lampirans + '-/-'+value.ukuran_file_surat_lampirans + '-/-' + value.tipe_file_surat_lampirans +'">')
                    uploadedDocumentMap['file.name'] = value.nama_file_surat_lampirans+'-/-'+value.ukuran_file_surat_lampirans+'-/-'+value.tipe_file_surat_lampirans
                });
            }
        }

        jQuery(document).ready(function () {
            $('.getStartEndDateEdit').daterangepicker({
                separator 	: " sampai ",
                locale: {
                    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    cancelLabel: "Batal",
                    fromLabel: "Dari",
                    toLabel: "Sampai",
                    customRangeLabel: "Pilih Sendiri",
                    daysOfWeek: [
                                    "Mi",
                                    "Se",
                                    "Se",
                                    "Ra",
                                    "Ka",
                                    "Ju",
                                    "Sa"
                                ],
                },
                ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "showDropdowns": true,
                timePicker: false,
                timePickerSeconds: false,
                timePicker12Hour: false,
                timePickerIncrement: 1,
                format      : 'DD MMM YYYY'
            });
        });
    </script>

@endsection