<!DOCTYPE html>
<html>
<?php require 'functions.php';
if (isset($_POST["kode_prov"]) && $_POST['level'] == "kabupaten") {
    $array = generateKabupaten($_POST["kode_prov"]);
} elseif (isset($_POST["kode_prov"]) && $_POST['level'] == "kecamatan") {
    $array = generateKecamatan($_POST["kode_prov"]);
} else {
    $array = generateKabupaten('00');
}

$arrayprov = generateProvinsi();

// $array = generateKabupaten('19');
?>


<head>
    <title>Anjab</title>
    <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        table#t01 tr:nth-child(even) {
            background-color: #5edb80;
        }

        table#t01 tr:nth-child(odd) {
            background-color: #fff;
        }

        table#t01 th {
            color: white;
            background-color: black;
        }

        input[type="text"] {
            background: transparent;
            border: none;
        }

        table#t01 {
            font-size: 10 pt;
        }
    </style>
</head>

<body>
    <?php $a = 1; ?>
    <?php $i = 1; ?>
    <?php $j = 1; ?>
    <?php $k = 501; ?>
    <?php $l = 501; ?>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Generate Data </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Generate Folder</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Generate Data</h1>
        <div>
            <form action="" method="post">
                <label>Kode Provinsi :</label>
                <!-- <input style="border-color:black" type="text" name="kode_prov" id="kode_prov" autofocus> -->
                <!-- <input type="text" style="border-color:black" name="directory" id="directory"> -->
                <select name="kode_prov" id="kode_prov" selected="selected">
                    <option value="00">Pilih Provinsi</option>
                    <option value="06">ACEH</option>
                    <option value="22">BALI</option>
                    <option value="28">BANTEN</option>
                    <option value="26">BENGKULU</option>
                    <option value="04">D.I. YOGYAKARTA</option>
                    <option value="01">DKI JAKARTA</option>
                    <option value="30">GORONTALO</option>
                    <option value="10">JAMBI</option>
                    <option value="02">JAWA BARAT</option>
                    <option value="03">JAWA TENGAH</option>
                    <option value="05">JAWA TIMUR</option>
                    <option value="13">KALIMANTAN BARAT</option>
                    <option value="15">KALIMANTAN SELATAN</option>
                    <option value="14">KALIMANTAN TENGAH</option>
                    <option value="16">KALIMANTAN TIMUR</option>
                    <option value="34">KALIMANTAN UTARA</option>
                    <option value="29">KEP. BANGKA BELITUNG</option>
                    <option value="31">KEP. RIAU</option>
                    <option value="12">LAMPUNG</option>
                    <option value="21">MALUKU</option>
                    <option value="27">MALUKU UTARA</option>
                    <option value="23">NTB</option>
                    <option value="24">NTT</option>
                    <option value="25">PAPUA</option>
                    <option value="32">PAPUA BARAT</option>
                    <option value="09">RIAU</option>
                    <option value="33">SULAWESI BARAT</option>
                    <option value="19">SULAWESI SELATAN</option>
                    <option value="18">SULAWESI TENGAH</option>
                    <option value="20">SULAWESI TENGGARA</option>
                    <option value="17">SULAWESI UTARA</option>
                    <option value="08">SULAWESI BARAT</option>
                    <option value="11">SUMATERA SELATAN</option>
                    <option value="07">SUMATERA UTARA</option>


                </select>
                <input type="radio" name="level" value="kabupaten">Kabupaten
                <input type="radio" name="level" value="kecamatan">Kecamatan
                <button type="submit" name="submit" id="submit">Submit</button>
            </form>
        </div>
        <br>
        <H2>PROV. <?php
                    if (isset($_POST['kode_prov'])) {
                        foreach ($arrayprov as $ar) {
                            if ($_POST['kode_prov'] ==  $ar['kodeprov']) {
                                print_r($ar['nama']);
                            }
                        }
                    }
                    ?></H2>
        <br>

        <table id="t01" width="100%">

            <tr>
                <th width="5%">No</th>
                <th width="25%">
                    Kabupaten
                </th>
                <th width="20%">
                    Copy
                </th>
                <th width="10%"></th>
                <th width="30%">
                    Link
                </th>
                <th width="10%"></th>
            </tr>
            <?php foreach ($array as $ar) : ?>
                <tr>
                    <td><?= $a++; ?></td>
                    <td>
                        <?php print_r($ar['Kabupaten']); ?>
                    </td>
                    <td>
                        <input type="text" value="<?php print_r($ar['Kecamatan']); ?>" id="pilih<?= $k++; ?>" readonly />
                    </td>
                    <td><button type="button" onclick="copyText2(<?= $l++; ?>)">Copy</button></td>
                    </td>
                    <td>
                        <input type="text" value="<?php print_r($ar['Link']); ?>" id="pilih<?= $i++; ?>" readonly />
                    </td>
                    <td><button type="button" onclick="copyText(<?= $j++; ?>)">Copy</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script type="text/javascript">
        function copyText(j) {
            /* Get the text field */
            var copyText = document.getElementById("pilih" + j);

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");
        }

        function copyText2(l) {
            /* Get the text field */
            var copyText = document.getElementById("pilih" + l);

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");
        }
    </script>
</body>

</html>
