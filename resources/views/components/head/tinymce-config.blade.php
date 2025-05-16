<script src="https://cdn.tiny.cloud/1/ac5legsdxzxv4f1y8z6cr1iagnvif0hktwy2m4wcp5m15rtw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
{{--<script>--}}
{{--    tinymce.init({--}}
{{--        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE--}}
{{--        plugins: 'code table lists',--}}
{{--        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'--}}
{{--    });--}}
{{--</script>--}}
<script>
    $(document).ready(function() {
        // Initialize rich text editor for the body fields
        tinymce.init({
            selector: 'textarea.richTextBox',
            skin: 'voyager',
            min_height: 300,
            resize: 'vertical',
            plugins: 'link, image, code, table, textcolor, lists',
            extended_valid_elements : 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
            file_browser_callback: function(field_name, url, type, win) {
                if(type == 'image'){
                    $('#upload_file').trigger('click');
                }
            },
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code table',
        });
    });
</script>
