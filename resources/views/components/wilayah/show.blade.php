@push('script')
<script>
    $(function() {
        $.get("{{ route('listProvinsi') }}", function(result) {
            $.each(result, function(key, val) {  
                if (val.id == '{{ $provinsi }}' ) {
                    $('#provinsi').html(val.nama);
                    return false;
                } 
            })
        });

        $.get("{{ route('listKabupatenKota') }}", {idProvinsi: '{{$provinsi}}'}, function(result) {
            $.each(result, function(key, val) {
                if (val.id == '{{ $kabupaten_kota }}' ) {
                    $('#kabupaten_kota').html(val.nama);
                    return false;
                } 
            })
        });

        $.get("{{ route('listKecamatan') }}", {idKabupatenKota: '{{$kabupaten_kota}}'}, function(result) {
            $.each(result, function(key, val) {
                if (val.id == '{{ $kecamatan }}' ) {
                    $('#kecamatan').html(val.nama);
                    return false;
                } 
            })
        });

        $.get("{{ route('listDesaKelurahan') }}", {idKecamatan: '{{$kecamatan}}'}, function(result) {
            $.each(result, function(key, val) {
                if (val.id == '{{ $desa_kelurahan }}' ) {
                    $('#desa_kelurahan').html(val.nama);
                    return false;
                } 
            })
        });
    });
</script>
@endpush