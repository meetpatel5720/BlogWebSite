tinymce.init({
    selector:'textarea',
    plugins: "link autolink image lists code codesample",
    toolbar: 'undo redo | styleselect formatselect fontselect fontsizeselect | bold italic underline removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample link image',
    codesample_languages: [
		{text: 'HTML/XML', value: 'markup'},
		{text: 'JavaScript', value: 'javascript'},
		{text: 'CSS', value: 'css'},
		{text: 'PHP', value: 'php'},
		{text: 'Ruby', value: 'ruby'},
		{text: 'Python', value: 'python'},
		{text: 'Java', value: 'java'},
		{text: 'C', value: 'c'},
		{text: 'C#', value: 'csharp'},
		{text: 'C++', value: 'cpp'}
	],

    // without images_upload_url set, Upload tab won't show up
    images_upload_url: 'includes/post_image_uploader.php',
    images_upload_base_path: '/BlogProject/',
    relative_urls : false,

    setup: function (editor) {
        editor.on('keydown change keypress', function (e) {

            document.getElementById('post_preview').innerHTML = editor.getContent();

//            this is to remove default width and height from image
            var images = document.querySelectorAll('.post-preview img');
            images.forEach(function myFunction(item, index) {
                console.log("..");
                images[index].removeAttribute("width");
                images[index].removeAttribute("height");
            });
        });
    },

    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'includes/post_image_uploader.php',true);

        xhr.onload = function() {
            var json;

            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            console.log(xhr.responseText);
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.location);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
});
