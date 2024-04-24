'use strict';

export class Ajax
{
    constructor() {
    }

    call(url, data, successFunc, method, alwaysFunc) {
        method = method || 'POST';
        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(data)
        }).done(function(res) {
            if(typeof successFunc === 'function') {
                successFunc(res);
            } else if(res && res.data && res.data.message) {
                $.app.toast.success(res.data.message);
            }
        }).fail(function(res) {
            if(res && res.responseJSON && res.responseJSON.data && res.responseJSON.data.length === 1) {
                $.app.toast.fail(res.responseJSON.data[0].message);
            } else {
                $.app.toast.fail('Please contact with IT.');
            }
        }).always(function() {
            if(typeof alwaysFunc === 'function') {
                alwaysFunc();
            }
        });
    }
}
