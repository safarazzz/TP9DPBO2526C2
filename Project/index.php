<?php
// load file model, view, dan presenter yang dibutuhkan
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';

require_once __DIR__ . '/models/TabelPewawancara.php';
require_once __DIR__ . '/views/ViewPewawancara.php';
require_once __DIR__ . '/presenters/PresenterPewawancara.php';

// cek halaman/modul yang diminta (default ke kandidat)
$page = $_POST['page'] ?? $_GET['page'] ?? 'kandidat';

// inisialisasi MVP sesuai modul yang aktif
if ($page === 'pewawancara') {
    $model = new TabelPewawancara('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewPewawancara();
    $presenter = new PresenterPewawancara($model, $view);
} else {
    $page = 'kandidat';
    $model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewKandidat();
    $presenter = new PresenterKandidat($model, $view);
}

// handle request POST (tambah, edit, hapus)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $presenter->tambahData($_POST);
    } elseif ($action === 'ubah') {
        $id = (int)($_POST['id'] ?? 0);
        $presenter->ubahData($id, $_POST);
    } elseif ($action === 'hapus') {
        $id = (int)($_POST['id'] ?? 0);
        $presenter->hapusData($id);
    }

    // redirect balik ke halaman modul terkait
    header("Location: index.php?page=" . urlencode($page));
    exit();
} else {
    // handle request GET untuk nampilin halaman list atau form
    $screen = $_GET['screen'] ?? 'list';
    if ($screen === 'add') {
        echo $presenter->tampilkanFormData();
    } elseif ($screen === 'edit' && isset($_GET['id'])) {
        echo $presenter->tampilkanFormData((int)$_GET['id']);
    } else {
        echo $presenter->tampilkanData();
    }
}
?>
