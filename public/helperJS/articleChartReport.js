$(document).ready(function() {

    //display article detail in modal
    $(document).on('click', '.view-detail-article', function() {
        var articleId = $(this).attr('attr-article-id');
        $.callAjax('post', '/admin/dashboard/get-article-detail', {id:articleId}, $('body'), function(response) {
            $.callModal('/admin/dashboard/modal-article-detail', 'modalArticleDetail', function() {
                var objResponse = JSON.parse(response);
                $('#article-summary').html(objResponse.data.post.summary);
                $('#article-content').html(objResponse.data.post.data);
                $('#article-header').html(objResponse.data.post.title);
            })
        })

    });
});
