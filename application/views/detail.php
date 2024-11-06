<?php

    // Display the qty value
    //echo "<pre>";
    //echo "Qty: " . $qty;
    //echo "</pre>";

    echo "<pre>";
    echo "===TAMPIL DI VIEW===";
    echo "</pre>";

    // Sample SQL query output for demonstration
    if ($details) {
        foreach ($details as $detail) {
            if (empty($detail['qty'])) {
                $detail['qty'] = 0;
            }
            
            $slot = $detail['Slot'];
            $stok_akhir = $detail['StokAkhir'];
            $nama_barang = $detail['NamaBarang'];
            $status_aktif = $detail['Aktif'];
            $qty = $detail['qty'];

            //echo "INSERT INTO DetailKejadianSlotIOT (KodeNota, $slot, $stok_akhir, PrevStok)
            //SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

            $query = "INSERT INTO DetailKejadianSlotIOT (KodeNota, Slot, StokAkhir, PrevStok)
            SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

            echo "<pre>";
            echo "Qty: " . $qty;
            echo "</pre>";

            echo $query;
        }
    }

?>