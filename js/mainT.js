$(window).load(function(){
  $('.bullet-title.toggle').click(function(){
    var el = $(this).parent().find('.expand-collapse .fa');
    if ($(el).hasClass('fa-chevron-down')) {
      $(el).removeClass('fa-chevron-down');
      $(el).addClass('fa-chevron-up');
    } else {
      $(el).removeClass('fa-chevron-up');
      $(el).addClass('fa-chevron-down');
    }
    $(this).parent().find('.toggle-container').toggle('fast');
  });



  $('.new-bullet-btn').click(function(evt){
    evt.preventDefault();
    $('.main-container').hide();
    $('.form-container').show();
    $('.new-bullet-wrapper').hide();
  });

  $('.btn.main.cancel').click(function() {
    $('.form-container').hide();
    $('.main-container').show();
    $('.new-bullet-wrapper').show();
  });


  $('.btn.main.create').click(function() {

      var name = document.getElementById("bullet-name").value;

      var dataArray = {ID: ID_FB,
               nome: name};
      console.log(dataArray);

       $.ajax({
         type: "POST",
         url: "php2/addBullet.php", //includes full webserver url
         data: dataArray,  
         cache: false,

         success: function(msg){
             console.log(msg);
             location.reload();
       }
    });
       alert('Bullet adicionado com sucesso :)');
       location.reload();
       $('.form-container').hide();
       $('.main-container').show();
       $('.new-bullet-wrapper').show();

    
    
  });

  /*$('.tab-ul li').click(function() {
    $('.tab-ul li').removeClass('active');
    $(this).addClass('active');
    if($(this).hasClass('my-tasks-li')) {
      $('.bullet-container.shared-with-me').hide();
      $('.bullet-container.my-tasks').show();
    } else {
      $('.bullet-container.my-tasks').hide();
      $('.bullet-container.shared-with-me').show();
    }
  });
*/
});
