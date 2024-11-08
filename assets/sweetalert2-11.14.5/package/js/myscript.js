var flashData = $('.flash-data').data('flashdata');
//console.log(flashData);

if (flashData) {
    Swal({
        title: 'Login ',
        text: 'Gagal ' + flashData,
        type: 'error'
    })
}