require('./bootstrap');

const base_url=$("meta[name='base_url']").attr('content');

setTimeout(function(){
    $('.alert').slideUp();
},3000);

$(document).ready( function () {
    $('#myTable').DataTable();
} );


$(document).on('click','.delete-banner',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Banner');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});


$(document).on('click','.delete-brand',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Brand');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$(document).on('click','.delete-category',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Category');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});


$(document).on('click','.delete-user',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete User');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});

$(document).ready(function() {
    $('.description').summernote();
  });

  $(document).on('click','.delete-product',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Product');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});

$(document).on('click','.delete-image',function(e){

    e.preventDefault();

    let image_id=$(this).data('imageid');
    const elem=$(this);
    // console.log('base_url:',base_url);

    $.ajax({
        
        url:base_url+"/delete-image",
        type:"get",
        data:{
            image_id:image_id
        },
        success:function(response)
        {
            $(elem).parent().remove();
        }
    });

});

$(document).on('click','.delete-blog',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Blog');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});

$(document).on('click','.delete-promotion',function(e){

    e.preventDefault();
    let clicked=confirm('Are You Sure Want To Delete Promotion');

    if(clicked)
    {
        $(this).parent().find('form').submit();
    }
});