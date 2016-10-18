/**
 * Created by JanJJ on 18.10.2016.
 */

var maze = {};

maze.loadMap = function (map) {
    var x=0;

    $.each(map, function (index, value) {
      // console.log("value" + index + ": " + value );
        var text = "";
        x++;

        text += maze.createStruct('','map',x,'start');

        for(var i = 0; i < value.length;i++){
            if(value[i]==0){
                text += maze.createStruct("__",'map',x,i);
            }else if(value[i]==1){
                text += maze.createStruct('##','map',x,i);
            }else if(value[i]==2){
                text += maze.createStruct('&#127852;','map',x,i);
            }
        }

        text += maze.createStruct('','map',x,'end');
        maze.printMap(text,'map');
    })
};


maze.createStruct = function (zeichen, className, x, y) {
    var env;
    if(y==="start"){
        env = '<div id="'+x+'">'+zeichen;
    }else if(y==="end"){
        env = zeichen+'</div>';
    }else{
         env = '<span id="'+ x +'.'+y+'">'+zeichen+'</span>';
    }
return env;
};


maze.printMap = function (env, divName) {
    jQuery("." + divName).append(env);
};
