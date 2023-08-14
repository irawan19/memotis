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
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Catatan</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_tugas->isEmpty())
		            				@foreach($lihat_tugas as $tugas)
								    	<tr>
								    		<td class="nowrap">{!! $tugas->nama_tugas !!}</td>
								    		<td class="nowrap">{!! $tugas->catatan_tugas !!}</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										<td colspan="2" class="center-align">Tidak ada data ditampilkan</td>
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

@endsection