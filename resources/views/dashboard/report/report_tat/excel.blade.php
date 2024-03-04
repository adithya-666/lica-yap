<!DOCTYPE html>
<html>

<head>

</head>

<body>

    <div>
    
        <table>

            <tr>
                <td>Nama Institusi</td>
                <td> : </td>
                <td> Laboratorium Klinik RST Soedjono Magelang</td>
            </tr>
            <tr>
                <td >Periode Tanggal</td>
                <td > : </td>
                <td > {{ $startDate }} - {{ $endDate }} </td>
            </tr>
        </table>

        <br>

        <table style="border: 1px solid black; margin: 5px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">No</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Tanggal</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">No Lab</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Check in Time</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Analytic Time</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Verify Time</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Validate Time</th>
                    <th style="text-align: center; border: 1px solid black; border-collapse: collapse;">Post Time</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $index = 1;
                $total_time ='';
                $date_time ='';
                $finish_time ='';
                $temp_totals = 0;
                $total_raw = 0;
                $count_tat_dibawah_target = 0;
                $count_tat_diatas_target = 0;
                $tat_in_seconds = 0;
                $target_tat_in_seconds = 140 * 60;
                $hasilPerHari = [];
                $tanggalDitemukan = [];
                $jumlahBarisPerTanggal = [];
                $counterPerTanggal = [];
                $tanggal_perhari = [];
                $averange_time= 0;
                $averange= 0;
                foreach ($tatData as $key => $data) {
    $checkin_time = \Carbon\Carbon::parse($data->checkin_time);
    $analytic = \Carbon\Carbon::parse($data->analytic_time);
    $verify = \Carbon\Carbon::parse($data->verify_time);
    $validate = \Carbon\Carbon::parse($data->validate_time);
    
    if ($data->post_time != null || $data->post_time != '') {
        $post = \Carbon\Carbon::parse($data->post_time);
    }

    $date = date('d-m-Y', strtotime($data->created_time));

    $analytics = strtotime($analytic) - strtotime($checkin_time);
    $analytic_time = gmdate('H:i:s', $analytics);

    $validates = strtotime($validate) - strtotime($checkin_time);
    $validate_time = gmdate('H:i:s', $validates);

    $verifys = strtotime($verify) - strtotime($checkin_time);
    $verify_time = gmdate('H:i:s', $validates);

    if ($data->post_time != null || $data->post_time != '') {
        $posts = strtotime($post) - strtotime($checkin_time);
        $post_time = gmdate('H:i:s', $posts);

        $anal_val = $analytics + $validates + $verifys;
        $total_raw = $posts + $anal_val;
    } else {
        $post_time = '-';
        $posts = 0;
        $anal_val = $analytics + $validates + $verifys;
        $total_raw = $posts + $anal_val;
    }

    if (!isset($hasilPerHari[$date])) {
        $hasilPerHari[$date] = [
            'sum' => 0,
            'date' => $date,
            'jumlah' => 0
        ];
    }

    $tatData[$key]->analytic_time =  $analytic_time;
    $tatData[$key]->validate_time =  $validate_time;
    $tatData[$key]->verify_time =  $verify_time;
    $tatData[$key]->post_time =  $post_time;

    $hasilPerHari[$date]['sum'] += $total_raw;

?>





    <tr>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $index }}</td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ date('d/m/Y', strtotime($data->created_time)) }}</td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $data->no_lab }}</td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ date('d/m/Y H:i:s', strtotime($checkin_time)) }}</td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">+ {{ $data->analytic_time }} </td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">+ {{ $data->verify_time }} </td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">+ {{ $data->validate_time }} </td>
        <td style="text-align: center; border: 1px solid black; border-collapse: collapse;">
            @if($data->post_time != '-' )
            +    {{ $data->post_time }} 
            @else
            -
            @endif
           
        </td>
   
    </tr>
    <?php
    $index++;
    $hasilPerHari[$date]['jumlah'] = $index;
    }
    ?>
    </tbody>



</table>

<?php
//   echo '<pre>';
//   print_r($hasilPerHari);
//       die;
$x = 1;
    ?>


<table  id="tb_result" style="border: 1px solid black; margin-top: 15px; margin-left:0px; border-collapse: collapse; width:50%;">
    <thead>
        <tr>
            <td style="text-align: center; border: 1px solid black; ">No.</td>
            <td style="text-align: center; border: 1px solid black; ">Tanggal</td>
            <td style="text-align: center; border: 1px solid black; ">RATA - RATA TOTAL</td>
        </tr>
    </thead>
    <tbody>
        @foreach($hasilPerHari as $dates => $hasil) 
@if( $date_time == '' || $date_time != $hasil['date'] )
@php
    $date_time = $hasil['date'];
    $sum = $hasil['sum'];
    $averange_time = $sum / ($hasil['jumlah'] - 1);
    $averange = gmdate('H:i:s', $averange_time);
@endphp
        <tr>
           <td style="text-align: center; border: 1px solid black; ">{{ $x }}</td>
           <td style="text-align: center; border: 1px solid black; ">{{ $hasil['date'] }}</td>
           <td style="text-align: center; border: 1px solid black; ">{{ $averange }}</td>
        </tr>
        @endif
<?php
$x++;
?>
@endforeach

    </tbody>
</table>


</body>

</html>