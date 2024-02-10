@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<form method="GET" action="{{ URL('dashboard/laporan_aktivitas_sales/cari') }}">
				@csrf
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<select class="form-control select2" id="cari_bulan_mulai" name="cari_bulan_mulai">
										@for($bulan_mulai = 1; $bulan_mulai <= 12; $bulan_mulai++)
											@php($selected = '')
											@if(!empty($hasil_bulan_mulai))
												@if($bulan_mulai == $hasil_bulan_mulai)
													@php($selected = 'selected')
												@endif
											@else
												@if($bulan_mulai == Request::old('cari_bulan_mulai'))
													@php($selected = 'selected')
												@endif
											@endif
											<option value="{{$bulan_mulai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_mulai)}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select class="form-control select2" id="cari_tahun_mulai" name="cari_tahun_mulai">
										@for($tahun_mulai = date('Y') - 2; $tahun_mulai <= date('Y') + 2; $tahun_mulai++)
											@php($selected = '')
											@if(!empty($hasil_tahun_mulai))
												@if($tahun_mulai == $hasil_tahun_mulai)
													@php($selected = 'selected')
												@endif
											@else
												@if($tahun_mulai == Request::old('cari_tahun_mulai'))
													@php($selected = 'selected')
												@endif
											@endif
											<option value="{{$tahun_mulai}}" {{ $selected }}>{{$tahun_mulai}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-1">
								<p class="textsampai">sampai</p>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select class="form-control select2" id="cari_bulan_selesai" name="cari_bulan_selesai">
										@for($bulan_selesai = 1; $bulan_selesai <= 12; $bulan_selesai++)
											@php($selected = '')
											@if(!empty($hasil_bulan_selesai))
												@if($bulan_selesai == $hasil_bulan_selesai)
													@php($selected = 'selected')
												@endif
											@else
												@if($bulan_selesai == Request::old('cari_bulan_selesai'))
													@php($selected = 'selected')
												@endif
											@endif
											<option value="{{$bulan_selesai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_selesai)}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-2">
									<div class="form-group">
										<select class="form-control select2" id="cari_tahun_selesai" name="cari_tahun_selesai">
											@for($tahun_selesai = date('Y') - 2; $tahun_selesai <= date('Y') + 2; $tahun_selesai++)
												@php($selected = '')
												@if(!empty($hasil_tahun_selesai))
													@if($tahun_selesai == $hasil_tahun_selesai)
														@php($selected = 'selected')
													@endif
												@else
													@if($tahun_selesai == Request::old('cari_tahun_selesai'))
														@php($selected = 'selected')
													@endif
												@endif
												<option value="{{$tahun_selesai}}" {{ $selected }}>{{$tahun_selesai}}</option>
											@endfor
										</select>
									</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<select class="form-control select2" id="cari_status_sales" name="cari_status_sales">
										<option value="" selected>Semua Status</option>
										@foreach($lihat_status_sales as $status_sales)
											@php($selected = '')
											@if(!empty($hasil_status_sales))
												@if($status_sales->id_status_sales == $hasil_status_sales)
													@php($selected = 'selected')
												@endif
											@else
												@if($status_sales->id_status_sales == Request::old('cari_status_sales'))
													@php($selected = 'selected')
												@endif
											@endif
											<option value="{{$status_sales->id_status_sales}}" {{ $selected }}>{{$status_sales->nama_status_sales}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<input class="form-control" id="cari_kata" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer right-align">
						{{General::reset()}}
						{{General::pencarian()}}
					</div>
				</div>
			</form>
        </div>
        
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							<strong>Laporan Aktivitas Sales</strong>
						</div>
						<div class="col-md-6 right-align">
							{{ General::cetakexcel($link_laporan_aktivitas_sales,'dashboard/laporan_aktivitas_sales/cetakexcel') }}
						</div>
					</div>
				</div>
				<div class="card-body">
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				<th class="nowrap">Sales</th>
				    				<th class="nowrap">Segmentasi</th>
				    				<th class="nowrap">Project</th>
				    				<th class="nowrap">Status</th>
				    				<th class="nowrap">Total</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_laporan_aktivitas_sales->isEmpty())
		            				@foreach($lihat_laporan_aktivitas_sales as $laporan_aktivitas_sales)
								    	<tr>
											@php($nama = $laporan_aktivitas_sales->nama_level_sistems.' - '.$laporan_aktivitas_sales->name)
											@if(!empty($laporan_aktivitas_sales->id_divisis))
												@php($nama = $laporan_aktivitas_sales->nama_level_sistems.' - '.$laporan_aktivitas_sales->nama_divisis.' - '.$laporan_aktivitas_sales->name)
											@endif
								    		<td class="nowrap">{{$nama}}</td>
								    		<td class="nowrap">{{$laporan_aktivitas_sales->nama_segmentasi_sales}}</td>
								    		<td class="nowrap">{{$laporan_aktivitas_sales->nama_project_sales}}</td>
								    		<td class="nowrap">{{$laporan_aktivitas_sales->nama_status_sales}}</td>
								    		<td class="nowrap right-align">{{General::ubahDBKeHarga($laporan_aktivitas_sales->total)}}</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										<td colspan="5" class="center-align">Tidak ada data ditampilkan</td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
									</tr>
								@endif
				    		</tbody>
				    	</table>
				    </div>
				</div>
			</div>
		</div>
	</div>

    <script type="text/javascript">
		jQuery(document).ready(function () {
            $('.resetbutton').on('click', function() {
				$('#cari_status_sales').val('').trigger('change');
				$('#cari_bulan_mulai').val({{$hasil_bulan_mulai}}).trigger('change');
				$('#cari_tahun_mulai').val({{$hasil_tahun_mulai}}).trigger('change');
				$('#cari_bulan_selesai').val({{$hasil_bulan_selesai}}).trigger('change');
				$('#cari_tahun_selesai').val({{$hasil_tahun_selesai}}).trigger('change');
				$('#cari_kata').val('');
			});
		});
    </script>

@endsection