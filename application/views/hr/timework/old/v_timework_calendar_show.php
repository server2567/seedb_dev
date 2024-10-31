<h4 class="partial-name"><span>ปฏิทินการทำงาน</span></h4>
<div class="panel-ctrls button-icon-bg">
  <a data-toggle="modal" href="#sync-with-google-calendar-modal">
    <span class="button-icon tooltips" style=" color: #616161; width: 270px;" data-original-title="เชื่อมต่อปฏิทินกับกูเกิ้ล (Sync Googlecalendar)">
      <!-- <img src="<?php echo base_url() . '/images/google.png'; ?>"/ style="margin-top:-10px; margin-right:10px;"> -->

      <!--                    <i class="fa fa-refresh" id="" style="font-size: 25px;"></i>-->
    </span>
  </a>
  <a data-toggle="modal" href="#sync-with-google-calendar-modal2">
    <span class="button-icon tooltips" style=" color: #616161; width: 150px;" data-original-title="คู่มือการเชื่อมต่อปฏิทินกับกูเกิ้ล">
      <!-- <img src="<?php echo base_url() . '/images/manual.png'; ?>"/ style="margin-top:-10px; margin-right:10px;"> -->

      <!--                    <i class="fa fa-refresh" id="" style="font-size: 25px;"></i>-->
    </span>
  </a>
</div>
<div id="menu-calendar">
  <span class="btn-group" id="dropdown">
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i><span class="checkbox-title" id="calendarTypeName"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
      <li><a class="dropdown-item" role="menuitem" data-action="toggle-daily"><i class="calendar-icon ic_view_day"></i>รายวัน</a></li>
      <li><a class="dropdown-item" role="menuitem" data-action="toggle-weekly"><i class="calendar-icon ic_view_week"></i>รายสัปดาห์</a></li>
      <li><a class="dropdown-item" role="menuitem" data-action="toggle-monthly"><i class="calendar-icon ic_view_month"></i>เดือน</a></li>
    </ul>
  </span>
  <span id="menu-navi">
    <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">วันนี้</button>
    <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev"><i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i></button>
    <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next"><i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i></button>
  </span>
  <span id="renderRange" class="render-range"></span>
</div>
<div id="calendar"></div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendar = new tui.Calendar('#calendar', {
      defaultView: 'month',
      // useCreationPopup: true,
      // useDetailPopup: true,
      calendars: CalendarList,
      // actors: ActorList,
      month: {
        daynames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์']
      },
      template: {
        monthDayname: function(model) {
          return '<span class="tui-full-calendar-dayname-name">' + model.label + '</span>';
        },
        monthDaynameExceed: function() {
          return '<span class="tui-full-calendar-dayname-name">...</span>';
        },
        monthDaynameOtherMonth: function(model) {
          return '<span class="tui-full-calendar-dayname-name tui-full-calendar-other-month">' + model.label + '</span>';
        },
        schedule: function(model) {
          return '<span>' + model.title + '</span>';
        },
        time: function(schedule) {
          return '<strong></strong> ' + schedule.title;
        },
      },
      theme: themeConfig, // set theme
      dateFormatter: {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
      },
    });

    function onClickNavi(e) {
      var action = e.target.getAttribute('data-action');
console.log(action);
      switch (action) {
        case 'move-prev':
          calendar.prev();
          calendarInstance.changeView('day', true);

          break;
        case 'move-next':
          calendar.next();
          break;
        case 'move-today':
          calendar.today();
          break;
        default:
          return;
      }
      // updateMonthYear();
      setRenderRangeText();
    }
    // สร้างเหตุการณ์สำหรับปฏิทิน
    var schedules = [{

        id: '1',
        calendarId: '1',
        title: 'นาย ณฐกร พงษ์สาริกิจ opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-20',
        end: '2024-04-20'
      },
      {
        id: '2',
        calendarId: '1',
        title: 'นาย จิริเดช ป้อมใหญ่ opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-20',
        end: '2024-04-20'
      },
      {
        id: '3',
        calendarId: '1',
        title: 'นาย ขจรศัก ผักใบเขียว opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-20',
        end: '2024-04-20'
      },
      {
        id: '4',
        calendarId: '1',
        title: 'นาย ขจรศัก ผักใบเขียว opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-20',
        end: '2024-04-20'
      },
      {
        id: '5',
        calendarId: '1',
        title: 'นาย ขจรศัก ผักใบเขียว opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-22',
        end: '2024-04-22'
      },
      {
        id: '6',
        calendarId: '1',
        title: 'นาย ขจรศัก ผักใบเขียว opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-22',
        end: '2024-04-22'
      }, {
        id: '6',
        calendarId: '1',
        title: 'นาย ขจรศัก ผักใบเขียว opd ห้อง 5',
        category: 'time',
        dueDateClass: '',
        start: '2024-04-22',
        end: '2024-04-22'
      },

    ];
    var themeConfig = {
      // month header 'dayname'
      'month.dayname.height': '42px',
      'month.dayname.borderLeft': 'none',
      'month.dayname.paddingLeft': '8px',
      'month.dayname.paddingRight': '0',
      'month.dayname.fontSize': '16px',
      'month.dayname.backgroundColor': 'inherit',
      'month.dayname.fontWeight': 'normal',
      'month.dayname.textAlign': 'center',

      // month day grid cell 'day'
      'month.holidayExceptThisMonth.color': '#f3acac',
      'month.dayExceptThisMonth.color': '#bbb',
      'month.weekend.backgroundColor': '#fafafa',
      'month.day.fontSize': '16px',

      // month schedule style
      'month.schedule.borderRadius': '5px',
      'month.schedule.height': '30px',
      'month.schedule.marginTop': '10px',
      'month.schedule.marginLeft': '10px',
      'month.schedule.marginRight': '10px',

      // // month more view
      // 'month.moreView.boxShadow': 'none',
      // 'month.moreView.paddingBottom': '0',
      // 'month.moreView.border': '1px solid #9a935a',
      // 'month.moreView.backgroundColor': '#f9f3c6',
      // 'month.moreViewTitle.height': '28px',
      // 'month.moreViewTitle.marginBottom': '0',
      // 'month.moreViewTitle.backgroundColor': '#f4f4f4',
      // 'month.moreViewTitle.borderBottom': '1px solid #ddd',
      // 'month.moreViewTitle.padding': '0 10px',
      // 'month.moreViewList.padding': '10px'
    };


    // เพิ่มเหตุการณ์ลงในปฏิทิน
    calendar.createSchedules(schedules);
    // เรียกใช้ปฏิทิน
    calendar.render();
    // เพิ่มเหตุการณ์ clickSchedule เพื่อให้ทำงานเมื่อคลิกบนเหตุการณ์ในปฏิทิน
    calendar.on('clickSchedule', function(event) {
      // เข้าถึง id ของเหตุการณ์
      var scheduleId = event.schedule.id;
      console.log('Clicked schedule ID:', scheduleId);
    });

    function openModal() {
      $('#disablebackdrop').modal('show'); // แทน #myModal ด้วย ID ของโมดอลของคุณ
      console.log("22");
    }
    initValue();

    function initValue() {
      // $('.aos-calendar-ac-selectpicker').selectpicker();
      setRenderRangeText();
      setEventListener();
      // updateMonthYear();
      setDropdownCalendarType();
      handleDropdownAction();
    }

    // set calendars
    (function() {
      /**
       *calendar
       */
      var options = window.calendar.getOptions();
      options.month.visibleWeeksCount = 0;
      viewName = 'month';
      window.calendar.setOptions(options, true);
      window.calendar.changeView(viewName, true);
      setDropdownCalendarType();
      setRenderRangeText();
      handleDropdownAction();

      var calendarList = document.getElementById('calendarList');
      var html = [];
      CalendarList.forEach(function(calendar) {
        html.push('<div class="lnb-calendars-item" style="display: inline;padding-right: 15px;"><label>' +
          '<input type="checkbox" style="display:none" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
          '<span id="cal-list-color-' + calendar.id + '" style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';' +
          'display: inline-block;border-radius: 50%;border-width: 3px;border-style: solid;width: 15px;height: 15px;margin-right: 10px;"></span>' +
          '<span>' + calendar.name + '</span>' +
          '</label></div>'
        );
      });
      calendarList.innerHTML = html.join('\n');
    })();
    function setRenderRangeText() {
      moment.locale('th'); // th
      var renderRange = document.getElementById('renderRange');
      var options = calendar.getOptions();
      var viewName = calendar.getViewName();
      var html = [];
      if (viewName === 'day') {
        html.push(moment(calendar.getDate().getTime()).format('DD MMMM') + ' พ.ศ. ' + (parseInt(moment(calendar.getDate().getTime()).format('YYYY')) + 543));
      } else if (viewName === 'month' &&
        (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
        html.push(moment(calendar.getDate().getTime()).format('MMMM') + ' พ.ศ. ' + (parseInt(moment(calendar.getDate().getTime()).format('YYYY')) + 543));
      } else {
        html.push(moment(calendar._renderRange.start._date).format('DD MMMM') + ' พ.ศ. ' + (parseInt(moment(calendar.getDate().getTime()).format('YYYY')) + 543));
        html.push(' ~ ');
        html.push(moment(calendar._renderRange.end._date).format('DD MMMM') + ' พ.ศ. ' + (parseInt(moment(calendar.getDate().getTime()).format('YYYY')) + 543));
      }
      renderRange.innerHTML = html.join('');
    }
//เปลี่ยนรูปแบบ และicon
function handleDropdownAction(e) {
  var action = e.target.getAttribute('data-action');
  console.log(action);
    switch(action) {
        case 'toggle-daily':
          type = 'รายวัน';
            // เรียกใช้ฟังก์ชันที่จะเปลี่ยนมุมมองเป็นรายวัน
            changeCalendarView('day');
            iconClassName = 'calendar-icon ic_view_day';
            break;
        case 'toggle-weekly':
          type = 'รายสัปดาห์';
            // เรียกใช้ฟังก์ชันที่จะเปลี่ยนมุมมองเป็นรายสัปดาห์
            changeCalendarView('week');
            iconClassName = 'calendar-icon ic_view_week';
            break;
        case 'toggle-monthly':
          type = 'เดือน';
            // เรียกใช้ฟังก์ชันที่จะเปลี่ยนมุมมองเป็นรายเดือน
            changeCalendarView('month');
            iconClassName = 'calendar-icon ic_view_month';
            break;
        default:
            // กรณีไม่รู้จักการกระทำ
            console.log('Unknown action:', action);
    }
    calendarTypeName.innerHTML = type;
    calendarTypeIcon.className = iconClassName;
}
function changeCalendarView(viewName) {
  calendar.changeView(viewName, true);
}
//
    function setEventListener() {
      window.addEventListener('resize', resizeThrottled);
      $('#menu-navi').on('click', onClickNavi);
      $('#dropdown').on('click', handleDropdownAction);
      // $('#select-year').on('change', changeYear);
      // $('#select-month').on('change', changeMonth);
      // $('#lnb-calendars').on('change', onChang);
    }


    // function changeYear() {
    //     let now_year = parseInt(moment(cal.getDate().getTime()).format('YYYY'));
    //     let select_year = parseInt($('#select-year').val());
    //     cal.move((select_year - now_year) * 12);
    //     cal.render(true);
    //     setRenderRangeText();
    //     updateMonthYear();
    // }

    // function changeMonth() {
    //     let now_month = parseInt(moment(cal.getDate().getTime()).format('M'));
    //     let select_month = parseInt($('#select-month').val());
    //     cal.move((select_month - now_month));
    //     cal.render(true);
    //     setRenderRangeText();
    //     updateMonthYear();
    // }
  });
</script>
<div class="modal fade" id="disablebackdrop" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ผู้เข้าเวรวันนี้</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="badge bg-info text-dark">(กะเช้า)</div><br>
        นาย ณฐกร พงษ์สาริกิจ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        <div class="badge bg-danger">(กะบ่าย)</div><br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        <div class="badge bg-primary">(กะเย็น)</div><br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
        นาย จิริเดช ป้อมใหญ่ opd ห้อง 5 <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- End Disabled Backdrop Modal-->
<!-- นำเข้า Bootstrap JavaScript ผ่าน CDN -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-time-picker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-date-picker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-calendar.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-icons.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-default.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-code-snippet.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-time-picker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-date-picker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/tui-calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/data/calendars_support.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/data/schedules.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/personal_dashboard/tui.calendar-vue-calendar-2.1.3/moment-with-locales.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
  // document.addEventListener("DOMContentLoaded", function(event) {
  //     const contacts = document.getElementById('dashboard-calendar-tab');
  //     contacts.addEventListener('click', function(event) {
  //         initValue();
  //     });
  // });

  // default keys and styles
  var themeConfig = {
    // month header 'dayname'
    'month.dayname.height': '42px',
    'month.dayname.borderLeft': 'none',
    'month.dayname.paddingLeft': '8px',
    'month.dayname.paddingRight': '0',
    'month.dayname.fontSize': '16px',
    'month.dayname.backgroundColor': 'inherit',
    'month.dayname.fontWeight': 'normal',
    'month.dayname.textAlign': 'center',

    // month day grid cell 'day'
    'month.holidayExceptThisMonth.color': '#f3acac',
    'month.dayExceptThisMonth.color': '#bbb',
    'month.weekend.backgroundColor': '#fafafa',
    'month.day.fontSize': '16px',

    // month schedule style
    'month.schedule.borderRadius': '5px',
    'month.schedule.height': '30px',
    'month.schedule.marginTop': '10px',
    'month.schedule.marginLeft': '10px',
    'month.schedule.marginRight': '10px',

    // month more view
    'month.moreView.boxShadow': 'none',
    'month.moreView.paddingBottom': '0',
    'month.moreView.border': '1px solid #9a935a',
    'month.moreView.backgroundColor': '#f9f3c6',
    'month.moreViewTitle.height': '28px',
    'month.moreViewTitle.marginBottom': '0',
    'month.moreViewTitle.backgroundColor': '#f4f4f4',
    'month.moreViewTitle.borderBottom': '1px solid #ddd',
    'month.moreViewTitle.padding': '0 10px',
    'month.moreViewList.padding': '10px'
  };

  var templates = {
    popupSave: function() {
      return 'บันทึก';
    },
    popupUpdate: function() {
      return 'แก้ไข';
    },
    startDatePlaceholder: function() {
      return 'วันที่เริ่มต้น';
    },
    endDatePlaceholder: function() {
      return 'วันที่สิ้นสุด';
    },
    popupIsAllDay: function() {
      return 'ทั้งวัน';
    },
    popupEdit: function() {
      return 'แก้ไข';
    },
    popupDelete: function() {
      return 'ลบ';
    },
    milestone: function(model) {
      return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
    },
    allday: function(schedule) {
      return getTimeTemplate(schedule, true);
    },
    time: function(schedule) {
      return getTimeTemplate(schedule, false);
    },
    monthGridHeaderExceed: function(hiddenSchedules) {
      return `<span class="aos-calendar-ac-weekday-grid-more-schedules">อีก ${hiddenSchedules} กิจกรรม</span>`;
    }
  };

  var resizeThrottled = tui.util.throttle(function() {
    cal.render();
  }, 50);
</script>
<style>
  .tui-full-calendar-weekday-grid-more-schedules {
    float: right;
    display: inline-block;
    height: 27px;
    line-height: 27px;
    padding: 0 5px;
    text-align: center;
    font-size: 11px;
    font-weight: bold;
    color: #aaa;
  }

  .tui-full-calendar-month-more {
    display: none;
    height: inherit;
    min-width: 280px;
    min-height: 150px;
  }
</style>
<script>
  document.onclick = function(event) {
    if (event.target.classList.contains('tui-full-calendar-weekday-grid-more-schedules')) {
      $('#disablebackdrop').modal('show');
    }
  };
</script>