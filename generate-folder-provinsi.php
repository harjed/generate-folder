<?php
$data = file_get_contents("convertcsv.json");
//var_dump($strJsonFileContents);
$data = json_decode($data);
$directory = 'D:\\anjab\\';

function generateFolderProvinsi($kode_prov, $data)
{
    function custom_copy($src, $dst)
    {

        // open the source directory 
        $dir = opendir($src);

        // Make the destination directory if not exist 
        @mkdir($dst);

        // Loop through the files in source directory 
        while ($file = readdir($dir)) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {

                    // Recursively calling custom copy function 
                    // for sub directory 
                    custom_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }

        closedir($dir);
    }
    function delete_files($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                delete_files($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
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
                    $kab = str_replace("KAB.", "BPS KABUPATEN", $d->NAMA);
                    array_push($arraykab, $kab);
                } else {
                    $kab = substr_replace($d->NAMA, "BPS ", 0, 0);
                    array_push($arraykab, $kab);
                }
            }
        }
    }

    foreach ($arraykab as $kab) {
        if (!file_exists($GLOBALS['directory'] . $prov . '/' . $kab)) {
            mkdir($GLOBALS['directory'] . $prov . '/' . $kab, 0777, true);
            if ($kab[5] == 'A') {
                $src = "utkKabupaten";
                $dst = $GLOBALS['directory'] . $prov . "/" . $kab;
                custom_copy($src, $dst);
                // $new = str_replace('BPS KABUPATEN', 'KSK', $kab);
                // mkdir($GLOBALS['directory'] . $prov . '/' . $kab . '/' . $new, 0777, true);
            } else {
                $src = $GLOBALS['directory'] . "utkKota";
                $dst = $GLOBALS['directory'] . $prov . "/" . $kab;
                custom_copy($src, $dst);
                // $new = str_replace('BPS KOTA', 'KSK KOTA', $kab);
                // mkdir($GLOBALS['directory'] . $prov . '/' . $kab . '/' . $new, 0777, true);
            }
        } else {
            echo '<br>';
            echo 'Folder tersedia';
            echo '</br>';
        }
    };
    echo 'Folder ' . $prov . ' Berhasil Dibuat';
}

function generateFolderKecamatan($kode_prov, $data)
{
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
                    $kode_kab = $d->KODE_WILAYAH;
                    $arraykab[] = array('kode_kab' => $kode_kab, 'nama' => $d->NAMA);
                } else {
                    $kode_kab = $d->KODE_WILAYAH;
                    $arraykab[] = array('kode_kab' => $kode_kab, 'nama' => $d->NAMA);
                }
            }
        }
    }

    foreach ($arraykab as $kab) {
        foreach ($data as $d) {
            if ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'A') {
                $file1 = 'KSK Banjarsari';
                $newV = str_replace("KAB. ", "", $kab['nama']);
                $newK = str_replace("KAB.", "BPS KABUPATEN", $kab['nama']);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $currentFilePath1 = $GLOBALS['directory'] . $file1 . '.docx';
                $newFilePath1 =  $GLOBALS['directory'] . $prov . '/' . $newK . '/KSK ' . $newV . '/' . $newC . '.docx';
                copy($currentFilePath1, $newFilePath1);
            } elseif ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'O') {
                $file1 = 'KSK Curug';
                $newV = str_replace("KAB. ", "", $kab['nama']);
                $newK = str_replace("KOTA", "BPS KOTA", $kab['nama']);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $currentFilePath1 = $GLOBALS['directory'] . $file1 . '.docx';
                $newFilePath1 = $GLOBALS['directory'] .  $prov . '/' . $newK . '/KSK ' . $newV . '/' . $newC . '.docx';
                copy($currentFilePath1, $newFilePath1);
            }
        }
    }
}
function generateProvinsi()
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);
    $provinsi = array();
    // $provinsi[] = array('nama' => 'Pilih Provinsi', 'kodeprov' => '00');
    foreach ($data as $d) {
        if ($d->LEVEL == 1) {
            $prov = str_replace("PROV. ", "", $d->NAMA);
            $provinsi[] = array('nama' => $prov, 'kodeprov' => substr($d->KODE_WILAYAH, 0, 2));
        }
    }

    // $nama = array_column($provinsi, 'nama');
    // array_multisort($nama, SORT_ASC, $provinsi);
    return $provinsi;
}

// function generateFolder($kode_prov, $data)
{
    // generateFolderProvinsi($kode_prov, $data);
    // generateFolderKecamatan($kode_prov, $data);
}

$provinsi = generateProvinsi();
foreach ($provinsi as $p) {
    generateFolderProvinsi($p['kodeprov'], $data);
}
