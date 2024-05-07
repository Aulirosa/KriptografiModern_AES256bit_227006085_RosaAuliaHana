<!DOCTYPE html>
<html>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<head>
    <title>Enkripsi & Dekripsi Teks Algoritma AES256</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container">
        <div class="container-2">
            <div class="judul">

                <h2>Enkripsi & Dekripsi Teks</h2>
                <p>Menggunakan algoritma AES 256bit</p>
                <img src="assets/images/ilustrasi-kriptografi.png" alt="ilustrasi kriptografi">
            </div>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="plaintext">Plaintext:</label>
                    <textarea class="form-control" name="plaintext" id="plaintext" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="key">Key:</label>
                    <input type="text" class="form-control kunci" name="key" id="key" required>
                </div>
                <button type="submit" class="btn btn-primary" name="encrypt">Enkripsi</button>
                <button type="submit" class="btn btn-primary" name="decrypt">Dekripsi</button>
            </form>

            <?php
            // Fungsi untuk mengenkripsi teks
            function encrypt($plaintext, $key)
            {
                $ivSize = openssl_cipher_iv_length('AES-256-CBC');
                $iv = openssl_random_pseudo_bytes($ivSize);

                $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

                $ciphertext = base64_encode($iv . $ciphertext);

                return $ciphertext;
            }

            // Fungsi untuk mendekripsi teks
            function decrypt($ciphertext, $key)
            {
                $ciphertext = base64_decode($ciphertext);

                $ivSize = openssl_cipher_iv_length('AES-256-CBC');
                $iv = substr($ciphertext, 0, $ivSize);

                $ciphertext = substr($ciphertext, $ivSize);

                $plaintext = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

                return $plaintext;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $plaintext = $_POST['plaintext'];
                $key = $_POST['key'];

                if (isset($_POST['encrypt'])) {
                    $ciphertext = encrypt($plaintext, $key);
                    echo '<div class="alert alert-success mt-3 " role="alert">
                    <div class="judul2">Ciphertext: </div><div class="teks-enkrip"> ' . $ciphertext . ' 
                </div></div>';
                } elseif (isset($_POST['decrypt'])) {
                    $decryptedText = decrypt($plaintext, $key);
                    echo '<div class="alert alert-success mt-3" role="alert"> 
                    <div class="judul2">Decrypted text: </div>' . $decryptedText . '
                </div>';
                }
            }
            ?>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>