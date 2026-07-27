function showAlert(title, text, icon) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            html: text,
            icon: icon,
        });
    } else if (typeof swal !== 'undefined' && typeof swal === 'function') {
        swal({
            title: title,
            text: text,
            icon: icon,
        });
    } else {
        alert(title + ": " + text);
    }
}


function logoutAndDeleteFunction(e) {
    var msg = e.getAttribute("data-msg") || "Are you sure you want to delete this?";
    var method = e.getAttribute("data-method") || "GET";
    var url = e.getAttribute("data-url");

    var swalObj = typeof Swal !== 'undefined' ? Swal : (typeof swal !== 'undefined' && swal.fire ? swal : null);

    if (swalObj && typeof swalObj.fire === 'function') {
        swalObj.fire({
            title: "Are you sure?",
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        })
        .then((result) => {
            if (result.isConfirmed) {
                yourFunction(url, method);
            }
        });
    } else {
        if (confirm(msg)) {
            yourFunction(url, method);
        }
    }
}

function yourFunction(url, method) {
    $.ajax({
        url: url,
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response && response.error !== undefined) {
                var text = "<span style='color:red'>" + response.error + "</span>";
                showAlert('Error', text, 'error');
                return false;
            }
            if (response && response.reload !== undefined) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "Success",
                        text: response.success || "Operation completed successfully",
                        icon: "success",
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                    setTimeout(() => { window.location.reload(); }, 1250);
                } else {
                    alert(response.success || "Operation completed successfully");
                    window.location.reload();
                }
                return false;
            }
            if (response && response.redirect !== undefined) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "Success",
                        text: response.success || "Operation completed successfully",
                        icon: "success",
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                    setTimeout(() => { window.location.href = response.redirect; }, 1250);
                } else {
                    alert(response.success || "Operation completed successfully");
                    window.location.href = response.redirect;
                }
                return false;
            }
            if (response && response.success !== undefined) {
                showAlert("Success", response.success, "success");
            }
        },
        error: function(xhr, status, error) {
            if (typeof ajaxErrorHandling === 'function') {
                ajaxErrorHandling(xhr, error);
            } else {
                var msg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) ? (xhr.responseJSON.message || xhr.responseJSON.error) : (error || "Something went wrong!");
                showAlert("Error", msg, "error");
            }
        }
    });
}

    function multipleerrorshandle(errors) {
        let message = '<ul style="text-align: left; list-style-type: none; padding-left: 0;">';
        for (var errorkey in errors) {
            // Laravel errors are usually arrays of messages
            let errorMessages = Array.isArray(errors[errorkey]) ? errors[errorkey] : [errors[errorkey]];
            errorMessages.forEach(msg => {
                message += '<li style="margin-bottom: 8px;"><i class="fas fa-exclamation-circle" style="color: #e74c3c; margin-right: 8px;"></i>' + msg + '</li>';
            });
        }
        message += '</ul>';
        
        Swal.fire({
            title: 'Validation Errors',
            html: message,
            icon: 'error',
            confirmButtonColor: '#3498db',
            customClass: {
                popup: 'rounded-lg shadow-xl'
            }
        });
    }

    function ajaxErrorHandling(data, msg){
        if (data.hasOwnProperty("responseJSON")) {
            var resp = data.responseJSON;
            if (resp.message == 'CSRF token mismatch.') {
                showAlert("Page has been expired and will reload in 2 seconds", "Page Expired!", "error");
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
                return;
            }
            if (resp.error) {
                var msg = (resp.error == '') ? 'Something went wrong!' : resp.error;
                showAlert(msg, "Error!", "error");
                return;
            }
            if (resp.message != 'The given data was invalid.') {
                showAlert(resp.message, "Error!", "error");
                return;
            }
            multipleerrorshandle(resp.errors);
        } else {
            showAlert(msg + "!", "Error!", 'error');
        }
        return;
    }
    //post
    function myAjax(url, formData, method = 'post', callback, options = {}) {
        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            // Ensure submit buttons are re-enabled on completion to avoid stuck disabled state
            complete: function(jqXHR, textStatus) {
                try {
                    // If a form element was provided in options, enable its submit buttons
                    if (options.form) {
                        $(options.form).find(':submit').prop('disabled', false);
                        $(options.form).find('.save-btn').prop('disabled', false);
                    }
                    // Generic fallback: re-enable any save-btn or disabled submit buttons on the page
                    $(':submit:disabled').prop('disabled', false);
                    $('.save-btn:disabled').prop('disabled', false);
                } catch (e) { console.warn('myAjax completion handler error', e); }
            },
            success: function(data) {
                if (data['reload'] != undefined) {
                    showAlert("Success", data.success, "success");
                    window.location.reload();
                    return false;
                }
                if (data['redirect'] != undefined) {
                    showAlert("Success", data.success, "success");
                    window.location.href = data['redirect'];
                    return false;
                }
                if (data['error'] !== undefined) {
                    var text = "<span style='color:red'>" + data['error'] + "</span>";
                    showAlert('Error', text, 'error');
                    return false;
                }
                if (data['errors'] !== undefined) {
                    multipleerrorshandle(data['errors'])
                    return false;
                }

                callback(data)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                ajaxErrorHandling(jqXHR, errorThrown);
            },

        });
    }





