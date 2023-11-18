@extends('dashboard.layouts.app')
@section('content')

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
								{{ General::tambah($link_aktivitas_sales,'dashboard/aktivitas_sales/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/aktivitas_sales/cari') }}">
						@csrf
	                	<div class="input-group">
	                		<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
	                		<span class="input-group-append">
	                		  	<button class="btn btn-primary" type="submit"> Cari</button>
	                		</span>
	                	</div>
	                </form>
	            	<br/>
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				@if(General::totalHakAkses($link_aktivitas_sales) != 0)
						    			<th width="5px"></th>
						    		@endif
				    				<th class="nowrap">Tanggal</th>
				    				<th class="nowrap">Kegiatan</th>
				    				<th class="nowrap">Segmentasi</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Alamat</th>
				    				<th class="nowrap">PIC</th>
				    				<th class="nowrap">Kontak Personal</th>
				    				<th class="nowrap">Status</th>
				    				<th class="nowrap">Project</th>
				    				<th class="nowrap">Jangka Waktu</th>
				    				<th class="nowrap">Total</th>
				    				<th class="nowrap">Catatan</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_aktivitas_sales->isEmpty())
		            				@foreach($lihat_aktivitas_sales as $aktivitas_sales)
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
								    		<td class="nowrap">{{General::ubahDBKeTanggal($aktivitas_sales->tanggal_aktivitas_sales)}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->nama_kegiatan_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->nama_segmentasi_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->nama_aktivitas_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->alamat_aktivitas_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->pic_aktivitas_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->kontak_personal_aktivitas_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->nama_status_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->nama_project_sales}}</td>
								    		<td class="nowrap">{{$aktivitas_sales->jangka_waktu_aktivitas_sales}}</td>
								    		<td class="nowrap right-align">{{$aktivitas_sales->total_aktivitas_sales}}</td>
								    		<td class="nowrap">{!! nl2br($aktivitas_sales->catatan_aktivitas_sales) !!}</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										@if(General::totalHakAkses($link_aktivitas_sales) != 0)
											<td colspan="13" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="12" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
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
			</div>
		</div>
	</div>

@endsection