<script>
    function example_image_upload_handler(blobInfo, success, failure, progress) {

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        //here make your post to upload the file, heres an example with axios
        axios.post("/admin/upload", formData)
            .then((response) => {
                console.log(response);
                //response should have the path for the image uploaded
                //if everything is fine, call success() with the path for the image
                success(response.data.location); //or whatever your variable name
            });
    }

    $(document).ready(function () {

        let toolbars = 'undo redo | bold italic underline strikethrough |forecolor backcolor|fontselect fontsizeselect formatselect |';
        toolbars += ' link | visualblocks |alignleft aligncenter alignright alignjustify | bullist numlist  | removeformat';
        toolbars += ' | image | table |fullscreen | code preview | customInsertHr ';

        tinymce.init({
            content_style: "img { padding: 20px; }",
            selector: 'textarea.editor',
            height: 400,
            menubar: false,
            branding: false,
            browser_spellcheck: true,
            toolbar: toolbars,
            plugins: [
                'link preview wordcount lists', 'paste', 'image', 'fullscreen', 'table', 'visualblocks', 'code'
            ],
            images_upload_handler: example_image_upload_handler,
            image_description: true,
            image_title: true,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,

            paste_auto_cleanup_on_paste: true,
            paste_remove_styles: true,
            paste_remove_styles_if_webkit: true,
            paste_strip_class_attributes: true,

            setup: function (editor) {
                editor.ui.registry.addButton('customInsertHr', {
                    text: 'Separator',
                    onAction: function (_) {
                        editor.insertContent('<hr class="separator" />');
                    }
                });
                editor.on('keyUp', function () {
                    tinyMCE.triggerSave();

                    if (!$.isEmptyObject(myForm.validate().submitted))
                        myForm.validate().form();
                });
            },
        });
    });
</script>