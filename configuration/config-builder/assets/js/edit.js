var genPanel = function(index, expanded){
    var stepIndex = index + 1;
    var header = '<div class="panel panel-default" id="panel-step-'+index+'">'+
    '<div class="panel-heading" role="tab" id="heading'+ index + '">'+
      '<h4 class="panel-title">'+
        '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+ index+ '" aria-expanded="'+expanded+'" aria-controls="collapse'+ index + '"> Step '+ stepIndex +'</a>'+
      '</h4>'+
    '</div>';


    var body = '<div id="collapse'+ index +'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+ index +'">'+
    '<div class="panel-body" id="form-render-'+ index +'">okokok</div>'+
    '</div></div>';

    //console.log(header+body);
    return header+body;
}

var fbInstances = [];

$.ajax({
    method: "GET",
    url: "saved_fields/fields.json"
})
.done(function( res ) {

    res.steps.forEach(function(element, index, steps) {

        if(index == 0){
            $("#accordion").append(genPanel(index, true));
        }else{
            var prevIndex = index - 1;
            $(genPanel(index, false)).insertAfter("#panel-step-"+prevIndex);
        }
        var formData = steps[index];
        var formRenderOpts = {
            formData,
            dataType: 'json'
        };

        setTimeout(function(){
            var fbRender = $("#form-render-"+index);
            // console.log(fbRender);
            // console.log(index);
            // console.log(formRenderOpts);
            fbInstances.push($(fbRender).formRender(formRenderOpts));
        },3000)
    });
});

$(document.getElementById("save-all")).click(function() {
    var allData = fbInstances.map(function(fb) {
        return fb.formData;
    });

//console.log(allData);
});