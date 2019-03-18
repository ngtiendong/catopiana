/**
 * Initial Tinymce
 */
tinymce.init({
    selector: '#post-data',
    relative_urls:false,
    remove_script_host:false,

    height: 500,
    entities_encode:'raw',

    plugins: [

        'advlist autolink lists link image charmap print preview hr anchor pagebreak',

        'searchreplace wordcount visualchars code fullscreen',

        'insertdatetime nonbreaking save table contextmenu directionality',

        'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'

    ],

    toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link anchor ',

    toolbar2: 'print preview | responsivefilemanager image | forecolor backcolor emoticons',

    //Configure to image
    // image_advtab: true,
    image_caption: true,
    image_dimensions: false,
    // content_style: 'img {width: 600px !important;} ',
    content_css: '/css/style.css',



    //Config template
    templates: [

        { title: 'Test template 1', content: 'Test 1' },

        { title: 'Test template 2', content: 'Test 2' }

    ],


    //Config filemanager
    external_filemanager_path:"/admin-lte/plugins/filemanager/",
    filemanager_title:"Responsive Filemanager" ,
    external_plugins: { "filemanager" : "/admin-lte/plugins/filemanager/plugin.min.js"},

});
