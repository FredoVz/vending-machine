<?php

    echo "<pre>===TAMPIL DI VIEW===</pre>";

    echo "<pre>===Kode Nota===</pre>";

    echo "IF (SELECT OBJECT_ID('tempdb..#LastKodeNotaSlotIOT')) IS NOT NULL DROP TABLE #LastKodeNotaSlotIOT
        SELECT $cabang+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/'+RIGHT('0000000'+CAST(ISNULL((select top 1 CAST(RIGHT(p.KodeNota,7) AS NUMERIC(8,0)) from MasterKejadianSlotIOT p where p.KodeNota like $cabang+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/%' order by p.KodeNota desc),1) AS VARCHAR),7) KodeNota
        INTO #LastKodeNotaSlotIOT";

    echo "<pre>===Master===</pre>";

    // Sample SQL query output for demonstration
    echo "INSERT INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
    SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), $noMesin, '', $createBy, GETDATE(), $operator, GETDATE(), $isApproved, $approvedBy, GETDATE(), $cabang
    FROM #LastKodeNotaSlotIOT";

    echo "<pre>===Details===</pre>";

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

            //echo "<pre>";
            //echo "Qty: " . $qty;
            //echo "</pre>";

            echo $query;
        }
    }

    echo "<pre>===Approved===</pre>";

    echo "INSERT INTO SlotIOT(NoMesin, Slot, Staff, Cabang, StokAkhir, Operator, TglEntry, Brg, SlotMerged, Aktif)
    SELECT m.NoMesin, d.Slot, '', m.Cabang, d.StokAkhir, $operator, GETDATE(), NULL, NULL, 1
    FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d
    WHERE m.KodeNota=:kodenotaPoint4
    AND m.KodeNota=d.KodeNota 
    AND NOT EXISTS(SELECT * FROM SlotIOT s WHERE m.NoMesin=s.NoMesin AND d.Slot=s.Slot)

    UPDATE s
    SET s.StokAkhir=d.StokAkhir, s.Operator=$operator, s.TglEntry=GETDATE() 
    FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d, SlotIOT s 
    WHERE m.KodeNota=:kodenotaPoint4
    AND m.KodeNota=d.KodeNota 
    AND m.NoMesin=s.NoMesin 
    AND d.Slot=s.Slot";

?>