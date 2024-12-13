
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vending Machine - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Custom CSS -->
<style>
    /* IMPORT FILE */
    .btn-light {
        background-color: white;
        border: 1px solid #ced4da;
    }

    #file-name {
        background-color: #e7dbeb;
        cursor: pointer; /* Makes the input look clickable */
    }

        /* SEARCH */
    .clearable input[type=text] {
        padding-right: 24px;
    }

    .clearable input[type=text]:not(:placeholder-shown) + .clearable__clear {
        display: inline;
    }

    @media (max-width: 768px) {
        /*Atur table*/
        .table-responsive {
            overflow-x: auto; /* Allows horizontal scrolling on smaller screens */
        }

        .table {
            width: 1000px;
        }

        /* Make the input fields take the full width on small screens */
        .qty-input {
            width: 100% !important; /* Ensures the input takes full width on mobile */
        }

        .form-row {
            flex-wrap: wrap; /* Allows label and input to stack on smaller screens */
        }

        .col-auto {
            width: 100%; /* Label will take full width */
            text-align: left; /* Align label to the left */
        }

        .col {
            width: 100%; /* Input field will take full width */
        }

        /*Atur tombol add*/
        .card-header {
            text-align: left;  /* Aligns the content to the left */
        }

        /* Ensure the Add button is centered or aligned properly */
        .mt-3 {
            width: 100%;  /* Make the button take the full width on small screens */
            display: flex;
            justify-content: flex-end;  /* Center the button */
            /*margin-left: 150px;*/
            /*padding-right: 10px;*/
            /*right: 0%;*/
            text-align: right;
        }
    }

    @media (max-width: 576px) {
        .clearable {
            width: 100%;  /*Full width on small screens */
        }
    }

    /* Tabel bawah isi kolom bisa di scroll */
    .table-responsive {
        max-height: 560px;
    }

    .table thead {
        position: sticky;
        top: 0;
        z-index: 2; /* Ensure the header stays on top */
    }
</style>
</head>