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
											@php $selected = ''; if(!empty($hasil_bulan_mulai) && $bulan_mulai == $hasil_bulan_mulai) $selected = 'selected'; elseif(empty($hasil_bulan_mulai) && $bulan_mulai == Request::old('cari_bulan_mulai')) $selected = 'selected'; @endphp
											<option value="{{$bulan_mulai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_mulai)}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select class="form-control select2" id="cari_tahun_mulai" name="cari_tahun_mulai">
										@for($tahun_mulai = date('Y') - 5; $tahun_mulai <= date('Y') + 2; $tahun_mulai++)
											@php $selected = ''; if(!empty($hasil_tahun_mulai) && $tahun_mulai == $hasil_tahun_mulai) $selected = 'selected'; elseif(empty($hasil_tahun_mulai) && $tahun_mulai == Request::old('cari_tahun_mulai')) $selected = 'selected'; @endphp
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
											@php $selected = ''; if(!empty($hasil_bulan_selesai) && $bulan_selesai == $hasil_bulan_selesai) $selected = 'selected'; elseif(empty($hasil_bulan_selesai) && $bulan_selesai == Request::old('cari_bulan_selesai')) $selected = 'selected'; @endphp
											<option value="{{$bulan_selesai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_selesai)}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-2">
									<div class="form-group">
										<select class="form-control select2" id="cari_tahun_selesai" name="cari_tahun_selesai">
											@for($tahun_selesai = date('Y') - 5; $tahun_selesai <= date('Y') + 2; $tahun_selesai++)
												@php $selected = ''; if(!empty($hasil_tahun_selesai) && $tahun_selesai == $hasil_tahun_selesai) $selected = 'selected'; elseif(empty($hasil_tahun_selesai) && $tahun_selesai == Request::old('cari_tahun_selesai')) $selected = 'selected'; @endphp
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
											@php $selected = ''; if(!empty($hasil_status_sales) && $status_sales->id_status_sales == $hasil_status_sales) $selected = 'selected'; elseif(empty($hasil_status_sales) && $status_sales->id_status_sales == Request::old('cari_status_sales')) $selected = 'selected'; @endphp
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
						@if(!empty($lihat_laporan_aktivitas_sales))
							@foreach($lihat_laporan_aktivitas_sales as $section)
								<table class="table table-laporan-sales-target table-bordered table-sm mb-4">
									<thead>
										<tr class="title-section">
											<td colspan="10" class="title-cell">{{ strtoupper($section['unit_name']) }} SALES TARGET</td>
										</tr>
										<tr class="header-row">
											<th class="th-nama">NAMA</th>
											<th class="th-segmentation">SEGMENTATION</th>
											<th class="th-revenue">ROOM REVENUE</th>
											<th class="th-revenue">BANQUET REVENUE</th>
											<th class="th-total">TOTAL TARGET REVENUE</th>
											<th class="th-week">W 1</th>
											<th class="th-week">W 2</th>
											<th class="th-week">W 3</th>
											<th class="th-week">W 4</th>
											<th class="th-result">RESULT</th>
										</tr>
									</thead>
									<tbody>
										@foreach($section['rows'] as $idx => $row)
											@php
												$total = (float) ($row['total'] ?? 0);
												$w = $total > 0 ? round($total / 4, 0) : 0;
											@endphp
											<tr>
												<td class="td-nama">{{ $row['name'] }}</td>
												<td class="td-segmentation">
													@if($idx === 0)
														Total akumulasi SEGMENTATION, G, SE, NA, DLL
													@endif
												</td>
												<td class="td-revenue text-right">Rp {{ number_format(0, 0, ',', '.') }}</td>
												<td class="td-revenue text-right">Rp {{ number_format(0, 0, ',', '.') }}</td>
												<td class="td-total text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w, 0, ',', '.') }}</td>
												<td class="td-result text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@endforeach
						@else
							<p class="center-align">Tidak ada data ditampilkan untuk periode {{ General::ubahDBKeTanggal($hasil_tanggal_mulai ?? '') }} s/d {{ General::ubahDBKeTanggal($hasil_tanggal_selesai ?? '') }}. Pastikan ada aktivitas sales di rentang tanggal tersebut dan user aktivitas terdaftar di tabel users.</p>
						@endif
				    </div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.table-laporan-sales-target { border-collapse: collapse; width: 100%; font-size: 14px; }
		.table-laporan-sales-target .title-section .title-cell {
			background: linear-gradient(180deg, #5a6c7d 0%, #4a5c6d 100%);
			color: #fff;
			font-weight: bold;
			padding: 10px 8px;
			border: 1px solid #3a4c5d;
		}
		.table-laporan-sales-target .header-row th {
			background: #e8e8e8;
			border: 1px solid #333;
			padding: 8px 6px;
			font-weight: bold;
		}
		.table-laporan-sales-target .th-total { background: #f9e79f !important; }
		.table-laporan-sales-target .th-week { background: #d5d8dc !important; }
		.table-laporan-sales-target tbody td { border: 1px solid #333; padding: 6px 8px; }
		.table-laporan-sales-target .td-segmentation { word-wrap: break-word; overflow-wrap: break-word; max-width: 200px; }
		.table-laporan-sales-target tbody tr:nth-child(even) { background-color: #fafafa; }
	</style>

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