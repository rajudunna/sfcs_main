$(function() {
    var fbInstancesArray = [];
    var addStepTab = document.getElementById("add-step-tab");
    var $fbSteps = $(document.getElementById("form-builder-steps"));
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

    addStepTab.onclick = function() {
        //alert("okkoko");
        var tabCount = document.getElementById("tabs").children.length,
        tabId = "step-" + tabCount.toString(),
        $newStepTemplate = $(document.getElementById("new-step")),
        $newStep = $newStepTemplate
        .clone()
        .attr("id", tabId)
        .addClass("fb-editor"),
        $newTab = $(this).clone().removeAttr("id"),
        $tabLink = $("a", $newTab)
        .attr("href", "#" + tabId)
        .text("Step " + tabCount);

        $newStep.insertBefore($newStepTemplate);
        $newTab.insertBefore(this);
        $fbSteps.tabs("refresh");
        $fbSteps.tabs("option", "active", tabCount - 1);
        fbInstancesArray.push($newStep.formBuilder(options));
    };

    $.ajax({
        url: "saved_fields/fields.json",
        method: "get",
        dataType: 'json',
    }).done(function(resp) {
        if(resp.steps.length > 0){
            console.log(resp.steps.length);
            resp.steps.forEach( (element, index, array) => {
                console.log(element);
                if(index == 0){
                    //var $fbSteps = $(document.getElementById("form-builder-steps"));
                    //var addStepTab = document.getElementById("add-step-tab");
                    //fbInstancesArray = [];
                
                    $fbSteps.tabs({
                    beforeActivate: function(event, ui) {
                        if (ui.newPanel.selector === "#new-step") {
                        return false;
                        }
                    }
                    });
                
                    var fb = $(".fb-editor").formBuilder(options);
                    fbInstancesArray.push(fb);
                    setTimeout(function(){
                        fb.actions.setData(JSON.stringify(element)) ;
                    },500);
                }else{
                    //var $fbSteps = $(document.getElementById("form-builder-steps"));
                    //var addStepTab = document.getElementById("add-step-tab");
                    //fbInstancesArray = [];

                    var tabCount = document.getElementById("tabs").children.length,
                    tabId = "step-" + tabCount.toString(),
                    $newStepTemplate = $(document.getElementById("new-step")),
                    $newStep = $newStepTemplate
                    .clone()
                    .attr("id", tabId)
                    .addClass("fb-editor"),
                    $newTab = $(addStepTab).clone().removeAttr("id"),
                    $tabLink = $("a", $newTab)
                    .attr("href", "#" + tabId)
                    .text("Step " + tabCount);
            
                    $newStep.insertBefore($newStepTemplate);
                    $newTab.insertBefore(addStepTab);
                    $fbSteps.tabs("refresh");
                    $fbSteps.tabs("option", "active", tabCount - 1);

                    var fb = $newStep.formBuilder(options);
                    fbInstancesArray.push(fb);
                    setTimeout(function(){
                        fb.actions.setData(JSON.stringify(element)) ;
                    },500);
                }
            });
        }else{
            //var $fbSteps = $(document.getElementById("form-builder-steps"));
            //var addStepTab = document.getElementById("add-step-tab");
            //fbInstancesArray = [];
          
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
                  .addClass("fb-editor"),
                $newTab = $(this).clone().removeAttr("id"),
                $tabLink = $("a", $newTab)
                  .attr("href", "#" + tabId)
                  .text("Step " + tabCount);
          
              $newStep.insertBefore($newStepTemplate);
              $newTab.insertBefore(this);
              $fbSteps.tabs("refresh");
              $fbSteps.tabs("option", "active", tabCount - 1);
              fbInstancesArray.push($newStep.formBuilder(options));
            };
          
            fbInstancesArray.push($(".fb-editor").formBuilder(options));
        }
    });
  
    $(document.getElementById("save-all")).click(function() {
        var allData = fbInstancesArray.map(function(fb) {
            return fb.formData;
        });

        var names = [];
        allData.forEach(function(element) {
            var data = JSON.parse(element);
            data.forEach(function(item){
                if(item.name != undefined){
                    names.push(item.name);
                }
            });
        });

        var isDuplicate = names.some(function(item, idx){ 
            return names.indexOf(item) != idx 
        });
        if(isDuplicate){
            toast("Please check names.");
            return false
        }

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



