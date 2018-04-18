var path_url = '/fit';
var base_url = window.location.origin + '/fit';

$(document).ready(function () {
    $('<div class="quantity-nav"><div class="quantity-button quantity-up"><span class="ui-icon ui-icon-triangle-1"></span></div><div class="quantity-button quantity-down"><span class="ui-icon ui-icon-triangle-2"></span></div></div>').insertAfter('.quantity input');
    $('.quantity').each(function() {
      var spinner = $(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
	$("input#flightAdult").on('change', function(){
	    // handle event
	   	$('.show-on-adult').hide();
	    $('.show-on-child').hide();
	    $('.show-on-infant').hide();
	    var val = parseInt($(this).val());
	    var valChild = parseInt($('input#flightChild').val());
		var valInfant = parseInt($('input#flightInfant').val());
	    if(eval(val + valChild) > 7) {
	    	$('.hidden-arrow').show();//.fadeOut(3000);
	    	$('.show-on-adult').show();
	    	$('.spoil_c4').html('Max 7 person');
	    	//$('#search_submit_flight').attr('disabled', true).css('color', '#cccccc');
	    	$(this).val($(this).data('val'));
	    } else if (eval(val) < eval(valInfant)) {
	    	$('.hidden-arrow').show();//.fadeOut(3000);
	    	$('.show-on-adult').show();
	    	$('.spoil_c4').html('Adult amount should be matched with infant');
	    	//$('#search_submit_flight').attr('disabled', true).css('color', '#cccccc');
	    	$(this).val($(this).data('val'));
	    } else {
	    	$('.hidden-arrow').hide();
	    	$('.show-on-adult').hide();
	    	$('.spoil_c4').html('');
	    	//$('#search_submit_flight').removeAttr('disabled').css('color', '#ffffff');
	    	$(this).data('val', val);
	    }
	});
	$("input#flightChild").on('change', function(){
	    // handle event
	    $('.show-on-adult').hide();
	    $('.show-on-child').hide();
	    $('.show-on-infant').hide();

	    var val = parseInt($(this).val());
	    var valAdult = parseInt($('input#flightAdult').val());

	    if(eval(val + valAdult) > 7) {
	    	$('.hidden-arrow').show();//.fadeOut(3000);
	    	$('.show-on-child').show();
	    	$('.spoil_c4').html('Max 7 person');
	    	//$('#search_submit_flight').attr('disabled', true).css('color', '#cccccc');
	    	$(this).val($(this).data('val'));
	    } else {
	    	$('.hidden-arrow').hide();
	    	$('.show-on-child').hide();
	    	$('.spoil_c4').html('');
	    	//$('#search_submit_flight').removeAttr('disabled').css('color', '#ffffff');
	    	$(this).data('val', val);
	    }
	});
	$("input#flightInfant").on('change', function(){
	    // handle event
	   	$('.show-on-adult').hide();
	    $('.show-on-child').hide();
	    $('.show-on-infant').hide();
	    var val = parseInt($(this).val());
	    var valAdult = parseInt($('input#flightAdult').val());

	    if(val > valAdult || val > 4) {
	    	$('.hidden-arrow').show();//.fadeOut(3000);
	    	$('.show-on-infant').show();
	    	$('.spoil_c4').html('The Infant amount max is 4 and can\'t go higher than adult amount');
	    	//$('#search_submit_flight').attr('disabled', true).css('color', '#cccccc');
	    	$(this).val($(this).data('val'));
	    } else {
	    	$('.hidden-arrow').hide();
	    	$('.show-on-infant').hide();
	    	$('.spoil_c4').html('');
	    	//$('#search_submit_flight').removeAttr('disabled').css('color', '#ffffff');
	    	$(this).data('val', val);
	    }
	});

	//UI FORM ELEMENTS


	var spinner = $('.spinner input').spinner({ min: 0 });

	localToday = new Date();
	localToday.setDate(localToday.getDate()+7);

	localToday2 = new Date();
	localToday2.setDate(localToday2.getDate()+8);

	localTodayHotel = new Date();
	localTodayHotel.setDate(localTodayHotel.getDate()+5);

	localTodayHotel2 = new Date();
	localTodayHotel2.setDate(localTodayHotel2.getDate()+6);

	$('#datepickerFlightCheckIn').datepicker({
		localToday: localToday,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 7,
		onSelect: function(dateText, inst) {
			$('.ui-state-default').removeClass('ui-state-default');
	        var date      = new Date($(this).val());
			var next_date = new Date(date.setDate(date.getDate() + 1));
			formatNextDate = next_date.getUTCFullYear() + '-' + ('00' + (next_date.getUTCMonth()+1)).slice(-2) + '-' + ('00' + next_date.getUTCDate()).slice(-2);
			$("#datepickerFlightCheckOut").val(formatNextDate);

			sessionStorage.setItem('datepickerFlightCheckIn', $(this).val());
      		sessionStorage.setItem('datepickerFlightCheckOut', $('#datepickerFlightCheckOut').val());

	    }
	});

	$('#datepickerFlightCheckOut').datepicker({
		localToday: localToday2,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 8,
		onSelect: function(dateText, inst) {
			sessionStorage.setItem('datepickerFlightCheckOut', $(this).val());
		}
	});

	$('#datepickerHotelCheckIn').datepicker({
		localToday: localTodayHotel,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 5,
		onSelect: function(dateText, inst) {
	        var date      = new Date($(this).val());
			var next_date = new Date(date.setDate(date.getDate() + 1));
			formatNextDate = next_date.getUTCFullYear() + '-' + ('00' + (next_date.getUTCMonth()+1)).slice(-2) + '-' + ('00' + next_date.getUTCDate()).slice(-2);
			$("#datepickerHotelCheckOut").val(formatNextDate);
	    }
	});

	$('#datepickerHotelCheckOut').datepicker({
		localToday: localTodayHotel2,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 6
	});

	$('#datepickerLandtourCheckIn').datepicker({
		localToday: localToday,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 7,
		onSelect: function(dateText, inst) {
	        date      = new Date($(this).val());
			next_date = new Date(date.setDate(date.getDate() + 1));
			formatNextDate = next_date.getUTCFullYear() + '-' + ('00' + (next_date.getUTCMonth()+1)).slice(-2) + '-' + ('00' + next_date.getUTCDate()).slice(-2);
			$("#datepickerLandtourCheckOut").val(formatNextDate);
	    }
	});

	$('#datepickerLandtourCheckOut').datepicker({
		localToday: localToday2,
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 7
	});

	$('.datepicker-wrap input').datepicker({
		showOn: 'button',
		buttonImage: base_url+'/assets/images/ico/calendar.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		minDate: 0
	});

	$( '#slider' ).slider({
		range: "min",
		value:1,
		min: 0,
		max: 10,
		step: 1
	});

	//CUSTOM FORM ELEMENTS
	$('input[type=radio],select, input[type=checkbox]').uniform();

	//SCROLL TO TOP BUTTON
	$('.scroll-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	//HEADER RIBBON NAVIGATION
	$('.ribbon li').hide();
	$('.ribbon li.active').show();
	$('.ribbon li a').click(function() {
		$('.ribbon li').hide();
		if ($(this).parent().parent().hasClass('open'))
			$(this).parent().parent().removeClass('open');
		else {
			$('.ribbon ul').removeClass('open');
			$(this).parent().parent().addClass('open');
		}
		$(this).parent().siblings().each(function() {
			$(this).removeClass('active');
		});
		$(this).parent().attr('class', 'active');
		$('.ribbon li.active').show();
		$('.ribbon ul.open li').show();
		return true;
	});

	//LIGHTBOX
	$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square'});

	//TABS
	$('.tab-content').hide().first().show();
    $('.inner-nav li:first').addClass("active");

    $('.inner-nav a').on('click', function (e) {
        e.preventDefault();
        $(this).closest('li').addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.tab-content').hide();
		var currentTab = $(this).attr("href");
		if (currentTab == "#location")
		initialize();
    });

    var hash = $.trim( window.location.hash );
    if (hash) $('.inner-nav a[href$="'+hash+'"]').trigger('click');

	//CSS
	$('.top-right-nav li:last-child,.social li:last-child,.twins .f-item:last-child,.ribbon li:last-child,.room-types li:last-child,.three-col li:nth-child(3n),.reviews li:last-child,.three-fourth .deals .one-fourth:nth-child(3n),.full .deals .one-fourth:nth-child(4n),.locations .one-fourth:nth-child(3n),.pager span:last-child,.get_inspired li:nth-child(5n)').addClass('last');
	$('.bottom nav li:first-child,.pager span:first-child').addClass('first');

	//ROOM TYPES MORE BUTTON
	/*
	$('.more-information').slideUp();
	$('.more-info').click(function() {
		var moreinformation = $(this).closest('li').find('.more-information');
		var txt = moreinformation.is(':visible') ? '+ more info' : ' - less info';
		$(this).text(txt);
		moreinformation.stop(true, true).slideToggle('slow');
	});
	*/

	//MAIN SEARCH
	/*
	$('.main-search #search_selection').change(function() {
		var showForm = $(this).val();
		$('.form').hide();
		$("#"+showForm).show();
	});
	*/

	$('.form').hide();
	$('.form:first').show();
	$('.f-item:first').addClass("active");
	$('.f-item:first span').addClass("checked");

	$('.f-item .radio').click(function() {
		$('.f-item').removeClass("active");
		$(this).parent().addClass("active");
	});

	// LIST AND GRID VIEW TOGGLE
	$('.view-type li:first-child').addClass('active');

	$('.grid-view').click(function() {
		$('.three-fourth article').attr("class", "one-fourth");
		$('.three-fourth article:nth-child(3n)').addClass("last");
		$('.view-type li').removeClass("active");
		$(this).addClass("active");
	});

	$('.list-view').click(function() {
		$('.three-fourth article').attr("class", "full-width");
		$('.view-type li').removeClass("active");
		$(this).addClass("active");
	});

	//LOGIN & REGISTER LIGHTBOX
	$('.close').click(function() {
		$('.lightbox').hide();
		$('.lightbox-booking').hide();
	});
	$('#login_modal').click(function() {
		$('#lightbox_login').show();
	});
	$('a#checkoutLoginModal').click(function() {
		$('#lightbox_login').show();
	});
	$('#signup_modal').click(function() {
		$('#lightbox_signup').show();
	});
	$('#fp_modal').click(function() {
		$('#lightbox_fp').show();
		$('#lightbox_login').hide();
	});

	//MY ACCOUNT EDIT FIELDS
	$('.edit_field').hide();
    $('.edit').on('click', function (e) {
        e.preventDefault();
        $($(this).attr('href')).toggle('slow', function(){});
    });
	$('.edit_field a,.edit_field input[type=submit]').click(function() {
		$('.edit_field').hide(400);
	});

	//HOTEL PAGE GALLERY
	$('.gallery img:first-child').css('opacity',1);

	var i=0,p=1,q=function(){return document.querySelectorAll(".gallery>img")};

	function s(e){
	for(c=0;c<q().length;c++){q()[c].style.opacity="0";q()[e].style.opacity="1"}
	}

	setInterval(function(){
	if(p){i=(i>q().length-2)?0:i+1;s(i)}
	},5000);

	/*--EXTRA CODE--*/
	// courtesy of http://stackoverflow.com/a/7613795/648350
    $.datepicker._gotoToday = function(id) {
        var target = $(id);
        var inst = this._getInst(target[0]);
        if (this._get(inst, 'gotoCurrent') && inst.currentDay) {
                inst.selectedDay = inst.currentDay;
                inst.drawMonth = inst.selectedMonth = inst.currentMonth;
                inst.drawYear = inst.selectedYear = inst.currentYear;
        }
        else {
                var date = inst.settings.localToday || new Date(); // CHANGED. use new option, or use new Date
                inst.selectedDay = date.getDate();
                inst.drawMonth = inst.selectedMonth = date.getMonth();
                inst.drawYear = inst.selectedYear = date.getFullYear();
                this._setDateDatepicker(target, date);
                this._selectDate(id, this._getDateDatepicker(target));
        }
        this._notifyChange(inst);
        this._adjustDate(target);
    }

    // from jqueryui 1.11.0 source
    $.datepicker._generateHTML = function(inst) {
		var maxDraw, prevText, prev, nextText, next, currentText, gotoDate,
			controls, buttonPanel, firstDay, showWeek, dayNames, dayNamesMin,
			monthNames, monthNamesShort, beforeShowDay, showOtherMonths,
			selectOtherMonths, defaultDate, html, dow, row, group, col, selectedDate,
			cornerClass, calender, thead, day, daysInMonth, leadDays, curRows, numRows,
			printDate, dRow, tbody, daySettings, otherMonth, unselectable,
			tempDate = inst.settings.localToday || new Date(), // CHANGED. use new option, or use new Date
			today = this._daylightSavingAdjust(
				new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate())), // clear time
			isRTL = this._get(inst, "isRTL"),
			showButtonPanel = this._get(inst, "showButtonPanel"),
			hideIfNoPrevNext = this._get(inst, "hideIfNoPrevNext"),
			navigationAsDateFormat = this._get(inst, "navigationAsDateFormat"),
			numMonths = this._getNumberOfMonths(inst),
			showCurrentAtPos = this._get(inst, "showCurrentAtPos"),
			stepMonths = this._get(inst, "stepMonths"),
			isMultiMonth = (numMonths[0] !== 1 || numMonths[1] !== 1),
			currentDate = this._daylightSavingAdjust((!inst.currentDay ? new Date(9999, 9, 9) :
				new Date(inst.currentYear, inst.currentMonth, inst.currentDay))),
			minDate = this._getMinMaxDate(inst, "min"),
			maxDate = this._getMinMaxDate(inst, "max"),
			drawMonth = inst.drawMonth - showCurrentAtPos,
			drawYear = inst.drawYear;

		if (drawMonth < 0) {
			drawMonth += 12;
			drawYear--;
		}
		if (maxDate) {
			maxDraw = this._daylightSavingAdjust(new Date(maxDate.getFullYear(),
				maxDate.getMonth() - (numMonths[0] * numMonths[1]) + 1, maxDate.getDate()));
			maxDraw = (minDate && maxDraw < minDate ? minDate : maxDraw);
			while (this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1)) > maxDraw) {
				drawMonth--;
				if (drawMonth < 0) {
					drawMonth = 11;
					drawYear--;
				}
			}
		}
		inst.drawMonth = drawMonth;
		inst.drawYear = drawYear;

		prevText = this._get(inst, "prevText");
		prevText = (!navigationAsDateFormat ? prevText : this.formatDate(prevText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth - stepMonths, 1)),
			this._getFormatConfig(inst)));

		prev = (this._canAdjustMonth(inst, -1, drawYear, drawMonth) ?
			"<a class='ui-datepicker-prev ui-corner-all' data-handler='prev' data-event='click'" +
			" title='" + prevText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "e" : "w") + "'>" + prevText + "</span></a>" :
			(hideIfNoPrevNext ? "" : "<a class='ui-datepicker-prev ui-corner-all ui-state-disabled' title='"+ prevText +"'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "e" : "w") + "'>" + prevText + "</span></a>"));

		nextText = this._get(inst, "nextText");
		nextText = (!navigationAsDateFormat ? nextText : this.formatDate(nextText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth + stepMonths, 1)),
			this._getFormatConfig(inst)));

		next = (this._canAdjustMonth(inst, +1, drawYear, drawMonth) ?
			"<a class='ui-datepicker-next ui-corner-all' data-handler='next' data-event='click'" +
			" title='" + nextText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "w" : "e") + "'>" + nextText + "</span></a>" :
			(hideIfNoPrevNext ? "" : "<a class='ui-datepicker-next ui-corner-all ui-state-disabled' title='"+ nextText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "w" : "e") + "'>" + nextText + "</span></a>"));

		currentText = this._get(inst, "currentText");
		gotoDate = (this._get(inst, "gotoCurrent") && inst.currentDay ? currentDate : today);
		currentText = (!navigationAsDateFormat ? currentText :
			this.formatDate(currentText, gotoDate, this._getFormatConfig(inst)));

		controls = (!inst.inline ? "<button type='button' class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all' data-handler='hide' data-event='click'>" +
			this._get(inst, "closeText") + "</button>" : "");

		buttonPanel = (showButtonPanel) ? "<div class='ui-datepicker-buttonpane ui-widget-content'>" + (isRTL ? controls : "") +
			(this._isInRange(inst, gotoDate) ? "<button type='button' class='ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all' data-handler='today' data-event='click'" +
			">" + currentText + "</button>" : "") + (isRTL ? "" : controls) + "</div>" : "";

		firstDay = parseInt(this._get(inst, "firstDay"),10);
		firstDay = (isNaN(firstDay) ? 0 : firstDay);

		showWeek = this._get(inst, "showWeek");
		dayNames = this._get(inst, "dayNames");
		dayNamesMin = this._get(inst, "dayNamesMin");
		monthNames = this._get(inst, "monthNames");
		monthNamesShort = this._get(inst, "monthNamesShort");
		beforeShowDay = this._get(inst, "beforeShowDay");
		showOtherMonths = this._get(inst, "showOtherMonths");
		selectOtherMonths = this._get(inst, "selectOtherMonths");
		defaultDate = this._getDefaultDate(inst);
		html = "";
		dow;
		for (row = 0; row < numMonths[0]; row++) {
			group = "";
			this.maxRows = 4;
			for (col = 0; col < numMonths[1]; col++) {
				selectedDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, inst.selectedDay));
				cornerClass = " ui-corner-all";
				calender = "";
				if (isMultiMonth) {
					calender += "<div class='ui-datepicker-group";
					if (numMonths[1] > 1) {
						switch (col) {
							case 0: calender += " ui-datepicker-group-first";
								cornerClass = " ui-corner-" + (isRTL ? "right" : "left"); break;
							case numMonths[1]-1: calender += " ui-datepicker-group-last";
								cornerClass = " ui-corner-" + (isRTL ? "left" : "right"); break;
							default: calender += " ui-datepicker-group-middle"; cornerClass = ""; break;
						}
					}
					calender += "'>";
				}
				calender += "<div class='ui-datepicker-header ui-widget-header ui-helper-clearfix" + cornerClass + "'>" +
					(/all|left/.test(cornerClass) && row === 0 ? (isRTL ? next : prev) : "") +
					(/all|right/.test(cornerClass) && row === 0 ? (isRTL ? prev : next) : "") +
					this._generateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate,
					row > 0 || col > 0, monthNames, monthNamesShort) + // draw month headers
					"</div><table class='ui-datepicker-calendar'><thead>" +
					"<tr>";
				thead = (showWeek ? "<th class='ui-datepicker-week-col'>" + this._get(inst, "weekHeader") + "</th>" : "");
				for (dow = 0; dow < 7; dow++) { // days of the week
					day = (dow + firstDay) % 7;
					thead += "<th scope='col'" + ((dow + firstDay + 6) % 7 >= 5 ? " class='ui-datepicker-week-end'" : "") + ">" +
						"<span title='" + dayNames[day] + "'>" + dayNamesMin[day] + "</span></th>";
				}
				calender += thead + "</tr></thead><tbody>";
				daysInMonth = this._getDaysInMonth(drawYear, drawMonth);
				if (drawYear === inst.selectedYear && drawMonth === inst.selectedMonth) {
					inst.selectedDay = Math.min(inst.selectedDay, daysInMonth);
				}
				leadDays = (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7;
				curRows = Math.ceil((leadDays + daysInMonth) / 7); // calculate the number of rows to generate
				numRows = (isMultiMonth ? this.maxRows > curRows ? this.maxRows : curRows : curRows); //If multiple months, use the higher number of rows (see #7043)
				this.maxRows = numRows;
				printDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1 - leadDays));
				for (dRow = 0; dRow < numRows; dRow++) { // create date picker rows
					calender += "<tr>";
					tbody = (!showWeek ? "" : "<td class='ui-datepicker-week-col'>" +
						this._get(inst, "calculateWeek")(printDate) + "</td>");
					for (dow = 0; dow < 7; dow++) { // create date picker days
						daySettings = (beforeShowDay ?
							beforeShowDay.apply((inst.input ? inst.input[0] : null), [printDate]) : [true, ""]);
						otherMonth = (printDate.getMonth() !== drawMonth);
						unselectable = (otherMonth && !selectOtherMonths) || !daySettings[0] ||
							(minDate && printDate < minDate) || (maxDate && printDate > maxDate);
						tbody += "<td class='" +
							((dow + firstDay + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + // highlight weekends
							(otherMonth ? " ui-datepicker-other-month" : "") + // highlight days from other months
							((printDate.getTime() === selectedDate.getTime() && drawMonth === inst.selectedMonth && inst._keyEvent) || // user pressed key
							(defaultDate.getTime() === printDate.getTime() && defaultDate.getTime() === selectedDate.getTime()) ?
							// or defaultDate is current printedDate and defaultDate is selectedDate
							" " + this._dayOverClass : "") + // highlight selected day
							(unselectable ? " " + this._unselectableClass + " ui-state-disabled": "") +  // highlight unselectable days
							(otherMonth && !showOtherMonths ? "" : " " + daySettings[1] + // highlight custom dates
							(printDate.getTime() === currentDate.getTime() ? " " + this._currentClass : "") + // highlight selected day
							(printDate.getTime() === today.getTime() ? " ui-datepicker-today" : "")) + "'" + // highlight today (if different)
							((!otherMonth || showOtherMonths) && daySettings[2] ? " title='" + daySettings[2].replace(/'/g, "&#39;") + "'" : "") + // cell title
							(unselectable ? "" : " data-handler='selectDay' data-event='click' data-month='" + printDate.getMonth() + "' data-year='" + printDate.getFullYear() + "'") + ">" + // actions
							(otherMonth && !showOtherMonths ? "&#xa0;" : // display for other months
							(unselectable ? "<span class='ui-state-default'>" + printDate.getDate() + "</span>" : "<a class='ui-state-default" +
							(printDate.getTime() === today.getTime() ? " ui-state-highlight" : "") +
							(printDate.getTime() === currentDate.getTime() ? " ui-state-active" : "") + // highlight selected day
							(otherMonth ? " ui-priority-secondary" : "") + // distinguish dates from other months
							"' href='#'>" + printDate.getDate() + "</a>")) + "</td>"; // display selectable date
						printDate.setDate(printDate.getDate() + 1);
						printDate = this._daylightSavingAdjust(printDate);
					}
					calender += tbody + "</tr>";
				}
				drawMonth++;
				if (drawMonth > 11) {
					drawMonth = 0;
					drawYear++;
				}
				calender += "</tbody></table>" + (isMultiMonth ? "</div>" +
							((numMonths[0] > 0 && col === numMonths[1]-1) ? "<div class='ui-datepicker-row-break'></div>" : "") : "");
				group += calender;
			}
			html += group;
		}
		html += buttonPanel;
		inst._keyEvent = false;
		return html;
	}
	/*--END OF EXTRA CODE--*/

});


jQuery(document).ready(function(){

	$('#contactform').submit(function(){
		var action = $(this).attr('action');
		$("#message").show(400,function() {
		$('#message').hide();

 		$('#submit')
			.after('<img src="'+base_url+'/images/ajax-loader.gif" class="loader" />')
			.attr('disabled','disabled');

		$.post(action, {
			name: $('#name').val(),
			email: $('#email').val(),
			phone: $('#phone').val(),
			//subject: $('#subject').val(),
			comments: $('#comments').val()
			//verify: $('#verify').val()
		},
			function(data){
				document.getElementById('message').innerHTML = data;
				$('#message').slideDown('slow');
				$('#contactform img.loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit').removeAttr('disabled');
				//if(data.match('success') != null) $('#contactform').slideUp(3000);

			}
		);

		});

		return false;
	});
});

jQuery(document).ready(function(){
	$(document).on("click", ".search-popup", function (e) {
		var countRoom = $("#hotel_noofroom").val();
	    var address = $(".address-hotel.tt-input").val();
	    $('.search_mark').html('hotel');
		//$('#divLoading', ".main-search").show();
		$('#divLoading').show();
	    $.ajax({
	        url : path_url + '/search/get_search_popup',
	        type : "post",
	        dataType:"html",
	        data : {
	            'countRoom' : countRoom,
	        },
	        success : function (result){
	    		//$('#divLoading', ".main-search").hide();
	    		$('#divLoading').hide();
	    		/* revert back the text */
		    	$('.search_mark').html('flight');
	    		$('.lightbox-booking').show();
	            $('.box-content-booking').html(result);
	        }
	    });
	});

	$('#search_submit_flight').on('click', function() {
		if ($('#flight_destination').val() == "") {

		} else {
			$('.search_mark').html('flight');
			$('#divLoading', ".main-search").show();
		}
		/**/
	});
});