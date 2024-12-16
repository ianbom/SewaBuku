var table, jsonTables, newUrl;
// {{-- function load datatables  --}}
function loadAjaxDataTables(params) {
    newUrl = params.urlAjax;
    // Setup - add a text input to each header cell
    // if (!params.responsive) {
    //     $(params.idTable + ' thead tr')
    //         .clone(true)
    //         .addClass('filters')
    //         .appendTo(params.idTable + ' thead');
    // }


    table = $('#table-1').DataTable({
        responsive: params.responsive,
        fixedHeader: true,
        dom: 'lBfrtip',
        buttons: {
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: `<i class="fas fa-file-excel"></i> Export to Excel`,
                    className: 'btn btn-outline-success mt-3 me-2 mb-3', // Bootstrap 5.3 classes (me-2 for margin-end)
                    titleAttr: 'Export ke Excel',
                    title: document.title + ' - ' + new Date().toDateString(), // Use page title
                    autoFilter: true,
                    footer: true,
                    sheetName: 'Exported data',
                    exportOptions: {
                        columns: ':not(:last-child)',
                        orthogonal: 'exportxls',
                        format: {
                            header: function (data, index, node) {
                                var cleanHeader = data.replace(/<\/?[^>]+(>|$)/g, ""); // Strip HTML tags
                                return cleanHeader.trim().toUpperCase();
                            }
                        }
                    },
                },
                // Check for params.pdf conditionally
                ...(params.pdf !== 'not_print' ? [
                    {
                        text: `<i class="fas fa-file-pdf"></i> Cetak Laporan`,
                        className: 'btn btn-outline-danger mt-3 mb-3', // Additional classes for styling
                        titleAttr: 'Perform Cetak Laporan',
                        action: function (e, dt, node, config) {
                            console.log('nwUrl: ', newUrl)
                            if (newUrl instanceof URL) {
                                // Add or update the 'pdf' parameter in the URLSearchParams of the URL object
                                newUrl.searchParams.set('pdf', 'print');

                                // Convert the updated URL object back to a string
                                let finalUrl = newUrl.toString();

                                console.log(finalUrl);

                                // Open the final URL in a new tab or window
                                window.open(finalUrl, '_blank');
                            } else {
                                // Ensure pdf=print is always the first query parameter for print
                                let params = new URLSearchParams(newUrl ? newUrl.split('?')[1] : "");
                                params.set('pdf', 'print'); // Add or update the pdf parameter
                                let finalUrl = newUrl.split('?')[0] + '?' + params.toString();
                                console.log(finalUrl)
                                window.open(finalUrl, '_blank');
                            }
                        }
                    }
                ] : [])
            ],
            dom: {
                button: {
                    className: 'btn' // Bootstrap 5.3 base button class
                }
            }
        },
        processing: true,



        /// ---- handle filter each column function  -----
        initComplete: function () {
            if (!params.responsive) {
                var api = this.api();
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html(
                            '<input type="text" class="text-center text-wrap" style="text-transform: uppercase;" placeholder="' +
                            title + '" />'
                        );

                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                // .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            }
        },
        ajax: params.urlAjax,
        columns: params.columns,
        columnDefs: params.defColumn,
    });


}

// console.log(table);
// ajax store data
function ajaxSaveDatas(params) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // If the method is PUT, add _method=PUT to FormData
    if (params.method === 'PUT' && params.input instanceof FormData) {
        params.input.append('_method', 'PUT');
        params.method = 'POST'; // Use POST to simulate PUT
    }

    $.ajax({
        url: params.url,
        method: params.method,
        async: true,
        dataType: 'json',
        data: params.input,
        processData: params.processData !== null ? params.processData : true,
        contentType: params.contentType !== null ? params.contentType : 'application/x-www-form-urlencoded',
        beforeSend: function (xhr) {
            Swal.fire({
                title: params.load_msg ? params.load_msg : 'Sedang menyimpan data...',
                html: 'Mohon ditunggu!',
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (data) {
            if (params.reload == null || params.reload == false) {
                if (typeof table !== 'undefined' && table != null) {
                    table.ajax.reload();
                }
            }

            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-right',
                icon: 'success',
                title: 'Yayy!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            if (params.forms) params.forms.reset();
            if (params.modal) params.modal.hide();

            if (params.reload === true) {
                location.reload();
            }

            if (params.redirect) {
                window.location.href = params.redirect;
            }
        },
        error: function (xhr) {
            Swal.close();
            var validationErrors = xhr.responseJSON.errors;
            var message = 'Ada yang salah saat menyimpan data. Coba lagi!';

            if (typeof validationErrors === 'object') {
                for (var fieldName in validationErrors) {
                    if (validationErrors.hasOwnProperty(fieldName)) {
                        var errorMessages = validationErrors[fieldName];
                        message = errorMessages.join(', ');
                        break;
                    }
                }
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message
            });
        }
    });
}



function deleteConfirm(event, params = null, isTable = true, callback = null) {
    Swal.fire({
        title: 'Konfirmasi Hapus!',
        text: 'Apakah Anda yakin ingin menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Iya',
        confirmButtonColor: 'red'
    }).then(dialog => {
        var method = 'GET',
            valueHeaders = '';
        if (params != null) {
            method = params;
            valueHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        if (dialog.isConfirmed) {
            // window.location.assign(event.dataset.deleteUrl);
            $.ajax({
                headers: valueHeaders,
                url: event.dataset.deleteUrl,
                type: method,
                dataType: "JSON",
                beforeSend: function (xhr) {
                    Swal.fire({
                        title: 'Sedang menyimpan data...',
                        html: 'Mohon ditunggu!',
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                error: function (xhr) {
                    var message;
                    var validationErrors = xhr.responseJSON.errors
                    for (var fieldName in validationErrors) {
                        if (validationErrors.hasOwnProperty(fieldName)) {
                            var errorMessages = validationErrors[fieldName];

                            // Handle each error message for the current field
                            console.log('Validation Errors for ' + fieldName + ':',
                                errorMessages);
                            message = errorMessages
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada yang salah saat menghapus data. Coba lagi! ' +
                            (xhr.responseJSON &&
                                xhr.statusText ? xhr.statusText :
                                message ?
                                    message : ""),
                    })
                    console.log("statustext: " + xhr.statusText + "responsetxt: " + xhr
                        .responseText)
                },
                success: function (data) {
                    if (isTable) {
                        table.ajax.reload()
                    } else {
                        $(event).closest(".form-row").remove();
                    }
                    if (typeof callback === "function") {
                        callback();
                    }
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                }
            });
        }
    })
}

function approveConfirm(event, params = null, isTable = true, text = 'Yakin ingin menyetujui Peserta ini?', modal = '') {
    Swal.fire({
        title: 'Konfirmasi Persetujuan!',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Iya',
        confirmButtonColor: 'red'
    }).then(dialog => {
        var method = 'GET',
            valueHeaders = '';
        if (params != null) {
            method = params;
            valueHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        if (dialog.isConfirmed) {
            // window.location.assign(event.dataset.deleteUrl);
            $.ajax({
                headers: valueHeaders,
                url: event.dataset.deleteUrl,
                type: method,
                dataType: "JSON",
                beforeSend: function (xhr) {
                    Swal.fire({
                        title: 'Sedang menyimpan data...',
                        html: 'Mohon ditunggu!',
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                error: function (xhr) {
                    Swal.close()
                    var message;
                    var validationErrors = xhr.responseJSON.errors
                    for (var fieldName in validationErrors) {
                        if (validationErrors.hasOwnProperty(fieldName)) {
                            var errorMessages = validationErrors[fieldName];

                            // Handle each error message for the current field
                            console.log('Validation Errors for ' + fieldName + ':',
                                errorMessages);
                            message = errorMessages
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada yang salah saat menyetujui data. Coba lagi! ' +
                            (xhr.responseJSON &&
                                xhr.statusText ? xhr.statusText :
                                message ?
                                    message : ""),
                    })
                    console.log("statustext: " + xhr.statusText + "responsetxt: " + xhr
                        .responseText)
                },
                success: function (data) {
                    console.log(data)
                    // Swal.close()
                    if (isTable) {
                        // console.log("table");
                        table.ajax.reload()
                    } else if (modal != '') {
                        console.log(modal)
                        $(modal).modal('hide');
                        table.ajax.reload()
                        // $(event).closest(".form-row").remove();
                    }
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })
                    if (data.status == 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }

                }
            });
        }
    })
}
