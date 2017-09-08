function Article(){

}

Article.prototype.init = function () {
    oTable = $('#articles').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $('#myroute').val(),
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'main_image', name: 'main_image'},
            {data: 'data', name: 'data'},
            {data: 'url', name: 'url'},
            {data: 'action', name: 'action'}
        ],
        "columnDefs" : [{
            "targets" : 3 ,
            "data": "main_image",
            "render" : function ( url, type, full) {
                return  '<img src="http://www.tert.am/news_images/826/2477835_1/8e32f749936471e696b1802b2d391fd7_3131.jpg" alt="" width="96" height="63">'
            }}],
        "pageLength": 5
    });

};

Article.prototype.bindEvents = function() {
    $('#delModal').on('hidden.bs.modal', function(event) {
        $( ".editform" ).remove();
    });

    $('#delModal').on('show.bs.modal', function(e) {
        if(e.relatedTarget != undefined){
            var target = e.relatedTarget;
            var id = target.id;


            if($(target).hasClass("edit") || $(target).hasClass("add") ){
                var title =  $(e.relatedTarget).data('article-title') || '';
                var description =  $(e.relatedTarget).data('article-description') || '';
                var main_image =  $(e.relatedTarget).data('article-main_image') || '';
                var data =  $(e.relatedTarget).data('article-data') || '';
                var url =  $(e.relatedTarget).data('article-url') || '';

                var text = ' <div class="editform">' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="title">Title:</label>\n' +
                    '    <input  class="form-control" id="title" value='+ title +'>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="description">Description:</label>\n' +
                    '    <textarea  class="form-control" id="description" rows="2" cols="2" >'+ description + '</textarea>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="main_image">Main Image:</label>\n' +
                    '    <input  class="form-control" id="main_image" value='+ main_image +'>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="data">Data:</label>\n' +
                    '    <input  class="form-control" id="data" value='+ data +'>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="url">Url:</label>\n' +
                    '    <input  class="form-control" id="url" value='+ url +'>\n' +
                    '  </div>\n' +
                    ' </div>';
                $('.modal-body').append(text);
            } else if ($(target).hasClass("delete") && $('.editform')[0]) {
                $( ".editform" ).remove();
            }

            $(document).on('click', '.save', function(){
                if($(target).hasClass("delete")){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            _method: 'DELETE',
                            "_token": $('#mytoken').val()
                        },
                        url: "articles/"+id,
                        success: function (data) {
                            if(data.status == 'ok'){
                                oTable.ajax.reload();
                                $('#delModal').modal('toggle');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                } else if($(target).hasClass("edit")){
                    var new_title = $('#title').val();
                    var new_description = $('#description').val();
                    var new_main_image = $('#main_image').val();
                    var new_data = $('#data').val();
                    var new_url = $('#url').val();


                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            title: new_title,
                            description: new_description,
                            main_image: new_main_image,
                            data: new_data,
                            url: new_url,
                            _method: 'PATCH',
                            "_token": $('#mytoken').val()
                        },
                        url: "articles/"+id,
                        success: function (data) {
                            if(data.status == 'ok'){
                                oTable.ajax.reload();
                                $('#delModal').modal('toggle');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                }  else if($(target).hasClass("add")) {

                    var new_title = $('#title').val();
                    var new_description = $('#description').val();
                    var new_main_image = $('#main_image').val();
                    var new_data = $('#data').val();
                    var new_url = $('#url').val();


                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            title: new_title,
                            description: new_description,
                            main_image: new_main_image,
                            data: new_data,
                            url: new_url,
                            "_token": $('#mytoken').val()
                        },
                        url: "articles",
                        success: function (data) {
                            if(data.status == 'ok'){
                                oTable.ajax.reload();
                                $('#delModal').modal('toggle');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
        }
    });

};

$(document).ready(function() {
   var article = new Article();
   article.init();
   article.bindEvents();
});


