<!-- app/Views/mahasiswa/home.php -->

<?php

function calculateIndex($param) {
    if ($param >= 80) {
        return 'A';
    } else if ($param >= 75) {
        return 'AB';
    } else if ($param >= 70) {
        return 'B';
    } else if ($param >= 65) {
        return 'BC';
    } else if ($param >= 60) {
        return 'C';
    } else if ($param >= 50) {
        return 'D';
    } else {
        return 'E';
    }
}

function convertIndexTo4($param) {
    if ($param == 'A') {
        return 4;
    } else if ($param == 'AB') {
        return 3.5;
    } else if ($param == 'B') {
        return 3;
    } else if ($param == 'BC') {
        return 2.5;
    } else if ($param == 'C') {
        return 2;
    } else if ($param == 'D') {
        return 1;
    } else {
        return 0;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Mahasiswa</title>
    <style>
        body {
            background: #00bcd4;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin: 20px 0;
        }

        form {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
        }

        button {
            background-color: #800000;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        div {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            border: 3px solid #000;
            width: 80%;
            text-align: center;
            margin: 0 auto;
            background: linear-gradient(to right, #4dd7ec, #26a69a);
            border-radius: 10px;
            margin-top: -25px; /* Adjust this value to move the table upwards */
        }   

        th, td {
            padding: 15px;
            line-height: 1.6;
            border: 1px solid #000;
            color: #000;
        }

        th {
            background: linear-gradient(to right, #1a7b95, #1a7b6d);
            color: #fff;
            font-size: 18px;
            border-bottom: 2px solid #000;
        }

        tr {
            border-bottom: 1px solid #000;
        }

        tr:nth-child(odd) {
            background: linear-gradient(to right, #dff3fa, #b6e1f3);
        }

        .empty-row td {
            height: 10px;
            background: #00bcd4;
            border: none;
            border-left: none;
            border-right: none;
        }

        .logout-button {
            margin-top: -50px; /* Adjust this value to move the table upwards */
            margin-right: 123px; /* Replace with desired default positioning */
            margin-bottom: 15px;
        }

        @media only screen and (min-zoom: 1.2) {
            .logout-button {
                margin-right: 10px; /* Adjust margin for zoomed-in state */
            }
        }

        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h1 style="color: black;">Welcome, <?= session('user_data')['nama'] ?>!</h1>
    </div>

    <div style="display: flex; flex-direction: column; align-items: flex-end; padding: 10px;">
        <form action="/mahasiswa/logout" method="post">
            <button type="submit" class="logout-button" style="color: white;">Logout</button>
        </form>
        
        <table>
            <tr>
                <th style="color: black;">No</th>
                <th style="color: black;">Class Code</th>
                <th style="color: black;">Class Name</th>
                <th style="color: black;">SKS</th>
                <th style="color: black;">Index</th>
            </tr>

            <?php
                function syncData() {
                    // Use the CodeIgniter curlrequest service to make a GET request
                    $client = \Config\Services::curlrequest();
                    $response = $client->request('GET', 'http://localhost:8080/api/penilaian-dosen', [
                        'headers' => [
                            'Accept' => 'application/json',
                        ]
                    ]);

                    // Check if the API request was successful (status code 200)
                    if ($response->getStatusCode() == 200) {
                        // Decode the JSON response into an associative array
                        $data = json_decode($response->getBody(), true);

                        // Get the logged-in user's nim from the session
                        $nim = session('user_data')['nim'];

                        // Filter $data to include only items where 'nim' matches the session's nim
                        $filteredData = array_filter($data, function ($item) use ($nim) {
                            return $item['nim'] == $nim;
                        });

                        // Return the filtered data
                        return $filteredData;
                    }

                    // Return an empty array in case of failure
                    return [];
                }

                $nilai = syncData();

                function printRows($nilai) {
                    $modelMahasiswa = new \App\Models\ModelMahasiswa();

                    $totalScore = 0;
                    $totalSKS = 0;

                    $mahasiswa = $modelMahasiswa->getMahasiswaByNIM(session('user_data')['nim']);
                    $currentOverallSKS = $mahasiswa[0]['totalsks'];
                    $currentTotalIPKScore = $mahasiswa[0]['ipk'] * $currentOverallSKS;

                    $nim = session('user_data')['nim'];
                    $mataKuliah = $modelMahasiswa->getMataKuliahByNIM($nim);

                    $i = 1;
                    foreach ($mataKuliah as $row) {
                        $classCode = $row['kode_matkul'];
                        $className = $row['nama'];
                        $sks = $row['sks'];

                        // Find the corresponding nilai_akhir from $nilai
                        $matchingNilai = array_filter($nilai, function ($item) use ($classCode) {
                            return $item['kode'] == $classCode;
                        });

                        // If a matching entry is found, use its nilai_akhir, otherwise, use a default value
                        $nilai_akhir = !empty($matchingNilai) ? reset($matchingNilai)['nilai_akhir'] : 0;                        
                        $index = calculateIndex($nilai_akhir);
                        
                        if ($row['pernah_update'] == "no") { // no previous index yet
                            $currentTotalIPKScore += convertIndexTo4($index) * $sks;
                            $currentOverallSKS += $sks;

                            $modelMahasiswa->createNewNilaiMatkul($nim, $classCode, $index);
                            $modelMahasiswa->markUpdated($nim, $classCode, "yes");
                        } else if ($row['pernah_update'] == "yes") { // has already been updated; need adjustments
                            $lastIndex = $modelMahasiswa->getIndeksMataKuliah($nim, $classCode);
                            $currentTotalIPKScore = ($currentTotalIPKScore - ((convertIndexTo4($lastIndex[0]['indeks']) - convertIndexTo4($index)) * $sks));

                            $modelMahasiswa->updateIndeksMatkul($nim, $classCode, $lastIndex[0]['indeks']);
                        }

                        $totalScore += convertIndexTo4($index) * $sks;
                        $totalSKS += $sks;

                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $classCode . "</td>";
                        echo "<td>" . $className . "</td>";
                        echo "<td>" . $sks . "</td>";
                        echo "<td>" . $index . "</td>";
                        echo "</tr>";
                    }
                    $IP = $totalScore / $totalSKS;
                    $IPK = $currentTotalIPKScore / $currentOverallSKS;

                    $modelMahasiswa->updateIPAndIPK($nim, $IP, $IPK, $currentOverallSKS);

                    echo '<tr class="empty-row">';
                    echo '<td colspan="5"></td>';
                    echo '</tr>';

                    echo '<tr class="ip-row">';
                    echo '<td colspan="2" style="background: #00bcd4;"></td>';
                    echo '<td colspan="1" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">IP</td>';
                    echo '<td colspan="2" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">' . number_format($IP, 2) . '</td>';
                    echo '</tr>';

                    echo '<tr class="ipk-row">';
                    echo '<td colspan="2" style="background: #00bcd4;"></td>';
                    echo '<td colspan="1" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">IPK</td>';
                    echo '<td colspan="2" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">' . number_format($IPK, 2) . '</td>';
                    echo '</tr>';

                    // return ($totalScore / $totalSKS);
                }

                printRows($nilai);
                // $IP = printRows($nilai);

                // $IPK = 0;
                // if (session('user_data')['ipk'] != null) {
                //     $IPK = session('user_data')['ipk'];
                // }

                // echo '<tr class="empty-row">';
                // echo '<td colspan="5"></td>';
                // echo '</tr>';

                // echo '<tr class="ip-row">';
                // echo '<td colspan="2" style="background: #00bcd4;"></td>';
                // echo '<td colspan="1" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">IP</td>';
                // echo '<td colspan="2" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">' . number_format($IP, 2) . '</td>';
                // echo '</tr>';

                // echo '<tr class="ipk-row">';
                // echo '<td colspan="2" style="background: #00bcd4;"></td>';
                // echo '<td colspan="1" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">IPK</td>';
                // echo '<td colspan="2" style="background: linear-gradient(to right, #ffc107, #ff8c00); font-weight: bold;">' . number_format($IPK, 2) . '</td>';
                // echo '</tr>';
            ?>

        </table>
    </div>
</body>
</html>

