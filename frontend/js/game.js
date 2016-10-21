/**
 * Created by JanJJ on 21.10.2016.
 */

var game={};
game.player={};

game.config = {
    player: "player",
    playerSymbol: "&#916;"
};

game.player.setPos = function (x, y) {
    var locationId = x + maze.config.splitChar + y;
    //if(maze.validatePostition()===true){          //Prüft ob nicht auf Mauer gelaufen wird
        //console.log(locationId);
    
        game.player.setPlayer(x,y);
        jQuery("#"+game.player.getPos()).removeAttr(game.config.player,"");     //Altes Attribut für Position löschen
        jQuery("#"+locationId).attr(game.config.player,"test");                 //Neues Attribut für Position setzen
    
    //}else{console.log("Unerlaubter Zug!";}
};

game.player.getPos = function () {
    return jQuery("span[player]").attr("id");
};

game.player.setPlayer = function (x,y) {
    var locationId = x + maze.config.splitChar + y;
    jQuery("#"+game.player.getPos()).html(maze.config.chars[0]);            //Alte Spieler Position zurücksetzen
    jQuery("#"+locationId).html(game.config.playerSymbol);                  //Neue Spieler Position setzen
};