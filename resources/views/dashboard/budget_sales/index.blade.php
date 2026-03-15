@extends('dashboard.layouts.app')
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<strong>Input Budget Sales</strong>
				<span class="small text-muted ml-2">— Form isian target & budget per sales per bulan (bukan laporan). Data yang disimpan dipakai di Laporan Sales Activity.</span>
			</div>
			<div class="card-body">
				@if (Session::get('setelah_simpan.alert') == 'sukses')
					{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
				@endif
				@if (Session::get('setelah_simpan.alert') == 'error')
					<div class="alert alert-danger">{{ Session::get('setelah_simpan.text') }}</div>
				@endif

				{{-- Filter: Pilih periode & unit --}}
				<form method="GET" action="{{ URL('dashboard/budget_sales') }}" class="mb-4">
					<div class="row align-items-end">
						<div class="col-md-2">
							<label class="form-col-form-label">Bulan</label>
							<select class="form-control" name="bulan">
								@for($b = 1; $b <= 12; $b++)
									<option value="{{ $b }}" {{ (int)($bulan ?? 0) === $b ? 'selected' : '' }}>{{ General::ubahDBKeBulan($b) }}</option>
								@endfor
							</select>
						</div>
						<div class="col-md-2">
							<label class="form-col-form-label">Tahun</label>
							<select class="form-control" name="tahun">
								@for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
									<option value="{{ $y }}" {{ (int)($tahun ?? 0) === $y ? 'selected' : '' }}>{{ $y }}</option>
								@endfor
							</select>
						</div>
						<div class="col-md-3">
							<label class="form-col-form-label">Unit Kerja</label>
							<select class="form-control" name="unit_kerjas_id">
								<option value="">— Semua unit —</option>
								@foreach($unit_kerjas ?? [] as $uk)
									<option value="{{ $uk->id_unit_kerjas }}" {{ ($unit_kerjas_id ?? '') == $uk->id_unit_kerjas ? 'selected' : '' }}>{{ $uk->nama_unit_kerjas }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">Tampilkan form isian</button>
						</div>
					</div>
				</form>

				@if(count($users ?? []) > 0)
					<p class="text-muted small mb-2">Periode: <strong>{{ $period_label ?? $period ?? '' }}</strong>. Isi target & budget per baris lalu klik <strong>Simpan Budget</strong>.</p>
					<form method="POST" action="{{ URL('dashboard/budget_sales/simpan') }}">
						{{ csrf_field() }}
						<input type="hidden" name="period" value="{{ $period ?? '' }}">
						@if(($unit_kerjas_id ?? '') !== '')
							<input type="hidden" name="unit_kerjas_id" value="{{ $unit_kerjas_id }}">
						@endif
						<div class="table-responsive">
							<table class="table table-bordered table-sm">
								<thead class="thead-light">
									<tr>
										<th>Nama Sales</th>
										<th>Unit Kerja</th>
										<th class="text-right">Total Sales Target</th>
										<th class="text-right">Room Rev Target</th>
										<th class="text-right">FB Rev Target</th>
										<th class="text-right">Budget W1</th>
										<th class="text-right">Budget W2</th>
										<th class="text-right">Budget W3</th>
										<th class="text-right">Budget W4</th>
									</tr>
								</thead>
								<tbody>
									@foreach($users as $u)
										@php
											$b = $budgetsByUser[$u->id] ?? null;
										@endphp
										<tr>
											<td>{{ $u->name }}</td>
											<td>{{ $u->nama_unit_kerjas ?? '—' }}</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][total_sales_target]" value="{{ $b ? General::ubahDBKeHarga($b->total_sales_target) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][room_rev_target]" value="{{ $b && $b->room_rev_target !== null ? General::ubahDBKeHarga($b->room_rev_target) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][fb_rev_target]" value="{{ $b && $b->fb_rev_target !== null ? General::ubahDBKeHarga($b->fb_rev_target) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][budget_w1]" value="{{ $b ? General::ubahDBKeHarga($b->budget_w1) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][budget_w2]" value="{{ $b ? General::ubahDBKeHarga($b->budget_w2) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][budget_w3]" value="{{ $b ? General::ubahDBKeHarga($b->budget_w3) : '' }}" placeholder="0">
											</td>
											<td>
												<input type="text" class="form-control form-control-sm text-right priceformat" name="users[{{ $u->id }}][budget_w4]" value="{{ $b ? General::ubahDBKeHarga($b->budget_w4) : '' }}" placeholder="0">
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-right mt-2">
							<button type="submit" class="btn btn-success">Simpan Budget</button>
						</div>
					</form>
				@else
					<p class="text-muted">Tidak ada data sales. List hanya menampilkan user yang punya Aktivitas Sales. Isi dulu aktivitas sales agar user muncul di sini, atau pilih unit kerja lain.</p>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection
