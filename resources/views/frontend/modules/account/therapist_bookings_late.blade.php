<div class="modal fade" id="confirmLateModal" tabindex="-1" aria-labelledby="confirmLateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0">Confirm</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span class="late_confirm_msg"></span>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="late_reason">Please Choose Your Reason For Late</label>
                        <select name="late_reason" id="late_reason" class="form-control">
                            <option value="Transport Delay">Transport Delay</option>
                            <option value="Customer Request">Customer Request</option>
                            <option value="Address Mismatch">Address Mismatch</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3 hide-elem late_other_reason_block">
                        <label for="late_other_reason">Please Enter Your Reason For Late</label>
                        <input type="text" name="late_other_reason" id="late_other_reason" value="" class="form-control">
                    </div>
                    <span class="text-danger late_validate_msg"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSubmitLate">Yes</button>
                <input type="hidden" name="late_booking_id" value="" />
            </div>
        </div>
    </div>
</div>

@push('footerJs')
<script>
    // Late functions
    $('.btn_late').click(function (e) {
        e.preventDefault();
        var modal = $('#confirmLateModal');
        let client = $('tr.selected td:nth-child(3)').text();
        let time = moment(datetime).format('HH:mm')
        let newtime = moment(datetime).add(30, 'minutes').format('HH:mm')
        let booking_id = $('tr.selected').attr('data-id');
        modal.find('.modal-body .late_confirm_msg').html('Are you sure you want to change ' + client + '\'s time from ' + time + ' to ' + newtime + '?');
        modal.find('[name="late_booking_id"]').val(booking_id);
        $('#confirmLateModal').modal('show');
    })
    $('#late_reason').change(function () {
        if ($('#late_reason option:selected').val() == 'Other') {
            $('.late_other_reason_block').removeClass('hide-elem')
        } else {
            $('.late_other_reason_block').addClass('hide-elem')
        }
    });
    $('.btnSubmitLate').click(function () {
        let late_reason = $('#late_reason').val();
        if (late_reason == 'Other') {
            late_reason = $('#late_other_reason').val();
        }
        let booking_id = $('[name="late_booking_id"]').val();
        if (!booking_id || !late_reason) {
            $('.late_validate_msg').html('Please select a proper late reason');
            return false;
        }

        $('.loading').show();
        $('#confirmLateModal').modal('hide');

        $.post("{{ route('late') }}", {
            booking_id: booking_id,
            late_reason: late_reason
        }, function (response) {
            let client = $('tr.selected td:nth-child(3)').text();
            $('tr.selected td:nth-child(2)').text(response)
            $('tr.selected').trigger('click');
            toastr.success(client + '\' booking has been made 30 minutes later and the office informed. Thank you.');
        }).always(function () {
            $('.loading').hide();
        });
    })
    // reset modal data states
    $('#confirmLateModal').on('hidden.bs.modal', function (event) {
        var modal = $('#confirmLateModal');
        modal.find('.modal-body .late_confirm_msg').html('');
        modal.find('[name="late_booking_id"]').val("");
        $('.late_validate_msg').html('');
        $('#late_reason').val("Transport Delay");
        $('#late_other_reason').val("");
        $('#late_reason').trigger('change');
    })
</script>
@endpush