<?php

// $directory = 'C:\\xampp\\htdocs\\wilayah\\';
$directory = 'D:\\anjab\\';

function generateProvinsi()
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);
    $provinsi = array();
    $provinsi[] = array('nama' => 'Pilih Provinsi', 'kodeprov' => '00');
    foreach ($data as $d) {
        if ($d->LEVEL == 1) {
            $prov = str_replace("PROV. ", "", $d->NAMA);
            $provinsi[] = array('nama' => $prov, 'kodeprov' => substr($d->KODE_WILAYAH, 0, 2));
        }
    }

    $nama = array_column($provinsi, 'nama');
    array_multisort($nama, SORT_ASC, $provinsi);
    return $provinsi;
}
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
                    $newV = str_replace("KAB. ", "", $d->NAMA);
                    $newK = str_replace("KAB.", "BPS KABUPATEN", $d->NAMA);
                    // $newC = str_replace("KEC.", "KSK", $d->NAMA);
                    $newQ = str_replace("KAB. ", "", $d->NAMA);
                    $newQa = strtolower($newQ);
                    $newQab = ucwords($newQa);
                    // $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\*.docx';
                    $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\*.docx';
                    $arraykab[] = array('Provinsi' => $prov, 'Kabupaten' => $d->NAMA, 'Link' => $newFilePath1, 'Kecamatan' => $newQab);
                } else if ($d->NAMA[3] == 'A') {
                    $newV = str_replace("KAB. ", "", $d->NAMA);
                    $newK = str_replace("KOTA", "BPS KOTA", $d->NAMA);
                    //  $newC = str_replace("KEC.", "KSK", $d->NAMA);
                    $newQ = str_replace("KOTA ", "", $d->NAMA);
                    $newQa = strtolower($newQ);
                    $newQab = ucwords($newQa);
                    // $newFilePath1 = $GLOBALS['directory'] . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\*.docx';
                    $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\*.docx';
                    $arraykab[] = array('Provinsi' => $prov, 'Kabupaten' => $d->NAMA, 'Link' => $newFilePath1, 'Kecamatan' => $newQab);
                }
            }
        }
    }

    return $arraykab;
}

function generateKecamatan($kode_prov)
{
    $data = file_get_contents("convertcsv.json");
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
    // echo $prov;
    foreach ($arraykab as $kab) {
        foreach ($data as $d) {
            if ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'A') {
                $newV = str_replace("KAB.", "KSK KABUPATEN", $kab['nama']);
                $newK = str_replace("KAB.", "BPS KABUPATEN", $kab['nama']);
                $newQ = str_replace("KAB. ", "", $kab['nama']);
                $newQa = strtolower($newQ);
                $newQab = ucwords($newQa);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $newCa = str_replace("KSK ", "", $newC);
                $newCam = strtolower($newCa);
                $newCama = ucwords($newCam);
                $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\' . $newC . '.docx';
                // $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\' . $newV . '\\*.docx';
                $arraykec[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1, 'Kecamatan' => $newCama);
            } elseif ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'O') {
                $newV = str_replace("KOTA", "KSK KOTA", $kab['nama']);
                $newK = str_replace("KOTA", "BPS KOTA", $kab['nama']);
                $newQ = str_replace("KOTA ", "", $kab['nama']);
                $newQa = strtolower($newQ);
                $newQab = ucwords($newQa);
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $newCa = str_replace("KSK ", "", $newC);
                $newCam = strtolower($newCa);
                $newCama = ucwords($newCam);
                $newFilePath1 = $GLOBALS['directory'] . $prov . '\\' . $newK . '\\KSK ' . $newV . '\\' . $newC . '.docx';
                // $newFilePath1 =  $GLOBALS['directory'] . $prov . '\\' . $newK . '\\' . $newV . '\\*.docx';
                $arraykec[] = array('Provinsi' => $prov, 'Kabupaten' => $newQab, 'Link' => $newFilePath1, 'Kecamatan' => $newCama);
            }
        }
    }
    return $arraykec;
}

function generateFolderProvinsi($kode_prov)
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);

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
    $kabfolder = array();
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
    echo $GLOBALS['directory'] . $prov;
    '<br>';
    foreach ($arraykab as $kab) {
        if (!file_exists($GLOBALS['directory'] . $prov . '\\' . $kab)) {
            mkdir($GLOBALS['directory'] . $prov . '\\' . $kab, 0777, true);
            if ($kab[5] == 'A') {
                $src = $GLOBALS['directory'] . "utkKabupaten";
                $dst = $GLOBALS['directory'] . $prov . "\\" . $kab;
                custom_copy($src, $dst);
                array_push($kabfolder, $kab);
            } else {
                $src = $GLOBALS['directory'] . "utkKota";
                $dst = $GLOBALS['directory'] . $prov . "\\" . $kab;
                custom_copy($src, $dst);
                array_push($kabfolder, $kab);
            }
            echo '<br>';
            echo 'Folder ' . $kab . ' Berhasil Dibuat';
            echo '</br>';
        } else {
            echo '<br>';
            echo 'Folder ' . $kab . ' tersedia';
            echo '</br>';
        }
    };
}

function generateFolderKecamatan($kode_prov)
{
    $data = file_get_contents("convertcsv.json");
    //var_dump($strJsonFileContents);
    $data = json_decode($data);
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
                //Generate Folder Kecamatan
                $folderBpsKab = str_replace('KAB.', 'BPS KABUPATEN', $kab['nama']);
                $folderKsk = str_replace('KAB.', 'KSK KABUPATEN', $kab['nama']);
                if (!file_exists($GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk)) {
                    mkdir($GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk, 0777, true);
                }
                // Move document 
                $file = 'KSK Kabupaten';
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $currentFilePath = $GLOBALS['directory'] . 'KSK\\' . $file . '.docx';
                $newFilePath_old =  $GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk . '\\' . $file . '.docx';
                $newFilePath_new =  $GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk . '\\' . $newC . '.docx';
                copy($currentFilePath, $newFilePath_old);
                rename($newFilePath_old, $newFilePath_new);
            } elseif ($kab['kode_kab'] == $d->MST_KODE_WILAYAH && $kab['nama'][1] == 'O') {
                //Generate Folder Kecamatan
                $folderBpsKab = str_replace('KOTA', 'BPS KOTA', $kab['nama']);
                $folderKsk = str_replace('KOTA', 'KSK KOTA', $kab['nama']);
                if (!file_exists($GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk)) {
                    mkdir($GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk, 0777, true);
                }
                // Move and rename document 
                $file = 'KSK Kota';
                $newC = str_replace("KEC.", "KSK", $d->NAMA);
                $currentFilePath = $GLOBALS['directory'] . 'KSK\\' . $file . '.docx';
                $newFilePath_old = $GLOBALS['directory'] .  $prov . '\\' . $folderBpsKab . '\\' . $folderKsk . '\\' . $file . '.docx';
                $newFilePath_new =  $GLOBALS['directory'] . $prov . '\\' . $folderBpsKab . '\\' . $folderKsk . '\\' . $newC . '.docx';
                copy($currentFilePath, $newFilePath_old);
                rename($newFilePath_old, $newFilePath_new);
            }
        }
    }
}
