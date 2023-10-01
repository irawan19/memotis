<table>
    <tr>
        <td colspan="24" style="font-weight: bold; text-align: center">Karyawan</td>
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
    </tr>
</table>
<table border="1px">
    <thead>
        <tr>
            <th>No</th>
            <th>Status</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Unit Kerja</th>
            <th>NIK GYS</th>
            <th>NIK TG</th>
            <th>Band Posisi</th>
            <th>Tanggal Bergabung</th>
            <th>Tanggal Keluar</th>
            <th>Nomor Identitas (KTP)</th>
            <th>Tanggal Lahir</th>
            <th>Tempat Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Alamat Rumah</th>
            <th>Status Perkawinan</th>
            <th>Pedidikan Terakhir</th>
            <th>Nama Institusi</th>
            <th>Hobi</th>
            <th>Keahlian Khusus</th>
            <th>No HP</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @if(!$lihat_karyawans->isEmpty())
        @php($no = 1)
        @foreach($lihat_karyawans as $karyawans)
        @if(!empty($karyawans->tanggal_keluar_karyawans))
        @if(strtotime($karyawans->tanggal_keluar_karyawans) < strtotime(date('Y-m-d'))) @php($color='color:red' ) @else @php($color='' ) @endif @else @php($color='' ) @endif @php($no=1))
            <tr {{$color}}>
                <td>{{$no}}</td>
                <td>
                    @if(!empty($karyawans->tanggal_keluar_karyawans))
                    @if(strtotime($karyawans->tanggal_keluar_karyawans) < strtotime(date('Y-m-d'))) Tidak Aktif @else Aktif @endif @else Aktif @endif </td>
                <td>
                    <a href="{{URL::asset('storage/'.$karyawans->foto_karyawans)}}">Klik</a>
                </td>
                <td>{{$karyawans->nama_karyawans}}</td>
                <td>{{$karyawans->nama_jabatans}}</td>
                <td>{{$karyawans->nama_unit_kerjas}}</td>
                <td>{{$karyawans->nik_gys_karyawans}}</td>
                <td>{{$karyawans->nik_tg_karyawans}}</td>
                <td>{{$karyawans->band_posisi_karyawans}}</td>
                <td>
                    @if(!empty($karyawans->tanggal_bergabung_karyawans))
                    {{General::ubahDBKeTanggal($karyawans->tanggal_bergabung_karyawans)}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if(!empty($karyawans->tanggal_keluar_karyawans))
                    {{General::ubahDBKeTanggal($karyawans->tanggal_keluar_karyawans)}}
                    @else
                    -
                    @endif
                </td>
                <td>{{$karyawans->ktp_karyawans}}</td>
                <td>
                    @if(!empty($karyawans->tanggal_lahir_karyawans))
                    {{General::ubaHDBkeTanggal($karyawans->tanggal_lahir_karyawans)}}
                    @else
                    -
                    @endif
                </td>
                <td>{{$karyawans->tempat_lahir_karyawans}}</td>
                <td>{{$karyawans->nama_jenis_kelamins}}</td>
                <td>{{$karyawans->nama_agamas}}</td>
                <td>{!! nl2br($karyawans->alamat_rumah_karyawans) !!}</td>
                <td>{{$karyawans->nama_status_kawins}}</td>
                <td>{{$karyawans->nama_pendidikans}}</td>
                <td>{{$karyawans->institusi_karyawans}}</td>
                <td>{!! nl2br($karyawans->hobi_karyawans) !!}</td>
                <td>{!! nl2br($karyawans->keahlian_khusus_karyawans) !!}</td>
                <td>
                    <a href="tel:{{$karyawans->no_hp_karyawans}}">
                        {{$karyawans->no_hp_karyawans}}
                    </a>
                </td>
                <td>
                    <a href="mailto:{{$karyawans->email_karyawans}}">
                        {{$karyawans->email_karyawans}}
                    </a>
                </td>
            </tr>
            @php($no++)
            @endforeach
            @else
            <tr>
                <td colspan="24" align="right-align">Tidak ada data ditampilkan</td>
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
            </tr>
            @endif
    </tbody>
</table>
