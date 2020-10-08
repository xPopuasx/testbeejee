$(function () {
    $(".modal-update").click(function (e) {
      var id_task =  $(this).parent().parent().find('.id-task').text();
      var user_name_task =  $(this).parent().parent().find('.user-name-task').text();
      var user_email_task =  $(this).parent().parent().find('.user-email-task').text();
      var text_task =  $(this).parent().parent().find('.text-task').text();


      $('#EditingModal').find('#id_task').html(id_task);
      $('#EditingModal').find('input[name="action"]').val('update_task');
      $('#EditingModal').find('input[name="id"]').val(id_task);
      $('#EditingModal').find('textarea[name="text_task"]').val(text_task);
      $('#EditingModal').find('input[name="user_name_task"]').val(user_name_task);
      $('#EditingModal').find('input[name="user_email_task"]').val(user_email_task);

      $('#EditingModal').find('input[type="submit"]').on('click', function(){
        if($('#EditingModal').find('textarea[name="text_task"]').val() == text_task)
        {
          alert('Задача не будет отредактирована ! Измените текст задачи');
          return false;
        }
      })
    })
})
