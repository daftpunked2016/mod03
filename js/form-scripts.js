function _(el){
  return document.getElementById(el);
}

$(document).ready(function(){
  var loadprop = {'background-image':'url(../../images/load.gif)', 'background-repeat': 'no-repeat','background-position': 'center'};
  var removeprop = {'background-image':'', 'background-repeat': 'no-repeat','background-position': ''};

  if (typeof location.origin === 'undefined')
    location.origin = location.protocol + '//' + location.host;

   $(".file-upload").change(function() {
      var val = $(this).val();
      var file_size =  parseFloat(this.files[0].size/1024/1024).toFixed(2);

      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
          case 'png':
          case 'gif':
          case 'jpg':
          case 'jpeg':
          case 'bmp':
              break;
          default:
              $(this).val('');
              // error message here
              alert("Invalid File! File must be Image Format only.");
              break;
      }

      if(file_size > 2)
      {
        $(this).val('');
        alert("The image you are trying to upload exceeds the Maximum file size limit.")
      }
    });

    //LIST SUBCAT OF PEA
    $("#pea-category").change(function(){
        var val  = $(this).val();

        $('select#pea-subcat').css(loadprop);
        $.post(location.origin+"/mod03/index.php/account/listsubcat", { cat_id : val }, function(data) {
            $("select#pea-subcat").html("<option value=''>Please Select.. </option>" + data);
            $("select#pea-refcode").html("<option value=''>Please Select.. </option>");
            success: $('select#pea-subcat').css(removeprop);
        });
    });

    //LIST REFERENCE CODE AND DESCRIPTION OF PEA
    $("#pea-subcat").change(function(){
        var val  = $(this).val();

        $('select#pea-refcode').css(loadprop);
        $.post(location.origin+"/mod03/index.php/account/listrefcode", { sub_id : val }, function(data) {
            $("select#pea-refcode").html("<option value=''>Please Select.. </option>" + data);
            success: $('select#pea-refcode').css(removeprop);
        });
    });

    $("#pea-category-admin").change(function(){
        var val  = $(this).val();

        $('select#pea-subcat').css(loadprop);
        $.post(location.origin+"/mod03/index.php/account/listsubcat", { cat_id : val }, function(data) {
            $("select#pea-subcat-admin").html("<option value=''>Please Select.. </option>" + data);
            $("select#pea-refcode-admin").html("<option value=''>Please Select.. </option>");
            success: $('select#pea-subcat-admin').css(removeprop);
        });
    });

    $("#pea-subcat-admin").change(function(){
        var val  = $(this).val();

        $('select#pea-refcode-admin').css(loadprop);
        $.post(location.origin+"/mod03/index.php/account/listallrefcode", { sub_id : val }, function(data) {
            $("select#pea-refcode-admin").html("<option value=''>Please Select.. </option>" + data);
            success: $('select#pea-refcode-admin').css(removeprop);
        });
    });


    $("input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
      var $box = $(this);
      if ($box.is(":checked")) {
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $box.prop("checked", true);
      } else {
        $box.prop("checked", false);
      }
    });

    //FUNCTION TO DISABLE NON-NUMERICAL CHARACTERS IN QUANTITY TEXT FIELD
    $(".quantity").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    //LIST REGIONS
    $("#area_no").change(function(){
      if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
            $("select#region").html("<option value=''>Select Region.. </option>" + data);
            $("select#chapter").html("<option value=''> -- </option>");
        });
    });

    //LIST CHAPTERS
    $("#region").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
            $("select#chapter").html("<option value=''>Select Chapter.. </option>" + data);
        });
    });

    // admin filters (category tree)

    // assign trainers
    $('.assign-trainer').click(function(event) {
      type = $(this).data('type');
      event.preventDefault();

      $.ajax({
         url: location.origin+'/mod03/index.php/training/default/render/type/'+ type,
         method: "POST",
         data: {type : type},
         success: function(response) {
            $('#addTrainerModal').modal('show');
            trainer_results = response;
         },
         complete: function() {
            $('#trainer-results').empty();
            $('#trainer-results').hide().html(trainer_results).fadeIn('4000');
         },
         error: function() {
            alert("ERROR in running requested function. Page will now reload.");
            location.reload();
         }
      });
    });

    //LIST REGIONS
    $(document).on("change", "#area_no", function(){
        $.post("http://www.jci.org.ph/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
            $("select#region_id").html("<option value='' disabled selected>Select Region.. </option>" + data);
            $("select#chapter_id").html("<option value='' disabled selected> -- </option>");
            $("select#member").html("<option value='' disabled selected> -- </option>");
        });
    });

    //LIST CHAPTERS
    $(document).on("change", "#region_id", function(){
        $.post("http://www.jci.org.ph/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
            $("select#chapter_id").html("<option value='' disabled selected>Select Chapter.. </option>" + data);
            $("select#member").html("<option value='' disabled selected> -- </option>");
        });
    });

    //POPULATE CHAPTER MEMBERS
    $(document).on("change", "#chapter_id", function(){
        type = $(this).data('type');
        $.post("http://www.jci.org.ph/mod02/index.php/account/listNotTrainers?chapter="+$(this).val()+"&type="+type, function(data) {
          $("select#member").html("<option value='' disabled selected>Select Member.. </option>" + data);
        });
    });

    // list pea submited chapters
    $('.list-chapters').click(function() {
      reg_id = $(this).data('reg_id');
      rep_id = $(this).data('rep_id');
      $.ajax({
        url: location.origin+'/mod03/index.php/training/default/listchapters/rep_id/'+ rep_id+'/region_id/'+ reg_id,
        success: function(response) {
          $('#chaptersModal').modal('show');
          chapter_results = response;
       },
        complete: function() {
          $('#chapter-results').empty();
          $('#chapter-results').hide().html(chapter_results).fadeIn('4000');
        }
      });
    });

    // list pea submited chapters
    $('.trainers-list-chapters').click(function() {
      reg_id = $(this).data('reg_id');
      rep_id = $(this).data('rep_id');
      $.ajax({
        url: location.origin+'/mod03/index.php/trainers/default/listchapters/rep_id/'+ rep_id+'/region_id/'+ reg_id,
        success: function(response) {
          $('#chaptersModal').modal('show');
          chapter_results = response;
       },
        complete: function() {
          $('#chapter-results').empty();
          $('#chapter-results').hide().html(chapter_results).fadeIn('4000');
        }
      });
    });
});