/*
Based on Monthly 2.1.0 by Kevin Thornbloom is licensed under a Creative Commons Attribution-ShareAlike 4.0 International License.
but without datepiker function.
change the method of back from event list view to month view. 
added day and week event detail view method.
and more...
*/ 
(function($) {
	$.fn.extend({
		monthly: function(options) {
			// These are overridden by options declared in footer
			//cal: jewish or gre(gregorian)
			//lang: he (hebrew) or en(english)
			var defaults = {
				cal:'gre',
				lang: 'en',
				caldate: false,
				weekStart: 'Sun',
				xmlUrl: '',
				jsonUrl: '',
				phpUrl: '',
				dataType: 'xml',
				listViewType: 'week',/*day,week,month*/
				maxWidth: false,
				setWidth: false
			}
			var options = $.extend(defaults, options), d;
			if(options.caldate != false){
				d = new Date(options.caldate);				
			}else{
				d = new Date();
			}
			//alert(d);
			var that = this,
				uniqueId = $(this).attr('id'),
				elmWidth = $('#'+uniqueId).width(),
				isRtl = (options.lang=='en')?'ltr':'rtl',
				currentMonth = d.getMonth() + 1,
				currentYear = d.getFullYear(),
				currentDay = d.getDate(),
				monthNames_en = options.monthNames || ["Jan", "Feb", "Mar", "Apr", "May", "June", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				fullMonthNames_en = options.monthNames || ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
				monthNames_he = options.monthNames || ["ינו'", "פבר'", "מרץ", "אפר'", "מאי", "יוני", "יולי", "אוג'", "ספט'", "אוק'", "נוב'", "דצמ'"],
				fullMonthNames_he = options.monthNames || ["ינואר", "פברואר", "מרץ", "אפריל", "מאי", "יוני", "יולי", "אוגוסט", "ספטמבר", "אוקטובר", "נובמבר", "דצמבר"],
				shortMonthNames = options.shortMonthNames || ["Ja", "Fe", "Mr", "Ap", "My", "Jn", "Jl", "Ag", "Sp", "Oc", "No", "De"], /*לא בשימוש כרגע*/
				dayNames_en = options.dayNames || ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
				fulldayNames_en = options.dayNames || ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
				dayNames_he = options.dayNames || ["א'","ב'","ג'","ד'","ה'","ו'","שבת"],
				fullDayNames_he = options.dayNames || ["ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת"],
				shortDayNames = options.shortDayNames || ["Su","Mo","Tu","We","Th","Fr","Sa"]; 
			//general
		
			//////////Cheke uniqueId///////////
			//for joomla - jewish calendar module
			var unq_id_chk = (uniqueId.indexOf('jewish_calander_cal_container_')!=-1)?true:false;
			var id_suffix;
			if(unq_id_chk){
				id_suffix =  uniqueId.split("_")[4];
			}else{
				id_suffix = uniqueId;
			}
			//alert("id_suffix="+id_suffix);
			///////////////////////////////////
			if (options.maxWidth != false){
				$('#'+uniqueId).css('maxWidth',options.maxWidth);
			}
			if (options.setWidth != false){
				$('#'+uniqueId).css('width',options.setWidth);
			}
			/////////////////////////////////////			
			//set week days namse for title
			if(options.lang=='en'){
				if (Number(elmWidth)<217){
					dayNames = shortDayNames;
				}else if(Number(elmWidth)>217 && Number(elmWidth)< 470){
					dayNames = dayNames_en;
				}else{
					dayNames = fulldayNames_en;
				}
			}else if(options.lang=='he'){
				if (Number(elmWidth)<217){
					dayNames = dayNames_he
				}else{
					dayNames = fullDayNames_he;
				}
			}
			// Add Day Of Week Titles
			if (options.weekStart == 'Sun') {
				$('#' + uniqueId).append('<div class="monthly-day-title-wrap" id="monthly-day-title-wrap_'+id_suffix+'" dir="'+isRtl+'"><div>'+dayNames[0]+'</div><div>'+dayNames[1]+'</div><div>'+dayNames[2]+'</div><div>'+dayNames[3]+'</div><div>'+dayNames[4]+'</div><div>'+dayNames[5]+'</div><div>'+dayNames[6]+'</div></div><div class="monthly-day-wrap" dir="'+isRtl+'"></div>');
			} else if (options.weekStart == 'Mon') {
				$('#' + uniqueId).append('<div class="monthly-day-title-wrap" id="monthly-day-title-wrap_'+id_suffix+'" dir="'+isRtl+'"><div>'+dayNames[1]+'</div><div>'+dayNames[2]+'</div><div>'+dayNames[3]+'</div><div>'+dayNames[4]+'</div><div>'+dayNames[5]+'</div><div>'+dayNames[6]+'</div><div>'+dayNames[0]+'</div></div><div class="monthly-day-wrap" dir="'+isRtl+'"></div>');
			} else {
				console.error('Monthly.js has an incorrect entry for the weekStart variable');
			}
			// Add Header & event list markup
			if(options.lang=='en'){
				$('#' + uniqueId).prepend('<div class="monthly-header" id="monthly-header_'+id_suffix+'"><div class="monthly-header-title"><a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'" onclick="return false"></a></div><a href="#" class="monthly-prev" title="Previous month"></a><a href="#" class="monthly-next" title="Next month"></a></div>').append('<div class="monthly-event-list" id="monthly-event-list_'+id_suffix+'"></div>');
			}else if(options.lang=='he'){
				$('#' + uniqueId).prepend('<div class="monthly-header" id="monthly-header_'+id_suffix+'"><div class="monthly-header-title"><a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'" onclick="return false"></a></div><a href="#" class="monthly-prev-rtl" title="חודש קודם"></a><a href="#" class="monthly-next-rtl" title="חודש הבא"></a></div>').append('<div class="monthly-event-list" id="monthly-event-list_'+id_suffix+'" dir="rtl"></div>');
			}			
			if(options.cal=='gre'){ ////////Gregorian calendar/////
				//set months names for title
				if(options.lang=='en'){
					if (Number(elmWidth)<250){
						monthNames = monthNames_en;
					}else{
						monthNames = fullMonthNames_en; 
					}
				}else if(options.lang=='he'){
					if (Number(elmWidth)<250){
						monthNames = monthNames_he; 
					}else{
						monthNames = fullMonthNames_he; 
					}
				}
				// How many days are in this month?
				function daysInMonth(m, y){
					return m===2?y&3||!(y%25)&&y&15?28:29:30+(m+(m>>3)&1);
				}			
				// Massive function to build the month
				function setMonthly_gre(m, y){
					//if the new month and year equal to current month and year
					//then remove "To day" button.
					if (m == currentMonth && y == currentYear){
						$('#'+uniqueId+' .monthly-reset').remove();
					}
					
					$('#' + uniqueId).data('setMonth', m).data('setYear', y);
					// Get number of days
					var dayQty = daysInMonth(m, y),
						// Get day of the week the first day is
						mZeroed = m -1,
						firstDay = new Date(y, mZeroed, 1, 0, 0, 0, 0).getDay();
					// Remove old days
					$('#' + uniqueId + ' .monthly-day, #' + uniqueId + ' .monthly-day-blank').remove();
					$('#'+uniqueId+' .monthly-event-list').empty();
					$('#'+uniqueId+' .monthly-day-wrap').empty();
					// Print out the days
					for(var i = 0; i < dayQty; i++) {
						var day = i + 1; // Fix 0 indexed days
						var dayNamenum = new Date(y, mZeroed, day, 0, 0, 0, 0).getDay();
						var shabat_suffix=isShabat(y,mZeroed,day)?'_isShabat':'';
						var week_num = weeksinMonth(y, m,day);
						$('#' + uniqueId + ' .monthly-day-wrap').append('<div class="m-d monthly-day monthly-day-event" id="monthly-day_'+id_suffix+shabat_suffix+'" data-number="'+day+'"><div class="monthly-day-number">'+day+'</div><div class="monthly-indicator-wrap"></div></div>');
						if(options.lang=="he"){
							$('#' + uniqueId + ' .monthly-event-list').append('<div class="monthly-list-item-rtl monthly-week-'+week_num+'" id="'+uniqueId+'day'+day+'" data-number="'+day+'"><div class="monthly-event-list-date-rtl">'+fullDayNames_he[dayNamenum]+'<br>'+day+'</div></div>');
						}else if(options.lang=="en"){
							$('#' + uniqueId + ' .monthly-event-list').append('<div class="monthly-list-item monthly-week-'+week_num+'" id="'+uniqueId+'day'+day+'" data-number="'+day+'"><div class="monthly-event-list-date">'+dayNames[dayNamenum]+'<br>'+day+'</div></div>');
						}
					}

					// Set Today
					var setMonth = $('#' + uniqueId).data('setMonth'),
						setYear = $('#' + uniqueId).data('setYear');
					if (setMonth == currentMonth && setYear == currentYear) {
						$('#' + uniqueId + ' *[data-number="'+currentDay+'"]').addClass('monthly-today');
					}

					// Reset button
					if (setMonth == currentMonth && setYear == currentYear) {
						$('#' + uniqueId + ' .monthly-header-title-date').html(monthNames[m - 1] +' '+ y);
					} else {
						if(options.lang=='en'){
							$('#' + uniqueId + ' .monthly-header-title').html('<a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'"  onclick="return false">'+monthNames[m - 1] +' '+ y +'</a><a href="#" class="monthly-reset" id="monthly-reset_'+id_suffix+'" title="Set to today">&crarr;</a> ');
						}else if(options.lang=='he'){
							$('#' + uniqueId + ' .monthly-header-title').html('<a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'"  onclick="return false">'+monthNames[m - 1] +' '+ y +'</a><a href="#" class="monthly-reset" id="monthly-reset_'+id_suffix+'" title="חזור לחודש הנוכחי">&crarr;</a> ');
						}
						
					}

					// Account for empty days at start
					if(options.weekStart == 'Sun' && firstDay != 7) {
						for(var i = 0; i < firstDay; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					} else if (options.weekStart == 'Mon' && firstDay == 0) {
						for(var i = 0; i < 6; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					} else if (options.weekStart == 'Mon' && firstDay != 1) {
						for(var i = 0; i < (firstDay - 1); i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					}

					//Account for empty days at end
					var numdays = $('#' + uniqueId + ' .monthly-day').length,
						numempty = $('#' + uniqueId + ' .monthly-day-blank').length,
						totaldays = numdays + numempty,
						roundup = Math.ceil(totaldays/7) * 7,
						daysdiff = roundup - totaldays;
					if(totaldays % 7 != 0) {
						for(var i = 0; i < daysdiff; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').append('<div class="m-d monthly-day-blank"  id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					}

					// Remove previous events
					// Add Events
					var addEvents = function(event) {
						// Year [0]   Month [1]   Day [2]
						if(options.dataType=='xml' || options.dataType=='json'){
							var fullstartDate = options.dataType == 'xml' ? $(event).find('startdate').text() : event.startdate,
								startArr = fullstartDate.split("-"),
								startYear = startArr[0],
								startMonth = parseInt(startArr[1], 10),
								startDay = parseInt(startArr[2], 10),
								fullendDate = options.dataType == 'xml' ? $(event).find('enddate').text() : event.enddate,
								endArr = fullendDate.split("-"),
								endYear = endArr[0],
								endMonth = parseInt(endArr[1], 10),
								endDay = parseInt(endArr[2], 10),
								eventURL = options.dataType == 'xml' ? $(event).find('url').text() : event.url,
								eventTitle = options.dataType == 'xml' ? $(event).find('name').text() : event.name,
								eventTtype = options.dataType == 'xml' ? $(event).find('type').text() : event.type,
								eventColor = options.dataType == 'xml' ? $(event).find('color').text() : event.color,
								eventId = options.dataType == 'xml' ? $(event).find('id').text() : event.id,
								startTime = options.dataType == 'xml' ? $(event).find('starttime').text() : event.starttime,
								startSplit = startTime.split(":"),
								endTime = options.dataType == 'xml' ? $(event).find('endtime').text() : event.endtime,
								endSplit = endTime.split(":"),
								eventLink = '',
								startPeriod = 'AM',
								endPeriod = 'PM';
						}else if(options.dataType=='php'){
							var fullstartDate = event.startdate,
								startArr = fullstartDate.split("-"),
								startYear = startArr[0],
								startMonth = parseInt(startArr[1], 10),
								startDay = parseInt(startArr[2], 10),
								fullendDate =  event.enddate,
								endArr = fullendDate.split("-"),
								endYear = endArr[0],
								endMonth = parseInt(endArr[1], 10),
								endDay = parseInt(endArr[2], 10),
								eventURL = event.url,
								eventTitle = event.name,
								eventTtype = event.type,
								eventColor = event.color,
								eventId = event.id,
								startTime = event.starttime,
								startSplit = startTime.split(":"),
								endTime = event.endtime,
								endSplit = endTime.split(":"),
								eventLink = '',
								startPeriod = 'AM',
								endPeriod = 'PM';							
						}
						/* Convert times to 12 hour & determine AM or PM */
						if(parseInt(startSplit[0]) >= 12) {
							var startTime = (startSplit[0] - 12)+':'+startSplit[1]+'';
							var startPeriod = 'PM'
						}

						if(parseInt(startTime) == 0) {
							var startTime = '12:'+startSplit[1]+'';
						}

						if(parseInt(endSplit[0]) >= 12) {
							var endTime = (endSplit[0] - 12)+':'+endSplit[1]+'';
							var endPeriod = 'PM'
						}
						if(parseInt(endTime) == 0) {
							var endTime = '12:'+endSplit[1]+'';
						}
						if (eventURL){
							var eventLink = 'href="'+eventURL+'"';
						}

						// function to print out list for multi day events
						function multidaylist(){
							var timeHtml = '';
							if (startTime){
								var startTimehtml = '<div><div class="monthly-list-time-start">'+startTime+' '+startPeriod+'</div>';
								var endTimehtml = '';
								if (endTime){
									var endTimehtml = '<div class="monthly-list-time-end">'+endTime+' '+endPeriod+'</div>';
								}
								var timeHtml = startTimehtml + endTimehtml + '</div>';
							}
							if(options.lang=='en'){
								$('#'+uniqueId+' .monthly-list-item[data-number="'+i+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}else if(options.lang=='he'){
								$('#'+uniqueId+' .monthly-list-item-rtl[data-number="'+i+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}
						}


						// If event is one day & within month
						if (!fullendDate && startMonth == setMonth && startYear == setYear) {
							// Add Indicators
							$('#'+uniqueId+' *[data-number="'+startDay+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
							// Print out event list for single day event
							var timeHtml = '';
							if (startTime){
								var startTimehtml = '<div><div class="monthly-list-time-start">'+startTime+' '+startPeriod+'</div>';
								var endTimehtml = '';
								if (endTime){
									var endTimehtml = '<div class="monthly-list-time-end">'+endTime+' '+endPeriod+'</div>';
								}
								var timeHtml = startTimehtml + endTimehtml + '</div>';
							}
							if(options.lang=='en'){
								$('#'+uniqueId+' .monthly-list-item[data-number="'+startDay+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}else if(options.lang=='he'){
								$('#'+uniqueId+' .monthly-list-item-rtl[data-number="'+startDay+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}


							// If event is multi day & within month
						} else if (startMonth == setMonth && startYear == setYear && endMonth == setMonth && endYear == setYear){
							for(var i = parseInt(startDay); i <= parseInt(endDay); i++) {
								// If first day, add title
								if (i == parseInt(startDay)) {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in prev month, and ends in current month
						} else if ((endMonth == setMonth && endYear == setYear) && ((startMonth < setMonth && startYear == setYear) || (startYear < setYear))) {
							for(var i = 0; i <= parseInt(endDay); i++) {
								// If first day, add title
								if (i==1){
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in this month, but ends in next
						} else if ((startMonth == setMonth && startYear == setYear) && ((endMonth > setMonth && endYear == setYear) || (endYear > setYear))){
							for(var i = parseInt(startDay); i <= dayQty; i++) {
								// If first day, add title
								if (i == parseInt(startDay)) {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in a prev month, ends in a future month
						} else if (((startMonth < setMonth && startYear == setYear) || (startYear < setYear)) && ((endMonth > setMonth && endYear == setYear) || (endYear > setYear))){
							for(var i = 0; i <= dayQty; i++) {
								// If first day, add title
								if (i == 1){
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

						}
					};

					//var eventsResource = (options.dataType == 'xml' ? options.xmlUrl : options.jsonUrl);
					switch (options.dataType){
						case('xml'):
							eventsResource = options.xmlUrl;
							break;
						case('json'):
							eventsResource = options.jsonUrl;
							break;
						case('php'):
							eventsResource = options.phpUrl;
							break;							
					}
					if(options.dataType=='xml' || options.dataType=='json'){
						$.get(''+eventsResource+'', {now: jQuery.now()}, function(d){
							if (options.dataType == 'xml') {
								$(d).find('event').each(function(index, event) {
									addEvents(event);
								});
							} else if (options.dataType == 'json') {
								$.each(d.monthly, function(index, event) {
									addEvents(event);
								});
							}
						}, options.dataType).fail(function() {
							console.error('Monthly.js failed to import '+eventsResource+'. Please check for the correct path & '+options.dataType+' syntax.');
						});
					}else if(options.dataType=='php'){
						//////////////////////joomla format//////////////////
						var request = {
							'option' : 'com_ajax',
							'module' : 'jewishcalendar',
							'data'   : m+'AND'+y, /*send here m (month)'AND' y(year)*/
							'method' :'getCreateJson',
							'format' : 'raw'
						};
						jQuery.ajax({
							type   : 'POST',
							data   : request,
							success: function (d) { /*d return events list in json format*/
								//alert(d);
								var obj = jQuery.parseJSON(d);//convert json strint to json object 
								$.each(obj.monthly, function(index, event) {
									addEvents(event);
								});									
							}
						});
					}
					var divs = $("#"+uniqueId+" .m-d");
					var j=1;
					for(var i = 0; i < divs.length; i+=7) {
					  divs.slice(i, i+7).wrapAll("<div class='monthly-week' data-week='"+j+"'></div>");
					  j++;
					}
					
				}
				// Set the calendar the first time
				setMonthly_gre(currentMonth, currentYear);
			}else if(options.cal=='jewish'){ ////Jewish calendar/////
				//Jwish date
				var currentJd = new Date(Number(currentYear),Number(currentMonth)-1,Number(currentDay));
				var jdateObject = new GregToHeb(currentJd);//d
				var jcurrentYear = jdateObject.y;
				var jcurrentMonth = jdateObject.m;
				var jcurrentDay = jdateObject.d;
				//alert(jcurrentDay+'-'+jcurrentMonth+'-'+jcurrentYear);
				// How many days are in this month?
				function daysInMonth(mnt, yir){
					var jdObj = HeMonthLen(yir, mnt);
					return jdObj;			
				}
				// Massive function to build the month
				function setMonthly_jewish(mnt, yir){
					//if the new month and year equal to current month and year
					//then remove "To day" button.
					if (mnt == jcurrentMonth && yir == jcurrentYear){
						$('#'+uniqueId+' .monthly-reset').remove();
					}
					$('#' + uniqueId).data('setMonth', mnt).data('setYear', yir);
					// Get number of days
					var dayQty = daysInMonth(mnt, yir),
						// Get day of the week the first day is
						mZeroed = mnt;// -1;
						var he2gre = HebToGreg(yir, mZeroed, 1);
						var jdObj = new GregToHeb(he2gre);
						var firstDay = jdObj.day;

					// Remove old days
					$('#' + uniqueId + ' .monthly-day, #' + uniqueId + ' .monthly-day-blank').remove();
					$('#'+uniqueId+' .monthly-event-list').empty();
					$('#'+uniqueId+' .monthly-day-wrap').empty();
					// Print out the days
					for(var i = 0; i < dayQty; i++) {

						var day = i + 1; // Fix 0 indexed days
						var he2gre_2 = HebToGreg(yir, mZeroed, day);
						var jdObj_2 = new GregToHeb(he2gre_2);
						var dayNamenum = jdObj_2.day;
						var week_num =  weeksinMonthJewish(yir, mnt,day);
						var shabat_suffix=isShabat(yir,mZeroed,day)?'_isShabat':'';
						if(options.lang=="he"){
							$('#' + uniqueId + ' .monthly-day-wrap').append('<div class="m-d monthly-day monthly-day-event" id="monthly-day_'+id_suffix+shabat_suffix+'" data-number="'+day+'"><div class="monthly-day-number">'+latin2hebrew.format(day)+'</div><div class="monthly-indicator-wrap"></div></div>');
							$('#' + uniqueId + ' .monthly-event-list').append('<div class="monthly-list-item-rtl monthly-week-'+week_num+'" id="'+uniqueId+'day'+day+'" data-number="'+day+'"><div class="monthly-event-list-date-rtl">'+fullDayNames_he[dayNamenum]+'<br>'+latin2hebrew.format(day)+'</div></div>');
						}else if(options.lang=="en"){
							$('#' + uniqueId + ' .monthly-day-wrap').append('<div class="m-d monthly-day monthly-day-event" id="monthly-day_'+id_suffix+shabat_suffix+'" data-number="'+day+'"><div class="monthly-day-number">'+day+'</div><div class="monthly-indicator-wrap"></div></div>');
							$('#' + uniqueId + ' .monthly-event-list').append('<div class="monthly-list-item monthly-week-'+week_num+'" id="'+uniqueId+'day'+day+'" data-number="'+day+'"><div class="monthly-event-list-date">'+dayNames[dayNamenum]+'<br>'+day+'</div></div>');
						}
					}

					// Set Today
					var setMonth = $('#' + uniqueId).data('setMonth'),
						setYear = $('#' + uniqueId).data('setYear');
					if (setMonth == jcurrentMonth && setYear == jcurrentYear) {
						$('#' + uniqueId + ' *[data-number="'+jcurrentDay+'"]').addClass('monthly-today');
					}

					// Reset button
					var enMonth,jYear, jMonth;
					if (setMonth == jcurrentMonth && setYear == jcurrentYear) {
						if(options.lang=='en'){
							enMonth = getJewishMonthName(mnt,yir,'en');//get en jewish month name
							$('#' + uniqueId + ' .monthly-header-title-date').html(enMonth +' '+ yir);
						}else if(options.lang=='he'){
							jYear = latin2hebrew.format(yir);
							jMonth = getJewishMonthName(mnt,yir,'he');
							$('#' + uniqueId + ' .monthly-header-title-date').html(jMonth +' ה'+ jYear);
						}
					} else {
						if(options.lang=='en'){
							enMonth = getJewishMonthName(mnt,yir,'en');
							$('#' + uniqueId + ' .monthly-header-title').html('<a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'" onclick="return false">'+enMonth +' '+ yir +'</a><a href="#" class="monthly-reset" id="monthly-reset_'+id_suffix+'" title="Set to today">&crarr;</a> ');
						}else if(options.lang=='he'){
							jYear = latin2hebrew.format(yir);
							jMonth = getJewishMonthName(mnt,yir,'he');					
							$('#' + uniqueId + ' .monthly-header-title').html('<a href="#" class="monthly-header-title-date" id="monthly-header-title-date_'+id_suffix+'" onclick="return false">'+jMonth +' ה'+ jYear +'</a><a href="#" class="monthly-reset" id="monthly-reset_'+id_suffix+'" title="חזור לחודש הנוכחי">&crarr;</a> ');
						}
						
					}

					// Account for empty days at start
					if(options.weekStart == 'Sun' && firstDay != 7) {
						for(var i = 0; i < firstDay; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					} else if (options.weekStart == 'Mon' && firstDay == 0) {
						for(var i = 0; i < 6; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					} else if (options.weekStart == 'Mon' && firstDay != 1) {
						for(var i = 0; i < (firstDay - 1); i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').prepend('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					}

					//Account for empty days at end
					var numdays = $('#' + uniqueId + ' .monthly-day').length,
						numempty = $('#' + uniqueId + ' .monthly-day-blank').length,
						totaldays = numdays + numempty,
						roundup = Math.ceil(totaldays/7) * 7,
						daysdiff = roundup - totaldays;
					if(totaldays % 7 != 0) {
						for(var i = 0; i < daysdiff; i++) {
							$('#' + uniqueId + ' .monthly-day-wrap').append('<div class="m-d monthly-day-blank" id="monthly-day-blank_'+id_suffix+'"><div class="monthly-day-number"></div></div>');
						}
					}

					// Remove previous events
					// Add Events
					var addEvents = function(event) {
						// Year [0]   Month [1]   Day [2]
						if(options.dataType=='xml' || options.dataType=='json'){
							var fullstartDate = options.dataType == 'xml' ? $(event).find('startdate').text() : event.startdate,
								startArr = fullstartDate.split("-"),
								startYear = startArr[0],
								startMonth = parseInt(startArr[1], 10),
								startDay = parseInt(startArr[2], 10),
								fullendDate = options.dataType == 'xml' ? $(event).find('enddate').text() : event.enddate,
								endArr = fullendDate.split("-"),
								endYear = endArr[0],
								endMonth = parseInt(endArr[1], 10),
								endDay = parseInt(endArr[2], 10),
								eventURL = options.dataType == 'xml' ? $(event).find('url').text() : event.url,
								eventTitle = options.dataType == 'xml' ? $(event).find('name').text() : event.name,
								eventTtype = options.dataType == 'xml' ? $(event).find('type').text() : event.type,
								eventColor = options.dataType == 'xml' ? $(event).find('color').text() : event.color,
								eventId = options.dataType == 'xml' ? $(event).find('id').text() : event.id,
								startTime = options.dataType == 'xml' ? $(event).find('starttime').text() : event.starttime,
								startSplit = startTime.split(":"),
								endTime = options.dataType == 'xml' ? $(event).find('endtime').text() : event.endtime,
								endSplit = endTime.split(":"),
								eventLink = '',
								startPeriod = 'AM',
								endPeriod = 'PM';
						}else if(options.dataType=='php'){
							var fullstartDate = event.startdate,
								startArr = fullstartDate.split("-"),
								startYear = startArr[0],
								startMonth = parseInt(startArr[1], 10),
								startDay = parseInt(startArr[2], 10),
								fullendDate =  event.enddate,
								endArr = fullendDate.split("-"),
								endYear = endArr[0],
								endMonth = parseInt(endArr[1], 10),
								endDay = parseInt(endArr[2], 10),
								eventURL = event.url,
								eventTitle = event.name,
								eventTtype = event.type,
								eventColor = event.color,
								eventId = event.id,
								startTime = event.starttime,
								startSplit = startTime.split(":"),
								endTime = event.endtime,
								endSplit = endTime.split(":"),
								eventLink = '',
								startPeriod = 'AM',
								endPeriod = 'PM';							
						}

						/* Convert times to 12 hour & determine AM or PM */
						if(parseInt(startSplit[0]) >= 12) {
							var startTime = (startSplit[0] - 12)+':'+startSplit[1]+'';
							var startPeriod = 'PM'
						}

						if(parseInt(startTime) == 0) {
							var startTime = '12:'+startSplit[1]+'';
						}

						if(parseInt(endSplit[0]) >= 12) {
							var endTime = (endSplit[0] - 12)+':'+endSplit[1]+'';
							var endPeriod = 'PM'
						}
						if(parseInt(endTime) == 0) {
							var endTime = '12:'+endSplit[1]+'';
						}
						if (eventURL){
							var eventLink = 'href="'+eventURL+'"';
						}

						// function to print out list for multi day events
						function multidaylist(){
							var timeHtml = '';
							if (startTime){
								var startTimehtml = '<div><div class="monthly-list-time-start">'+startTime+' '+startPeriod+'</div>';
								var endTimehtml = '';
								if (endTime){
									var endTimehtml = '<div class="monthly-list-time-end">'+endTime+' '+endPeriod+'</div>';
								}
								var timeHtml = startTimehtml + endTimehtml + '</div>';
							}
							if(options.lang=='en'){
								$('#'+uniqueId+' .monthly-list-item[data-number="'+i+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}else if(options.lang=='he'){
								$('#'+uniqueId+' .monthly-list-item-rtl[data-number="'+i+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}
						}
						/*//////////////////////////////need to convert /////////////
							startYear,startMonth,startDay => jewish
							endYear,endMonth,endDay => jewish
						
						var start_dobjc = new Date(Number(startYear), startMonth-1, startDay);
						var jdObj_start = new GregToHeb(start_dobjc);
						startYear = jdObj_start.y;
						startMonth = jdObj_start.m;
						startDay = jdObj_start.d;
						
						if(!fullendDate){
							var end_dobjc = new Date(Number(endYear), endMonth-1, endDay);
							var jdObj_end = new GregToHeb(end_dobjc);
							endYear = jdObj_end.y;
							endMonth = jdObj_end.m;
							endDay = jdObj_end.d;
						}*/
						// If event is one day & within month
						if (!fullendDate && startMonth == setMonth && startYear == setYear) {
							// Add Indicators
							$('#'+uniqueId+' *[data-number="'+startDay+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
							// Print out event list for single day event
							var timeHtml = '';
							if (startTime){
								var startTimehtml = '<div><div class="monthly-list-time-start">'+startTime+' '+startPeriod+'</div>';
								var endTimehtml = '';
								if (endTime){
									var endTimehtml = '<div class="monthly-list-time-end">'+endTime+' '+endPeriod+'</div>';
								}
								var timeHtml = startTimehtml + endTimehtml + '</div>';
							}
							if(options.lang=='en'){
								$('#'+uniqueId+' .monthly-list-item[data-number="'+startDay+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}else if(options.lang=='he'){
								$('#'+uniqueId+' .monthly-list-item-rtl[data-number="'+startDay+'"]').addClass('item-has-event').append('<a href="'+eventURL+'" class="listed-event" id="listed-event-'+eventTtype+'"  data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+' '+timeHtml+'</a>');
							}


							// If event is multi day & within month
						} else if (startMonth == setMonth && startYear == setYear && endMonth == setMonth && endYear == setYear){
							for(var i = parseInt(startDay); i <= parseInt(endDay); i++) {
								// If first day, add title
								if (i == parseInt(startDay)) {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in prev month, and ends in current month
						} else if ((endMonth == setMonth && endYear == setYear) && ((startMonth < setMonth && startYear == setYear) || (startYear < setYear))) {
							for(var i = 0; i <= parseInt(endDay); i++) {
								// If first day, add title
								if (i==1){
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in this month, but ends in next
						} else if ((startMonth == setMonth && startYear == setYear) && ((endMonth > setMonth && endYear == setYear) || (endYear > setYear))){
							for(var i = parseInt(startDay); i <= dayQty; i++) {
								// If first day, add title
								if (i == parseInt(startDay)) {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

							// If event is multi day, starts in a prev month, ends in a future month
						} else if (((startMonth < setMonth && startYear == setYear) || (startYear < setYear)) && ((endMonth > setMonth && endYear == setYear) || (endYear > setYear))){
							for(var i = 0; i <= dayQty; i++) {
								// If first day, add title
								if (i == 1){
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'">'+eventTitle+'</div>');
								} else {
									$('#'+uniqueId+' *[data-number="'+i+'"] .monthly-indicator-wrap').append('<div class="monthly-event-indicator" id="monthly-event-indicator-'+eventTtype+'" data-eventid="'+ eventId +'"  title="'+eventTitle+'"></div>');
								}
								multidaylist();
							}

						}
					};
					//var eventsResource = (options.dataType == 'xml' ? options.xmlUrl : options.jsonUrl);
					switch (options.dataType){
						case('xml'):
							eventsResource = options.xmlUrl;
							break;
						case('json'):
							eventsResource = options.jsonUrl;
							break;
						case('php'):
							eventsResource = options.phpUrl;
							break;							
					}
					if(options.dataType=='xml' || options.dataType=='json'){
						$.get(''+eventsResource+'', {now: jQuery.now()}, function(d){
							if (options.dataType == 'xml') {
								$(d).find('event').each(function(index, event) {
									addEvents(event);
								});
							} else if (options.dataType == 'json') {
								$.each(d.monthly, function(index, event) {
									addEvents(event);
								});
							}
						}, options.dataType).fail(function() {
							console.error('Monthly.js failed to import '+eventsResource+'. Please check for the correct path & '+options.dataType+' syntax.');
						});
					}else if(options.dataType=='php'){
						//////////////////////joomla format//////////////////
						var request = {
							'option' : 'com_ajax',
							'module' : 'jewishcalendar',
							'data'   : mnt+'AND'+yir, /*send here mnt (month)'AND' yir(year)*/
							'method' :'getCreateJson',
							'format' : 'raw'
						};
						jQuery.ajax({
							type   : 'POST',
							data   : request,
							success: function (d) { /*d return events list in json format*/
								//alert('month:'+mnt+'-'+yir+'\n'+d);
								var obj = jQuery.parseJSON(d);//convert json strint to json object 
								$.each(obj.monthly, function(index, event) {
									addEvents(event);
								});									
							}
						});
					}
					var divs = $("#"+uniqueId+" .m-d");
					var j=1;
					for(var i = 0; i < divs.length; i+=7) {
					  divs.slice(i, i+7).wrapAll("<div class='monthly-week' data-week='"+j+"'></div>");
					  j++;
					}
				}
				// Set the calendar the first time
				setMonthly_jewish(jcurrentMonth, jcurrentYear); //mnt , yir currentMonth, currentYear
				
				function getJewishMonthName(jm,jy,l){
					var jm_en = ["Tishrei","Cheshvan","Kislev","Tevet","Shevat","","Adar","Nisan","Iyar","Sivan","Tamuz","Av","Elul"];
					var jm_en_leap = ["Tishrei","Cheshvan","Kislev","Tevet","Shevat","Adar A","Adar B","Nisan","Iyar","Sivan","Tamuz","Av","Elul"];
					var jm_he = ["תשרי","חשוון","כסלו","טבת","שבט","","אדר","ניסן","אייר","סיוון","תמוז","אב","אלול"];
					var jm_he_leap = ["תשרי","חשוון","כסלו","טבת","שבט","אדר א'","אדר ב'","ניסן","אייר","סיוון","תמוז","אב","אלול"];
					var isleap = leapYear(jy);
					if(l=="en" && isleap){
						return jm_en_leap[Number(jm)-1];
					}else if(l=="en" && !isleap){
						return jm_en[Number(jm)-1];
					}else if(l=="he" && isleap){
						return jm_he_leap[Number(jm)-1];
					}else if(l=="he" && !isleap){
						return jm_he[Number(jm)-1];
					}
				}
				
			}

			// Advance months
			function leapYear(yH) {
				var c = yH%19;
				return (c==3||c==6||c==8||c==11||c==14||c==17||c==0);
			}
			//cheke if day is Shabat
			function isShabat(dY,dM,dD){
				var dayNum, dCal = options.cal;
				if(dCal=='gre'){
					dayNum = new Date(Number(dY), Number(dM), Number(dD)).getDay();
					if(dayNum==6){
						return true;
					}else{
						return false;
					}
				}else if(dCal=='jewish'){
					var je2gre = HebToGreg(Number(dY), Number(dM), Number(dD));
					var jeObj = new GregToHeb(je2gre);
					dayNum = jeObj.day;					
					if(dayNum==6){
						return true;
					}else{
						return false;
					}					
				}
			}
			function weeksinMonth(y,m,d){
				var date = new Date(y,m-1,d);
				var firstDay = new Date(y, m-1, 1).getDay();
				return Math.ceil((date.getDate() + firstDay)/7);  
			}
			function weeksinMonthJewish(jy,jm,jd){
				//the week day of the first day of the month
				var he2grefirstDay = HebToGreg(jy, jm, 1);
				var jedObjfirstDay = new GregToHeb(he2grefirstDay);
				var firstDay= jedObjfirstDay.day;
				//the date of input date (1-31)
				var he2gre = HebToGreg(jy, jm, jd);
				var jedObj = new GregToHeb(he2gre);
				var dayNamenum = jedObj.d;
				
				//date object // var date = new Date(y,m-1,d); 
				//x->get the week day of the first day of the month//var firstDay = new Date(y, m-1, 1).getDay();
				//y->the date of current date (1-31)
				//return z = Math.ceil((x+y)/7) // Math.ceil->round up
				//Math.ceil((2+21)/7=3.286)=4
				//Math.ceil((2+30)/7=4.57)=5
				return Math.ceil((dayNamenum + firstDay)/7);  
			}			
			function goNextMonth(clndr){ 
				var setMonth = $('#' + uniqueId).data('setMonth'),
					setYear = $('#' + uniqueId).data('setYear');
				if(clndr=='jewish'){
					var isLeap = leapYear(setYear);
					if (setMonth == 13) {
						var newMonth = 1,
							newYear = setYear + 1;
						setMonthly_jewish(newMonth, newYear);
					}else if(setMonth == 5 && !isLeap) { //skip adar1 in none leap year
						var newMonth = setMonth + 2,
							newYear = setYear;
						setMonthly_jewish(newMonth, newYear);
					}else{
						var newMonth = setMonth + 1,
							newYear = setYear;
						setMonthly_jewish(newMonth, newYear);				
					}					
				}else if(clndr=='gre'){
					if (setMonth == 12) {
						var newMonth = 1,
							newYear = setYear + 1;
						setMonthly_gre(newMonth, newYear);
					} else {
						var newMonth = setMonth + 1,
							newYear = setYear;
						setMonthly_gre(newMonth, newYear);
					}
				}
			}
			$(document.body).on('click', '#'+uniqueId+' .monthly-next', function (e) {
				goNextMonth(options.cal);
				e.preventDefault(options.cal);
			});		
			$(document.body).on('click', '#'+uniqueId+' .monthly-next-rtl', function (e) {
				goNextMonth(options.cal);
				e.preventDefault();
			});			
			// Go back in months
			function goBackMonth(clndr){
				var setMonth = $('#' + uniqueId).data('setMonth'),
					setYear = $('#' + uniqueId).data('setYear');
				if(clndr=='jewish'){	
					var isLeap = leapYear(setYear);
					if (setMonth == 1) {
						var newMonth = 13,
							newYear = setYear - 1;
						setMonthly_jewish(newMonth, newYear);
					}else if(setMonth == 7 && !isLeap){
						var newMonth = setMonth - 2,
							newYear = setYear;
						setMonthly_jewish(newMonth, newYear);				
					} else {
						var newMonth = setMonth - 1,
							newYear = setYear;
						setMonthly_jewish(newMonth, newYear);
					}
				}else if(clndr=='gre'){
					if (setMonth == 1) {
						var newMonth = 12,
							newYear = setYear - 1;
						setMonthly_gre(newMonth, newYear);
					} else {
						var newMonth = setMonth - 1,
							newYear = setYear;
						setMonthly_gre(newMonth, newYear);
					}
				}			
			}		
			$(document.body).on('click', '#'+uniqueId+' .monthly-prev', function (e) {
				goBackMonth(options.cal);
				e.preventDefault();
			});
			$(document.body).on('click', '#'+uniqueId+' .monthly-prev-rtl', function (e) {
				goBackMonth(options.cal);
				e.preventDefault();
			});
			// Reset Month
			$(document.body).on('click', '#'+uniqueId+' .monthly-reset', function (e) {
				$('#'+uniqueId+' .monthly-reset').remove();
				if(options.cal=='gre'){
					setMonthly_gre(currentMonth, currentYear);
				}else if(options.cal=='jewish'){
					setMonthly_jewish(jcurrentMonth, jcurrentYear);
				}
				//viewToggleButton();
				e.preventDefault();
				e.stopPropagation();
			});

			// Click A Day
			$(document.body).on('click', '#'+uniqueId+' a.monthly-day', function(e){
				e.preventDefault();
			});
			$(document.body).on('click','#'+uniqueId+' .monthly-event-indicator', function (e) { //
				// If events, show events list
				 if(options.listViewType == "month"){ //all month events
					//var test_this = $(this);
					var whichDay = $(this).parent().parent().data('number');//monthly-day
					var weekNum = $(this).parent().parent().parent().data('week');
					$('#' + uniqueId+' .monthly-event-list').show();
					$('#' + uniqueId+' .monthly-event-list').css('transform');
					$('#' + uniqueId+' .monthly-event-list').css('transform','scale(1)');
					if(options.lang=='en'){
						$('#' + uniqueId+' .monthly-list-item-rt[data-number="'+whichDay+'"]').show();
					}else if(options.lang=='he'){
						$('#' + uniqueId+' .monthly-list-item-rtl[data-number="'+whichDay+'"]').show();
					}
					var myElement = $('#' + uniqueId+'day'+whichDay);
					var topPos = myElement.offset().top;
					var eventListPos = $('#' + uniqueId+' .monthly-event-list').offset().top;
					$('#' + uniqueId+' .monthly-event-list').scrollTop(topPos-eventListPos);
					//viewToggleButton();
				}else if(options.listViewType == "week"){
					var weekNum = $(this).parent().parent().parent().data('week');
					$('#' + uniqueId+' .monthly-event-list').show();
					$('#' + uniqueId+' .monthly-event-list').css('transform');
					$('#' + uniqueId+' .monthly-event-list').css('transform','scale(1)');
					if(options.lang=='en'){
						$('#' + uniqueId+' .monthly-list-item').hide();
					}else if(options.lang=='he'){
						$('#' + uniqueId+' .monthly-list-item-rtl').hide();
					}
					$('.monthly-week-'+weekNum+'.item-has-event').show();				
				}else if(options.listViewType == "day"){
					var dir;
					if (window.getComputedStyle) { // all browsers
						dir = window.getComputedStyle(this, null).getPropertyValue('direction');
					} else {
						dir = this.currentStyle.direction; // IE5-8
					}
					//alert(dir);
					var whichDay = $(this).parent().parent().data('number');
					var this_day = $('#'+$(this).parent().parent().attr('id')+'[data-number="'+whichDay+'"]'+' .monthly-day-number');
					var this_day_html =this_day.html();
					var date = $('#monthly-header-title-date_'+id_suffix).html();
					var titl;
					if(options.lang=="en"){
						titl = this_day_html+' '+date;
					}else if(options.lang=="he"){
						titl = this_day_html+' ב'+date;
					}
					var serchId = $(this).parent().parent().parent().parent().parent().attr('id');
					var event_box = $('#' + uniqueId+'day'+whichDay).dialog({
						dialogClass: "montly_dialog_"+id_suffix,
						closeText: "hide",
						modal: true,
						autoOpen: false,
						resizable: false,
						title: titl,
						height: ($('#'+serchId).height()/2),
						width: ($('#'+serchId).width()/2),
						position:{
							my: "center",
							at: "center",
							of : $('#'+serchId)							
						},
						open: function(){
							 $('.ui-widget-overlay').bind('click',function(){
								 $('#' + uniqueId+'day'+whichDay).dialog('close');
							});
						}
					});
					//var dialogClass = event_box.dialog( "option", "dialogClass" );
					$('.montly_dialog_'+id_suffix+' .ui-dialog-title').attr("dir",dir);
					if($('.montly_dialog_'+id_suffix+' .listed-event').attr("href")==""){
						$('.montly_dialog_'+id_suffix+' .listed-event').attr("onclick","return false");
					}
					//$('.montly_dialog_'+id_suffix).css("overflow", "hidden");
					$('.montly_dialog_'+id_suffix+' .ui-dialog-title').css("text-align", "center");
					event_box.parent().draggable({ 
							containment: $('#'+serchId), 
							opacity: 0.70 
					});
					var $bc=$(this).css("background-color");
					var $tc=$(this).css("color");
					//alert(hexc($c));
					$('.montly_dialog_'+id_suffix+' .ui-dialog-title').css({
						"background-color": $bc,
						"color": $tc
						});
					$('.montly_dialog_'+id_suffix+' .monthly-list-item').css({
						"position": "relative",
						"padding": "10px 10px 5px 60px",
						"text-align": "left"
						});	
					$('.montly_dialog_'+id_suffix+' .monthly-list-item-rtl').css({
						"position": "relative",
						"padding": "10px 60px 5px 10px",
						"text-align": "right"
						});							
					$('.montly_dialog_'+id_suffix+' .monthly-event-list-date').css({
						"position": "absolute",
						"top": "13px",
						"left": "5px"
						});	
					$('.montly_dialog_'+id_suffix+' .monthly-event-list-date-rtl').css({
						"position": "absolute",
						"top": "13px",
						"right": "5px"
						});						
					$('.montly_dialog_'+id_suffix+' .listed-event').css({
						"background-color": $bc,
						"color": $tc
						});
					$('.montly_dialog_'+id_suffix+' .monthly-today').css({
						"color": "#ff0303"		
						});
					//$('.montly_dialog_'+id_suffix+' .ui-dialog-title').css("color", $tc);
					

					event_box.dialog("open");
				}
				e.preventDefault();

			});
			/*
			function hexc(colorval) {
				var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
				delete(parts[0]);
				for (var i = 1; i <= 3; ++i) {
					parts[i] = parseInt(parts[i]).toString(16);
					if (parts[i].length == 1) parts[i] = '0' + parts[i];
				}
				return '#' + parts.join('');
			}	*/		
				///////////////////////My Modify///////////////////////////////// 
			// hide monthly-event-list when click on it
			$('#' + uniqueId+' .monthly-event-list').on('click',function(){
				$('#' + uniqueId+' .monthly-event-list').css('transform','scale(0)');
				setTimeout(function(){
					$('#' + uniqueId+' .monthly-event-list').hide();
				}, 250);				
			});
		
			// Clicking an event within the list
			$(document.body).on('click', '#'+uniqueId+' .listed-event', function (e) {
				var href = $(this).attr('href');
				// If there isn't a link, don't go anywhere
				if(!href) {
					e.preventDefault();
				}
			});
		}
	});
})(jQuery);
