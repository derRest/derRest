/**
 * Created by JanJJ on 21.10.2016.
 */

var game={};
game.player={};

game.config = {
    player: "player",
    playerSymbol: "&#916;",
    startPosX: "1",
    startPosY: "1"
};

game.player = {
  name: ""

};

game.startTime = 0;

game.player.setPos = function (x, y) {
    var locationId = x + maze.config.splitChar + y;
    if(maze.isWall(x,y)===true){                    //Prüft ob nicht auf Mauer gelaufen wird
        console.log("isWall: " + maze.isWall(x,y));

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
    //loadJson();
    if(game.startTime==0){
        game.player.setPos(game.config.startPosX,game.config.startPosY);
        game.timeMeassure("start");
        game.player.name = jQuery("#first_name").val();
        //game.keyevent();       //Startet möglichkeit zu Steuern
    }else{
        console.log("Allready started!");
    }
};

game.timeMeassure = function (start) {
    var jetzt = new Date();

    if(start==="start"){
        game.startTime = Date.now();
        console.log("Zeit Messung gestartet: "+ game.startTime);
    }
    if(start==="stop"&&(game.startTime!=0)){
        var TimeDiff = Date.now() - game.startTime;
        console.log("Zeit Messung beendet Diff: "+ TimeDiff);
        return TimeDiff;
    }
};

game.exit = function () {
    var timeInMiliSeconds = game.timeMeassure("stop");
    var timeInSeconds = timeInMiliSeconds/1000;
    console.log(game.player.name + 0 + timeInSeconds);
    //TODO calculateScore;
    saveScore(game.player.name,0,timeInSeconds);
};
