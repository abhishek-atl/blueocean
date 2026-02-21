<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright text-center text-md-start">
                    <p class="text-sm">
                        Designed and Developed by
                        <a href="https://www.acetechnolabs.com" rel="nofollow" target="_blank">
                            Acetechnolabs Software Pvt Ltd
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('pageScripts')
<script>
    $(document).ready(function () {
        @if (Session:: has('status'))
            toastr.success("{{ Session::get('status') }}")
        @endif
    });
</script>
@endpush