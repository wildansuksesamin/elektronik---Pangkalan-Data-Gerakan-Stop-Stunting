    <table align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
        <thead align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
            <tr align="center" style="vertical-align: center;border: 1px solid black;font-weight : bold">
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">No.</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Nomor KK</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Nama Kepala Keluarga</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Desa / Kelurahan</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Kecamatan</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Kabupaten / Kota</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Provinsi</th>
                <th scope="col" align="center"
                    style="vertical-align: center;border: 1px solid black;font-weight : bold">Nomor HP</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($daftarResponden as $responden)
                <tr style="vertical-align: center;border: 1px solid black;">
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $loop->iteration }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->kartu_keluarga }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->nama_kepala_keluarga }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->desa_kelurahan->nama ?? '' }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->kecamatan->nama ?? '' }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->kabupaten_kota->nama ?? '' }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->provinsi->nama ?? '' }}</td>
                    <td style="vertical-align: center;border: 1px solid black;" align="center">
                        {{ $responden->nomor_hp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
