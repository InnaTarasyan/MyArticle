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

Article.prototype.dialog = function (title, description, main_image, data, url) {

    return ' <div class="editform">' +
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

};

Article.prototype.add = function (id, title, description, main_image, data, url){

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            title: title,
            description: description,
            main_image: main_image,
            data: data,
            url: url,
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
};

Article.prototype.edit = function(id, title, description, main_image, data, url){

    var self = this;

    $.ajax({
        type: 'Get',
        dataType: 'json',
        data: {
            id: id,
            "_token": $('#mytoken').val()
        },
        url: "articles/" + id + '/edit',
        success: function (res) {
            if(data.status = 'ok'){
                title = res.data.title;
                description = res.data.description;
                main_image = res.data.main_image;
                url = res.data.url;
                data = res.data.data;

                var text = self.dialog(title, description, main_image, data, url);
                $('.modal-body').append(text);

            }
        },
        error: function (res) {
            console.log(data);
        }
    });
};


Article.prototype.delete= function(id){
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

};


Article.prototype.update = function (id, title, description, main_image, data, url) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            title: title,
            description: description,
            main_image: main_image,
            data: data,
            url: url,
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
};

Article.prototype.bindEvents = function() {
    var self = this;
    $('#delModal').on('hidden.bs.modal', function(event) {
        $( ".editform" ).remove();
    });

    $('#delModal').on('show.bs.modal', function(e) {
        if(e.relatedTarget != undefined){
            var target = e.relatedTarget;
            var id = target.id;



            if($(target).hasClass("edit")  ){

                var title = '';
                var description = '';
                var main_image = ''
                var url = '';
                var data = '';

                self.edit(id, title, description , main_image, url, data  );

            } else if($(target).hasClass("add")) {

                var title = '';
                var description = '';
                var main_image = ''
                var url = '';
                var data = '';

                var text = self.dialog(title, description, main_image, data, url );
                $('.modal-body').append(text);


            }
            else if ($(target).hasClass("delete") && $('.editform')[0]) {
                $( ".editform" ).remove();
            }

            $(document).on('click', '.save', function(){
                if($(target).hasClass("delete")){
                    self.delete(id);

                } else if($(target).hasClass("edit")){
                    var new_title = $('#title').val();
                    var new_description = $('#description').val();
                    var new_main_image = $('#main_image').val();
                    var new_data = $('#data').val();
                    var new_url = $('#url').val();

                    self.update(id, new_title, new_description, new_main_image, new_data, new_url);


                }  else if($(target).hasClass("add")) {
                    self.add(id, $('#title').val(),$('#description').val(),$('#main_image').val(), $('#data').val(),$('#url').val()  );
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


