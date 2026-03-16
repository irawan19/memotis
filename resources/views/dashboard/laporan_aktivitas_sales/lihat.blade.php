@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<form method="GET" action="{{ URL('dashboard/laporan_aktivitas_sales/cari') }}">
				<div class="card">
					<div class="card-header py-2">
						<strong>Filter Laporan</strong>
						<span class="small text-muted ml-2">— Pilih periode dan filter lalu klik Cari.</span>
					</div>
					<div class="card-body">
						{{-- Baris 1: Rentang tanggal --}}
						<div class="form-group row mb-3">
							<label class="col-form-label col-sm-12 col-md-2 text-md-right">Rentang Tanggal</label>
							<div class="col-sm-12 col-md-10">
								<div class="d-flex flex-wrap align-items-center">
									<div class="mr-2 mb-1">
										<label class="small text-muted d-block mb-0">Bulan Mulai</label>
										<select class="form-control form-control-sm select2" id="cari_bulan_mulai" name="cari_bulan_mulai" style="min-width: 100px;">
											@for($bulan_mulai = 1; $bulan_mulai <= 12; $bulan_mulai++)
												@php $selected = ''; if(!empty($hasil_bulan_mulai) && $bulan_mulai == $hasil_bulan_mulai) $selected = 'selected'; elseif(empty($hasil_bulan_mulai) && $bulan_mulai == Request::old('cari_bulan_mulai')) $selected = 'selected'; @endphp
												<option value="{{$bulan_mulai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_mulai)}}</option>
											@endfor
										</select>
									</div>
									<div class="mr-2 mb-1">
										<label class="small text-muted d-block mb-0">Tahun Mulai</label>
										<select class="form-control form-control-sm select2" id="cari_tahun_mulai" name="cari_tahun_mulai" style="min-width: 85px;">
											@for($tahun_mulai = date('Y') - 5; $tahun_mulai <= date('Y') + 2; $tahun_mulai++)
												@php $selected = ''; if(!empty($hasil_tahun_mulai) && $tahun_mulai == $hasil_tahun_mulai) $selected = 'selected'; elseif(empty($hasil_tahun_mulai) && $tahun_mulai == Request::old('cari_tahun_mulai')) $selected = 'selected'; @endphp
												<option value="{{$tahun_mulai}}" {{ $selected }}>{{$tahun_mulai}}</option>
											@endfor
										</select>
									</div>
									<span class="align-self-end mb-1 mr-2 text-muted small">sampai</span>
									<div class="mr-2 mb-1">
										<label class="small text-muted d-block mb-0">Bulan Selesai</label>
										<select class="form-control form-control-sm select2" id="cari_bulan_selesai" name="cari_bulan_selesai" style="min-width: 100px;">
											@for($bulan_selesai = 1; $bulan_selesai <= 12; $bulan_selesai++)
												@php $selected = ''; if(!empty($hasil_bulan_selesai) && $bulan_selesai == $hasil_bulan_selesai) $selected = 'selected'; elseif(empty($hasil_bulan_selesai) && $bulan_selesai == Request::old('cari_bulan_selesai')) $selected = 'selected'; @endphp
												<option value="{{$bulan_selesai}}" {{ $selected }}>{{General::ubahDBKeBulan($bulan_selesai)}}</option>
											@endfor
										</select>
									</div>
									<div class="mb-1">
										<label class="small text-muted d-block mb-0">Tahun Selesai</label>
										<select class="form-control form-control-sm select2" id="cari_tahun_selesai" name="cari_tahun_selesai" style="min-width: 85px;">
											@for($tahun_selesai = date('Y') - 5; $tahun_selesai <= date('Y') + 2; $tahun_selesai++)
												@php $selected = ''; if(!empty($hasil_tahun_selesai) && $tahun_selesai == $hasil_tahun_selesai) $selected = 'selected'; elseif(empty($hasil_tahun_selesai) && $tahun_selesai == Request::old('cari_tahun_selesai')) $selected = 'selected'; @endphp
												<option value="{{$tahun_selesai}}" {{ $selected }}>{{$tahun_selesai}}</option>
											@endfor
										</select>
									</div>
								</div>
							</div>
						</div>
						{{-- Baris 2: Unit, Status, Kata kunci --}}
						<div class="form-group row mb-0">
							<label class="col-form-label col-sm-12 col-md-2 text-md-right">Filter Lain</label>
							<div class="col-sm-12 col-md-10">
								<div class="row">
									<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mb-lg-0">
										<label class="small text-muted d-block mb-0">Unit Kerja</label>
										<select class="form-control form-control-sm select2" id="cari_unit_kerja" name="cari_unit_kerja">
											<option value="">Semua Unit Kerja</option>
											@foreach(isset($lihat_unit_kerjas) ? $lihat_unit_kerjas : [] as $uk)
												@php $selected = ''; if((string)$uk->id_unit_kerjas === (string)($hasil_unit_kerja ?? '')) $selected = 'selected'; @endphp
												<option value="{{ $uk->id_unit_kerjas }}" {{ $selected }}>{{ $uk->nama_unit_kerjas }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-6 col-md-4 col-lg-3 mb-2 mb-lg-0">
										<label class="small text-muted d-block mb-0">Status Aktivitas</label>
										<select class="form-control form-control-sm select2" id="cari_status_sales" name="cari_status_sales">
											<option value="">Semua Status</option>
											@foreach($lihat_status_sales as $status_sales)
												@php $selected = ''; if(!empty($hasil_status_sales) && $status_sales->id_status_sales == $hasil_status_sales) $selected = 'selected'; elseif(empty($hasil_status_sales) && $status_sales->id_status_sales == Request::old('cari_status_sales')) $selected = 'selected'; @endphp
												<option value="{{$status_sales->id_status_sales}}" {{ $selected }}>{{$status_sales->nama_status_sales}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4">
										<label class="small text-muted d-block mb-0">Cari kata (nama user, company, segmentasi)</label>
										<input class="form-control form-control-sm" id="cari_kata" type="text" name="cari_kata" placeholder="Kosongkan = tampilkan semua" value="{{ $hasil_kata }}">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right py-2">
						{{ General::reset() }}
						{{ General::pencarian() }}
					</div>
				</div>
			</form>
		</div>

		@if(!empty($sales_achievement_dashboard['units']))
		{{-- Sales Activity: per bulan per unit, urut visit tertinggi --}}
		<div class="col-sm-12 mb-4">
			<div class="card">
				<div class="card-header">
					<strong>SALES ACTIVITY</strong>
					<span class="small text-muted ml-2">— Per bulan per unit. Rank #1 = jumlah visit terbanyak, urutan terakhir = visit paling rendah.</span>
				</div>
				<div class="card-body p-0">
					@php
						$unitHeaderColors = ['#2c3e50', '#16a085', '#2980b9', '#8e44ad', '#c0392b', '#d35400', '#27ae60', '#7f8c8d'];
					@endphp
					@foreach($sales_achievement_dashboard['units'] as $unit)
					@php $unitColor = $unitHeaderColors[$loop->index % count($unitHeaderColors)] ?? '#5a6c7d'; @endphp
					<div class="border-bottom border-light">
						<div class="px-3 py-2 text-white" style="background-color: {{ $unitColor }};">
							<strong>{{ $unit['name'] }}</strong>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-sm mb-0 achievement-table">
								<thead>
									<tr>
										<th class="text-center text-white" style="width: 90px; background-color: {{ $unitColor }} !important;">BULAN</th>
										<th class="text-center text-white" style="width: 40px; background-color: {{ $unitColor }} !important;">#</th>
										<th class="text-white" style="background-color: {{ $unitColor }} !important;">Nama</th>
										<th class="text-center text-white" style="width: 70px; background-color: {{ $unitColor }} !important;">Visit</th>
										<th class="text-white" style="background-color: {{ $unitColor }} !important;">Activity</th>
										<th class="text-white" style="background-color: {{ $unitColor }} !important;">Segmentation</th>
										<th class="text-center text-white" style="width: 95px; background-color: {{ $unitColor }} !important;">Definitive</th>
										<th class="text-center text-white" style="width: 95px; background-color: {{ $unitColor }} !important;">Cancel</th>
										<th class="text-center text-white" style="width: 95px; background-color: {{ $unitColor }} !important;">Lost</th>
									</tr>
								</thead>
								<tbody>
									@foreach(isset($unit['rows']) ? $unit['rows'] : [] as $r)
									<tr>
										<td class="text-center">{{ $r['month_label'] ?? '—' }}</td>
										<td class="text-center font-weight-bold">{{ $r['rank'] ?? '—' }}</td>
										<td>{{ $r['name'] ?? '—' }}</td>
										<td class="text-center">{{ $r['visit_count'] ?? 0 }}</td>
										<td>
											@foreach($r['activities'] ?? [] as $act => $cnt)
												{{ $act }}: {{ $cnt }}@if(!$loop->last), @endif
											@endforeach
											@if(empty($r['activities'])) — @endif
										</td>
										<td>
											@foreach($r['segmentations'] ?? [] as $seg => $cnt)
												{{ $seg }}: {{ $cnt }}@if(!$loop->last), @endif
											@endforeach
											@if(empty($r['segmentations'])) — @endif
										</td>
										<td class="text-center">
											<div>{{ $r['definitive'] ?? 0 }}</div>
											<div class="small text-nowrap">Rp {{ number_format($r['definitive_nominal'] ?? 0, 0, ',', '.') }}</div>
										</td>
										<td class="text-center">
											<div>{{ $r['cancellation'] ?? 0 }}</div>
										</td>
										<td class="text-center">
											<div>{{ $r['lost'] ?? 0 }}</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif

		{{-- Grafik % Result per user (dari data Laporan Aktivitas Sales) --}}
		@php
			$chart_pct_labels = [];
			$chart_pct_values = [];
			$chart_user_pct = [];
			foreach ($lihat_laporan_aktivitas_sales ?? [] as $section) {
				foreach ($section['rows'] as $row) {
					$name = $row['name'] ?? '—';
					if (!isset($chart_user_pct[$name])) {
						$chart_user_pct[$name] = [];
					}
					if (isset($row['pct_result']) && $row['pct_result'] !== null) {
						$chart_user_pct[$name][] = (float) $row['pct_result'];
					}
				}
			}
			foreach ($chart_user_pct as $nama => $pcts) {
				$chart_pct_labels[] = $nama;
				$chart_pct_values[] = count($pcts) > 0 ? round(array_sum($pcts) / count($pcts), 1) : 0;
			}
		@endphp
		@if(!empty($chart_pct_labels))
		<div class="col-sm-12 mb-4">
			<div class="card">
				<div class="card-header">
					<strong>Grafik % Result per User</strong>
					<span class="small text-muted ml-2">— Rata-rata % Result per user. Garis putus-putus 100% = penanda; di bawah = belum target, di atas = melewati target.</span>
				</div>
				<div class="card-body">
					<div class="position-relative" style="height: 320px;">
						<canvas id="chartPctResultUser"></canvas>
					</div>
				</div>
			</div>
		</div>
		@endif
        
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
							@php
								$laporanHeaderColors = ['#2c3e50', '#16a085', '#2980b9', '#8e44ad', '#c0392b', '#d35400', '#27ae60', '#7f8c8d'];
							@endphp
							@foreach($lihat_laporan_aktivitas_sales as $section)
								@php $sectionColor = $laporanHeaderColors[$loop->index % count($laporanHeaderColors)] ?? '#5a6c7d'; @endphp
								<table class="table table-laporan-sales-target table-bordered table-sm mb-4">
									<thead>
										<tr class="title-section">
											<td colspan="19" class="title-cell text-white" style="background: {{ $sectionColor }} !important; border-color: {{ $sectionColor }};">{{ strtoupper($section['unit_name']) }} SALES TARGET</td>
										</tr>
										<tr class="header-row">
											<th class="th-bulan text-white" style="background: {{ $sectionColor }} !important;">BULAN</th>
											<th class="th-nama text-white" style="background: {{ $sectionColor }} !important;">NAMA</th>
											<th class="th-revenue text-white" style="background: {{ $sectionColor }} !important;">ROOM REVENUE</th>
											<th class="th-revenue text-white" style="background: {{ $sectionColor }} !important;">BANQUET REVENUE</th>
											<th class="th-total text-white" style="background: {{ $sectionColor }} !important;">TOTAL REVENUE</th>
											<th class="th-target text-white" style="background: {{ $sectionColor }} !important;">TOTAL SALES TARGET</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W1</th>
											<th class="th-budget text-white" style="background: {{ $sectionColor }} !important;">BUDGET W1</th>
											<th class="th-pct text-white" style="background: {{ $sectionColor }} !important;">% W1</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W2</th>
											<th class="th-budget text-white" style="background: {{ $sectionColor }} !important;">BUDGET W2</th>
											<th class="th-pct text-white" style="background: {{ $sectionColor }} !important;">% W2</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W3</th>
											<th class="th-budget text-white" style="background: {{ $sectionColor }} !important;">BUDGET W3</th>
											<th class="th-pct text-white" style="background: {{ $sectionColor }} !important;">% W3</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W4</th>
											<th class="th-budget text-white" style="background: {{ $sectionColor }} !important;">BUDGET W4</th>
											<th class="th-pct text-white" style="background: {{ $sectionColor }} !important;">% W4</th>
											<th class="th-result text-white" style="background: {{ $sectionColor }} !important;">% RESULT</th>
										</tr>
									</thead>
									<tbody>
										@foreach($section['rows'] as $idx => $row)
											@php
												$total = (float) ($row['total'] ?? 0);
												$room_revenue = (float) ($row['room_revenue'] ?? 0);
												$banquet_revenue = (float) ($row['banquet_revenue'] ?? 0);
												$w1 = (float) ($row['w1'] ?? 0);
												$w2 = (float) ($row['w2'] ?? 0);
												$w3 = (float) ($row['w3'] ?? 0);
												$w4 = (float) ($row['w4'] ?? 0);
											@endphp
											<tr>
												<td class="td-bulan">{{ $row['month_label'] ?? '—' }}</td>
												<td class="td-nama">{{ $row['name'] }}</td>
												<td class="td-revenue text-right">Rp {{ number_format($room_revenue, 0, ',', '.') }}</td>
												<td class="td-revenue text-right">Rp {{ number_format($banquet_revenue, 0, ',', '.') }}</td>
												<td class="td-total text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
												<td class="td-target text-right">@if(!empty($row['total_sales_target'])) Rp {{ number_format($row['total_sales_target'], 0, ',', '.') }} @else — @endif</td>
												<td class="td-week text-right">Rp {{ number_format($w1, 0, ',', '.') }}</td>
												<td class="td-budget text-right">@if(!empty($row['budget_w1'])) Rp {{ number_format($row['budget_w1'], 0, ',', '.') }} @else — @endif</td>
												<td class="td-pct text-center">@if(isset($row['pct_w1'])) {{ number_format($row['pct_w1'], 0, ',', '') }}% @else — @endif</td>
												<td class="td-week text-right">Rp {{ number_format($w2, 0, ',', '.') }}</td>
												<td class="td-budget text-right">@if(!empty($row['budget_w2'])) Rp {{ number_format($row['budget_w2'], 0, ',', '.') }} @else — @endif</td>
												<td class="td-pct text-center">@if(isset($row['pct_w2'])) {{ number_format($row['pct_w2'], 0, ',', '') }}% @else — @endif</td>
												<td class="td-week text-right">Rp {{ number_format($w3, 0, ',', '.') }}</td>
												<td class="td-budget text-right">@if(!empty($row['budget_w3'])) Rp {{ number_format($row['budget_w3'], 0, ',', '.') }} @else — @endif</td>
												<td class="td-pct text-center">@if(isset($row['pct_w3'])) {{ number_format($row['pct_w3'], 0, ',', '') }}% @else — @endif</td>
												<td class="td-week text-right">Rp {{ number_format($w4, 0, ',', '.') }}</td>
												<td class="td-budget text-right">@if(!empty($row['budget_w4'])) Rp {{ number_format($row['budget_w4'], 0, ',', '.') }} @else — @endif</td>
												<td class="td-pct text-center">@if(isset($row['pct_w4'])) {{ number_format($row['pct_w4'], 0, ',', '') }}% @else — @endif</td>
												<td class="td-result text-center font-weight-bold">@if(isset($row['pct_result'])) {{ number_format($row['pct_result'], 0, ',', '') }}% @else — @endif</td>
											</tr>
										@endforeach
									</tbody>
									@php
										$sum_room = 0; $sum_banquet = 0; $sum_total = 0; $sum_target = 0;
										$sum_w1 = 0; $sum_w2 = 0; $sum_w3 = 0; $sum_w4 = 0;
										$sum_b1 = 0; $sum_b2 = 0; $sum_b3 = 0; $sum_b4 = 0;
										foreach ($section['rows'] as $r) {
											$sum_room += (float)($r['room_revenue'] ?? 0);
											$sum_banquet += (float)($r['banquet_revenue'] ?? 0);
											$sum_total += (float)($r['total'] ?? 0);
											$sum_target += (float)($r['total_sales_target'] ?? 0);
											$sum_w1 += (float)($r['w1'] ?? 0);
											$sum_w2 += (float)($r['w2'] ?? 0);
											$sum_w3 += (float)($r['w3'] ?? 0);
											$sum_w4 += (float)($r['w4'] ?? 0);
											$sum_b1 += (float)($r['budget_w1'] ?? 0);
											$sum_b2 += (float)($r['budget_w2'] ?? 0);
											$sum_b3 += (float)($r['budget_w3'] ?? 0);
											$sum_b4 += (float)($r['budget_w4'] ?? 0);
										}
										$foot_pct_w1 = $sum_b1 > 0 ? round($sum_w1 / $sum_b1 * 100, 2) : null;
										$foot_pct_w2 = $sum_b2 > 0 ? round($sum_w2 / $sum_b2 * 100, 2) : null;
										$foot_pct_w3 = $sum_b3 > 0 ? round($sum_w3 / $sum_b3 * 100, 2) : null;
										$foot_pct_w4 = $sum_b4 > 0 ? round($sum_w4 / $sum_b4 * 100, 2) : null;
										$foot_pct_result = $sum_target > 0 ? round($sum_total / $sum_target * 100, 2) : null;
									@endphp
									<tfoot>
										<tr class="table-laporan-footer font-weight-bold">
											<td colspan="2" class="text-right">TOTAL</td>
											<td class="td-revenue text-right">Rp {{ number_format($sum_room, 0, ',', '.') }}</td>
											<td class="td-revenue text-right">Rp {{ number_format($sum_banquet, 0, ',', '.') }}</td>
											<td class="td-total text-right">Rp {{ number_format($sum_total, 0, ',', '.') }}</td>
											<td class="td-target text-right">@if($sum_target > 0) Rp {{ number_format($sum_target, 0, ',', '.') }} @else — @endif</td>
											<td class="td-week text-right">Rp {{ number_format($sum_w1, 0, ',', '.') }}</td>
											<td class="td-budget text-right">@if($sum_b1 > 0) Rp {{ number_format($sum_b1, 0, ',', '.') }} @else — @endif</td>
											<td class="td-pct text-center">@if($foot_pct_w1 !== null) {{ number_format($foot_pct_w1, 0, ',', '') }}% @else — @endif</td>
											<td class="td-week text-right">Rp {{ number_format($sum_w2, 0, ',', '.') }}</td>
											<td class="td-budget text-right">@if($sum_b2 > 0) Rp {{ number_format($sum_b2, 0, ',', '.') }} @else — @endif</td>
											<td class="td-pct text-center">@if($foot_pct_w2 !== null) {{ number_format($foot_pct_w2, 0, ',', '') }}% @else — @endif</td>
											<td class="td-week text-right">Rp {{ number_format($sum_w3, 0, ',', '.') }}</td>
											<td class="td-budget text-right">@if($sum_b3 > 0) Rp {{ number_format($sum_b3, 0, ',', '.') }} @else — @endif</td>
											<td class="td-pct text-center">@if($foot_pct_w3 !== null) {{ number_format($foot_pct_w3, 0, ',', '') }}% @else — @endif</td>
											<td class="td-week text-right">Rp {{ number_format($sum_w4, 0, ',', '.') }}</td>
											<td class="td-budget text-right">@if($sum_b4 > 0) Rp {{ number_format($sum_b4, 0, ',', '.') }} @else — @endif</td>
											<td class="td-pct text-center">@if($foot_pct_w4 !== null) {{ number_format($foot_pct_w4, 0, ',', '') }}% @else — @endif</td>
											<td class="td-result text-center">@if($foot_pct_result !== null) {{ number_format($foot_pct_result, 0, ',', '') }}% @else — @endif</td>
										</tr>
									</tfoot>
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
		.achievement-table th { background: #5a6c7d !important; color: #fff !important; font-size: 13px; padding: 10px 8px; }
		.achievement-table td { font-size: 13px; vertical-align: middle !important; padding: 8px; }
		.table-laporan-sales-target { border-collapse: collapse; width: 100%; font-size: 14px; }
		.table-laporan-sales-target th,
		.table-laporan-sales-target td { white-space: nowrap; }
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
		.table-laporan-sales-target tbody tr:nth-child(even) { background-color: #fafafa; }
		.table-laporan-sales-target tfoot .table-laporan-footer td { border: 1px solid #333; padding: 8px; background-color: #e8e8e8 !important; }
	</style>

	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script type="text/javascript">
		jQuery(document).ready(function () {
            $('.resetbutton').on('click', function() {
				$('#cari_status_sales').val('').trigger('change');
				$('#cari_unit_kerja').val('').trigger('change');
				$('#cari_bulan_mulai').val({{$hasil_bulan_mulai}}).trigger('change');
				$('#cari_tahun_mulai').val({{$hasil_tahun_mulai}}).trigger('change');
				$('#cari_bulan_selesai').val({{$hasil_bulan_selesai}}).trigger('change');
				$('#cari_tahun_selesai').val({{$hasil_tahun_selesai}}).trigger('change');
				$('#cari_kata').val('');
			});

			@if(!empty($chart_pct_labels))
			var ctxPct = document.getElementById('chartPctResultUser');
			if (ctxPct && typeof Chart !== 'undefined') {
				var chartPctLabels = @json($chart_pct_labels);
				var chartPctValues = @json($chart_pct_values);
				var colors = ['#2c3e50', '#16a085', '#2980b9', '#8e44ad', '#c0392b', '#d35400', '#27ae60', '#7f8c8d', '#1abc9c', '#3498db'];
				var line100 = chartPctLabels.map(function() { return 100; });
				new Chart(ctxPct, {
					type: 'bar',
					data: {
						labels: chartPctLabels,
						datasets: [
							{
								label: '% Result',
								data: chartPctValues,
								backgroundColor: chartPctLabels.map(function(_, i) { return colors[i % colors.length]; }),
								borderColor: chartPctLabels.map(function(_, i) { return colors[i % colors.length]; }),
								borderWidth: 1
							},
							{
								type: 'line',
								label: 'Target 100%',
								data: line100,
								borderColor: '#e74c3c',
								borderWidth: 2,
								borderDash: [6, 4],
								pointRadius: 0,
								pointHoverRadius: 0,
								fill: false,
								order: 0
							}
						]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: {
							legend: {
								display: true,
								labels: { filter: function(item) { return item.datasetIndex === 1; } }
							},
							tooltip: {
								callbacks: {
									label: function(ctx) {
										if (ctx.datasetIndex === 1) return 'Target 100%';
										return ctx.parsed.y + '%';
									}
								}
							}
						},
						scales: {
							y: {
								beginAtZero: true,
								ticks: { callback: function(v) { return v + '%'; } }
							}
						}
					}
				});
			}
			@endif
		});
    </script>

@endsection