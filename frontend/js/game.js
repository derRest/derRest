/**
 * Created by JanJJ on 21.10.2016.
 */

var game={};
game.player={};

game.config = {
    player: "player",
    playerSymbol: "&#916;",
    startPosX: 1,
    startPosY: 1
};

game.player = {
  name: "",
  collectedCandys: 0,
  keyCount: 0
};

game.startTime = 0;

game.player.setPos = function (x, y) {
    var locationId = x + maze.config.splitChar + y;
    if(!maze.isWall(x,y)){                    //Prüft ob nicht auf Mauer gelaufen wird
        console.log("isWall: " + maze.isWall(x,y));
        if (maze.isCandy(x, y)) {
	        jQuery("#" + x+maze.config.splitChar+y).html(maze.config.chars[0]);
	        jQuery("#" + x+maze.config.splitChar+y).removeClass("candy");  
	        game.player.collectedCandys++;
	    }
	    game.player.setPlayer(x,y);
        jQuery("#"+game.player.getPos()).removeAttr(game.config.player,"");     //Altes Attribut für Position löschen
        jQuery("#"+locationId).attr(game.config.player,"test");  //Neues Attribut für Position setzen
        if (maze.isOnExit(x, y)) {
        	game.exit();
        }               
    }else{
        console.log("Unerlaubter Zug!");
    }
};


game.keyevent = function () {
	if (game.startTime == 0) {
		jQuery(document).off("keydown");
		return;
	}
    jQuery(document).on("keydown", jQuery(document), function (event) {
        if (event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 37) {
            var playerPos = game.player.getPos();
            if (typeof(playerPos) == "undefined") {
            	console.log("limitless space of undefinedness");
            	game.exit();
            	return;
            }
            if (game.startTime == 0) {
            	return;
            }
            game.player.keyCount++;
            var playerPosXY = playerPos.split(maze.config.splitChar);
            switch (event.keyCode) {
                case 37:
                    game.player.setPos(parseInt(playerPosXY[0]), parseInt(playerPosXY[1])-1);
                    break; 
                case 38:
                    game.player.setPos(parseInt(playerPosXY[0])-1, parseInt(playerPosXY[1]));
                    break;
                case 39:
                    game.player.setPos(parseInt(playerPosXY[0]), parseInt(playerPosXY[1])+1);
                    break;
                case 40:
                    game.player.setPos(parseInt(playerPosXY[0])+1, parseInt(playerPosXY[1]));
                    break;
            }
        }
    });
}

game.calculateScore = function (candy, time) {
    var result = (1/(Math.sqrt(time)) * ((candy*(maze.config.candyCount/100))*Math.PI));
    return Math.round(Math.abs(result*maze.config.length * maze.config.width / Math.sqrt (game.player.keyCount)));
}


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
    game.player.name = jQuery("#first_name").val();
    //if (game.player.name == "")
    //{
    //	jQuery("#first_name")
    //}
    document.body.style.overflow = "hidden";
    game.reset();
    if(game.startTime==0){
        game.player.setPos(game.config.startPosX,game.config.startPosY);
        game.timeMeassure("start");
        game.keyevent();       //Startet möglichkeit zu Steuern
    }else{
        console.log("Already started!");
    }
};

game.timeMeassure = function (start) {
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

game.saveScore = function(name, points, timeInSeconds) {
    var url = location.protocol + '//' + location.host + location.pathname + 'api/highscore';
    jQuery.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        data: JSON.stringify({
            name: name,
            score: points,
            level: 1,
            elapsedTime: timeInSeconds
        })
    });
}

game.exit = function () {
	//document.onkeydown = null;
	jQuery(document).off("keydown");
	document.body.style.overflow = "auto";
    var timeInMiliSeconds = game.timeMeassure("stop");
    var timeInSeconds = timeInMiliSeconds/1000;
    game.startTime = 0;
    console.log(game.player.name + 0 + timeInSeconds);
    var points = game.calculateScore(game.player.collectedCandys, timeInSeconds);
    game.saveScore(game.player.name, points, timeInSeconds);
    maze.unload();
    maze.printResult(points, timeInSeconds);
    game.reset();
};

game.reset = function () {
	game.startTime = 0;
	game.player.name = "";
	maze.isLoaded = false;
	//document.onkeydown = null;
	//jQuery.off("keydown");
    //maze.config.width = maze.config.width + 2;
    //maze.config.length = maze.config.length + 2;
    //loadJson();
}
