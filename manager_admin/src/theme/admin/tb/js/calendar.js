// document ready function
// $(document).ready(function() { 	

// 	//------------- Full calendar  -------------//

// 	$(function () {
// 		var date = new Date();
// 		var d = date.getDate();
// 		var m = date.getMonth();
// 		var y = date.getFullYear();
		
// 		//front page calendar
// 		$('#calendar').fullCalendar({
// 			//isRTL: true,
// 			//theme: true,
// 			header: {
// 				left: 'title,today',
// 				center: 'prev,next',
// 				right: 'month,agendaWeek,agendaDay'
// 			},
// 			buttonText: {
// 	        	prev: '<span class="icon24 icomoon-icon-arrow-left-2"></span>',
// 	        	next: '<span class="icon24 icomoon-icon-arrow-right-2"></span>'
// 	    	},
// 			editable: true,
// 			events: [
// 				{
// 					title: 'All Day Event',
// 					start: new Date(y, m, 1)
// 				},
// 				{
// 					title: 'Long Event',
// 					start: new Date(y, m, d-5),
// 					end: new Date(y, m, d-2)
// 				},
// 				{
// 					id: 999,
// 					title: 'Repeating Event',
// 					start: new Date(y, m, d-3, 16, 0),
// 					allDay: false
// 				},
// 				{
// 					id: 999,
// 					title: 'Repeating Event',
// 					start: new Date(y, m, d+4, 16, 0),
// 					allDay: false
// 				},
// 				{
// 					title: 'Meeting',
// 					start: new Date(y, m, d, 10, 30),
// 					allDay: false
// 				},
// 				{
// 					title: 'Lunch',
// 					start: new Date(y, m, d, 12, 0),
// 					end: new Date(y, m, d, 14, 0),
// 					allDay: false,
// 					color: '#9FC569'
// 				},
// 				{
// 					title: 'Birthday Party',
// 					start: new Date(y, m, d+1, 19, 0),
// 					end: new Date(y, m, d+1, 22, 30),
// 					allDay: false,
// 					color: '#ED7A53'
// 				},
// 				{
// 					title: 'Click for Google',
// 					start: new Date(y, m, 28),
// 					end: new Date(y, m, 29),
// 					url: 'http://google.com/'
// 				}
// 			]
// 		});
// 	});

// 	/* initialize the external events
// 	-----------------------------------------------------------------*/
	
// 	$('#external-events div.external-event').each(function() {
	
// 		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
// 		// it doesn't need to have a start or end
// 		var eventObject = {
// 			title: $.trim($(this).text()) // use the element's text as the event title
// 		};
		
// 		// store the Event Object in the DOM element so we can get to it later
// 		$(this).data('eventObject', eventObject);
		
// 		// make the event draggable using jQuery UI
// 		$(this).draggable({
// 			zIndex: 999,
// 			revert: true,      // will cause the event to go back to its
// 			revertDuration: 0  //  original position after the drag
// 		});
		
// 	});


// 	/* initialize the calendar
// 	-----------------------------------------------------------------*/
	
// 	$('#calendar-events').fullCalendar({
// 		header: {
// 			left: 'title,today',
// 			center: 'prev,next',
// 			right: 'month,agendaWeek,agendaDay'
// 		},
// 		buttonText: {
//         	prev: '<span class="icon24 icomoon-icon-arrow-left-2"></span>',
//         	next: '<span class="icon24 icomoon-icon-arrow-right-2"></span>'
//     	},
// 		editable: true,
// 		droppable: true, // this allows things to be dropped onto the calendar !!!
// 		drop: function(date, allDay) { // this function is called when something is dropped
		
// 			// retrieve the dropped element's stored Event Object
// 			var originalEventObject = $(this).data('eventObject');
			
// 			// we need to copy it, so that multiple events don't have a reference to the same object
// 			var copiedEventObject = $.extend({}, originalEventObject);
			
// 			// assign it the date that was reported
// 			copiedEventObject.start = date;
// 			copiedEventObject.allDay = allDay;
			
// 			// render the event on the calendar
// 			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
// 			$('#calendar-events').fullCalendar('renderEvent', copiedEventObject, true);
// 			$(this).remove();
			
// 		}
// 	});

// 	//--------------- Tabs ------------------//

//     //activate calendar ot tab click
//     $('#myTab a[data-toggle="tab"]').on('shown', function (e) {
// 		$('#calendar').fullCalendar('render');
// 	})

// 	//Boostrap modal
// 	$('#myModal').modal({ show: false});
	
// 	//add event to modal after closed
// 	$('#myModal').on('hidden', function () {
// 	  	console.log('modal is closed');
// 	})

// });//End document ready functions

// //sparkline in sidebar area
// var positive = [1,5,3,7,8,6,10];
// var negative = [10,6,8,7,3,5,1]
// var negative1 = [7,6,8,7,6,5,4]

// $('#stat1').sparkline(positive,{
// 	height:15,
// 	spotRadius: 0,
// 	barColor: '#9FC569',
// 	type: 'bar'
// });
// $('#stat2').sparkline(negative,{
// 	height:15,
// 	spotRadius: 0,
// 	barColor: '#ED7A53',
// 	type: 'bar'
// });
// $('#stat3').sparkline(negative1,{
// 	height:15,
// 	spotRadius: 0,
// 	barColor: '#ED7A53',
// 	type: 'bar'
// });
// $('#stat4').sparkline(positive,{
// 	height:15,
// 	spotRadius: 0,
// 	barColor: '#9FC569',
// 	type: 'bar'
// });
// //sparkline in widget
// $('#stat5').sparkline(positive,{
// 	height:15,
// 	spotRadius: 0,
// 	barColor: '#9FC569',
// 	type: 'bar'
// });

// $('#stat6').sparkline(positive, { 
// 	width: 70,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
// 	height: 20,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
// 	lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
// 	fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
// 	spotColor: '#e72828',//The CSS colour of the final value marker. Set to false or an empty string to hide it
// 	maxSpotColor: '#005e20',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
// 	minSpotColor: '#f7941d',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
// 	spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
// 	lineWidth: 2//In pixels (default: 1) - Integer
// });


document.addEventListener('DOMContentLoaded', function() {
    //khoi tao bien
    let resEvent = [];
    let resTypeEvent = [];
    let calendarEl = null;
    let calendar = null;

    window.onload = function(){
        //
        $.ajax({
            url: 'http://api.local/index.php?req=typeevent',
            type: 'get',
            dataType: 'json',
            success: function(response){
               appendListTypeEvent(response)
               appendSelect(response)
            }
        });	
        
        $.ajax({
            url: 'http://api.local/index.php?req=event',
            type: 'get',
            dataType: 'json',
            success: (response)=>{
                formatData(response)
            }
        });
    };

    function appendSelect(datas){
        datas.forEach(data=>{
            $("#type_id").append(`
                <option value="${data.id}">${data.name_type}</option>
            `)
        })
    }

    function initResource(data){
        data.forEach(el=>{
            resTypeEvent.push( {id: el.code_type, color: el.code_color} )
        })
    }

    function appendListTypeEvent(data){
        data.forEach(el=>{
            $('.list-group').append(
                `<li class="list-group-item active">
                    <span class="label" style="background: ${el.code_color}"></span> 
                <span class="title">${el.name_type}</span>
              </li>`
            );
        })
    }

    function setColor(item){
        var currentTime = new Date(); 
        var startTime = new Date(item.start_time);
        var difference = startTime.getTime() - currentTime.getTime(); // This will give difference in milliseconds
        var resultInMinutes = Math.round(difference / 60000);
        
        if(resultInMinutes <=10 && resultInMinutes >= 0){
            item.code_color = "orange";
        }
    }

    function formatData(request = null){
        
       if(request){
            request.forEach(el=>{

                setColor(el)

                resEvent.push({
                    title: el.event_name,
                    start: el.start_time,
                    end: el.end_time,
                    color: el.code_color,
                    name_customer: el.name_customer,
                    phone_customer: el.phone_customer,
                    email_customer: el.email_customer,
                    number_adults: el.number_adults,
                    number_kid: el.number_kid,
                    type_id: el.type_id,
                    status: el.status
                })

            })
       }

        initCalendar(resEvent)
    }

    function initCalendar(data){
        calendarEl = document.getElementById('calendar');
        initThemeChooser({
            init: (slotDuration) => {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    eventClick: function(info) {
                        info.jsEvent.stopPropagation();

                        // $box = $('.box-event');
                        // $boxY = info.jsEvent.pageY - $box.height()-20;
                        // $boxX = info.jsEvent.pageX - ($box.width()/2);
                        // $box.css({
                        //     'top' : $boxY,
                        //     'left' : $boxX,
                        //     'background-color': info.event.borderColor
                        // })

                        // $box.html(`
                        //     <div class="box-main">
                        //         <h5 class="title"> ${info.event.title} </h5>
                        //         <div> ${info.event.extendedProps.name_customer} </div>
                        //         <div class="start-time"> ${formatDate(info.event.startStr)} </div>
                        //         <div class="end-time"> ${formatDate(info.event.endStr)} </div>
                        //     </div>
                        // `);
                        // $box.show()

                        var start = new Date(info.event.startStr).toISOString();
                        var end = new Date(info.event.endStr).toISOString();

                        showHideboxAddevent('show')
                        $('input[name="event_name"]').val(`${info.event.title}`);
                        $('input[name="start_time"]').val(`${start.substring(0,start.length-1)}`);
                        $('input[name="end_time"]').val(`${end.substring(0,end.length-1)}`);
                        $('input[name="name_customer"]').val(`${info.event.extendedProps.name_customer}`);
                        $('input[name="phone_customer"]').val(`${info.event.extendedProps.phone_customer}`);
                        $('input[name="email_customer"]').val(`${info.event.extendedProps.email_customer}`);
                        $('input[name="number_adult"]').val(`${info.event.extendedProps.number_adults}`);
                        $('input[name="number_kid"]').val(`${info.event.extendedProps.number_kid}`);
                        $('select[name="type_id"]').val(`${info.event.extendedProps.type_id}`);
                        $('select[name="status"]').val(`${info.event.extendedProps.status}`);
                        hidenShowBtnSubmit('hide')
                    },
                    headerToolbar: {
                        left: 'prev,next today addEventButton',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    customButtons: {
                        addEventButton: {
                          text: 'Add event',
                          click: function() {
                            $('.show-error').html('')
                            showHideboxAddevent('show')
                            hidenShowBtnSubmit('show')
                            addEventFullcalendar()
                            $('#formElem')[0].reset()
                          }
                        }
                    },
                    slotDuration: '00:30:00',

                    slotLabelInterval: 30,

                    slotMinutes: 30,
                    
                    events: data
                });
                calendar.render();
            },

            change: function(slotDuration) {
              console.log(slotDuration)
              calendar.setOption('slotDuration', slotDuration);
            }

        });
    }

    function addEventFullcalendar()
    {
        $("#formElem").submit (function(e){
            e.preventDefault();
            const data = new URLSearchParams();
            for (const pair of new FormData(document.querySelector("#formElem"))) {
                data.append(pair[0], pair[1]);
            }

            fetch('http://api.local/index.php?req=event&mode=regist', {
                method: 'post',
                body: data,
            })
            .then(response => response.json())
            .then(data => {
                if(data[0]=='true'){
                    alert('Thêm thành công');
                    location.reload()
                }else {
                    let str = "";
                    data.forEach(el=>{
                        str += `<p>${Object.keys(el)[0]}: ${Object.values(el)[0]} </p>`;
                    })
                    $('.show-error').html(str)
                }
            });
          });
    }
    
    function hidenShowBtnSubmit(btn){
        if(btn=='show'){
            $('input[name="submit"]').css('display','inline-block');
        }else {
            $('input[name="submit"]').css('display','none');
        }
    }

    function showHideboxAddevent(text){
        $addevent = $('.box-addevent');
        if(text=='show'){
            $addevent.animate( {left: "30%"}, 500 );
        }else {
            $left = $addevent.width();
            $addevent.animate( {left: -$left + "px"},500 );
        }
    }

    function formatDate(date){
        return new Date(date).toLocaleString();
    }

    $('.btn-close.btn-addevent').click(function(){
        showHideboxAddevent('close');
    })

    $('.box-event').click(function(e){
        e.stopPropagation();
        console.log(e)
    })

    $(function(){
        $(document).click(function() {
            $('.box-event').hide()
        });
    })

    $(function(){
        setTimeout(() => {
            $('.fc-dayGridMonth-button').click(function(){
                $("#theme-system-selector").css('display', 'none');
            })
            $('.fc-timeGridWeek-button').click(function(){
                $("#theme-system-selector").css('display', 'inline-block');
            })
            $('.fc-timeGridDay-button').click(function(){
                $("#theme-system-selector").css('display', 'inline-block');
            })
        }, 500);
    })
    
});
