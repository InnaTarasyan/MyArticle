function Article(){

}

Article.prototype.init = function () {
    oTable = $('#articles').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url:  $('#myroute').val(),
            type: 'POST',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                // startDate: $("#datetimepicker6").find("input").val(),
                startDate: $("#datetimepicker6").find("input").val(),
                endDate: $("#datetimepicker7").find("input").val(),
                dataType: "JSON"
            },
        },
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
                 return  '<img class="myImg" src="' + full.main_image + '" alt="" width="96" height="63">'
            }},
            { "width": "2%", "targets": 0 },
            { "width": "20%", "targets": 1 },
            { "width": "30%", "targets": 2 },
            { "width": "10%", "targets": 3 },
            { "width": "8%", "targets": 4 },
            { "width": "10%", "targets": 5 }
            ],

        "fnCreatedRow": function (row, data, index) {
            var info = $(this).DataTable().page.info();
            $('td', row).eq(0).html(info.start + index + 1);
        },
        "pageLength": 5,
        "order": [[ 4, "desc" ]],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            $(nRow.cells[3].firstChild).on("click", function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            });

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    });


};

Article.prototype.dialog = function (title, description, main_image, data, url) {

    return ' <div class="editform">' +
        ' <div class="form-group editform">\n' +
        '    <label for="title">Title:</label>\n' +
        '    <textarea  class="form-control" id="title" rows="2" cols="2" >'+ title + '</textarea>\n' +
        '  </div>\n' +
        ' <div class="form-group editform">\n' +
        '    <label for="description">Description:</label>\n' +
        '    <textarea  class="form-control" id="description" rows="4" cols="4" >'+ description + '</textarea>\n' +
        '  </div>\n' +
        ' <div class="form-group editform row">\n' +
        ' <div class="col-md-6">'+
        '    <label for="main_image">Main Image:</label>\n' +
        '    <img  id="main_image" src="' + main_image + '" width="180" height="120" />\n' +
        ' </div>'+
        ' <input type="file" id ="main_image_file" name="main_image_file" class="col-md-6"></input>\n'+
        '  </div>\n' +
        ' <div class="form-group editform">\n' +
        '    <label for="data">Data:</label>\n' +
        '    <input  type="date" class="form-control" id="data" value='+ data +'>\n' +
        '  </div>\n' +
        ' <div class="form-group editform">\n' +
        '    <label for="url">Url:</label>\n' +
        '    <input  class="form-control" id="url" value='+ url +'>\n' +
        '  </div>\n' +
        ' </div>';

};

Article.prototype.add = function (id, title, description, main_image, data, url){

    var uploadedFile = $( '#main_image_file' )[0] && $( '#main_image_file' )[0].files[0];

    var fd = new FormData();
    fd.append('id', id);
    fd.append('file', uploadedFile);
    fd.append('title', title),
    fd.append('description', description);
    fd.append('data', data);
    fd.append('url', url);
    fd.append('_token', $('meta[name="_token"]').attr('content'));
    if(uploadedFile){
        fd.append('main_image', uploadedFile.name);
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: fd,
        url: "articles",
        processData: false,
        contentType: false,
        success: function (data) {
            if(data.status == 'ok'){
                oTable.ajax.reload();
                $('#delModal').modal('hide');
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
        },
        url: "articles/" + id + '/edit',
        beforeSend: function(xhr) {
            xhr.setRequestHeader("_token", $('meta[name="_token"]').attr('content'));
        },
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
            _token:  $('meta[name="_token"]').attr('content')
        },
        url: "articles/"+id,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("_token", $('meta[name="_token"]').attr('content'));
        },
        success: function (data) {
            if(data.status == 'ok'){
                oTable.ajax.reload();
                $('#delModal').modal('hide');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });

};


Article.prototype.update = function (id, title, description, data, url) {
    var uploadedFile = $( '#main_image_file' )[0] && $( '#main_image_file' )[0].files[0];

    var fd = new FormData();
    fd.append('file', uploadedFile);
    fd.append('id', id);
    fd.append('title', title);
    fd.append('description', description);
    fd.append('data', data);
    if(uploadedFile){
        fd.append('main_image', uploadedFile.name);
    }

    fd.append('url', url);
    fd.append('_method', 'PATCH');
    fd.append('_token', $('meta[name="_token"]').attr('content'));


    $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        url: "articles/"+id,
        success: function (data) {
            if(data.status == 'ok'){
                oTable.ajax.reload();
                $('#delModal').modal('hide');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
};

Article.prototype.bindEvents = function() {

    $(document).on('change', 'input[name=main_image_file]' , function(evt) {

        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#main_image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }

    });

    var self = this;
    $('#delModal').on('hidden.bs.modal', function(event) {
        $( ".editform" ).remove();
    });

    $('#delModal').on('show.bs.modal', function(e) {
        if(e.relatedTarget != undefined){
            var target = e.relatedTarget;
            var id = target.id;

            if($(target).hasClass("edit")  ){
               if($(target).hasClass("add")){
                   return;
               } else {
                   var title = '';
                   var description = '';
                   var main_image = ''
                   var url = '';
                   var data = '';

                   self.edit(id, title, description , main_image, url, data  );
               }

            } else if($(target).hasClass("add")) {

                if($(target).hasClass("edit")){
                    return;
                } else {
                    var title = '';
                    var description = '';
                    var main_image = $('#publicpath').val() + '/default.jpg';
                    var url = '';
                    var data = '';

                    var text = self.dialog(title, description, main_image, data, url );
                    $('.modal-body').append(text);
                }


            }
            else if ($(target).hasClass("delete") && $('.editform')[0]) {
                $( ".editform" ).remove();
            }

            $(document).on('click', '.save', function(){

                if($(target).hasClass("delete")){

                    if($(target).hasClass("add") || $(target).hasClass("edit") ){
                        return;
                    } else {
                        self.delete(id);
                        $(target).removeClass("delete");
                        return;
                    }


                } else if($(target).hasClass("edit")){

                    if($(target).hasClass("add") || $(target).hasClass("delete") ){
                        return;
                    } else {
                        var new_title = $('#title').val();
                        var new_description = $('#description').val();
                        //var new_main_image = $('#main_image')[0].src;
                        var new_data = $('#data').val();
                        var new_url = $('#url').val();

                        self.update(id, new_title, new_description, new_data, new_url);

                        $(target).removeClass("edit");
                        $('.add_button').addClass('add');
                        return;
                    }


                }  else if($(target).hasClass("add") || $(target).hasClass("delete") ) {

                    if($(target).hasClass("edit")){
                        return;
                    } else {
                        self.add(id, $('#title').val(),$('#description').val(),$('#main_image').val(), $('#data').val(),$('#url').val()  );
                        $(target).removeClass("add");

                        return;
                    }


                }


            });
        }
    });

    $(document).on('click', '#search_btn', this.filterPosts.bind(this));

};

Article.prototype.filterPosts = function () {

    $('#articles').DataTable().clear().destroy();
    this.init();

};


$(document).ready(function() {
   var article = new Article();
   article.init();
   article.bindEvents();
});


