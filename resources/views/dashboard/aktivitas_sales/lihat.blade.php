@extends('dashboard.layouts.app')
@section('content')

<style>
	.table-aktivitas-sales thead th {
		background: linear-gradient(180deg, #c9952e 0%, #b8860b 100%) !important;
		color: #fff !important;
		font-weight: bold;
		border: 1px solid #9a7209;
		padding: 10px 8px;
		white-space: nowrap;
	}
	.table-aktivitas-sales tbody tr:nth-child(even) { background-color: #f9f9f9; }
	.table-aktivitas-sales tbody tr:nth-child(odd) { background-color: #fff; }
	.table-aktivitas-sales tbody td { border: 1px solid #dee2e6; padding: 8px; vertical-align: middle; }
	.table-aktivitas-sales .revenue-cell { text-align: right; white-space: nowrap; }
	.table-aktivitas-sales .status-definite { background-color: #2eb85c !important; color: #fff; font-weight: bold; text-align: center; vertical-align: middle; }
	.table-aktivitas-sales .status-cell { text-align: center; }
	.table-aktivitas-sales .no-cell { text-align: center; width: 40px; }
</style>

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Aktivitas Sales</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::cetakexcel($link_aktivitas_sales,'dashboard/aktivitas_sales/cetakexcel') }}
								{{ General::tambah($link_aktivitas_sales,'dashboard/aktivitas_sales/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/aktivitas_sales') }}">
						@csrf
						<div class="row align-items-end">
							<div class="col-md-3">
								<div class="form-group mb-0">
									<label class="form-col-form-label">Bulan</label>
									<select class="form-control select2" id="cari_bulan" name="cari_bulan">
										<option value="">Semua Bulan</option>
										@for($b = 1; $b <= 12; $b++)
											@php $sel_b = (isset($hasil_bulan) && $hasil_bulan !== '' && (int)$hasil_bulan === $b) ? 'selected' : ''; @endphp
											<option value="{{ $b }}" {{ $sel_b }}>{{ General::ubahDBKeBulan($b) }}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group mb-0">
									<label class="form-col-form-label">Tahun</label>
									<select class="form-control select2" id="cari_tahun" name="cari_tahun">
										<option value="">Semua Tahun</option>
										@for($t = date('Y') + 2; $t >= date('Y') - 5; $t--)
											@php $sel_t = (isset($hasil_tahun) && $hasil_tahun !== '' && (int)$hasil_tahun === $t) ? 'selected' : ''; @endphp
											<option value="{{ $t }}" {{ $sel_t }}>{{ $t }}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label class="form-col-form-label">Kata kunci</label>
									<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari nama, PIC, alamat, ..." value="{{ $hasil_kata ?? '' }}">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group mb-0">
									<label class="form-col-form-label">&nbsp;</label>
									<button class="btn btn-primary btn-block" type="submit">Cari</button>
								</div>
							</div>
						</div>
					</form>
	            	<br/>
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-aktivitas-sales table-responsive-sm table-bordered table-sm">
				    		<thead>
				    			<tr>
				    				@if(General::totalHakAkses($link_aktivitas_sales) != 0)
						    			<th></th>
						    		@endif
									<th class="no-cell">NO</th>
									@if(Auth::user()->level_sistems_id == 1)
										<th>USER</th>
									@endif
									<th>COMPANY</th>
									<th>SEGMENTATION</th>
									<th>SALES</th>
									<th>DATE</th>
									<th>STATUS</th>
									<th>INCOM REVENUE</th>
									<th>BANQUET REVENUE</th>
									<th>NETT REVENUE</th>
									<th>PIC</th>
									<th>CONTACT</th>
									<th>RESULT</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_aktivitas_sales->isEmpty())
		            				@foreach($lihat_aktivitas_sales as $no => $aktivitas_sales)
								    	@php
											$no_urut = $no + 1;
											if (method_exists($lihat_aktivitas_sales, 'currentPage')) {
												$no_urut = ($lihat_aktivitas_sales->currentPage() - 1) * $lihat_aktivitas_sales->perPage() + $no + 1;
											}
											$has_status = !empty(trim($aktivitas_sales->nama_status_sales ?? ''));
											$status_class = $has_status ? 'status-definite' : '';
										@endphp
								    	<tr>
								    		@if(General::totalHakAkses($link_aktivitas_sales) != 0)
								    			<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{General::edit($link_aktivitas_sales,'dashboard/aktivitas_sales/edit/'.$aktivitas_sales->id_aktivitas_sales)}}
										            		<div class="dropdown-divider"></div>
										            		{{General::hapus($link_aktivitas_sales,'dashboard/aktivitas_sales/hapus/'.$aktivitas_sales->id_aktivitas_sales, $aktivitas_sales->id_aktivitas_sales.' - '.$aktivitas_sales->nama_aktivitas_sales)}}
										            	</div>
										            </div>
											    </td>
								    		@endif
											<td class="no-cell">{{ $no_urut }}</td>
											@if(Auth::user()->level_sistems_id == 1)
												@php
													$nama = $aktivitas_sales->nama_level_sistems.' - '.$aktivitas_sales->name;
													if(!empty($aktivitas_sales->id_divisis)) {
														$nama = $aktivitas_sales->nama_level_sistems.' - '.$aktivitas_sales->nama_divisis.' - '.$aktivitas_sales->name;
													}
												@endphp
								    			<td>{{ $nama }}</td>
											@endif
								    		<td>{{ $aktivitas_sales->nama_aktivitas_sales }}</td>
								    		<td>{{ $aktivitas_sales->nama_segmentasi_sales }}</td>
								    		<td>{{ $aktivitas_sales->nama_kegiatan_sales }}</td>
								    		<td>{{ General::ubahDBKeTanggal($aktivitas_sales->tanggal_aktivitas_sales) }}</td>
								    		<td class="status-cell {{ $status_class }}">{{ $aktivitas_sales->nama_status_sales ?? '-' }}</td>
								    		<td class="revenue-cell">-</td>
								    		<td class="revenue-cell">-</td>
								    		<td class="revenue-cell">Rp {{ number_format((float)($aktivitas_sales->total_aktivitas_sales ?? 0), 0, ',', '.') }}</td>
								    		<td>{{ $aktivitas_sales->pic_aktivitas_sales }}</td>
								    		<td>{{ $aktivitas_sales->kontak_personal_aktivitas_sales }}</td>
								    		<td style="word-wrap:break-word;overflow-wrap:break-word;">@if(trim($aktivitas_sales->catatan_aktivitas_sales ?? '') !== ''){!! nl2br(e($aktivitas_sales->catatan_aktivitas_sales)) !!}@else - @endif</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										@php
											$colspan = 12;
											if (General::totalHakAkses($link_aktivitas_sales) != 0) $colspan++;
											if (Auth::user()->level_sistems_id == 1) $colspan++;
										@endphp
										<td colspan="{{ $colspan }}" class="center-align">Tidak ada data ditampilkan</td>
									</tr>
								@endif
				    	</tbody>
				    	</table>
				    </div>
					@if(isset($lihat_aktivitas_sales) && method_exists($lihat_aktivitas_sales, 'hasPages') && $lihat_aktivitas_sales->hasPages())
						<div class="col-sm-12 mt-3">
							{{ $lihat_aktivitas_sales->appends(Request::except('page'))->links('vendor.pagination.custom') }}
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection