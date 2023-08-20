@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
    <div class="col-sm-12">
			<div class="card">
				<form class="form-horizontal m-t-40" action="{{ URL('dashboard/mom/prosestambahtugas/'.$lihat_moms->id_moms) }}" method="POST">
					{{ csrf_field() }}
					<div class="card-header">
						<strong>Tambah Tugas</strong>
					</div>
					<div class="card-body">
						@if (Session::get('setelah_simpan.alert') == 'sukses')
					    	{{ General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					    @endif
                        <div class="form-group">
                            <label class="form-col-form-label" for="users_id">Peserta Internal <b style="color:red">*</b></label>
                            <select class="form-control select2" id="users_id" name="users_id">
                                @foreach($tambah_users as $users)
									@php($nama = $users->nama_level_sistems.' - '.$users->name)
									@if(!empty($users->id_divisis))
										@php($nama = $users->nama_level_sistems.' - '.$users->nama_divisis.' - '.$users->name)
									@endif
                                    <option value="{{$users->id}}" {{ Request::old('users') == $users->id ? $select='selected' : $select='' }}>{{$nama}}</option>
                                @endforeach
                            </select>
                            {{General::pesanErrorForm($errors->first('status_tugas_id'))}}
                        </div>
						<div class="form-group">
							<label class="form-col-form-label" for="tugas_mom_users">Tugas <b style="color:red">*</b></label>
                            <textarea class="form-control {{ General::validForm($errors->first('tugas_mom_users')) }}" id="tugas_mom_users" name="tugas_mom_users" rows="5">{{Request::old('tugas_mom_users')}}</textarea>
							{{General::pesanErrorForm($errors->first('tugas_mom_users'))}}
						</div>
                        <div class="form-group">
                            <label class="form-col-form-label" for="status_tugas_id">Status <b style="color:red">*</b></label>
                            <select class="form-control select2" id="status_tugas_id" name="status_tugas_id">
                                @foreach($tambah_status_tugas as $status_tugas)
                                    <option value="{{$status_tugas->id_status_tugas}}" {{ Request::old('status_tugas_id') == $status_tugas->id_status_tugas ? $select='selected' : $select='' }}>{{$status_tugas->nama_status_tugas}}</option>
                                @endforeach
                            </select>
                            {{General::pesanErrorForm($errors->first('status_tugas_id'))}}
                        </div>
						<div class="form-group">
							<label class="form-col-form-label" for="catatan_mom_users">Catatan <b style="color:red">*</b></label>
                            <textarea class="form-control {{ General::validForm($errors->first('catatan_mom_users')) }}" id="catatan_mom_users" name="catatan_mom_users" rows="5">{{Request::old('catatan_mom_users')}}</textarea>
							{{General::pesanErrorForm($errors->first('catatan_mom_users'))}}
						</div>
					</div>
			        <div class="card-footer right-align">
						{{General::simpan()}}
			          	@if(request()->session()->get('halaman') != '')
		            		@php($ambil_kembali = request()->session()->get('halaman'))
	                    @else
	                    	@php($ambil_kembali = URL('dashboard/status_tugas'))
	                    @endif
						{{General::batal($ambil_kembali)}}
			        </div>
				</form>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<strong>Tugas {{$lihat_moms->no_moms}}</strong>
				</div>
				<div class="card-body">
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				<th class="nowrap" width="5px">No</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Tugas</th>
				    				<th class="nowrap">Status</th>
				    				<th class="nowrap">Catatan</th>
				    				<th class="nowrap">Hapus</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_mom_users->isEmpty())
                                    @php($no = 1)
		            				@foreach($lihat_mom_users as $mom_users)
								    	<tr>
											@php($nama = $mom_users->nama_level_sistems.' - '.$mom_users->name)
											@if(!empty($mom_users->id_divisis))
												@php($nama = $mom_users->nama_level_sistems.' - '.$mom_users->nama_divisis.' - '.$mom_users->name)
											@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">{{$nama}}</td>
								    		<td class="nowrap">{!! nl2br($mom_users->tugas_mom_users) !!}</td>
								    		<td class="nowrap">{{$mom_users->nama_status_tugas}}</td>
								    		<td class="nowrap">{!! nl2br($mom_users->catatan_mom_user) !!}</td>
                                            <td>
                                                {{General::hapusButtonTanpaAkses('dashboard/mom/proseshapustugas/'.$mom_users->id_mom_users, 'Tugas no '.$no)}}
                                            </td>
								    	</tr>
                                        @php($no++)
								    @endforeach
								@else
									<tr>
										<td colspan="6" class="center-align">Tidak ada data ditampilkan</td>
										<td style="display:none"></td>
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
			    <div class="card-footer right-align">
			      	@if(request()->session()->get('halaman') != '')
		        		@php($ambil_kembali = request()->session()->get('halaman'))
	                @else
	                	@php($ambil_kembali = URL('dashboard/mom'))
	                @endif
					{{General::batal($ambil_kembali)}}
			    </div>
			</div>
		</div>
	</div>

@endsection