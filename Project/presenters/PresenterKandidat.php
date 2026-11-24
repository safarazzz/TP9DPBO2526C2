<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

// presenter untuk modul kandidat
class PresenterKandidat implements KontrakPresenter {
    private KontrakModel $model;
    private KontrakView $view;

    public function __construct(KontrakModel $model, KontrakView $view) {
        $this->model = $model;
        $this->view  = $view;
    }

    // bikin baris <tr> HTML tabel kandidat
    private function buildRowHtml(int $no, Kandidat $kandidat): string {
        $id = (int)$kandidat->getId();
        $nama = htmlspecialchars($kandidat->getNama());
        $posisi = htmlspecialchars($kandidat->getPosisi());
        $domisili = htmlspecialchars($kandidat->getDomisili());
        $skorTes = number_format($kandidat->getSkorTes()) . ' / 100';
        $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$posisi}</td>
            <td>{$domisili}</td>
            <td>{$skorTes}</td>
            <td>{$pengalaman}</td>
            <td class='col-actions'>
                <a href='index.php?page=kandidat&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
                    <input type='hidden' name='page' value='kandidat'>
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    // ambil data kandidat dari model dan kirim HTML-nya ke view
    public function tampilkanData(): string {
        $listKandidat = $this->model->getAllData();
        $totalKandidat = count($listKandidat);
        $rowsHtml = "";
        if (empty($listKandidat)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data yang ditambahkan.</td></tr>';
        } else {
            $no = 1;
            foreach ($listKandidat as $kandidat) {
                $rowsHtml .= $this->buildRowHtml($no, $kandidat);
                $no++;
            }
        }
        return $this->view->renderDaftar($rowsHtml, $totalKandidat);
    }

    // siapkan form tambah atau edit kandidat
    public function tampilkanFormData(?int $id = null): string {
        if ($id !== null) {
            $kandidat = $this->model->getDataById($id);
            if ($kandidat === null) {
                header("Location: index.php?page=kandidat");
                exit();
            }
            $formData = [
                'id'              => $kandidat->getId(),
                'nama'            => $kandidat->getNama(),
                'posisi'          => $kandidat->getPosisi(),
                'domisili'        => $kandidat->getDomisili(),
                'skorTes'         => $kandidat->getSkorTes(),
                'pengalamanTahun' => $kandidat->getPengalamanTahun()
            ];
            return $this->view->renderForm("Ubah Data Kandidat", "ubah", $formData);
        }
        return $this->view->renderForm("Tambah Kandidat Baru", "tambah", []);
    }

    // simpan data kandidat baru lalu redirect
    public function tambahData(array $data): void {
        $this->model->addData($data);
        header("Location: index.php?page=kandidat");
        exit();
    }

    // update data kandidat lalu redirect
    public function ubahData(int $id, array $data): void {
        $this->model->updateData($id, $data);
        header("Location: index.php?page=kandidat");
        exit();
    }

    // hapus kandidat lalu redirect
    public function hapusData(int $id): void {
        $this->model->deleteData($id);
        header("Location: index.php?page=kandidat");
        exit();
    }

    // method alias untuk backward compatibility
    public function tampilkanKandidat(): string {
        return $this->tampilkanData();
    }

    public function tampilkanFormKandidat(?int $id = null): string {
        return $this->tampilkanFormData($id);
    }

    public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->tambahData([
            'nama'            => $nama,
            'posisi'          => $posisi,
            'domisili'        => $domisili,
            'skorTes'         => $skorTes,
            'pengalamanTahun' => $pengalamanTahun
        ]);
    }

    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->ubahData($id, [
            'nama'            => $nama,
            'posisi'          => $posisi,
            'domisili'        => $domisili,
            'skorTes'         => $skorTes,
            'pengalamanTahun' => $pengalamanTahun
        ]);
    }

    public function hapusKandidat(int $id): void {
        $this->hapusData($id);
    }
}
?>
