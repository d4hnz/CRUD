<?php 
error_reporting(E_ALL); 
include_once 'koneksi.php'; 

if (isset($_POST['submit'])) { 
    $id = $_POST['id']; 
    $nama = mysqli_real_escape_string($conn, $_POST['nama']); 
    $kategori = mysqli_real_escape_string($conn, $_POST['katagori']); 
    $harga_jual = mysqli_real_escape_string($conn, $_POST['harga_jual']); 
    $harga_beli = mysqli_real_escape_string($conn, $_POST['harga_beli']); 
    $stok = mysqli_real_escape_string($conn, $_POST['stok']); 
    $file_gambar = $_FILES['file_gambar']; 
    $gambar = null; 

    if ($file_gambar['error'] == 0) { 
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($file_gambar['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions) && $file_gambar['size'] <= 5 * 1024 * 1024) { 
            $filename = str_replace(' ', '_', $file_gambar['name']); 
            $destination = dirname(__FILE__) . $filename; 

            if (move_uploaded_file($file_gambar['tmp_name'], $destination)) { 
                $gambar = $filename; 
            } else {
                echo "Error: Failed to upload the image.";
            }
        } else {
            echo "Error: Invalid file type or size exceeds 5MB.";
        }
    }

    $sql = "UPDATE data_barang SET 
            nama = '{$nama}', 
            katagori = '{$katagori}', 
            harga_jual = '{$harga_jual}', 
            harga_beli = '{$harga_beli}', 
            stok = '{$stok}'";
    
    if (!empty($gambar)) {
        $sql .= ", gambar = '{$gambar}'";
    }
    
    $sql .= " WHERE id_barang = '{$id}'"; 

    $result = mysqli_query($conn, $sql); 

    if ($result) {
        header('Location: index.php'); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'"; 
$result = mysqli_query($conn, $sql); 

if (!$result) {
    die('Error: Data tidak tersedia');
}

$data = mysqli_fetch_array($result); 

function is_select($var, $val) {
    return ($var == $val) ? 'selected="selected"' : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
    }

    h1 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 20px;
        color: #333;
    }

    .main {
        padding: 20px;
    }

    .input {
        margin-bottom: 15px;
    }

    .input label {
        font-size: 1rem;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .input input[type="text"],
    .input select,
    .input input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .input input[type="text"]:focus,
    .input select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    .submit input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #007BFF;
        color: white;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .submit input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Responsive design */
    @media screen and (max-width: 600px) {
        .container {
            width: 95%;
        }

        h1 {
            font-size: 1.5rem;
        }

        .input input[type="text"],
        .input select,
        .input input[type="file"],
        .submit input[type="submit"] {
            font-size: 0.9rem;
            padding: 8px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ubah Barang</h1>
        <div class="main">
            <form method="post" action="ubah.php" enctype="multipart/form-data">
                <div class="input">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" value="<?php echo $data['nama'];?>" />
                </div>
                <div class="input">
                    <label>Kategori</label>
                    <select name="katagori">
                        <option <?php echo is_select ('Minuman', $var['minuman']="Minuman");?>>Minuman</option>
                        <option <?php echo is_select ('Snack', $var['katagori']="Snack");?>>Snack
                        </option>
                        <option <?php echo is_select ('Rokok', $var['katagori'] = "Rokok");?>>Rokok
                        </option>
                    </select>
                </div>
                <div class="input">
                    <label>Harga Beli</label>
                    <input type="text" name="harga_beli" value="<?php echo $data['harga_jual'];?>" />
                </div>
                <div class="input">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual" value="<?php echo $data['harga_beli'];?>" />
                </div>
                <div class="input">
                    <label>Stok</label>
                    <input type="text" name="stok" value="<?php echo $data['stok'];?>" />
                </div>
                <div class="input">
                    <label>File Gambar</label>
                    <input type="file" name="file_gambar" />
                </div>
                <div class="submit">
                    <input type="hidden" name="id" value="<?php echo $data['id_barang'];?>" />
                    <input type="submit" name="submit" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>