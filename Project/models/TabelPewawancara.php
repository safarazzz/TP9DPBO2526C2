<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModel.php';
require_once __DIR__ . '/Pewawancara.php';

// model untuk tabel pewawancara
class TabelPewawancara extends DB implements KontrakModel {

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // konversi array database ke objek Pewawancara
    private function mapRowToPewawancara(array $row): Pewawancara {
        return new Pewawancara(
            (int)$row['id'],
            $row['nama'],
            $row['jabatan'],
            $row['departemen'],
            $row['tipe_wawancara'],
            (int)$row['total_interview']
        );
    }

    // ambil seluruh data pewawancara
    public function getAllData(): array {
        $query = "SELECT * FROM pewawancara ORDER BY total_interview DESC, id ASC";
        $this->executeQuery($query);
        $rows = $this->getAllResult();
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->mapRowToPewawancara($row);
        }
        return $list;
    }

    // ambil data pewawancara berdasarkan id
    public function getDataById(int $id): ?object {
        $query = "SELECT * FROM pewawancara WHERE id = :id LIMIT 1";
        $this->executeQuery($query, ["id" => $id]);
        $rows = $this->getAllResult();
        if (empty($rows)) {
            return null;
        }
        return $this->mapRowToPewawancara($rows[0]);
    }

    // tambah pewawancara baru
    public function addData(array $data): void {
        $this->addPewawancara(
            $data['nama'] ?? '',
            $data['jabatan'] ?? '',
            $data['departemen'] ?? '',
            $data['tipe_wawancara'] ?? '',
            (int)($data['total_interview'] ?? 0)
        );
    }

    // update data pewawancara
    public function updateData(int $id, array $data): void {
        $this->updatePewawancara(
            $id,
            $data['nama'] ?? '',
            $data['jabatan'] ?? '',
            $data['departemen'] ?? '',
            $data['tipe_wawancara'] ?? '',
            (int)($data['total_interview'] ?? 0)
        );
    }

    // hapus pewawancara berdasarkan id
    public function deleteData(int $id): void {
        $this->deletePewawancara($id);
    }

    // helper alias
    public function getAllPewawancara(): array {
        return $this->getAllData();
    }

    public function getPewawancaraById(int $id): ?Pewawancara {
        /** @var ?Pewawancara */
        return $this->getDataById($id);
    }

    public function addPewawancara(string $nama, string $jabatan, string $departemen, string $tipeWawancara, int $totalInterview): void {
        $query = "INSERT INTO pewawancara (nama, jabatan, departemen, tipe_wawancara, total_interview) 
                  VALUES (:nama, :jabatan, :departemen, :tipe_wawancara, :total_interview)";
        $this->executeQuery($query, [
            'nama'            => $nama,
            'jabatan'         => $jabatan,
            'departemen'      => $departemen,
            'tipe_wawancara'  => $tipeWawancara,
            'total_interview' => $totalInterview
        ]);
    }

    public function updatePewawancara(int $id, string $nama, string $jabatan, string $departemen, string $tipeWawancara, int $totalInterview): void {
        $query = "UPDATE pewawancara 
                  SET nama = :nama, jabatan = :jabatan, departemen = :departemen, tipe_wawancara = :tipe_wawancara, total_interview = :total_interview 
                  WHERE id = :id";
        $this->executeQuery($query, [
            'id'              => $id,
            'nama'            => $nama,
            'jabatan'         => $jabatan,
            'departemen'      => $departemen,
            'tipe_wawancara'  => $tipeWawancara,
            'total_interview' => $totalInterview
        ]);
    }

    public function deletePewawancara(int $id): void {
        $query = "DELETE FROM pewawancara WHERE id = :id";
        $this->executeQuery($query, ['id' => $id]);
    }
}
?>
