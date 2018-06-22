$(function() {
    "use strict";

    var options = {
        typeUserDisabledAttrs:{
            'checkbox-group' :[
                'toggle',
                'access',
                'classNameName'
            ],
            'paragraph' :[
                'toggle',
                'access',
                'className',
                'subtype'
            ],
            'header' :[
                'toggle',
                'access',
                'className',
            ],
            'select' :[
                'toggle',
                'access',
            ],
            'text' :[
                'toggle',
                'access',
            ],
            'textarea' :[
                'toggle',
                'access',
            ],
        },
        disableFields: ['autocomplete','button', 'hidden', 'file', 'date', 'number','radio-group'],
        // order text input and textarea to the top
        controlOrder: [
            'header',
        ]
    };

    $.ajax({
        url: "saved_fields/fields.json",
        method: "get",
        dataType: 'json',
    }).done(function(resp) {
        console.log(resp);
    });

    var $fbSteps = $(document.getElementById("form-builder-steps"));
    var addStepTab = document.getElementById("add-step-tab");
    var fbInstances = [];
  
    $fbSteps.tabs({
      beforeActivate: function(event, ui) {
        if (ui.newPanel.selector === "#new-step") {
          return false;
        }
      }
    });
  
    addStepTab.onclick = function() {
      var tabCount = document.getElementById("tabs").children.length,
        tabId = "step-" + tabCount.toString(),
        $newStepTemplate = $(document.getElementById("new-step")),
        $newStep = $newStepTemplate
          .clone()
          .attr("id", tabId)
          .addClass("fb-editor");
        $newTab = $(this).clone().removeAttr("id");
        $tabLink = $("a", $newTab)
          .attr("href", "#" + tabId)
          .text("Step " + tabCount);
  
      $newStep.insertBefore($newStepTemplate);
      $newTab.insertBefore(this);
      $fbSteps.tabs("refresh");
      $fbSteps.tabs("option", "active", tabCount - 1);
      fbInstances.push($newStep.formBuilder(options));
    };
  
    fbInstances.push($(".fb-editor").formBuilder(options));
  
    $(document.getElementById("save-all")).click(function() {
        var allData = fbInstances.map(function(fb) {
            return fb.formData;
        });

        //console.log(allData);

        $.ajax({
            url: "saveFields.php",
            method: "POST",
            dataType: 'json',
            data: {"data":allData}
        }).done(function(resp) {
            if(resp.status == 'ok'){
                toast("Data saved.");
            }else{
                toast("Data not saved.");
            }
        });
    });

    function toast(message) {
        // Get the snackbar DIV
        var x = document.getElementById("snackbar")
        x.innerHTML = message;
    
        // Add the "show" class to DIV
        x.className = "show";
    
        // After 3 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }

    if(typeof dbstatus !== 'undefined'  && dbstatus == 1){
        toast("Database files are saved.");
    }else if(typeof dbstatus !== 'undefined'  && dbstatus == 0){
        toast("Database files are not saved.");
    }

});



