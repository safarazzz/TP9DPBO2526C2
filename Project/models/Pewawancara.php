<?php
// entitas data pewawancara
class Pewawancara {
    private ?int $id;
    private string $nama;
    private string $jabatan;
    private string $departemen;
    private string $tipeWawancara;
    private int $totalInterview;

    public function __construct(
        ?int $id,
        string $nama,
        string $jabatan,
        string $departemen,
        string $tipeWawancara,
        int $totalInterview
    ) {
        $this->id = $id;
        $this->nama = $nama;
        $this->jabatan = $jabatan;
        $this->departemen = $departemen;
        $this->tipeWawancara = $tipeWawancara;
        $this->totalInterview = $totalInterview;
    }

    // getter
    public function getId(): ?int { return $this->id; }
    public function getNama(): string { return $this->nama; }
    public function getJabatan(): string { return $this->jabatan; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getTipeWawancara(): string { return $this->tipeWawancara; }
    public function getTotalInterview(): int { return $this->totalInterview; }

    // setter
    public function setNama(string $nama): void { $this->nama = $nama; }
    public function setJabatan(string $jabatan): void { $this->jabatan = $jabatan; }
    public function setDepartemen(string $departemen): void { $this->departemen = $departemen; }
    public function setTipeWawancara(string $tipeWawancara): void { $this->tipeWawancara = $tipeWawancara; }
    public function setTotalInterview(int $totalInterview): void { $this->totalInterview = $totalInterview; }
}
?>
