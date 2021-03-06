function Article(){
  var totalCount = 1000;
}

Article.prototype.init = function (total) {
    var self = this;
    var test = self.totalCount;
    var lang = $('#articles').attr('data-lang');

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
                total: total ? total : self.totalCount,
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
            {data: 'action', name: 'action'},
            {data: 'select', name: 'select'}
        ],
        "columnDefs" : [{
            "targets" : 3 ,
            "data": "main_image",
            "render" : function ( url, type, full) {
                 return  '<img class="myImg" src="' + full.main_image + '" alt="" width="96" height="63">'
            }}, {
                'targets': 7,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="' + full["id"]+ '" value="' + $('<div/>').text(data).html() + '">';
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
        //"pageLength": 5,
        "lengthMenu": [[ 5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
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
        },
        // "oLanguage": {
        //     "sLengthMenu": "Display _MENU_ records per page",
        //     "sZeroRecords": "Nothing found - sorry",
        //     "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
        //     "sInfoEmpty": "Showing 0 to 0 of 0 records",
        //     "sInfoFiltered": "(filtered from _MAX_ total records)"
        // }
        "language": {
            "url": (lang == 'am') ? "//cdn.datatables.net/plug-ins/1.10.19/i18n/Armenian.json" : "//cdn.datatables.net/plug-ins/1.10.19/i18n/English.json"
        }
    });


};


Article.prototype.add = function ( title, description, main_image, data, url){

    var uploadedFile = $( '#main_image_file' )[0] && $( '#main_image_file' )[0].files[0];

    var fd = new FormData();
  //  fd.append('id', id);
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
                $('.modal-body').html(text);

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

    $(document).on('click', '.add_button', function (e) {
        var title = '';
        var description = '';
        var main_image =  'default.jpg';
        var url = '';
        var data = '';

        var text = self.dialog(title, description, main_image, data, url );
        $('.modal-body').html(text);
        $('.save').addClass('append');

    });

    $(document).on('click', '.edit', function (e) {

       var id = e.target.id;

        var title = '';
        var description = '';
        var main_image = ''
        var url = '';
        var data = '';

        self.edit(id, title, description , main_image, url, data  );
        $('.save').removeClass('append');
    });

    $(document).on('click', '#save_article', function(){
        if($('.save').hasClass('append')){
            self.add( $('#title').val(),$('#description').val(),$('#main_image').val(), $('#data').val(),$('#url').val()  );
            return;
        }
    });

    $(document).on('click', '#delete_all', this.deleteAll.bind(this));

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

             if ($(target).hasClass("delete") && $('.editform')[0]) {
                $( ".editform" ).remove();
            }


            $(document).on('click', '#save_article', function(){

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

                        return;
                    }
                }

            });
        }
    });

    $(document).on('click', '#search_btn', this.filterPosts.bind(this));
    $(document).on('click', '.total_count li a', this.changeTotalNumber.bind(this));

};

Article.prototype.deleteAll = function () {

    var selected = [];

    $('input:checkbox').each(function () {
        var sThisVal = this.checked ? $(this).attr('name') : "";
        if(sThisVal != ''){
            selected.push(sThisVal);
        }
    });


    var fd = new FormData();
    fd.append('data', JSON.stringify(selected));
    fd.append('_token', $('meta[name="_token"]').attr('content'));

    $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        url: 'destroyAll',
        success: function (data) {
            if(data.status == 'ok'){
                oTable.ajax.reload();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });


};

Article.prototype.changeTotalNumber = function (e) {
  var value = $(e.target).text();
    $('#articles').DataTable().clear().destroy();
    this.init(value);
    this.totalCount = value;
    $('#totalCount').text('(' + value + ')');
};

Article.prototype.filterPosts = function () {

    $('#articles').DataTable().clear().destroy();
    this.init();

};

function myFunction() {
    var value = $("#langs option:selected").attr('data-href');
    window.location.href = value;
}

$(document).ready(function() {
   var article = new Article();
   article.init();
   article.bindEvents();

});


