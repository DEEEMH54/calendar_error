<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Full Calendar js</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
</head>
<body>


<!-- Modal -->
<div class="modal fade" id="bookinModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
      <div class="col">
        <input type="text" name='title_booking' id="title" class="form-control" placeholder="اسم الدورة"><br><br>
        <span id="titleErorr" class="text-denger"></span>
       <!-- <input type="datetime-local" name='start_time_booking' id="start_date" class="form-control"  placeholder="start"> فيه بداله في سكربت -->
       <span id="startErorr" class="text-denger"></span>
       <br>
         <input type="number" name='room_booking' id="room" class="form-control" placeholder="room"><br>
         <span id="roomErorr" class="text-denger"></span>
         
      </div>
      <div class="col">
       <!--<input type="datetime-local" name='end_time_booking' id="end_date" class="form-control"   placeholder="end"> فيه بداله في سكربت --><br>
      </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='close' data-dismiss="modal">Close</button>
        <button type="button" id="save" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



        <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mt-5">FullCalendar js Laravel series with Career Development Lab</h3>
                <div class="col-md-11 offset-1 mt-5 mb-5">

                    <div id="calendar">

                    </div>

                </div>
            </div>
        </div>
    </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
   <script>
    $(document).ready(function () {
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        var booking=@json($event);
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
                },
               events:booking,
               selectable:true,
               selectHelper: true,
               select: function(start, end ,allDays) {
                $('#bookinModel').modal('toggle');
                $('#save').click(function(){
                    var title =$('#title').val();
                    var start_date =moment(start).format('YYYY-MM-DD');
                    var end_date =moment(end).format('YYYY-MM-DD');
                   
                    var room =$('#room').val();
                     
                    
                        $.ajax({
                             url:"{{ route('calendar.store') }}",
                            type:"POST",
                            dataType:'json',
                            data:{ title, start_date, end_date ,room },
                            success: function(response){
                              $('#bookinModel').modal('hide');
                             $('#calendar').fullCalendar('renderEvent',{
                              'title': response.title,
                              'start': response.start_date,
                               'end': response.end_date,
                               'room':response.room,
                               
                             })
                            },
                            error:function(error){
                                if(error.responseJSON.errors){
                                    $('#titleErorr').html(error.responseJSON.errors.title);
                                    $('#roomErorr').html(error.responseJSON.errors.room);
                                }

                            },
                           
                        });
                })
        
        
              },
        editable:true,
        eventDrop:function(event){
          var id =event.id;
          var start_date=moment(event.start).format('YYY-MM-DD');
          var end_date=moment(event.end).format('YYY-MM-DD');
          var title=event.title;
          var room =event.room;
             $.ajax({
                             url:"{{ route('calendar.update','') }}"+'/'+id,
                            type:"PUT",
                            dataType:'json',
                            data:{ start_date, end_date ,title,room},
                            success: function(response){
                             console.log(response);
                            },
                            error:function(error){
                               console.log(error);
                            },
                           
                        });

        }
      }
        )});
    </script>  
</body>
</html>