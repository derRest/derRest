/**
 * Created by admpc2520 on 21.10.2016.
 */


var game={};
game.player={};
game.config = {
    player: "player"
};

game.player.setPos = function (x, y) {
    var locationId = x + maze.config.splitChar + y;
    //if(maze.validatePostition()===true){
        //console.log(locationId);
        jQuery("#"+game.player.getPos()).removeAttr(game.config.player,"");     //Alte Position löschen
        jQuery("#"+locationId).attr(game.config.player,"test");                 //Neue Position setzen

    //TODO game.player.setPos aufrufen

    //}else{console.log("Unerlaubter Zug!";}
};

game.player.getPos = function () {
    return jQuery("span[player]").attr("id");
};