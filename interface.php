<?php
// ===== SOAL 1: INTERFACE PEMBAYARAN =====
interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

function formatRupiah(float $angka): string {
    return "Rp " . number_format($angka, 0, ',', '.');
}

class TransferBank implements MetodePembayaran {
    private $noRekening;
    public function __construct(string $noRekening) {
        $this->noRekening = $noRekening;
    }
    public function getNamaMetode(): string {
        return "Transfer Bank";
    }
    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0;
        $total = $jumlah + $biayaAdmin;
        echo "METODE: " . $this->getNamaMetode() . "\n";
        echo "No Rekening : {$this->noRekening}\n";
        echo "Keterangan  : $keterangan\n";
        echo "Jumlah      : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin : 0% (" . formatRupiah($biayaAdmin) . ")\n";
        echo "TOTAL BAYAR : " . formatRupiah($total) . "\n";
        echo "--------------------------\n\n";
        return true;
    }
}

class QRIS implements MetodePembayaran {
    public function getNamaMetode(): string {
        return "QRIS";
    }
    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.7 / 100;
        $total = $jumlah + $biayaAdmin;
        echo "METODE: " . $this->getNamaMetode() . "\n";
        echo "Keterangan  : $keterangan\n";
        echo "Jumlah      : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin : 0.7% (" . formatRupiah($biayaAdmin) . ")\n";
        echo "TOTAL BAYAR : " . formatRupiah($total) . "\n";
        echo "--------------------------\n\n";
        return true;
    }
}

class KartuKredit implements MetodePembayaran {
    private $noKartu;
    public function __construct(string $noKartu) {
        $this->noKartu = $noKartu;
    }
    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }
    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 2.5 / 100;
        $total = $jumlah + $biayaAdmin;
        $sensor = substr($this->noKartu, -4);
        echo "METODE: " . $this->getNamaMetode() . "\n";
        echo "No Kartu    : ****-****-****-$sensor\n";
        echo "Keterangan  : $keterangan\n";
        echo "Jumlah      : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin : 2.5% (" . formatRupiah($biayaAdmin) . ")\n";
        echo "TOTAL BAYAR : " . formatRupiah($total) . "\n";
        echo "--------------------------\n\n";
        return true;
    }
}

// ===== SOAL 2: INTERFACE NOTIFIKASI =====
interface Notifikasi {
    public function kirim(string $penerima, string $pesan): bool;
}

class Email implements Notifikasi {
    public function kirim(string $penerima, string $pesan): bool {
        echo "[EMAIL] Ke: $penerima | Pesan: $pesan\n";
        return true;
    }
}
class WhatsApp implements Notifikasi {
    public function kirim(string $penerima, string $pesan): bool {
        echo "[WHATSAPP] Ke: $penerima | Pesan: $pesan\n";
        return true;
    }
}
class SMS implements Notifikasi {
    public function kirim(string $penerima, string $pesan): bool {
        echo "[SMS] Ke: $penerima | Pesan: $pesan\n";
        return true;
    }
}

// ===== UJI COBA =====
echo "=== PEMBAYARAN ===\n\n";
$bayar1 = new TransferBank("1122334455");
$bayar1->prosesBayar(500000, "Pembayaran SPP");

$bayar2 = new QRIS();
$bayar2->prosesBayar(500000, "Jajan Kantin");

$bayar3 = new KartuKredit("1234567812345678");
$bayar3->prosesBayar(500000, "Belanja Online");

echo "\n=== NOTIFIKASI ===\n\n";
(new Email())->kirim("budi@gmail.com", "Pembayaran Rp 500.000 Berhasil");
(new WhatsApp())->kirim("081234567890", "Kode OTP: 1234");
(new SMS())->kirim("081234567890", "Terima kasih sudah bayar");
?>