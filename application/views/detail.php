<?php

    // Display the qty value
    echo "<pre>";
    echo "Qty: " . $qty;
    echo "</pre>";

    // Sample SQL query output for demonstration
    if ($details) {
        foreach ($details as $detail) {
            $slot = $detail['Slot'];
            $stok_akhir = $detail['StokAkhir'];
            $nama_barang = $detail['NamaBarang'];
            $status_aktif = $detail['Aktif'];

            //echo "INSERT INTO DetailKejadianSlotIOT (KodeNota, $slot, $stok_akhir, PrevStok)
            //SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

            $query = "INSERT INTO DetailKejadianSlotIOT (KodeNota, $slot, $stok_akhir, PrevStok)
            SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

            echo $query;
        }
    }

?>