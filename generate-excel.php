<?php
// $data = array(
//     array("Provinsi" => "Natly", "Kabupaten" => "Jones", "Link" => "natly@gmail.com", "Kecamatan" => "Test Kecamatan by Natly"),
//     array("Provinsi" => "Codex", "Kabupaten" => "World", "Link" => "info@codexworld.com", "Kecamatan" => "Test Kecamatan by CodexWorld"),
//     array("Provinsi" => "John", "Kabupaten" => "Thomas", "Link" => "john@gmail.com", "Kecamatan" => "Test Kecamatan by John"),
//     array("Provinsi" => "Michael", "Kabupaten" => "Vicktor", "Link" => "michael@gmail.com", "Kecamatan" => "Test Kecamatan by Michael"),
//     array("Provinsi" => "Sarah", "Kabupaten" => "David", "Link" => "sarah@gmail.com", "Kecamatan" => "Test Kecamatan by Sarah")
// );
//print("<pre>" . print_r($data, true) . "</pre>");

function generateKecamatan($kode_prov)
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);

    $i = 0;
    foreach ($data as $element) {
        //check the property of every element
        if ($element->LEVEL == 4) {
            unset($data[$i]);
        }
        $i++;
    }


    $prov = "";
    $arraykab = array();
    $arraykec = array();
    foreach ($data as $d) {
        //unset($d->MST_KODE_WILAYAH);
        if (substr($d->KODE_WILAYAH, 0, 2) == $kode_prov) {
            if ($d->LEVEL == 1) {
                $prov = str_replace("PROV. ", "", $d->NAMA);
            }
            if ($d->LEVEL == 2) {
                if ($d->NAMA[3] != 'A') {
                    $kode_kab = $d->KODE_WILAYAH;
                    $arraykab[] = array('kode_kab' => $kode_kab, 'nama' => $d->NAMA);
                } else {
                    $kode_kab = $d->KODE_WILAYAH;
                    $arraykab[] = array('kode_kab' => $kode_kab, 'nama' => $d->NAMA);
                }
            }
        }
    }
    echo $prov;
    // print_r($arraykab[12]['nama'][1]);
    // die;
    foreach ($arraykab as $kab) {
        foreach ($data as $d) {
            if ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'A') {
                // $file1 = 'KSK Banjarsari';
                $newV = str_replace("KAB. ", "", $kab['nama']);
                $newK = str_replace("KAB.", "BPS KABUPATEN", $kab['nama']);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $newQ = str_replace("KAB. ", "", $kab['nama']);
                $newQa = strtolower($newQ);
                $newQab = ucwords($newQa);
                $newFilePath1 =  'C:\\xampp\\htdocs\\wilayah\\' . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\' . $newC . '.docx';
                $arraykec[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1, 'Kecamatan' => $d->NAMA);
            } elseif ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'O') {
                $newV = str_replace("KAB. ", "", $kab['nama']);
                $newK = str_replace("KOTA", "BPS KOTA", $kab['nama']);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $newQ = str_replace("KOTA ", "", $kab['nama']);
                $newQa = strtolower($newQ);
                $newQab = ucwords($newQa);
                $newFilePath1 = 'C:\\xampp\\htdocs\\wilayah\\' . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\' . $newC . '.docx';
                $arraykec[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1, 'Kecamatan' => $d->NAMA);
            }
        }
    }
    // $arraykec[] = array('Provinsi' => $kode_kab, 'Kabupaten' => $d->NAMA, 'Link' => $d->NAMA, 'Kecamatan' => $d->NAMA);
    print("<pre>" . print_r($arraykec, true) . "</pre>");
    return $arraykec;
}
// $arraykec = generateKecamatan(19);
// generateKecamatan(19);
// die;

function generateKabupaten($kode_prov)
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);

    $i = 0;
    foreach ($data as $element) {
        //check the property of every element
        if ($element->LEVEL == 4) {
            unset($data[$i]);
        }
        $i++;
    }


    $prov = "";
    $arraykab = array();
    foreach ($data as $d) {
        //unset($d->MST_KODE_WILAYAH);
        if (substr($d->KODE_WILAYAH, 0, 2) == $kode_prov) {
            if ($d->LEVEL == 1) {
                $prov = str_replace("PROV. ", "", $d->NAMA);
            }
            if ($d->LEVEL == 2) {
                if ($d->NAMA[3] != 'A') {
                    $newK = str_replace("KAB.", "BPS KABUPATEN", $d->NAMA);
                    $newQ = str_replace("KAB. ", "", $d->NAMA);
                    $newQa = strtolower($newQ);
                    $newQab = ucwords($newQa);
                    $newFilePath1 =  'C:\\xampp\\htdocs\\wilayah\\' . $prov . '\\' . $newK . '\\*.docx';
                    $arraykab[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1);
                } else if ($d->NAMA[3] == 'A') {
                    $newK = str_replace("KOTA", "BPS KOTA", $d->NAMA);
                    $newQ = str_replace("KAB. ", "", $d->NAMA);
                    $newQa = strtolower($newQ);
                    $newQab = ucwords($newQa);
                    $newFilePath1 =  'C:\\xampp\\htdocs\\wilayah\\' . $prov . '\\' . $newK . '\\*.docx';
                    $arraykab[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1);
                }
            }
        }
    }
    // $arraykab[] = array('Provinsi' => $prov, 'Kabupaten' => $d->NAMA, 'Link' => $d->NAMA, 'Kecamatan' => $d->NAMA);
    print("<pre>" . print_r($arraykab, true) . "</pre>");
    return $arraykab;
}

function generate($var, $kode_prov)
{
    if ($var == 'kab') {
        generateKabupaten($kode_prov);
    } elseif ($var == 'kec') {
        generateKecamatan($kode_prov);
    }
}

$array = generateKabupaten(19);
// generateKabupaten(19);
// die;
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// file name for download
$fileName = "codexworld_export_data" . date('Ymd') . ".xls";

// headers for download
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach ($array as $row) {
    if (!$flag) {
        // display column names as first row
        echo implode("\t", array_keys($row)) . "\n";
        $flag = true;
    }
    // filter data
    array_walk($row, 'filterData');
    echo implode("\t", array_values($row)) . "\n";
}

exit;
