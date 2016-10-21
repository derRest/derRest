/**
 * Created by JanJJ on 21.10.2016.
 */

var game={};
game.player={};

game.config = {
    player: "player",
    playerSymbol: "&#916;"
};

game.startTime = 0;

game.player.setPos = function (x, y) {
    var locationId = x + maze.config.splitChar + y;
    if(maze.isWall(x,y)===true){                //Prüft ob nicht auf Mauer gelaufen wird
        console.log("isWall: "+maze.isWall(x,y));

        game.player.setPlayer(x,y);
        jQuery("#"+game.player.getPos()).removeAttr(game.config.player,"");     //Altes Attribut für Position löschen
        jQuery("#"+locationId).attr(game.config.player,"test");                 //Neues Attribut für Position setzen

        //TODO maze.candyInPosition()

    }else{
        console.log("Unerlaubter Zug!");
    }
};

game.player.getPos = function () {
    return jQuery("span[player]").attr("id");
};

game.player.setPlayer = function (x,y) {
    var locationId = x + maze.config.splitChar + y;

    jQuery("#"+game.player.getPos()).html(maze.config.chars[0]);            //Alte Position löschen
    jQuery("#"+game.player.getPos()).toggleClass("player");                 //setze Klasse "player" zurück für die Farbe

    jQuery("#"+locationId).html(game.config.playerSymbol);                  //Neue Position setzen
    jQuery("#"+locationId).toggleClass("player");                           //setze Klasse "player" für die Farbe

};

game.startGame = function () {
    loadJson();
    game.timeMeassure("start");
};

game.timeMeassure = function (start) {
    var jetzt = new Date();
    if(start=="start"){
        game.startTime = Date.now();
        console.log("Zeit Messung gestartet: "+ game.startTime);
    }else{
        var TimeDiff = 0;
       return TimeDiff = Date.now() - game.startTime;
        console.log("Zeit Messung beendet Diff: "+ TimeDiff);
    }
};



