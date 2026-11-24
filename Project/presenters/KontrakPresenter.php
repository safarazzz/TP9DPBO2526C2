<?php
// interface kontrak untuk presenter
interface KontrakPresenter {
    // ambil dan format data tabel
    public function tampilkanData(): string;

    // render form tambah/edit data
    public function tampilkanFormData(?int $id = null): string;

    // proses penambahan data baru
    public function tambahData(array $data): void;

    // proses update data
    public function ubahData(int $id, array $data): void;

    // proses hapus data
    public function hapusData(int $id): void;
}
?>
