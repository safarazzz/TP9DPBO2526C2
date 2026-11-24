<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

// presenter untuk modul pewawancara
class PresenterPewawancara implements KontrakPresenter {
    private KontrakModel $model;
    private KontrakView $view;

    public function __construct(KontrakModel $model, KontrakView $view) {
        $this->model = $model;
        $this->view  = $view;
    }

    // bikin baris <tr> HTML tabel pewawancara
    private function buildRowHtml(int $no, Pewawancara $pewawancara): string {
        $id = (int)$pewawancara->getId();
        $nama = htmlspecialchars($pewawancara->getNama());
        $jabatan = htmlspecialchars($pewawancara->getJabatan());
        $departemen = htmlspecialchars($pewawancara->getDepartemen());
        $tipeWawancara = htmlspecialchars($pewawancara->getTipeWawancara());
        $totalInterview = number_format($pewawancara->getTotalInterview()) . ' Sesi';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$jabatan}</td>
            <td>{$departemen}</td>
            <td><span class='badge'>{$tipeWawancara}</span></td>
            <td>{$totalInterview}</td>
            <td class='col-actions'>
                <a href='index.php?page=pewawancara&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus data pewawancara ini?')\">
                    <input type='hidden' name='page' value='pewawancara'>
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    // ambil data pewawancara dari model dan kirim HTML ke view
    public function tampilkanData(): string {
        $listPewawancara = $this->model->getAllData();
        $totalPewawancara = count($listPewawancara);
        $rowsHtml = "";

        if (empty($listPewawancara)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data pewawancara yang ditambahkan.</td></tr>';
        } else {
            $no = 1;
            foreach ($listPewawancara as $pewawancara) {
                $rowsHtml .= $this->buildRowHtml($no, $pewawancara);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalPewawancara);
    }

    // siapkan form tambah atau edit pewawancara
    public function tampilkanFormData(?int $id = null): string {
        if ($id !== null) {
            $pewawancara = $this->model->getDataById($id);
            if ($pewawancara === null) {
                header("Location: index.php?page=pewawancara");
                exit();
            }
            $formData = [
                'id'              => $pewawancara->getId(),
                'nama'            => $pewawancara->getNama(),
                'jabatan'         => $pewawancara->getJabatan(),
                'departemen'      => $pewawancara->getDepartemen(),
                'tipe_wawancara'  => $pewawancara->getTipeWawancara(),
                'total_interview' => $pewawancara->getTotalInterview()
            ];
            return $this->view->renderForm("Ubah Data Pewawancara", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Pewawancara Baru", "tambah", []);
    }

    // simpan data pewawancara baru lalu redirect
    public function tambahData(array $data): void {
        $this->model->addData($data);
        header("Location: index.php?page=pewawancara");
        exit();
    }

    // update data pewawancara lalu redirect
    public function ubahData(int $id, array $data): void {
        $this->model->updateData($id, $data);
        header("Location: index.php?page=pewawancara");
        exit();
    }

    // hapus pewawancara lalu redirect
    public function hapusData(int $id): void {
        $this->model->deleteData($id);
        header("Location: index.php?page=pewawancara");
        exit();
    }

    // method alias untuk backward compatibility
    public function tampilkanPewawancara(): string {
        return $this->tampilkanData();
    }

    public function tampilkanFormPewawancara(?int $id = null): string {
        return $this->tampilkanFormData($id);
    }

    public function tambahPewawancara(string $nama, string $jabatan, string $departemen, string $tipeWawancara, int $totalInterview): void {
        $this->tambahData([
            'nama'            => $nama,
            'jabatan'         => $jabatan,
            'departemen'      => $departemen,
            'tipe_wawancara'  => $tipeWawancara,
            'total_interview' => $totalInterview
        ]);
    }

    public function ubahPewawancara(int $id, string $nama, string $jabatan, string $departemen, string $tipeWawancara, int $totalInterview): void {
        $this->ubahData($id, [
            'nama'            => $nama,
            'jabatan'         => $jabatan,
            'departemen'      => $departemen,
            'tipe_wawancara'  => $tipeWawancara,
            'total_interview' => $totalInterview
        ]);
    }

    public function hapusPewawancara(int $id): void {
        $this->hapusData($id);
    }
}
?>
