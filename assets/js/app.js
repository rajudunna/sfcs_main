(function(){
    var app = angular.module('brand',[]);
    app.controller('menu',['$http',function($http){
        a = this;
        a.ss = false;
        a.res121 = [];
        a.sugissions = function(){
            if(a.ser_box){
                //=============== http ajax call ==================
                a.ss = true;
                $http.get("template/search.php?search="+a.ser_box)
                    .then(function(response) {
                        a.res121 = response.data;
                    });
            }else{
                a.ss = false;
                a.res = [];
            }
        };


        var classname = document.getElementsByClassName("disable-btn");

        var myFunction = function(event) {
            var className = this.className;
            var elChild = document.createElement('a');
            elChild.innerHTML  = "Loading...";
            elChild.className  = className;
            this.after(elChild)
            this.style.display = "none";
        };

        for (var i = 0; i < classname.length; i++) {
            classname[i].addEventListener('click', myFunction);
        }

    }]);

})();
