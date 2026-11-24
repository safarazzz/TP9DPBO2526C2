<?php
require_once __DIR__ . '/KontrakView.php';

// view untuk modul pewawancara (pakai regex buat ubah teks template)
class ViewPewawancara implements KontrakView {
    private string $skinPath;
    private string $formPath;

    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/skin.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/form.html';
    }

    // render daftar tabel pewawancara
    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->skinPath);

        // ganti judul kolom dan tab aktif lewat regex
        $patterns = [
            '/<title>.*?<\/title>/i'                                   => '<title>Daftar Pewawancara</title>',
            '/<h1>Daftar Kandidat Karyawan<\/h1>/i'                   => '<h1>Daftar Pewawancara (Interviewer)</h1>',
            '/<th>Nama<\/th>/i'                                       => '<th>Nama Pewawancara</th>',
            '/<th>Posisi Dilamar<\/th>/i'                             => '<th>Jabatan</th>',
            '/<th>Domisili<\/th>/i'                                   => '<th>Departemen</th>',
            '/<th>Skor Tes<\/th>/i'                                   => '<th>Tipe Wawancara</th>',
            '/<th>Pengalaman<\/th>/i'                                 => '<th>Total Interview</th>',
            '/href="index\.php\?page=kandidat&screen=add"/i'          => 'href="index.php?page=pewawancara&screen=add"',
            '/\+ Tambah Kandidat/i'                                   => '+ Tambah Pewawancara',
            '/Total Kandidat:/i'                                      => 'Total Pewawancara:',
            '/(class="nav-tab)\s+active(">\s*Daftar Kandidat<\/a>)/i' => '$1$2',
            '/(class="nav-tab)(">\s*Daftar Pewawancara<\/a>)/i'       => '$1 active$2',
        ];

        $template = preg_replace(array_keys($patterns), array_values($patterns), $template);

        // pasang baris tabel dan jumlah data
        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData,
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    // render form input atau edit pewawancara
    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);

        // ganti label dan nama field form dari kandidat jadi pewawancara
        $patterns = [
            '/<title>.*?<\/title>/i'                                                  => '<title>Form Pewawancara</title>',
            '/<input\s+type="hidden"\s+name="page"\s+value="kandidat">/i'             => '<input type="hidden" name="page" value="pewawancara">',
            '/>Nama Kandidat</i'                                                      => '>Nama Pewawancara<',
            '/placeholder="Nama lengkap kandidat"/i'                                  => 'placeholder="Nama lengkap pewawancara"',
            '/>Posisi Dilamar</i'                                                     => '>Jabatan<',
            '/for="posisi"/i'                                                         => 'for="jabatan"',
            '/id="posisi"\s+name="posisi"/i'                                          => 'id="jabatan" name="jabatan"',
            '/placeholder="Misal: Backend Developer"/i'                               => 'placeholder="Misal: Tech Lead, HR Specialist"',
            '/value="\{\{POSISI\}\}"/i'                                               => 'value="{{JABATAN}}"',
            '/>Domisili</i'                                                           => '>Departemen<',
            '/for="domisili"/i'                                                       => 'for="departemen"',
            '/id="domisili"\s+name="domisili"/i'                                      => 'id="departemen" name="departemen"',
            '/placeholder="Misal: Bandung"/i'                                         => 'placeholder="Misal: IT & Engineering, Human Capital"',
            '/value="\{\{DOMISILI\}\}"/i'                                             => 'value="{{DEPARTEMEN}}"',
            '/>Skor Tes \(0-100\)</i'                                                 => '>Tipe Wawancara<',
            '/for="skorTes"/i'                                                        => 'for="tipe_wawancara"',
            '/<input\s+id="skorTes"[^>]*value="\{\{SKOR_TES\}\}">/i'                   => '<input id="tipe_wawancara" name="tipe_wawancara" type="text" placeholder="Misal: Technical Interview" value="{{TIPE_WAWANCARA}}" required>',
            '/>Pengalaman Kerja \(Tahun\)</i'                                         => '>Total Sesi Interview<',
            '/for="pengalamanTahun"/i'                                                => 'for="total_interview"',
            '/<input\s+id="pengalamanTahun"[^>]*value="\{\{PENGALAMAN_TAHUN\}\}">/i'   => '<input id="total_interview" name="total_interview" type="number" min="0" step="1" value="{{TOTAL_INTERVIEW}}" required>',
            '/href="index\.php\?page=kandidat"/i'                                     => 'href="index.php?page=pewawancara"',
        ];

        $template = preg_replace(array_keys($patterns), array_values($patterns), $template);

        // pasang data ke token form
        $tokens = [
            '{{FORM_TITLE}}'       => htmlspecialchars($title),
            '{{ACTION}}'           => htmlspecialchars($action),
            '{{ID}}'               => htmlspecialchars((string)($formData['id'] ?? '')),
            '{{NAMA}}'             => htmlspecialchars($formData['nama'] ?? ''),
            '{{JABATAN}}'          => htmlspecialchars($formData['jabatan'] ?? ''),
            '{{DEPARTEMEN}}'       => htmlspecialchars($formData['departemen'] ?? ''),
            '{{TIPE_WAWANCARA}}'   => htmlspecialchars($formData['tipe_wawancara'] ?? ''),
            '{{TOTAL_INTERVIEW}}'  => htmlspecialchars((string)($formData['total_interview'] ?? 0)),
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
