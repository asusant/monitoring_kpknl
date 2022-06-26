// Loading elm
let loadElm = document.getElementById('bobb-loading')

window.onbeforeunload = function () {
    loadElm.style.display = 'block';
}

// Warna normal untuk notif dll
let colors = {
    'primary'   : '#435ebe',
    'secondary' : '#6c757d',
    'danger'    : '#dc3545',
    'success'   : '#00b09b'
};

// Warna gradient untuk notif dll
let grad_colors = {
    'info'      : 'linear-gradient(to bottom, #33ccff 0%, #3366ff 100%)',
    'danger'    : 'linear-gradient(to bottom, #ff0066 0%, #ff0000 100%)',
    'success'   : 'linear-gradient(to right, #00b09b, #96c93d)'
};

// Toast function
function showToast(msg, type, time = 3000){
    if( !(type in colors) )
    {
        type = 'info';
    }
    bg = colors[type];
    Toastify({
        text: msg,
        duration: time,
        gravity:"top",
        position: "right",
        backgroundColor: bg,
    }).showToast();
}

var allBtnSubmit = document.querySelectorAll('.btn-submit');
for (var i = 0; i < allBtnSubmit.length; i++) {
    allBtnSubmit[i].addEventListener('click', function(e) {
        elm = e.target;
        elm.querySelector('.loading-spinner').style.display = 'inline-block';
        elm.disabled = true;
        elm.closest('.form').submit();
    });
}

function confirmDelete(url)
{
    Swal.fire({
        title: 'Anda yakin akan menghapus data ini?',
        showDenyButton: true,
        confirmButtonColor: colors['danger'],
        denyButtonColor: colors['secondary'],
        confirmButtonText: 'Hapus',
        denyButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = url;
        }
    })
}

function confirmAction(url, txt='Apakah Anda yakin?', confirmTxt = 'Yakin', denyTxt='Tidak', callback='')
{
    Swal.fire({
        title: txt,
        showDenyButton: true,
        confirmButtonColor: colors['danger'],
        denyButtonColor: colors['secondary'],
        confirmButtonText: confirmTxt,
        denyButtonText: denyTxt,
    }).then((result) => {
        if (result.isConfirmed) {
            if(url == '' && callback != '')
            {
                callback();
            }
            else
            {
                window.location = url;
            }
        }
    })
}

function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

/**
 * toggle check / uncheck checkboxes
 */
function checkAll(elmName, source)
{
    checkboxes = document.getElementsByName(elmName);
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}

function initTooltip()
{
    // tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}

function initDatePickers()
{
    var datepickers = [].slice.call(document.querySelectorAll('[data-datepicker]'))
    datepickers.map(function (el) {
        return new Datepicker(el, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd'
        });
    });

    // Time Picker
    // var timepickers = [].slice.call(document.querySelectorAll('[data-timepicker]'))
    // var timepickersList = timepickers.map(function (el) {
    //     return new Datepicker(el, {
    //         buttonClass: 'btn',
    //         format: 'hh:ii:ss'
    //     });
    // });
}

function genSpinner(customText='')
{
    spinnerTxt = 'Loading...';
    if(customText != '')
    {
        spinnerTxt = customText;
    }
    return '<p class="text-center"><span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span> '+spinnerTxt+'</p>';
}

(function() {
    initTooltip();
    initDatePickers();
})();

//
// function focusChoicesJs()
// {
//     document.querySelector(".choices__inner").querySelector("input[type=text]").focus();
// }
