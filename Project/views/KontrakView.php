<?php
// interface kontrak untuk view
interface KontrakView {
    // render template daftar tabel
    public function renderDaftar(string $tableRowsHtml, int $totalData): string;

    // render template form input/edit
    public function renderForm(string $title, string $action, array $formData = []): string;
}
?>
