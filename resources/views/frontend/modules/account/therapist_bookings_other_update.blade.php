<div class="modal fade" id="confirmOtherUpdateModal" tabindex="-1" aria-labelledby="confirmOtherUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0 p-0">Confirm</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="other_update" class="other_update">Please enter a short message describing what other update you would like to make to
                            this booking:</label>
                        <textarea name="other_update" id="other_update" class="form-control" maxlength="256" rows="5"></textarea>
                        (<span class="remaining_chars">256</span> characters remaining)
                        <div class="text-danger other_update_validation_msg"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btnSubmitOtherUpdate">Save</button>
                <input type="hidden" name="other_update_booking_id" value="" />
            </div>
        </div>
    </div>
</div>
@push('footerJs')
<script>
    // Other Updates
    $('.btn_other_update').click(function (e) {
        e.preventDefault();
        var modal = $('#confirmOtherUpdateModal');
        let booking_id = $('tr.selected').attr('data-id');
        modal.find('[name="other_update_booking_id"]').val(booking_id);
        $('#confirmOtherUpdateModal').modal('show');
    })
    $('#other_update').keyup(function () {
        let entered_chars = $('#other_update').val().length;
        let remaining_chars = 256 - entered_chars;
        $('.remaining_chars').text(remaining_chars);
    });
    $('#other_update').focus(function () {
        $('.other_update_validation_msg').html('');
    });
    $('.btnSubmitOtherUpdate').click(function () {
        let booking_id = $('[name="other_update_booking_id"]').val();
        let update = $('#other_update').val();
        if (!update || !booking_id) {
            $('.other_update_validation_msg').html('Please enter a valid update.');
            return false;
        }
        $('.loading').show();
        $('#confirmOtherUpdateModal').modal('hide');
        $.post("{{ route('booking_update') }}", {
            booking_id: booking_id,
            update: update
        }, function (response) {
            toastr.success('Your updated has been passed to office. Thank you.');
        }).always(function () {
            $('.loading').hide();
        });
    })
    // reset modal data
    $('#confirmOtherUpdateModal').on('hidden.bs.modal', function () {
        var modal = $('#confirmOtherUpdateModal');
        modal.find('[name="other_update_booking_id"]').val("");
        $('#other_update').val("");
        $('.other_update_validation_msg').html('');
        $('.remaining_chars').text(256);
    })
</script>
@endpush