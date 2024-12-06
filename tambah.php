<?php 
error_reporting(E_ALL); 
include_once 'koneksi.php'; 

if (isset($_POST['submit'])) { 
    $nama = $_POST['nama']; 
    $katagori = $_POST['katagori']; 
    $harga_jual = $_POST['harga_jual']; 
    $harga_beli = $_POST['harga_beli']; 
    $stok = $_POST['stok']; 

    $foto = $_FILES['file_gambar']; 
    $gambar = null; 

    if ($foto['error'] == 0) { 
        $filename = str_replace(' ', '_', $foto['name']); 

        $destination = dirname(__FILE__) . $filename; 

        if (move_uploaded_file($foto['tmp_name'], $destination)) { 
            $gambar = $filename; 
        } else {
            echo "Error: Gagal mengunggah gambar.";
        }
    }

    if ($gambar) {
        $sql = "INSERT INTO data_barang (nama, katagori, harga_jual, harga_beli, stok, gambar) ";
        $sql .= "VALUES ('{$nama}', '{$katagori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Gambar tidak ditemukan atau gagal diupload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        width: 90%;
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        font-family: 'Arial', sans-serif;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.8);
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    .main {
        padding: 20px;
    }

    .input {
        margin-bottom: 20px;
    }

    .input label {
        display: block;
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 8px;
    }

    .input input[type="text"],
    .input select,
    .input input[type="file"] {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        transition: all 0.3s ease-in-out;
    }

    .input input[type="text"]:focus,
    .input select:focus,
    .input input[type="file"]:focus {
        border-color: #007BFF;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .submit input[type="submit"] {
        width: 100%;
        padding: 15px;
        background: #45aedb;
        color: white;
        font-size: 1.2rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .input input[type="text"]:hover,
    .input select:hover,
    .input input[type="file"]:hover {
        background-color: #f1f1f1;
    }

    @media (max-width: 600px) {
        .container {
            width: 95%;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
        }

        .input input[type="text"],
        .input select,
        .input input[type="file"],
        .submit input[type="submit"] {
            font-size: 1rem;
            padding: 10px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <div class="main">
            <form method="post" action="tambah.php" enctype="multipart/form-data">
                <div class="input">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" />
                </div>
                <div class="input">
                    <label>Kategori</label>
                    <select name="katagori">
                        <option value="Minuman">Minuman</option>
                        <option value="Snack">Snack</option>
                        <option value="Rokok">Rokok</option>
                    </select>
                </div>
                <div class="input">
                    <label>Harga Beli</label>
                    <input type="text" name="harga_beli" />
                </div>
                <div class="input">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual" />
                </div>
                <div class="input">
                    <label>Stok</label>
                    <input type="text" name="stok" />
                </div>
                <div class="input">
                    <label>File Gambar</label>
                    <input type="file" name="file_gambar" />
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>