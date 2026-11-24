<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModel.php';
require_once __DIR__ . '/Kandidat.php';

// model untuk tabel kandidat
class TabelKandidat extends DB implements KontrakModel {

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // konversi array associative database ke objek Kandidat
    private function mapRowToKandidat(array $row): Kandidat {
        return new Kandidat(
            (int)$row['id'],
            $row['nama'],
            $row['posisi'],
            $row['domisili'],
            (int)$row['skorTes'],
            (int)$row['pengalamanTahun']
        );
    }

    // ambil semua data kandidat dari database
    public function getAllData(): array {
        $query = "SELECT * FROM kandidat ORDER BY skorTes DESC, id ASC";
        $this->executeQuery($query);
        $rows = $this->getAllResult();
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->mapRowToKandidat($row);
        }
        return $list;
    }

    // ambil satu data kandidat berdasarkan id
    public function getDataById(int $id): ?object {
        $query = "SELECT * FROM kandidat WHERE id = :id LIMIT 1";
        $this->executeQuery($query, ["id" => $id]);
        $rows = $this->getAllResult();
        if (empty($rows)) {
            return null;
        }
        return $this->mapRowToKandidat($rows[0]);
    }

    // simpan data kandidat baru
    public function addData(array $data): void {
        $this->addKandidat(
            $data['nama'] ?? '',
            $data['posisi'] ?? '',
            $data['domisili'] ?? '',
            (int)($data['skorTes'] ?? 0),
            (int)($data['pengalamanTahun'] ?? 0)
        );
    }

    // update data kandidat
    public function updateData(int $id, array $data): void {
        $this->updateKandidat(
            $id,
            $data['nama'] ?? '',
            $data['posisi'] ?? '',
            $data['domisili'] ?? '',
            (int)($data['skorTes'] ?? 0),
            (int)($data['pengalamanTahun'] ?? 0)
        );
    }

    // hapus data kandidat
    public function deleteData(int $id): void {
        $this->deleteKandidat($id);
    }

    // helper alias bawaan starter project
    public function getAllKandidat(): array {
        return $this->getAllData();
    }

    public function getKandidatById(int $id): ?Kandidat {
        /** @var ?Kandidat */
        return $this->getDataById($id);
    }

    public function addKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $query = "INSERT INTO kandidat (nama, posisi, domisili, skorTes, pengalamanTahun) 
                  VALUES (:nama, :posisi, :domisili, :skorTes, :pengalamanTahun)";
        $this->executeQuery($query, [
            'nama'            => $nama,
            'posisi'          => $posisi,
            'domisili'        => $domisili,
            'skorTes'         => $skorTes,
            'pengalamanTahun' => $pengalamanTahun
        ]);
    }

    public function updateKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $query = "UPDATE kandidat 
                  SET nama = :nama, posisi = :posisi, domisili = :domisili, skorTes = :skorTes, pengalamanTahun = :pengalamanTahun 
                  WHERE id = :id";
        $this->executeQuery($query, [
            'id'              => $id,
            'nama'            => $nama,
            'posisi'          => $posisi,
            'domisili'        => $domisili,
            'skorTes'         => $skorTes,
            'pengalamanTahun' => $pengalamanTahun
        ]);
    }

    public function deleteKandidat(int $id): void {
        $query = "DELETE FROM kandidat WHERE id = :id";
        $this->executeQuery($query, ['id' => $id]);
    }
}
?>
