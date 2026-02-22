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
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-col-form-label">Unit Kerja</label>
									<select class="form-control select2" id="cari_unit_kerja" name="cari_unit_kerja">
										<option value="">Semua Unit Kerja</option>
										@foreach(isset($lihat_unit_kerjas) ? $lihat_unit_kerjas : [] as $uk)
											@php $selected = ''; if((string)$uk->id_unit_kerjas === (string)($hasil_unit_kerja ?? '')) $selected = 'selected'; @endphp
											<option value="{{ $uk->id_unit_kerjas }}" {{ $selected }}>{{ $uk->nama_unit_kerjas }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4">
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
							<div class="col-md-4">
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

		@if(!empty($sales_achievement_dashboard['units']))
		{{-- Sales Achievement: per bulan per unit --}}
		<div class="col-sm-12 mb-4">
			<div class="card">
				<div class="card-header">
					<strong>SALES ACHIEVEMENT</strong>
					<span class="small text-muted ml-2">— Per bulan per unit. W1–W4: (value minggu ÷ total target bulan) × 100%. Total target = W1+W2+W3+W4.</span>
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
										<th class="text-center text-white" style="width: 70px; background-color: {{ $unitColor }} !important;">% Achieve</th>
										<th class="text-center text-white" style="width: 70px; background-color: {{ $unitColor }} !important;">Visit</th>
										<th class="text-white" style="background-color: {{ $unitColor }} !important;">Activity</th>
										<th class="text-center text-white" style="width: 60px; background-color: {{ $unitColor }} !important;">Definitive</th>
										<th class="text-center text-white" style="width: 60px; background-color: {{ $unitColor }} !important;">Cancel</th>
										<th class="text-center text-white" style="width: 60px; background-color: {{ $unitColor }} !important;">Lost</th>
										<th class="text-center text-white" style="width: 44px; background-color: {{ $unitColor }} !important;">W1</th>
										<th class="text-center text-white" style="width: 44px; background-color: {{ $unitColor }} !important;">W2</th>
										<th class="text-center text-white" style="width: 44px; background-color: {{ $unitColor }} !important;">W3</th>
										<th class="text-center text-white" style="width: 44px; background-color: {{ $unitColor }} !important;">W4</th>
									</tr>
								</thead>
								<tbody>
									@foreach(isset($unit['rows']) ? $unit['rows'] : [] as $r)
									<tr class="@if(($r['achievement_pct'] ?? 0) >= 100) table-success @else table-danger @endif">
										<td class="text-center">{{ $r['month_label'] ?? '—' }}</td>
										<td class="text-center font-weight-bold">{{ $r['rank'] ?? '—' }}</td>
										<td>{{ $r['name'] ?? '—' }}</td>
										<td class="text-center @if(($r['achievement_pct'] ?? 0) >= 100) font-weight-bold @endif">{{ $r['achievement_pct'] ?? 0 }}%</td>
										<td class="text-center">{{ $r['visit_count'] ?? 0 }}</td>
										<td>
											@foreach($r['activities'] ?? [] as $act => $cnt)
												{{ $act }}: {{ $cnt }}@if(!$loop->last), @endif
											@endforeach
											@if(empty($r['activities'])) — @endif
										</td>
										<td class="text-center">{{ $r['definitive'] ?? 0 }}</td>
										<td class="text-center">{{ $r['cancellation'] ?? 0 }}</td>
										<td class="text-center">{{ $r['lost'] ?? 0 }}</td>
										<td class="text-center">{{ number_format($r['w1_pct'] ?? 0, 2, ',', '') }}%</td>
										<td class="text-center">{{ number_format($r['w2_pct'] ?? 0, 2, ',', '') }}%</td>
										<td class="text-center">{{ number_format($r['w3_pct'] ?? 0, 2, ',', '') }}%</td>
										<td class="text-center">{{ number_format($r['w4_pct'] ?? 0, 2, ',', '') }}%</td>
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
											<td colspan="10" class="title-cell text-white" style="background: {{ $sectionColor }} !important; border-color: {{ $sectionColor }};">{{ strtoupper($section['unit_name']) }} SALES TARGET</td>
										</tr>
										<tr class="header-row">
											<th class="th-bulan text-white" style="background: {{ $sectionColor }} !important;">BULAN</th>
											<th class="th-nama text-white" style="background: {{ $sectionColor }} !important;">NAMA</th>
											<th class="th-revenue text-white" style="background: {{ $sectionColor }} !important;">ROOM REVENUE</th>
											<th class="th-revenue text-white" style="background: {{ $sectionColor }} !important;">BANQUET REVENUE</th>
											<th class="th-total text-white" style="background: {{ $sectionColor }} !important;">TOTAL REVENUE</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W1 (Result)</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W2 (Result)</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W3 (Result)</th>
											<th class="th-week text-white" style="background: {{ $sectionColor }} !important;">W4 (Result)</th>
											<th class="th-result text-white" style="background: {{ $sectionColor }} !important;">RESULT</th>
										</tr>
									</thead>
									<tbody>
										@foreach($section['rows'] as $idx => $row)
											@php
												$total = (float) ($row['total'] ?? 0);
												$w1 = (float) ($row['w1'] ?? 0);
												$w2 = (float) ($row['w2'] ?? 0);
												$w3 = (float) ($row['w3'] ?? 0);
												$w4 = (float) ($row['w4'] ?? 0);
											@endphp
											<tr>
												<td class="td-bulan">{{ $row['month_label'] ?? '—' }}</td>
												<td class="td-nama">{{ $row['name'] }}</td>
												<td class="td-revenue text-right">Rp {{ number_format(0, 0, ',', '.') }}</td>
												<td class="td-revenue text-right">Rp {{ number_format(0, 0, ',', '.') }}</td>
												<td class="td-total text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w1, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w2, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w3, 0, ',', '.') }}</td>
												<td class="td-week text-right">Rp {{ number_format($w4, 0, ',', '.') }}</td>
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
		.achievement-table th { background: #5a6c7d !important; color: #fff !important; font-size: 13px; padding: 10px 8px; }
		.achievement-table td { font-size: 13px; vertical-align: middle !important; padding: 8px; }
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
		.table-laporan-sales-target tbody tr:nth-child(even) { background-color: #fafafa; }
	</style>

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
		});
    </script>

@endsection