@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Divisi</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::tambah($link_divisi,'dashboard/divisi/tambah') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/divisi/cari') }}">
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
				    				@if(General::totalHakAkses($link_divisi) != 0)
						    			<th width="5px"></th>
						    		@endif
				    				<th class="nowrap">Nama</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_divisis->isEmpty())
		            				@foreach($lihat_divisis as $divisis)
								    	<tr>
								    		@if(General::totalHakAkses($link_divisi) != 0)
								    			<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{General::edit($link_divisi,'dashboard/divisi/edit/'.$divisis->id_divisis)}}
										            		<div class="dropdown-divider"></div>
										            		{{General::hapus($link_divisi,'dashboard/divisi/hapus/'.$divisis->id_divisis, $divisis->id_divisis.' - '.$divisis->nama_divisis)}}
										            	</div>
										            </div>
											    </td>
								    		@endif
								    		<td class="nowrap">{{$divisis->nama_divisis}}</td>
								    	</tr>
								    @endforeach
								@else
									<tr>
										@if(General::totalHakAkses($link_divisi) != 0)
											<td colspan="2" class="center-align">Tidak ada data ditampilkan</td>
											<td style="display:none"></td>
										@else
											<td class="center-align">Tidak ada data ditampilkan</td>
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