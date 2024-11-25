<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $nim = trim($_POST['nim']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $bio = trim($_POST['bio']);
    $file = $_FILES['file'];

    // Validasi server-side
    $errors = [];

    if (empty($name) || strlen($name) < 3 || strlen($name) > 100) {
        $errors[] = "Nama harus antara 3-100 karakter.";
    }
    if (!preg_match('/^\d{9}$/', $nim)) {
        $errors[] = "NIM harus berupa 9 digit angka.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    if (!preg_match('/^\d{10,13}$/', $phone)) {
        $errors[] = "Nomor telepon harus 10-13 digit.";
    }
    if (empty($bio) || strlen($bio) < 10 || strlen($bio) > 500) {
        $errors[] = "Pesan harus antara 10-500 karakter.";
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Gagal mengunggah file.";
    } else {
        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = "Ukuran file terlalu besar. Maksimal 2MB.";
        }
        if (mime_content_type($file['tmp_name']) !== 'text/plain') {
            $errors[] = "File harus berupa teks (.txt).";
        }
    }

    if (!empty($errors)) {
        echo "<h3>Validasi Gagal:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        exit;
    }

    // Baca isi file
    $fileContent = file_get_contents($file['tmp_name']);
    $rows = explode("\n", $fileContent);

    // Simpan data dan redirect
    session_start();
    $_SESSION['result'] = [
        'name' => $name,
        'nim' => $nim,
        'email' => $email,
        'phone' => $phone,
        'bio' => $bio,
        'fileContent' => $rows,
        'browser' => $_SERVER['HTTP_USER_AGENT'],
    ];

    header('Location: result.php');
    exit;
}
?>
