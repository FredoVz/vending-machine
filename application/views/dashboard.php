<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .fixed-top-custom {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030; /* 1030 Pastikan di atas konten lainnya */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Table to display channels -->
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow fixed-top-custom">
                <!-- sticky-top, fixed-top-custom -->

                <div class="mr-5">
                    <h1>Dashboard</h1>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <ul class="na navbar-nav navbar-right d-flex align-items-center">
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <li class="nav-item">
                                <!--li-->
                                <div>Selamat Datang, <?php echo $this->session->userdata('username'); ?></div>
                            </li>
                            <li class="nav-item ml-2">
                                <!--li class="ml-2"-->
                                <?php echo anchor('login/logout', 'Logout', ['class' => 'nav-link']); ?>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <!--li-->
                                <?php echo anchor('login/index', 'Login', ['class' => 'nav-link']); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </ul>
            </nav>

        <!-- End of Topbar -->

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-lg mb-5">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="d-flex flex-row align-items-center mb-3 mb-md-0">
                            <div class="custom-spacing me-2">Show</div>
                            <div class="custom-spacing me-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">10</button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" onclick="changeItemsPerPage(10)">10</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeItemsPerPage(25)">25</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeItemsPerPage(50)">50</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeItemsPerPage(100)">100</a></li>
                                </ul>
                            </div>
                            <div class="ms-2"> Entries</div>
                        </div>
                        <h5 class="mb-0">Data List</h5>
                        <div class="clearable position-relative" style="width: 250px; position: relative;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search..."
                                style="padding-right: 24px;">
                            <!--i class="clearable__clear" id="cancelSearch">&times;</i-->
                            <i class="clearable__clear" id="cancelSearch"
                                style="position: absolute;top: 50%;right: 8px;transform: translateY(-50%);cursor: pointer;display: none;">&times;</i>
                            <!-- display: none; -->
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-striped mb-0">
                                <thead id="data-head" style="background-color: orange; position: sticky;">
                                    <tr>
                                        <th scope="col" style="width:33%;" data-column="vendingMachine">Vending Machine
                                            <i class="bi bi-caret-down-fill"></i></th>
                                        <th scope="col" style="width:33%;" data-column="cabang">Cabang <i
                                                class="bi bi-caret-down-fill"></i></th>
                                        <th scope="col" style="width:33%;">Action </th>
                                    </tr>
                                </thead>
                                <tbody id="data-body" style="overflow-y: auto;">
                                    <?php if (!empty($arrayVM)): ?>
                                        <?php foreach ($arrayVM as $vm): ?>
                                            <tr>
                                                <td scope="row" style="width:33%;" data-label="vendingMachine">
                                                    <?php echo $vm['vendingMachine']; ?></td>
                                                <td scope="row" style="width:33%;" data-label="cabang">
                                                    <?php echo $vm['cabang']; ?></td>
                                                <td scope="row" style="width:33%;">
                                                    <button href="<?= base_url('detail') ?>" class="btn btn-primary">Detail</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center">No data found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="text-center" id="no-results"
                                style="display: none; padding: 20px;top: 50%;left: 50%;right: 50%;">No results found.
                            </div>
                        </div>
                        <div id="entries-info" class="mb-3 mb-md-0" style="padding: 20px;">Showing 1 to 10 of 3053
                            entries</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mt-3" id="pagination">
                                <!-- Pagination buttons will be rendered here -->
                            </ul>
                        </nav>
                    </div>
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
    <!-- JavaScript -->
    <script>
        //videos
        //channels
        var data = <?php echo json_encode($arrayVM); ?>;
        var itemsPerPage = 10;
        var currentPage = 1;
        //var filteredData = initialized(data);
        var filteredData = data;
        var totalItems = data.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var sortColumn = '';  // Default sort column
        var sortOrder = 'asc';  // Default sort order
        var button = document.getElementById('dropdownMenuButton');

        function renderTable(data) {
            var $dataBody = $('#data-body');
            $dataBody.empty();
            var offset = (currentPage - 1) * itemsPerPage;
            var paginatedData = data.slice(offset, offset + itemsPerPage);

            var no = offset + 1; // Set nomor urut berdasarkan offset saat ini

            paginatedData.forEach(row => {
                $dataBody.append(`
                <tr>
                    <td scope="row" style="width:33%;" data-label="vendingMachine">${row.vendingMachine}</td>
                    <td scope="row" style="width:33%;" data-label="cabang">${row.cabang}</td>
                    <td scope="row" style="width:33%;">
                        <button href="<?= base_url('detail') ?>" class="btn btn-primary">Detail</button>
                    </td>
                </tr>
            `);
            });
        }

        function sortData(column, order) {
            if (column === '') {
                return filteredData.slice();
            }

            /*if (column === 'No') {
                return filteredData.slice().sort((a, b) => {
                    var valA = a.originalIndex;
                    var valB = b.originalIndex;
    
                    if (valA < valB) return order === 'asc' ? -1 : 1;
                    if (valA > valB) return order === 'asc' ? 1 : -1;
    
                    return 0;
                });
            }*/

            return filteredData.slice().sort((a, b) => {
                var valA = a[column] || '';
                var valB = b[column] || '';
                if (typeof valA === 'string') valA = valA.toLowerCase();
                if (typeof valB === 'string') valB = valB.toLowerCase();

                if (valA < valB) return order === 'asc' ? -1 : 1;
                if (valA > valB) return order === 'asc' ? 1 : -1;

                return 0;
            });
        }

        function navigatePage(page) {
            currentPage = page;
            var sortedData = sortData(sortColumn, sortOrder);
            renderTable(sortedData);
            updatePagination();
            updateEntriesInfo();
        }

        function updatePagination() {
            var $pagination = $('.pagination');
            $pagination.empty();

            if (currentPage > 1) {
                $pagination.append(`<li class="page-item"><button class="page-link" onclick="navigatePage(${currentPage - 1})">Previous</button></li>`);
            } else {
                $pagination.append(`<li class="page-item disabled"><button class="page-link">Previous</button></li>`);
            }

            var startPage = Math.max(1, currentPage - 1);
            var endPage = Math.min(totalPages, currentPage + 1);

            if (startPage > 1) {
                $pagination.append(`<li class="page-item disabled"><button class="page-link">...</button></li>`);
            }

            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    $pagination.append(`<li class="page-item active"><button class="page-link">${i} <span class="sr-only"></span></button></li>`);
                } else {
                    $pagination.append(`<li class="page-item"><button class="page-link" onclick="navigatePage(${i})">${i}</button></li>`);
                }
            }

            if (endPage < totalPages) {
                $pagination.append(`<li class="page-item disabled"><button class="page-link">...</button></li>`);
            }

            if (currentPage < totalPages) {
                $pagination.append(`<li class="page-item"><button class="page-link" onclick="navigatePage(${currentPage + 1})">Next</button></li>`);
            } else {
                $pagination.append(`<li class="page-item disabled"><button class="page-link">Next</button></li>`);
            }
        }

        function debounce(func, wait) {
            var timeout;
            return function (...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func.apply(this, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function changeItemsPerPage(newItemsPerPage) {
            itemsPerPage = newItemsPerPage;
            totalPages = Math.ceil(totalItems / itemsPerPage);
            currentPage = 1;
            var sortedData = sortData(sortColumn, sortOrder);
            renderTable(sortedData);
            updatePagination();
            updateEntriesInfo();
            button.textContent = `${newItemsPerPage}`;
        }

        function handleSort(column) {
            if (sortColumn === column) {
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                sortColumn = column;
                sortOrder = 'asc';
            }

            $('#data-head th').each(function () {
                var $this = $(this);
                var column = $this.data('column');
                var $icon = $this.find('i');
                if (column === sortColumn) {

                    $icon.removeClass('bi-caret-down-fill bi-caret-up-fill').addClass(sortOrder === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill');
                } else {
                    $icon.removeClass('bi-caret-up-fill bi-caret-down-fill').addClass('bi-caret-down-fill');
                }
            });

            var sortedData = sortData(sortColumn, sortOrder);
            renderTable(sortedData);
            updatePagination();
            //updateEntriesInfo();
        }

        function updateEntriesInfo() {
            var startEntry = (currentPage - 1) * itemsPerPage + 1;
            var endEntry = Math.min(currentPage * itemsPerPage, totalItems);
            $('#entries-info').text(`Showing ${startEntry} to ${endEntry} of ${totalItems} entries`);
        }

        $(document).ready(function () {
            function refreshTable() {
                var sortedData = sortData(sortColumn, sortOrder);
                renderTable(sortedData);
                updatePagination();
                updateEntriesInfo();
            }

            $('#searchInput').on('keyup', debounce(function () {
                var query = $(this).val().toLowerCase();

                if (query) {
                    $('#cancelSearch').show();  // Tampilkan tombol cancel saat ada input
                } else {
                    $('#cancelSearch').hide();  // Sembunyikan tombol saat input kosong
                }

                filteredData = data.filter(row =>
                    Object.values(row).some(val => {
                        // Pastikan val adalah string sebelum memanggil toLowerCase
                        if (typeof val === 'string') {
                            return val.toLowerCase().includes(query);
                        }
                        // Jika val bukan string, kita bisa memilih untuk mengabaikannya atau melakukan sesuatu
                        return false;
                    })
                );

                if (query.length > 2 && filteredData.length === 0) {
                    $('#no-results').show();
                } else {
                    $('#no-results').hide();
                }

                totalItems = filteredData.length;
                totalPages = Math.ceil(totalItems / itemsPerPage);
                currentPage = 1;
                refreshTable();
            }, 300));

            $('#data-head th').on('click', function () {
                var column = $(this).data('column');
                handleSort(column);
                updateEntriesInfo();
            });

            $('#cancelSearch').on('click', function () {
                $('#searchInput').val('');
                data = <?php echo json_encode($arrayVM); ?>;
                filteredData = data;
                $(this).hide();  // Sembunyikan tombol cancel
                totalItems = filteredData.length;
                totalPages = Math.ceil(totalItems / itemsPerPage);
                currentPage = 1;
                $('#no-results').hide();  // Pastikan pesan "No results found" disembunyikan
                refreshTable();
            });

            filteredData = data;  // Initialize filteredData with allData on page load
            refreshTable();
        });
    </script>
</body>

</html>