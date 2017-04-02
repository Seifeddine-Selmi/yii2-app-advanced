<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;

$DragJS = <<<EOF
/* initialize the external events
-----------------------------------------------------------------*/

$('#external-events .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
    // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
    });
});

EOF;

$this->registerJs($DragJS);

?>
<div class="event-index">



    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">

        <?php

        $JSCode = <<<EOF
function(start, end) {

 console.log('JSCode event');

  var date = start.format();
      $.get(document.location.origin +'/event/create',{'date':date},function(data){
            $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });


}
EOF;

        $JSDropEvent = <<<EOF
function(date) {

      console.log('JSDrop event');
    alert("Dropped on " + date.format());
    if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
}
EOF;

        $JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {

console.log('JSEventClick  event');

      var event_id = calEvent.id;
      $.get(document.location.origin +'/event/update',{'id':event_id},function(data){
            $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });

    // change the border color just for fun
    $(this).css('border-color', 'red');

}

EOF;


        $JSDayClick = <<<EOF
    function(start,end) {
       console.log('JSDay event');


      var date = start.format();
          $.get(document.location.origin +'/event/create',{'date':date},function(data){
                $('#modal').modal('show')
                    .find('#modalContent')
                    .html(data);
            });

        }
EOF;

        $JSDayMouseover = <<<EOF
    function() {
       console.log('JSDayMouseover event');

        }
EOF;

        $JSDayMouseout = <<<EOF
    function() {
       console.log('JSDayMouseout event');


        }
EOF;

        ?>

        <div id="external-events" style="display: none">
            <h4>Draggable Events</h4>
            <?php foreach ($events AS $event){  ?>
                <div class="fc-event ui-draggable ui-draggable-handle"> <?php echo  $event->title;?></div>
            <?php  }  ?>


            <p>
                <input type="checkbox" id="drop-remove">
                <label for="drop-remove">remove after drop</label>
            </p>
        </div>


        <?php
        // Modal to create, update event

        Modal::begin([
            'header'=>'<h4>Event</h4>',
            'id' => 'modal',
            'size'=>'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
        ?>

        <?= yii2fullcalendar\yii2fullcalendar::widget(array(
           'events'=> $events,
            'options' => [
                'language' => 'en',
                //'eventLimit' => 2,
            ],
            'clientOptions' => [
                'selectable' => true,
                'selectHelper' => true,
              //  'droppable' => true,
                'editable' => true,
              //  'drop' => new JsExpression($JSDropEvent),
                'select' => new JsExpression($JSCode),
                'eventClick' => new JsExpression($JSEventClick),
              // 'dayClick'=>new JsExpression($JSDayClick),
             //   'eventMouseover' =>new JsExpression($JSDayMouseover),
             //   'eventMouseout' =>new JsExpression($JSDayMouseout),
               //  'defaultDate' => date('Y-m-d'),
               // 'theme'=>true,
              // 'fixedWeekCount' => false,
              // 'height' => 650,
              // 'language' => 'fa',
              // 'eventLimit' => true,

                //  'allDaySlot' => false,
                // 'defaultView' => 'agendaWeek',
               //'longPressDelay' => 2000,
               // 'firstDay' => date('w'),    // Sunday=0, Monday=1, Tuesday=2, etc.

              /*  'header' => [
                    'center'=>'prev,next today',
                    'left'=>'', //'title',
                    'right'=>'agendaDay,agendaWeek,month',
                ],*/
              /*  'businessHours' => [
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    'dow' => [ 0, 1, 2, 3, 4, 5, 6 ], // Sunday - Saturday
                   // 'start' => , //'5:00'
                   // 'end' => , // '18:00'
                ],*/
               // 'navLinks'=> true,
            ],
          // 'ajaxEvents' => Url::to(['/event/jsoncalendar']),

        ));
        ?>





    </div>
</div>

<?php
/* echo GridView::widget([
     'dataProvider' => $dataProvider,
     'filterModel' => $searchModel,
     'columns' => [
         ['class' => 'yii\grid\SerialColumn'],

         'id',
         'title',
         'description:ntext',
         'created_date',

         ['class' => 'yii\grid\ActionColumn'],
     ],
 ]);*/
?>