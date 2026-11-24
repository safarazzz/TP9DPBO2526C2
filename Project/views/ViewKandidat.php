<?php
require_once __DIR__ . '/KontrakView.php';

// view untuk modul kandidat (pasif, hanya mapping data ke template)
class ViewKandidat implements KontrakView {
    private string $skinPath;
    private string $formPath;

    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/skin.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/form.html';
    }

    // ganti token baris tabel dan total data pada skin.html
    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->skinPath);

        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData,
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    // isi nilai input ke dalam template form.html
    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);

        $tokens = [
            '{{FORM_TITLE}}'       => htmlspecialchars($title),
            '{{ACTION}}'           => htmlspecialchars($action),
            '{{ID}}'               => htmlspecialchars((string)($formData['id'] ?? '')),
            '{{NAMA}}'             => htmlspecialchars($formData['nama'] ?? ''),
            '{{POSISI}}'           => htmlspecialchars($formData['posisi'] ?? ''),
            '{{DOMISILI}}'         => htmlspecialchars($formData['domisili'] ?? ''),
            '{{SKOR_TES}}'         => htmlspecialchars((string)($formData['skorTes'] ?? 0)),
            '{{PENGALAMAN_TAHUN}}' => htmlspecialchars((string)($formData['pengalamanTahun'] ?? 0)),
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
