@extends('dashboard.layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<strong>Mom</strong>
						</div>
						<div class="col-sm-6">
							<div class="right-align">
								{{ General::buat($link_mom,'dashboard/mom/tambah', 'MOM') }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if(!$lihat_moms->isEmpty())
			@foreach($lihat_moms as $moms)
				<div class="col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="nav-tabs-boxed">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true">
													Mom
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">
													Detail
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="home-1" role="tabpanel">
												<div class="row">
													<div class="col-sm-6">
														<p class="judulsurat">{{$moms->judul_moms}}</p>
													</div>
													<div class="col-sm-6 right-align">
														<p class="judultanggal">{{General::ubahDBKeTanggalwaktu($moms->tanggal_moms)}}</p>
														<p class="nosurat">0201/MOM/01/2023</p>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="profile-1" role="tabpanel">
												<div class="row">
													<div class="col-sm-6">
														<p class="judulsurat">Judul MOM</p>
													</div>
													<div class="col-sm-6 right-align">
														<p class="judultanggal">21 Juli 2023 00:00:01</p>
														<p class="nosurat">0201/MOM/01/2023</p>
													</div>
													<div class="col-sm-12">
														2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@else

		@endif
	</div>

@endsection