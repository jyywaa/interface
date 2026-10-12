<?php

interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

class TransferBank implements MetodePembayaran {
    private string $nomorRekening;

    public function __construct(string $nomorRekening) {
        $this->nomorRekening = $nomorRekening;
    }

    public function getNamaMetode(): string {
        return "Transfer Bank";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0; // 0%
        $totalBayar = $jumlah + $biayaAdmin;

        echo "Metode: " . $this->getNamaMetode() . " (No. Rek: " . $this->nomorRekening . ")<br>";
        echo "Keterangan: " . $keterangan . "<br>";
        echo "Tagihan: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin (0%): " . formatRupiah($biayaAdmin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($totalBayar) . "<br>";
        echo "------------------------------------------------------<br>";

        return true;
    }
}

class QRIS implements MetodePembayaran {
    public function getNamaMetode(): string {
        return "QRIS";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.007; 
        $totalBayar = $jumlah + $biayaAdmin;

        echo "Metode: " . $this->getNamaMetode() . "<br>";
        echo "Keterangan: " . $keterangan . "<br>";
        echo "Tagihan: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin (0.7%): " . formatRupiah($biayaAdmin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($totalBayar) . "<br>";
        echo "------------------------------------------------------<br>";

        return true;
    }
}

class KartuKredit implements MetodePembayaran {
    private string $nomorKartu;

    public function __construct(string $nomorKartu) {
        $this->nomorKartu = $nomorKartu;
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.025; 
        $totalBayar = $jumlah + $biayaAdmin;
        
        $empatDigitTerakhir = substr($this->nomorKartu, -4);

        echo "Metode: " . $this->getNamaMetode() . " (****-****-****-" . $empatDigitTerakhir . ")<br>";
        echo "Keterangan: " . $keterangan . "<br>";
        echo "Tagihan: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin (2.5%): " . formatRupiah($biayaAdmin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($totalBayar) . "<br>";
        echo "------------------------------------------------------<br>";

        return true;
    }
}

function formatRupiah(float $angka): string {
    return "Rp " . number_format($angka, 0, ',', '.');
}



$jumlahTagihan = 500000;


$pembayaran1 = new TransferBank("1234567890");
$pembayaran1->prosesBayar($jumlahTagihan, "Pembayaran Laptop Asus");


$pembayaran2 = new QRIS();
$pembayaran2->prosesBayar($jumlahTagihan, "Pembayaran Mouse Wireless");

$pembayaran3 = new KartuKredit("4111222233334444");
$pembayaran3->prosesBayar($jumlahTagihan, "Pembayaran Monitor Samsung");

?>