<div class="container-fluid mt-5">
    <!-- Table to display data -->
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card shadow-lg mb-5 my-5">
                <div class="flash-data" data-flashdata='<?= json_encode($this->session->flashdata('message')); ?>'></div>
                <form action="<?= base_url('detail/add'); ?>" method="post">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="">
                            <div>
                                <strong>No Mesin: </strong>
                                <?= urldecode($noMesin); ?>
                            </div>
                            <div>
                                <strong>Nama Staff: </strong>
                                <?= urldecode($namaStaff); ?>
                            </div>
                            <div>
                                <strong>Nama Cabang: </strong>
                                <?= urldecode($namaCabang); ?>
                            </div>
                            <input type="hidden" name="NoMesin" id="NoMesin" value="<?= $noMesin ?>">
                            <input type="hidden" name="NamaStaff" id="NamaStaff" value="<?= $namaStaff ?>">
                            <input type="hidden" name="NamaCabang" id="NamaCabang" value="<?= $namaCabang ?>">

                            <div class="form-row align-items-center mb-1" style="display: flex; align-items: center;">
                                <div class="col-auto">
                                    <label class="form-check-label mr-2"><strong>Approve:</strong></label>
                                    <input class="form-check-input col-form-label ml-2" type="checkbox"
                                        id="approveCheckbox">
                                    <input type="hidden" name="approve" id="approveHidden" value="0">
                                </div>
                            </div>
                        </div>
                        <!-- modal-footer -->
                        <div class="mt-3 md-0">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-striped mb-0" style="width: 100%;">
                                <thead id="data-head" style="background-color: orange; position: sticky;">
                                    <tr>
                                        <th scope="col" style="width:20%;" data-column="Slot">Slot</th>
                                        <th scope="col" style="width:20%;" data-column="NamaBarang">Nama Barang</th>
                                        <th scope="col" style="width:20%;" data-column="StokAkhir">Stok Akhir</th>
                                        <th scope="col" style="width:20%;" data-column="Aktif">Status</th>
                                        <th scope="col" style="width:20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data-body">
                                    <?php if (!empty($arrayDetailVM)): ?>
                                        <?php $i = 0; // Initialize $i ?>
                                        <?php foreach ($arrayDetailVM as $vm): ?>
                                            <tr>
                                                <td scope="row" style="width:20%;" data-label="Slot">
                                                    <?= $vm['Slot']; ?>
                                                </td>
                                                <td scope="row" style="width:20%;" data-label="NamaBarang">
                                                    <?= $vm['NamaBarang']; ?>
                                                </td>
                                                <td scope="row" style="width:20%;" data-label="StokAkhir">
                                                    <?= (int) $vm['StokAkhir']; ?>
                                                </td>
                                                <td scope="row" style="width:20%;" data-label="Aktif">
                                                    <?= $vm['Aktif'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?>
                                                </td>
                                                <td scope="row" style="width:20%;">
                                                    <div class="form-row align-items-center mt-1 mb-1 mr-1 ml-1">
                                                        <div class="col-auto">
                                                            <label for="qty"
                                                                class="col-form-label"><strong>Qty:</strong></label>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Dynamic qty name based on index -->
                                                            <input type="number" class="form-control qty-input"
                                                                name="qty[<?= $i ?>]" value="0" min="0">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center">No data found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (!empty($arrayDetailVM)): ?>
                            <!-- Convert arrayDetailVM to JSON and store it in hidden input -->
                            <input type="hidden" name="arrayDetailVM" id="arrayDetailVM"
                                value='<?= json_encode($arrayDetailVM); ?>'>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<!-- SWEET ALERT -->
<!--script src="< ?= base_url(); ?>assets/sweetalert2-11.14.5/package/js/sweetalert2.all.min.js"></script-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        var flashData = document.querySelector('.flash-data').dataset.flashdata;
        var confirmButtonText = 'OK';

        //console.log(flashData);

        if (flashData) {
            // Parsing data JSON
            var data = JSON.parse(flashData);

            //console.log(data);

            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                confirmButtonText: confirmButtonText
            });
        }
    });
</script>

<!-- FUNGSI DYNAMIC MODAL BODY -->
<script>
    $(document).on('click', '.openDetailModal', function () {
        var id = $(this).data('NoMesin');
        var resDetails = <?= json_encode($arrayDetailVM); ?>; // Convert PHP array to JavaScript
        //console.log(resDetails);
        var filteredData = resDetails.filter(vm => vm.id == id); // Get all data matching the ID
        var modalContent = '';
        var hiddenInputs = '';

        if (filteredData.length > 0) {
            filteredData.forEach(function (data, index) {
                // Determine Aktif status
                var aktifStatus = data.Aktif == 1 ? 'Aktif' : 'Tidak Aktif';

                // Convert StokAkhir to integer, or set to 0 if NaN
                var stokAkhir = parseInt(data.StokAkhir);
                var formattedStokAkhir = isNaN(stokAkhir) ? '0' : stokAkhir.toLocaleString();

                modalContent += `
                    <div class="modal-body-entry">
                        <div class="d-flex">
                            <strong>Slot : </strong>
                            <div>${data.Slot}</div>
                        </div>
                        <div class="d-flex">
                            <strong>Nama Barang : </strong>
                            <div>${data.NamaBarang}</div>
                        </div>
                        <div class="d-flex">
                            <strong>Stok Akhir : </strong>
                            <div>${formattedStokAkhir}</div>
                        </div>
                        <div class="d-flex">
                            <strong>Status : </strong>
                            <div>${aktifStatus}</div>
                        </div>
                        <div class="form-row align-items-center mt-1 mb-1 mr-1 ml-1">
                            <div class="col-auto">
                                <label for="qty" class="col-form-label"><strong>Qty:</strong></label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control qty-input" id="qty_${index}" name="details[${index}][qty]" placeholder="Input qty..." value="0" min="0" data-index="${index}">
                            </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                `;

                // Create hidden inputs for each data field to be sent to the controller
                hiddenInputs += `
                    <input type="hidden" name="details[${index}][Slot]" value="${data.Slot}">
                    <input type="hidden" name="details[${index}][StokAkhir]" id="stokAkhir_${index}" value="${formattedStokAkhir}">
                    <input type="hidden" name="details[${index}][NamaBarang]" value="${data.NamaBarang}">
                    <input type="hidden" name="details[${index}][Aktif]" value="${data.Aktif}">
                `;
            });
            $('#modal-body-content').html(modalContent); // Insert the generated content into the modal

            // Append hidden inputs to the form
            $('#detailForm').append(hiddenInputs);
        } else {
            alert('Data tidak ditemukan.');
        }
    });

    // Update Stok Akhir based on Qty input
    $(document).on('input', '.qty-input', function () {
        var index = $(this).data('index'); // Get the index for this input
        var qty = parseInt($(this).val()) || 0; // Get the qty value, defaulting to 0 if empty

        // Update hidden input and displayed StokAkhir with the qty value
        $(`#stokAkhir_${index}`).val(qty);
        //$(`#stokAkhirDisplay_${index}`).text(qty);
    });
</script>

<!-- FUNGSI CENTANG APPROVE DI MODAL -->
<script>
    $(document).ready(function () {
        $('#approveCheckbox').on('change', function () {
            // Jika checkbox dicentang, atur hidden input value ke 1
            $('#approveHidden').val(this.checked ? '1' : '0');
            //$check = $('#approveHidden').val(this.checked ? '1' : '0');
        });
        //console.log($check)
    });
</script>