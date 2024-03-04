<!DOCTYPE html>
<html>


<body>

    <div>
     
        <table>
            <tr>
                <td >Nama Institusi</td>
                <td > : </td>
                <td > Laboratorium Klinik RST Soedjono Magelang</td>
            </tr>
            <tr>
                <td >Periode Tanggal</td>
                <td > : </td>
                <td > {{ $startDate }} - {{ $endDate }} </td>
            </tr>
            <tr>
                <td >Nama Asuransi</td>
                <td > : </td>
                <td > {{ $insurance }}  </td>
            </tr>
        </table>

        <br>

        <table id="tb_result" style="border: 1px solid black; margin: 5px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">No</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">Tanggal</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">No. Rekam Medis</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">No. Register</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">No. Lab</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">Nama Pasien</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">Asal</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">Nama Pemeriksaan</th>
                    <th class="border-bottom" style="text-align: center;  border: 1px solid black; border-collapse: collapse; font-weight:bold;">Asuransi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $index = 1;
                @endphp
                @foreach ($supportData as $data)
                <tr>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $index }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ date('Y-m-d', strtotime($data->created_time))  }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->patient_medrec }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->no_order }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->no_lab }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->patient_name }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->room_name }}</td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">
                        @if($data->package_id != null)
                        {{ $data->package_name }}
                        @else
                        {{ $data->test_name }}
                        @endif
                    </td>
                    <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->insurance_name }}</td>
                </tr>
                @php
                $index++;
                @endphp
                @endforeach

            </tbody>
        </table>
</body>

</html>