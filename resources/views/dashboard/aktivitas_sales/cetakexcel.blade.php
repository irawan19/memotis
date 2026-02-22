<table border="1" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background: #c9952e; color: #fff; font-weight: bold;">
            <th>NO</th>
            @if($is_admin)
            <th>USER</th>
            @endif
            <th>COMPANY</th>
            <th>SEGMENTATION</th>
            <th>SALES</th>
            <th>DATE</th>
            <th>STATUS</th>
            <th>INCOM REVENUE</th>
            <th>BANQUET REVENUE</th>
            <th>NETT REVENUE</th>
            <th>PIC</th>
            <th>CONTACT</th>
            <th>RESULT</th>
        </tr>
    </thead>
    <tbody>
        @if(!$lihat_aktivitas_sales->isEmpty())
            @foreach($lihat_aktivitas_sales as $no => $row)
            @php
                $nama_user = $row->nama_level_sistems . ' - ' . $row->name;
                if(!empty($row->id_divisis)) {
                    $nama_user = $row->nama_level_sistems . ' - ' . ($row->nama_divisis ?? '') . ' - ' . $row->name;
                }
            @endphp
            <tr>
                <td>{{ $no + 1 }}</td>
                @if($is_admin)
                <td>{{ $nama_user }}</td>
                @endif
                <td>{{ $row->nama_aktivitas_sales }}</td>
                <td>{{ $row->nama_segmentasi_sales }}</td>
                <td>{{ $row->nama_kegiatan_sales }}</td>
                <td>{{ General::ubahDBKeTanggal($row->tanggal_aktivitas_sales) }}</td>
                <td>{{ $row->nama_status_sales ?? '-' }}</td>
                <td style="text-align:right">-</td>
                <td style="text-align:right">-</td>
                <td style="text-align:right">Rp {{ number_format((float)($row->total_aktivitas_sales ?? 0), 0, ',', '.') }}</td>
                <td>{{ $row->pic_aktivitas_sales }}</td>
                <td>{{ $row->kontak_personal_aktivitas_sales }}</td>
                <td>{{ trim($row->catatan_aktivitas_sales ?? '') !== '' ? $row->catatan_aktivitas_sales : '-' }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="{{ $is_admin ? 13 : 12 }}" style="text-align:center">Tidak ada data</td>
            </tr>
        @endif
    </tbody>
</table>
