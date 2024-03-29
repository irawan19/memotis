@php($ambil_konfigurasi_aplikasis = \App\Models\Master_konfigurasi_aplikasi::first())
<!DOCTYPE html>
<html lang="en">

<head>
	<base href="./">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta name="description" content="{{$ambil_konfigurasi_aplikasis->deskripsi_konfigurasi_aplikasis}}">
	<meta name="author" content="{{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}">
	<meta name="keyword" content="{{$ambil_konfigurasi_aplikasis->keywords_konfigurasi_aplikasis}}">
	<title>Dashboard {{$ambil_konfigurasi_aplikasis->nama_konfigurasi_aplikasis}}</title>
	<link href="{{URL::asset('template/back/vendors/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/css/style.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/vendors/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet">
	<link rel="icon" type="image/png" href="{{URL::asset('storage/'.$ambil_konfigurasi_aplikasis->icon_konfigurasi_aplikasis)}}" sizes="any" />
	<link rel="stylesheet" href="{{URL::asset('template/back/vendors/fancybox/jquery.fancybox.min.css')}}" />
	<link rel="stylesheet" href="{{URL::asset('template/back/vendors/sweetalert2/dist/sweetalert2.min.css')}}" />
	<link type="text/css" media="screen" rel="stylesheet" href="{{ URL::asset('template/back/vendors/jqueryui/jquery-ui.css')}}" />
	<link type="text/css" media="screen" rel="stylesheet" href="{{{ URL::asset('template/back/vendors/daterangepicker/daterangepicker.css')}}}" />
	<link type="text/css" media="screen" rel="stylesheet" src="{{ URL::asset('template/back/vendors/datetimepicker/bootstrap-datetimepicker.min.css') }}"></link>
	<link type="text/css" media="screen" rel="stylesheet" href="{{{ URL::asset('template/back/vendors/select2/dist/css/select2.min.css')}}}" />
	<link type="text/css" media="screen" rel="stylesheet" href="{{ URL::asset('template/back/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" />
	<link href="{{URL::asset('template/back/vendors/@coreui/icons/css/free.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/vendors/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('template/back/vendors/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css" />
	<meta name="_token" content="{{ csrf_token() }}">
	<script src="{{URL::asset('template/back/vendors/jquery/js/jquery.min.js')}}"></script>
	<link href="{{URL::asset('template/back/css/custom.css')}}" rel="stylesheet">
    <script type="text/javascript">
        jQuery(document).ready(function () {
            //Select2
                $('.select2').select2({
                    width: '100%',
                });

			//Creation
				$(".select2creation").select2({
					tags: true
				});
        });
    </script>
</head>

<body class="c-app">
	@include('dashboard.layouts.sidebar')
	<div class="c-wrapper">
		<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
			@include('dashboard.layouts.header')
		</header>
		<div class="c-body">
			<main class="c-main">
				<div class="container-fluid">
					<div class="fade-in">@yield('content')</div>
				</div>
			</main>
		</div>
		@include('dashboard.layouts.footer')
	</div>
	<script src="{{ URL::asset('template/back/vendors/jqueryui/jquery-ui.js') }}"></script>
	<script src="{{URL::asset('template/back/vendors/pace-progress/js/pace.min.js')}}"></script>
	<script src="{{URL::asset('template/back/vendors/@coreui/coreui-pro/js/coreui.bundle.min.js')}}"></script>
	<script src="{{URL::asset('template/back/vendors/fancybox/jquery.fancybox.min.js')}}"></script>
	<script src="{{URL::asset('template/back/vendors/sweetalert2/dist/sweetalert2.min.js')}}"></script>
	<script src="{{URL::asset('template/back/vendors/sweetalert2/sweet-alert.init.js')}}"></script>
	<script src="{{ URL::asset('template/back/vendors/price/jquery.price.js') }}"></script>
	<script type="text/javascript" src="{{{ URL::asset('template/back/vendors/daterangepicker/moment.js')}}}"></script>
	<script type="text/javascript" src="{{{ URL::asset('template/back/vendors/daterangepicker/daterangepicker.js')}}}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/select2/dist/js/select2.full.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/ckeditor/ckeditor.js') }} "></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{URL::asset('template/back/js/tooltips.js')}}"></script>
	<script src="{{URL::asset('template/back/js/datatables.js')}}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/chained/jquery.chained.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('template/back/vendors/mousewheel/jquery.mousewheel.min.js') }}"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
	<script src="{{URL::asset('template/back/vendors/smoothproducts/js/smoothproducts.min.js')}}"></script>
	<script type="text/javascript">
		$(function() {
		   	$(".scrolltable").mousewheel(function(event, delta) {
		    	this.scrollLeft -= (delta * 30);
		    	event.preventDefault();
		   	});
		});
	    jQuery(document).ready(function () {
			//Smooth Products
				$('.sp-wrap').smoothproducts();
				
	        //Number
	            $('.number_form').keyup(function () {
	                this.value = this.value.replace(/[^0-9\.]/g, '');
	            });

	        //Price
	            $('.priceformat').priceFormat({
	                clearPrefix: true,
		        	allowNegative: true,
	            });

	        //Daterangepicker
		   		var dateNowRange = new Date();
	       		$('.getStartEndDate').daterangepicker({
	       		    startDate   : dateNowRange,
	       		    endDate     : dateNowRange,
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
	       		       'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
	       		    },
	       		    "showDropdowns": true,
	       		    timePicker: false,
	       		    timePickerSeconds: false,
	       		    timePicker12Hour: false,
	       		    timePickerIncrement: 1,
	       		    format      : 'DD MMM YYYY'
	       		});

	       		var dateNowRange = new Date();
	       		$('.getStartEndDateTime').daterangepicker({
	       		    startDate   : dateNowRange,
	       		    endDate     : dateNowRange,
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

				$('.getStartEndDateMonthYear').daterangepicker({
	       		    startDate   : dateNowRange,
	       		    endDate     : dateNowRange,
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
	       		    "showDropdowns": true,
	       		    timePicker: false,
	       		    timePickerSeconds: false,
	       		    timePicker12Hour: false,
	       		    timePickerIncrement: 1,
	       		    format      : 'MMM YYYY'
	       		}).on('hide.daterangepicker', function (ev, picker) {
					$('.table-condensed tbody tr:nth-child(2) td').click();
				});

	        //Datepicker
	            $('.getDate').datepicker({
	                dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
	            	dayNamesMin: ['Mi', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
	            	dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
	            	monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
	            	dateFormat: "dd M yy",
	            	changeMonth: true,
	            	changeYear: true,
	            });

	            $('.getDateTime').datetimepicker({
	                dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
	            	dayNamesMin: ['Mi', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
	            	dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
	            	monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
	            	dateFormat: "dd M yy",
					timeFormat: "HH:mm:ss",
	            	changeMonth: true,
	            	changeYear: true,
					enableTime: true,
	            });

	            $('.getYear').datepicker({
	            	changeMonth: false,
			        changeYear: true,
			        showButtonPanel: true,
			        dateFormat: 'yy',
			        onClose: function(dateText, inst) { 
			            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			            $(this).datepicker('setDate', new Date(year, 0, 1));
			        }
	            });

	        //Month Year
	        	$('.getDateMonthYear').datepicker({
	        		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
	        		changeMonth: true,
	        		changeYear: true,
	        		dateFormat: "M yy",
	        		showButtonPanel: true,
	        		onClose: function() {
				        var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				        $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
				   	},
				   	closeText : "Pilih",
				   	currentText : "Bulan Ini",
	        	});

	     	//Timepicker
	     	    $('.getTime').timepicker({
	     	        timeFormat: 'HH:mm:ss',
	     	    });
	     	    
	     	    $('.getHours').timepicker({
	     	        timeFormat: 'HH:mm',
	     	    });

	        //Datatable
	            $('#tablesort').DataTable({
	                "paging": false,
	                "ordering": true,
	                "info": false,
	                "searching": false,
	            });

	            $('#tablesort1').DataTable({
	                "paging": false,
	                "ordering": true,
	                "info": false,
	                "searching": false,
	            });

	            $('#tablefixed').DataTable({
	                "paging": false,
	                "ordering": false,
	                "info": false,
	                "searching": false,
	                fixedHeader: {
	                	header: true,
				    },
			        "scrollY": 500,
			        "scrollX": true
	            });

	        //Sweet Alert
	            $('.showModalHapus').click(function () {
	                var that = this;
	                var myLabel = $(that).data('nama');
	                var myLink = $(that).data('link');
	                swal({
	                    title: "Anda yakin ingin mehapus " + myLabel + "?",
	                    text: "Data akan dihapus dan Anda tidak dapat mengembalikan",
	                    type: "info",
	                    showCancelButton: true,
	                    confirmButtonColor: "#dc3545",
	                    confirmButtonText: "Ya",
	                    cancelButtonText: "Batal"
	                }).then((result) => {
	                    if (result.value) {
	                        swal({
	                            title: "Delete",
	                            text: "Data anda berhasil di hapus",
	                            type: "info"
	                        }).then(function () {
	                            $.ajax({
	                                type: 'GET',
	                                url: myLink,
	                                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
	                                success: function (data) {
	                                    location.reload();
	                                }
	                            });
	                        });
	                    }
	                    else if (result.dismiss === swal.DismissReason.cancel) {
	                        swal(
	                            'Batal',
	                            'Tidak ada perubahan yang dilakukan.',
	                            'error'
	                        )
	                    }
	                });
	            });

	        //Menu
	            $('#urutan_halaman').sortable({
	                handle: 'span',
	                update: function (event, ui) {
	                    $.ajaxSetup({
	                        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') }
	                    });
	                    $.post("{{URL('dashboard/menu/prosesurutan')}}", { type: "urutanHalaman", namaHalaman: $('#urutan_halaman').sortable('serialize') });
	                }
	            });

	        //CKeditor
				ClassicEditor
				.create( document.querySelector( '#editor1' ),{
                ckfinder: {
                    uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
				}
        		})
				.catch( error => {
					// console.error( error );
				} );

	        //Fitur Sub Menu
	        @if (Request:: segment(3) == 'tambah_submenu' || Request:: segment(3) == 'edit_submenu')
		        checkCheckedSubMenu();
		        $("#fitur_lihat").click(function () {
		            checkCheckedSubMenu();
		        });

		        function checkCheckedSubMenu() {
		            if ($('#fitur_lihat').prop('checked') == true) {
		                $('#fitur_baca').prop('disabled', false);
		                $('#fitur_tambah').prop('disabled', false);
		                $('#fitur_edit').prop('disabled', false);
		                $('#fitur_hapus').prop('disabled', false);
		                $('#fitur_cetak').prop('disabled', false);
		            }
		            else {
		                $('#fitur_baca').prop('checked', false);
		                $('#fitur_baca').prop('disabled', true);
		                $('#fitur_tambah').prop('checked', false);
		                $('#fitur_tambah').prop('disabled', true);
		                $('#fitur_edit').prop('checked', false);
		                $('#fitur_edit').prop('disabled', true);
		                $('#fitur_hapus').prop('checked', false);
		                $('#fitur_hapus').prop('disabled', true);
		                $('#fitur_cetak').prop('checked', false);
		                $('#fitur_cetak').prop('disabled', true);
		            }
		        }
		        @endif

		        //Level System
			        //Check Checkbox Before
				        var check_checkbox_one_lihat = $('input[class="chk-lihat"]').prop('checked');
				        if (check_checkbox_one_lihat == false)
				            $('input[class="chk-all-lihat"]').prop('checked', false);
				        else if (check_checkbox_one_lihat == true) {
				            var check_checked = $('input:checkbox:checked.chk-lihat').length;
				            var check_unchecked = $('input:checkbox.chk-lihat').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-lihat"]').prop('checked', true);
				        }

				        var check_checkbox_one_baca = $('input[class="chk-baca"]').prop('checked');
				        if (check_checkbox_one_baca == false)
				            $('input[class="chk-all-baca"]').prop('checked', false);
				        else if (check_checkbox_one_baca == true) {
				            var check_checked = $('input:checkbox:checked.chk-baca').length;
				            var check_unchecked = $('input:checkbox.chk-baca').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-baca"]').prop('checked', true);
				        }

				        var check_checkbox_one_tambah = $('input[class="chk-tambah"]').prop('checked');
				        if (check_checkbox_one_tambah == false)
				            $('input[class="chk-all-tambah"]').prop('checked', false);
				        else if (check_checkbox_one_tambah == true) {
				            var check_checked = $('input:checkbox:checked.chk-tambah').length;
				            var check_unchecked = $('input:checkbox.chk-tambah').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-tambah"]').prop('checked', true);
				        }

				        var check_checkbox_one_edit = $('input[class="chk-edit"]').prop('checked');
				        if (check_checkbox_one_edit == false)
				            $('input[class="chk-all-edit"]').prop('checked', false);
				        else if (check_checkbox_one_edit == true) {
				            var check_checked = $('input:checkbox:checked.chk-edit').length;
				            var check_unchecked = $('input:checkbox.chk-edit').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-edit"]').prop('checked', true);
				        }

				        var check_checkbox_one_hapus = $('input[class="chk-hapus"]').prop('checked');
				        if (check_checkbox_one_hapus == false)
				            $('input[class="chk-all-hapus"]').prop('checked', false);
				        else if (check_checkbox_one_hapus == true) {
				            var check_checked = $('input:checkbox:checked.chk-hapus').length;
				            var check_unchecked = $('input:checkbox.chk-hapus').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-hapus"]').prop('checked', true);
				        }

				        var check_checkbox_one_cetak = $('input[class="chk-cetak"]').prop('checked');
				        if (check_checkbox_one_cetak == false)
				            $('input[class="chk-all-cetak"]').prop('checked', false);
				        else if (check_checkbox_one_cetak == true) {
				            var check_checked = $('input:checkbox:checked.chk-cetak').length;
				            var check_unchecked = $('input:checkbox.chk-cetak').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-cetak"]').prop('checked', true);
				        }

			        //All Checkbox
				        $('input[class="chk-all-lihat"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-lihat"]').prop('checked');
				            console.log(check_checkbox_all);
				            if (check_checkbox_all == true)
				                $('input[class="chk-lihat"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-lihat"]').prop('checked', false);
				        });

				        $('input[class="chk-all-baca"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-baca"]').prop('checked');
				            if (check_checkbox_all == true)
				                $('input[class="chk-baca"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-baca"]').prop('checked', false);
				        });

				        $('input[class="chk-all-tambah"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-tambah"]').prop('checked');
				            if (check_checkbox_all == true)
				                $('input[class="chk-tambah"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-tambah"]').prop('checked', false);
				        });

				        $('input[class="chk-all-edit"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-edit"]').prop('checked');
				            if (check_checkbox_all == true)
				                $('input[class="chk-edit"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-edit"]').prop('checked', false);
				        });

				        $('input[class="chk-all-hapus"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-hapus"]').prop('checked');
				            if (check_checkbox_all == true)
				                $('input[class="chk-hapus"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-hapus"]').prop('checked', false);
				        });

				        $('input[class="chk-all-cetak"]').click(function () {
				            var check_checkbox_all = $('input[class="chk-all-cetak"]').prop('checked');
				            if (check_checkbox_all == true)
				                $('input[class="chk-cetak"]').prop('checked', true);
				            else if (check_checkbox_all == false)
				                $('input[class="chk-cetak"]').prop('checked', false);
				        });

			        //One Checkbox
				        $('input[class="chk-lihat"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-lihat').length;
				            var check_unchecked = $('input:checkbox.chk-lihat').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-lihat"]').prop('checked', true);
				            else
				                $('input[class="chk-all-lihat"]').prop('checked', false);
				        });

				        $('input[class="chk-baca"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-baca').length;
				            var check_unchecked = $('input:checkbox.chk-baca').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-baca"]').prop('checked', true);
				            else
				                $('input[class="chk-all-baca"]').prop('checked', false);
				        });

				        $('input[class="chk-tambah"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-tambah').length;
				            var check_unchecked = $('input:checkbox.chk-tambah').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-tambah"]').prop('checked', true);
				            else
				                $('input[class="chk-all-tambah"]').prop('checked', false);
				        });

				        $('input[class="chk-edit"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-edit').length;
				            var check_unchecked = $('input:checkbox.chk-edit').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-edit"]').prop('checked', true);
				            else
				                $('input[class="chk-all-edit"]').prop('checked', false);
				        });

				        $('input[class="chk-hapus"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-hapus').length;
				            var check_unchecked = $('input:checkbox.chk-hapus').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-hapus"]').prop('checked', true);
				            else
				                $('input[class="chk-all-hapus"]').prop('checked', false);
				        });

				        $('input[class="chk-cetak"]').click(function () {
				            var check_checked = $('input:checkbox:checked.chk-cetak').length;
				            var check_unchecked = $('input:checkbox.chk-cetak').length;
				            if (check_checked == check_unchecked)
				                $('input[class="chk-all-cetak"]').prop('checked', true);
				            else
				                $('input[class="chk-all-cetak"]').prop('checked', false);
				        });
	        });
	</script>
</body>

</html>