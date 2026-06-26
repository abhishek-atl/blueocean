<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0">Confirm</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span class="cancel_confirm_msg"></span>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="cancel_reason">Please Choose Your Reason For Cancel</label>
                        <select name="cancel_reason" id="cancel_reason" class="form-control">
                            <option value="Client No Longer Available">Client No Longer Available</option>
                            <option value="Client Expected Massage Table">Client Expected Massage Table</option>
                            <option value="Client Sent Inappropriate Messages">Client Sent Inappropriate Messages</option>
                            <option value="Client Details Wrong">Client Details Wrong</option>
                            <option value="Client No Show"> Client No Show</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3 hide-elem cancel_other_reason_block">
                        <label for="cancel_other_reason">Please Enter Your Reason For Cancel</label>
                        <input type="text" name="cancel_other_reason" id="cancel_other_reason" value="" class="form-control">
                    </div>
                    <span class="text-danger cancel_validation_msg"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSubmitCancel">Yes</button>
                <input type="hidden" name="cancel_booking_id" value="" />
            </div>
        </div>
    </div>
</div>
@push('footerJs')
<script>
    // cancellation functions
    $('.btn_cancel').click(function (e) {
        e.preventDefault();
        var modal = $('#confirmCancelModal');
        let client = $('tr.selected td:nth-child(3)').text();
        let booking_id = $('tr.selected').attr('data-id');
        modal.find('.modal-body .cancel_confirm_msg').html('Are you sure you want to CANCEL ' + client + '\'s booking');
        modal.find('[name="cancel_booking_id"]').val(booking_id);
        $('#confirmCancelModal').modal('show');
    })
    $('#cancel_reason').change(function () {
        if ($('#cancel_reason option:selected').val() == 'Other') {
            $('.cancel_other_reason_block').removeClass('hide-elem')
        } else {
            $('.cancel_other_reason_block').addClass('hide-elem')
        }
    });
    $('.btnSubmitCancel').click(function () {

        let cancel_reason = $('#cancel_reason').val();
        if (cancel_reason == 'Other') {
            cancel_reason = $('#cancel_other_reason').val();
        }
        let booking_id = $('[name="cancel_booking_id"]').val();
        if (!booking_id || !cancel_reason) {
            $('.cancel_validation_msg').html('Please select a proper reason.');
            return false;
        }

        $('.loading').show();
        $('#confirmCancelModal').modal('hide');
        $.post("{{ route('cancel') }}", {
            booking_id: booking_id,
            cancel_reason: cancel_reason
        }, function (response) {
            let client = $('tr.selected td:nth-child(3)').text();
            $('tr.selected').trigger('click');
            $('tr.selected').css("background-color", "#fa9884");
            toastr.success('Your Request to cancel ' + client + '\' booking has been sent to the office. Please wait until you receive a cancellation text message to confirm. Thank you.');
        }).always(function () {
            $('.loading').hide();
        });
    })
    // reset modal data states
    $('#confirmLateModal').on('hidden.bs.modal', function (event) {
        var modal = $('#confirmLateModal');
        modal.find('.modal-body .cancel_confirm_msg').html('');
        modal.find('[name="cancel_booking_id"]').val("");
        $('.cancel_validation_msg').html('');
        $('#cancel_reason').val("Customer Request");
        $('#cancel_reason').trigger('change');
    })
</script>
@endpush