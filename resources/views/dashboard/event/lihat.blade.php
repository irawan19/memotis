@extends('dashboard.layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Event</strong>
                    </div>
                    <div class="col-sm-6">
                        <div class="right-align">
                            {{ General::tambah($link_event, 'dashboard/event/tambah') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ URL('dashboard/event/cari') }}">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{ $hasil_kata }}">
                        <span class="input-group-append">
                            <button class="btn btn-primary" type="submit"> Cari</button>
                        </span>
                    </div>
                </form>
                <br />
                <div class="scrolltable">
                    <table id="tablesort" class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                @if (General::totalHakAkses($link_event) != 0)
                                <th width="5px"></th>
                                @endif
                                <th class="nowrap">Mulai</th>
                                <th class="nowrap">Selesai</th>
                                <th class="nowrap">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$lihat_events->isEmpty())
                            @foreach ($lihat_events as $events)
                            <tr>
                                @if (General::totalHakAkses($link_event) != 0)
                                <td class="nowrap">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            {{ General::edit($link_event, 'dashboard/event/edit/' . $events->id_events) }}
                                            <div class="dropdown-divider"></div>
                                            {{ General::hapus($link_event, 'dashboard/event/hapus/' . $events->id_events, $events->id_events . ' - ' . $events->nama_events) }}
                                        </div>
                                    </div>
                                </td>
                                @endif
                                <td class="nowrap">{{ General::ubahDBKeTanggalwaktu($events->mulai_events) }}
                                </td>
                                <td class="nowrap">{{ General::ubahDBKeTanggalwaktu($events->selesai_events) }}
                                </td>
                                <td class="nowrap">{{ $events->nama_events }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                @if (General::totalHakAkses($link_event) != 0)
                                <td colspan="4" class="center-align">Tidak ada data ditampilkan</td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                                @else
                                <td colspan="3" class="center-align">Tidak ada data ditampilkan</td>
                                <td style="display:none"></td>
                                <td style="display:none"></td>
                                @endif
                            </tr>
                            @endif
                        </tbody>
                    </table>
					<div class="col-sm-12">
						{{ $lihat_events->appends(Request::except('page'))->links('vendor.pagination.custom') }}
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
