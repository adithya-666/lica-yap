var baseUrl = function(url) {
    return base + url;
}

function getAgeFull(dateString) {
  var now = new Date();
  var today = new Date(now.getYear(), now.getMonth(), now.getDate());

  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();
  var dob = new Date(dateString);

  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";


  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow - monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
    years: yearAge,
    months: monthAge,
    days: dateAge
  };

  if (age.years > 1) yearString = "Y";
  else yearString = "Y";
  if (age.months > 1) monthString = "M";
  else monthString = "M";
  if (age.days > 1) dayString = "D";
  else dayString = "D";


  if ((age.years > 0) && (age.months > 0) && (age.days > 0))
    ageString = age.years + yearString + "/" + age.months + monthString + "/" + age.days + dayString + "";
  else if ((age.years == 0) && (age.months == 0) && (age.days > 0))
    ageString = "/" + age.days + dayString + "";
  else if ((age.years > 0) && (age.months == 0) && (age.days == 0))
    ageString = age.years + yearString + "";
  else if ((age.years > 0) && (age.months > 0) && (age.days == 0))
    ageString = age.years + yearString + "/" + age.months + monthString + "";
  else if ((age.years == 0) && (age.months > 0) && (age.days > 0))
    ageString = age.months + monthString + "/" + age.days + dayString + "";
  else if ((age.years > 0) && (age.months == 0) && (age.days > 0))
    ageString = age.years + yearString + "/" + age.days + dayString + "";
  else if ((age.years == 0) && (age.months > 0) && (age.days == 0))
    ageString = age.months + monthString + "";
  else ageString = "Oops! Could not calculate age!";

  return ageString;
}
  
var DateRangePicker = () => {
  var start = moment();
  var end = moment();

  function cb(start, end) {
      $("#daterange-picker").html(start.format("YYYY-MM-DD") + "," + end.format("YYYY-MM-DD"));
      const startDate = $("#daterange-picker").data('daterangepicker').startDate.format('YYYY-MM-DD');
      const endDate = $("#daterange-picker").data('daterangepicker').endDate.format('YYYY-MM-DD');
  }

  $("#daterange-picker").daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
      "Today": [moment(), moment()],
      "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
      "Last 7 Days": [moment().subtract(6, "days"), moment()],
      "Last 30 Days": [moment().subtract(29, "days"), moment()],
      "This Month": [moment().startOf("month"), moment().endOf("month")],
      "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
      },
      locale:{
          format: 'DD MMMM YYYY'
      },
      alwaysShowCalendars: true
  }, cb);

  cb(start, end);

  $("#daterange-picker").on('change', function () {
      const startDate = $(this).data('daterangepicker').startDate.format('YYYY-MM-DD');
      const endDate = $(this).data('daterangepicker').endDate.format('YYYY-MM-DD');
      const typeId = $("#type_id").val();
      const patientId = $("#patient_id").val();
    
      console.log(typeId); // Cetak nilai typeId pada konsol untuk memastikan
      // var test_name = $("select[value='test_name']").val();
      const url = baseUrl('report/history-patient-datatable/'+startDate+'/'+endDate+'/'+typeId+'/'+patientId);
      Datatable.refreshTableAjax(url);

     
    const printUrl = baseUrl('report/history-patient-print/'+startDate+'/'+endDate+'/'+typeId+'/'+patientId);
    $('#print-report').attr("href", printUrl);
    const excelUrl = baseUrl('report/history-patient-excel/'+startDate+'/'+endDate+'/'+typeId+'/'+patientId);
    $('#export-report').attr("href", excelUrl);
  });

  

  // $("#test_name").on('change', function () {
  //   $("#daterange-picker").trigger('change')
  // });

  $("#patient_id").on('change', function () {
    $("#daterange-picker").trigger('change')
  });

  $("#type_id").on('change', function () {
    $("#daterange-picker").trigger('change')
  });
}

var testDropdown = () => {
  $("#type_id").on('change', function () {
    $("#daterange-picker").trigger('change')
  });


  $("#patient_id").on('change', function () {
    $("#daterange-picker").trigger('change')
  });
}

var Select2ServerSideTest = function () {
    var _componentSelect2 = function () {
      // Initialize
      $('.select-type').select2({
        allowClear: true,
        ajax: {
          url: baseUrl('report/select-test-options'),
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.test_id + " - "
  
                return {
                  text: PrefixText + item.test_name + additionalText,
                  id: item.test_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
  
      });
  
    }
  
    //
    // Return objects assigned to module
    //
  
    return {
      init: function () {
        _componentSelect2();
      }
    }
  }
var Select2ServerSidePatient = function () {
    var _componentSelect2 = function () {
      // Initialize
      $('.select-patient').select2({
        allowClear: true,
        ajax: {
          url: baseUrl('report/select-patient-options'),
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.patient_id + " - " + item.patient_medrec + "  "
  
                return {
                  text: PrefixText + item.patient_name + additionalText,
                  id: item.patient_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
  
      });
  
    }
  
    //
    // Return objects assigned to module
    //
  
    return {
      init: function () {
        _componentSelect2();
      }
    }
  }
  
document.addEventListener('DOMContentLoaded', function () {
  Datatable.init();
  DateRangePicker();
  testDropdown();
  Select2ServerSideTest().init();
  Select2ServerSidePatient().init();
  $('.btnPrint').printPage();
  $('body').tooltip({
    selector: '[data-toggle="tooltip"]',
    trigger: 'hover'
  });

});