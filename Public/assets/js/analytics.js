$(function () {
  $('#daterange-btn').daterangepicker(
          {
            minDate: moment().subtract(3, 'month').startOf('month'),
            maxDate: moment(),
            ranges: {
              'This Week': [getThisWeekStart(), getThisWeekEnd()],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Past Week': [getLastWeekStart(), getLastWeekEnd()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
//            startDate: getThisWeekStart(),
//            endDate: moment()
          },
          function (start, end) {
            $('#daterange-btn span').html('<i class="fa fa-calendar"></i> &nbsp; ' + start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            $('#filterDateStart').val(start.format('YYYY-MM-DD'));
            $('#filterDateEnd').val(end.format('YYYY-MM-DD'));
            $('#analyticsFilterForm').submit();
          }
  );
  function cb(start, end) {
    $('#daterange-btn').data('daterangepicker').setStartDate(start);
    $('#daterange-btn').data('daterangepicker').setEndDate(end);

    $('#daterange-btn span').html('<i class="fa fa-calendar"></i> &nbsp; ' + start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    $('#filterDateStart').val(start.format('YYYY-MM-DD'));
    $('#filterDateEnd').val(end.format('YYYY-MM-DD'));
  }
 
  if ($('#filterDateStart').val() == '' || $('#filterDateEnd').val() == '') {
    cb(moment().subtract(6, 'days'), moment());
  } else {
    cb(moment($('#filterDateStart').val()), moment($('#filterDateEnd').val()));
  }
//  cb(start, end);

//console.log(GetLastWeekStart().format('MMM D, YYYY'));
//console.log(GetLastWeekEnd().format('MMM D, YYYY'));

//  console.log(moment());
//
//  console.log(moment().tz());
//  console.log(moment().startOf('week').subtract(1, 'days').startOf('week').format('MMM D, YYYY'));
//  console.log(moment().startOf('week').subtract(1, 'days').endOf('week').format('MMM D, YYYY'));
//
//  console.log(moment().startOf('week').format('MMM D, YYYY'));
//  console.log(moment().endOf('week').subtract(1, 'days').format('MMM D, YYYY'));

});

function getThisWeekStart() {
  var thisWeekStart = moment().startOf('week');
  return thisWeekStart;
}

function getThisWeekEnd() {
  var thisWeekEnd = moment().endOf('week');
  if (thisWeekEnd > moment()) {
    return moment();
  } else {
    return thisWeekEnd;
  }
}
function getLastWeekStart() {
  var today = moment();
  var daystoLastMonday = 0 - (1 - today.isoWeekday()) + 7;

  var lastMonday = today.subtract(daystoLastMonday, 'days');

  return lastMonday;
}

function getLastWeekEnd() {
  var lastMonday = getLastWeekStart();
  var lastSunday = lastMonday.add(6, 'days');

  return lastSunday;
}
