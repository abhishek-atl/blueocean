<div class="modal fade" id="confirmExtendModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0">Confirm</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="booking_extension_duration" class="extend_select_duration_message"></label>
                        <select name="booking_extension_duration" id="booking_extension_duration" class="form-control">
                            <option value="0">Please select</option>
                            <option value="30">30 Mins</option>
                            <option value="60">60 Mins</option>
                        </select>
                        <span class="text-danger extend_validation_msg"></span>
                    </div>
                    <div class="col-md-12 mt-3">
                        <p class="extend_confirm_message"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary btnSubmitExtend">Yes</button>
                <input type="hidden" name="extend_booking_id" value="" />
            </div>
        </div>
    </div>
</div>
@push('pageScripts')
<script>
    // Extend functions
    $('.btn_extend').click(function (e) {
        e.preventDefault();
        var modal = $('#confirmExtendModal');
        let client = $('tr.selected td:nth-child(3)').text();
        let booking_id = $('tr.selected').attr('data-id');
        modal.find('.modal-body .extend_select_duration_message').html('How much do you want to EXTEND  ' + client + '\'s booking by?');
        modal.find('[name="extend_booking_id"]').val(booking_id);
        $('#confirmExtendModal').modal('show');
    })
    $('#booking_extension_duration').change(function () {
        var modal = $('#confirmExtendModal');
        let client = $('tr.selected td:nth-child(3)').text();
        let duration = $('#booking_extension_duration option:selected').val();
        if (duration != 0) {
            $('.extend_validation_msg').html('');
            modal.find('.modal-body .extend_confirm_message').html('Are you sure you want to extend ' + client + '\'s booking by  ' + duration + ' mins?');
        } else {
            modal.find('.modal-body .extend_confirm_message').html("");
        }
    });
    $('.btnSubmitExtend').click(function () {
        let booking_id = $('[name="extend_booking_id"]').val();
        let duration = $('#booking_extension_duration option:selected').val();
        if (!booking_id || duration == 0) {
            $('.extend_validation_msg').html('Please select a proper duration.');
            return false;
        }
        $('.loading').show();
        $('#confirmExtendModal').modal('hide');
        $.post("{{ route('extend') }}", {
            booking_id: booking_id,
            duration: duration
        }, function (booking) {
            if (booking.payment.payment_type == 'cash')
                toastr.success('Thank you, ' + booking.name + '\'s booking has been extended. Please check your new SMS for the updated price.');
            else
                toastr.success('Thank you. Please ask  ' + booking.name + ' to check his message(text and email) to pay for his extension. Once ' + booking.name + ' has paid, your will receive a SMS confirming.');
        }).always(function () {
            $('.loading').hide();
        });
    })
    // reset modal data states
    $('#confirmExtendModal').on('hidden.bs.modal', function (event) {
        var modal = $('#confirmExtendModal');
        modal.find('.modal-body .extend_select_duration_message').html('');
        modal.find('[name="extend_booking_id"]').val("");
        modal.find('.modal-body .extend_confirm_message').html("");
        $('.extend_validation_msg').html('');
        $('#booking_extension_duration').val(0);
        $('#booking_extension_duration').trigger('change');
    })
</script>
@endpush