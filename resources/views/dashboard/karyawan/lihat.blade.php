@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				@foreach($lihat_unit_kerjas as $unit_kerjas)
					@php($tanggal_sekarang = date('Y-m-d'))
					@php($total_karyawans_aktif = \App\Models\Karyawan::whereRaw('tanggal_keluar_karyawans IS NULL')
																	->where('unit_kerjas_id',$unit_kerjas->id_unit_kerjas)
																	->orWhereRaw('tanggal_keluar_karyawans > "'.$tanggal_sekarang.'"')
																	->where('unit_kerjas_id',$unit_kerjas->id_unit_kerjas)
																	->count())
					@php($total_karyawans_tidak_aktif = \App\Models\Karyawan::where('unit_kerjas_id',$unit_kerjas->id_unit_kerjas)
																	->whereRaw('tanggal_keluar_karyawans < "'.$tanggal_sekarang.'"')
																	->count())
					<div class="col-sm-4">
						<div class="card">
							<div class="card-header content-center" style="background-color:#423c3b">
								<div class="text-white" style="padding-top:20px; padding-bottom:20px; padding-right:10px; padding-left: 10px">
									<b style="font-size:18px">{{$unit_kerjas->nama_unit_kerjas}}</b>
									<br/>
									{{$unit_kerjas->lokasi_unit_kerjas}}
								</div>
							</div>
							<div class="card-body row text-center">
								<div class="col">
									<div class="text-value-xl">{{General::konversiNilai($total_karyawans_aktif). ' ' .General::konversiNilaiString($total_karyawans_aktif)}}</div>
									<div class="text-uppercase text-muted small" style="color:green !important">Aktif</div>
								</div>
								<div class="c-vr"></div>
								<div class="col">
									<div class="text-value-xl">{{General::konversiNilai($total_karyawans_tidak_aktif). ' ' .General::konversiNilaiString($total_karyawans_tidak_aktif)}}</div>
									<div class="text-uppercase text-muted small" style="color:red !important">Tidak Aktif</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			
		</div>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<strong>Karyawan</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::tambah($link_karyawan,'dashboard/karyawan/tambah') }}
								{{ General::cetakexcel($link_karyawan,'dashboard/karyawan/cetakexcel') }}
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="GET" action="{{ URL('dashboard/karyawan/cari') }}">
						@csrf
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<select class="form-control select2" id="cari_unit_kerja" name="cari_unit_kerja">
										<option value="" selected>Semua Unit Kerja</option>
										@foreach($lihat_unit_kerjas as $unit_kerjas)
											@php($selected = '')
											@if(!empty($hasil_unit_kerja))
												@if($unit_kerjas->id_unit_kerjas == $hasil_unit_kerja)
													@php($selected = 'selected')
												@endif
											@else
												@if($unit_kerjas->id_unit_kerjas == Request::old('cari_unit_kerja'))
													@php($selected = 'selected')
												@endif
											@endif
											<option value="{{$unit_kerjas->id_unit_kerjas}}" {{ $selected }}>{{$unit_kerjas->nama_unit_kerjas}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="input-group">
									<input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
									<span class="input-group-append">
										<button class="btn btn-primary" type="submit"> Cari</button>
									</span>
								</div>
							</div>
						</div>
	                </form>
	            	<br/>
	            	<div class="scrolltable">
                        <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
				    		<thead>
				    			<tr>
				    				@if(General::totalHakAkses($link_karyawan) != 0)
						    			<th width="5px"></th>
						    		@endif
				    				<th class="nowrap">No</th>
				    				<th class="nowrap">Status</th>
				    				<th class="nowrap">Foto</th>
				    				<th class="nowrap">Nama</th>
				    				<th class="nowrap">Jabatan</th>
				    				<th class="nowrap">Unit Kerja</th>
				    				<th class="nowrap">Lokasi Kerja</th>
				    				<th class="nowrap">NIK GYS</th>
				    				<th class="nowrap">NIK TG</th>
				    				<th class="nowrap">Tanggal Bergabung</th>
				    				<th class="nowrap">Band Posisi</th>
				    				<th class="nowrap">Tanggal Keluar</th>
				    				<th class="nowrap">Status Karyawan</th>
				    				<th class="nowrap">Nomor NPWP</th>
				    				<th class="nowrap">Nomor Identitas (KTP)</th>
				    				<th class="nowrap">Tanggal Lahir</th>
				    				<th class="nowrap">Tempat Lahir</th>
				    				<th class="nowrap">Jenis Kelamin</th>
				    				<th class="nowrap">Agama</th>
				    				<th class="nowrap">Alamat Domisili</th>
				    				<th class="nowrap">Status Perkawinan</th>
				    				<th class="nowrap">Pedidikan Terakhir</th>
				    				<th class="nowrap">Nama Institusi</th>
				    				<th class="nowrap">Hobi</th>
				    				<th class="nowrap">Keahlian Khusus</th>
				    				<th class="nowrap">No HP</th>
				    				<th class="nowrap">Email</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@if(!$lihat_karyawans->isEmpty())
									@php($no = 1)
		            				@foreach($lihat_karyawans as $key => $karyawans)
										@php($no = $lihat_karyawans->firstItem() + $key) 
                                        @if(!empty($karyawans->tanggal_keluar_karyawans))
                                            @if(strtotime($karyawans->tanggal_keluar_karyawans) <= strtotime(date('Y-m-d')))
                                                @php($color = 'color:red')
                                            @else
                                                @php($color = '')
                                            @endif
                                        @else
                                            @php($color = '')
                                        @endif
								    	<tr style={{$color}}>
								    		@if(General::totalHakAkses($link_karyawan) != 0)
								    			<td class="nowrap">
											      	<div class="dropdown">
										            	<button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										            	<div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
										            		{{General::edit($link_karyawan,'dashboard/karyawan/edit/'.$karyawans->id_karyawans)}}
										            		<div class="dropdown-divider"></div>
										            		{{General::hapus($link_karyawan,'dashboard/karyawan/hapus/'.$karyawans->id_karyawans, $karyawans->id_karyawans.' - '.$karyawans->nama_karyawans)}}
										            	</div>
										            </div>
											    </td>
								    		@endif
								    		<td class="nowrap">{{$no}}</td>
								    		<td class="nowrap">
                                                @if(!empty($karyawans->tanggal_keluar_karyawans))
                                                    @if(strtotime($karyawans->tanggal_keluar_karyawans) <= strtotime(date('Y-m-d')))
                                                        Tidak Aktif
                                                    @else
                                                        Aktif
                                                    @endif
                                                @else
                                                    Aktif
                                                @endif
                                            </td>
								    		<td class="nowrap">
                                                <a data-fancybox="gallery" href="{{URL::asset('storage/'.$karyawans->foto_karyawans)}}">
                                                    <img src="{{ URL::asset('storage/'.$karyawans->foto_karyawans) }}" width="32">
                                                </a>
                                            </td>
								    		<td class="nowrap">{{$karyawans->nama_karyawans}}</td>
								    		<td class="nowrap">{{$karyawans->nama_jabatans}}</td>
								    		<td class="nowrap">{{$karyawans->nama_unit_kerjas}}</td>
								    		<td class="nowrap">{!! nl2br($karyawans->lokasi_unit_kerjas) !!}</td>
								    		<td class="nowrap">{{$karyawans->nik_gys_karyawans}}</td>
								    		<td class="nowrap">{{$karyawans->nik_tg_karyawans}}</td>
								    		<td class="nowrap">
                                                @if(!empty($karyawans->tanggal_bergabung_karyawans))    
                                                    {{General::ubahDBKeTanggal($karyawans->tanggal_bergabung_karyawans)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
								    		<td class="nowrap">{{$karyawans->band_posisi_karyawans}}</td>
								    		<td class="nowrap">
                                                @if(!empty($karyawans->tanggal_keluar_karyawans))    
                                                    {{General::ubahDBKeTanggal($karyawans->tanggal_keluar_karyawans)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
								    		<td class="nowrap">{{$karyawans->nama_status_karyawans}}</td>
								    		<td class="nowrap">{{$karyawans->npwp_karyawans}}</td>
								    		<td class="nowrap">{{$karyawans->ktp_karyawans}}</td>
								    		<td class="nowrap">
												@if(!empty($karyawans->tanggal_lahir_karyawans))
													{{General::ubaHDBkeTanggal($karyawans->tanggal_lahir_karyawans)}}
												@else
													-
												@endif
											</td>
								    		<td class="nowrap">{{$karyawans->tempat_lahir_karyawans}}</td>
								    		<td class="nowrap">{{$karyawans->nama_jenis_kelamins}}</td>
								    		<td class="nowrap">{{$karyawans->nama_agamas}}</td>
								    		<td class="nowrap">{!! nl2br($karyawans->alamat_domisili_karyawans) !!}</td>
								    		<td class="nowrap">{{$karyawans->nama_status_kawins}}</td>
								    		<td class="nowrap">{{$karyawans->nama_pendidikans}}</td>
								    		<td class="nowrap">{{$karyawans->institusi_karyawans}}</td>
								    		<td class="nowrap">{!! nl2br($karyawans->hobi_karyawans) !!}</td>
								    		<td class="nowrap">{!! nl2br($karyawans->keahlian_khusus_karyawans) !!}</td>
								    		<td class="nowrap">
                                                <a href="tel:{{$karyawans->no_hp_karyawans}}">
                                                    {{$karyawans->no_hp_karyawans}}
                                                </a>
                                            </td>
								    		<td class="nowrap">
                                                <a href="mailto:{{$karyawans->email_karyawans}}">
                                                    {{$karyawans->email_karyawans}}
                                                </a>
                                            </td>
								    	</tr>
										@php($no++)
								    @endforeach
								@else
									<tr>
										@if(General::totalHakAkses($link_karyawan) != 0)
											<td colspan="28" class="center-align">Tidak ada data ditampilkan</td>
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
											<td style="display:none"></td>
											<td style="display:none"></td>
											<td style="display:none"></td>
										@else
											<td colspan="27" class="center-align">Tidak ada data ditampilkan</td>
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
											<td style="display:none"></td>
											<td style="display:none"></td>
										@endif
									</tr>
								@endif
				    		</tbody>
				    	</table>
				    </div>
					<div class="col-sm-12">
						{{ $lihat_karyawans->appends(Request::except('page'))->links('vendor.pagination.custom') }}
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection