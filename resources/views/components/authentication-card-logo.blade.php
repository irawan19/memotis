@php($ambil_konfigurasi_aplikasi = \App\Models\Master_konfigurasi_aplikasi::first())
<a href="{{URL('/')}}">
    <img src="{{URL::asset('storage/'.$ambil_konfigurasi_aplikasi->logo_konfigurasi_aplikasis)}}" width="128px">
</a>
