@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <strong>List Tugas {{$lihat_status_tugas->nama_status_tugas}}</strong>
				</div>
				<div class="card-body">
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				<th class="nowrap">MOM</th>
				    				<th class="nowrap">Proyek</th>
				    				<th class="nowrap">Tugas</th>
									@php($ambil_divisis = \App\Models\Master_level_sistem::where('id_level_sistems',Auth::user()->level_sistems_id)
																						->first())
									@if(Auth::user()->level_sistems_id == 1 || $ambil_divisis->divisis_id == null)
										<th class="nowrap">Ditugaskan</th>
									@endif
				    				<th class="nowrap">Tenggat Waktu</th>
				    				<th class="nowrap">Dikirimkan</th>
				    				<th class="nowrap">Catatan</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_tugas->isEmpty())
		            				@foreach($lihat_tugas as $tugas)
								    	<tr>
								    		<td class="nowrap">{{ $tugas->no_moms }}</td>
								    		<td class="nowrap">{{ $tugas->proyek_mom_users }}</td>
								    		<td class="nowrap">{!! nl2br($tugas->tugas_mom_users) !!}</td>
											@if(Auth::user()->level_sistems_id == 1 || $ambil_divisis->divisis_id == null)
												@php($nama = $tugas->nama_level_sistems.' - '.$tugas->name)
												@if(!empty($tugas->id_divisis))
													@php($nama = $tugas->nama_level_sistems.' - '.$tugas->nama_divisis.' - '.$tugas->name)
												@endif
								    			<td class="nowrap">{{ $nama }}</td>
											@endif
								    		<td class="nowrap">
												@if($tugas->tenggat_waktu_mom_users != null)
													{{General::ubahDBKeTanggal($tugas->tenggat_waktu_mom_users)}}
												@endif
											</td>
								    		<td class="nowrap">{{$tugas->dikirimkan_mom_users}}</td>
								    		<td class="nowrap">{!! nl2br($tugas->catatan_mom_users) !!}</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										@if(Auth::user()->level_sistems_id == 1 || $ambil_divisis->divisis_id == null)
											<td colspan="7" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="6" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@endif
									</tr>
								@endif
				    		</tbody>
				    	</table>
				    </div>
				</div>
				<div class="card-footer right-align">
	                    @php($ambil_kembali = URL('dashboard'))
						{{General::batal($ambil_kembali)}}
			        </div>
			</div>
		</div>
	</div>

@endsection