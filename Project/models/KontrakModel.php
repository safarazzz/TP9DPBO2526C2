<?php
// interface kontrak untuk model
interface KontrakModel {
    // ambil semua list data
    public function getAllData(): array;

    // cari data berdasarkan id
    public function getDataById(int $id): ?object;

    // tambah data baru
    public function addData(array $data): void;

    // update data berdasarkan id
    public function updateData(int $id, array $data): void;

    // hapus data berdasarkan id
    public function deleteData(int $id): void;
}
?>
