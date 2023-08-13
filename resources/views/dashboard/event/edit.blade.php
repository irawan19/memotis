@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/event/prosesedit/'.$edit_events->id_events) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Edit Event</strong>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-col-form-label" for="tanggal_events">Tanggal <b style="color:red">*</b></label>
                            @php($tanggal_events = General::ubahDBkeTanggalwaktu($edit_events->mulai_events).' sampai '.General::ubahDBkeTanggalwaktu($edit_events->selesai_events))
							<input readonly class="form-control {{ General::validForm($errors->first('tanggal_events')) }} getStartEndDateTimeEdit" id="tanggal_events" type="text" name="tanggal_events" value="{{Request::old('tanggal_events') == '' ? $tanggal_events : Request::old('tanggal_events')}}">
							{{General::pesanErrorForm($errors->first('tanggal_events'))}}
						</div>
						<div class="form-group">
							<label class="form-col-form-label" for="nama_events">Nama <b style="color:red">*</b></label>
							<input class="form-control {{ General::validForm($errors->first('nama_events')) }}" id="nama_events" type="text" name="nama_events" value="{{Request::old('nama_events') == '' ? $edit_events->nama_events : Request::old('nama_events')}}">
							{{General::pesanErrorForm($errors->first('nama_events'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::perbarui()}}
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

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('.getStartEndDateTimeEdit').daterangepicker({
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
                timePicker: true,
                timePickerSeconds: true,
                timePicker12Hour: false,
                timePickerIncrement: 1,
                format      : 'DD MMM YYYY HH:mm:ss'
            });
        });
    </script>

@endsection