/**
 * Created by JanJJ on 18.10.2016.
 */

var maze = {};

maze.loadMap = function (map) {

    $.each(map, function (index, value) {
      //  console.log(index + ": " + value );
        console.log("value" + index + ": " + value );

      //  maze.printMap('[','map')
        for(var i = 0; i < value.length;i++){

        //    console.log("for" + i + ": " + value[i]);

            if(value[i]==0){
                maze.printMap("__",'map')
            }else if(value[i]==1){
                maze.printMap('##','map')
            }else if(value[i]==2){
                maze.printMap('&#127852;','map')
            }
        }
        //maze.printMap(']','map')
        maze.printMap('<br>','map')
    })

}


maze.printMap = function (zeichen, className) {

    jQuery("." + className).append(zeichen);
}