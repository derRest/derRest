/**
 * Created by admpc2520 on 21.10.2016.
 */


var game={};
game.player={};

game.player.setPos = function (x, y) {

    var locationId = x + maze.config.splitChar + y;

    console.log(locationId);
    //$(maze.config.selectorMap).append(singleLine);
    jQuery("#locationId").val();
};

game.player.getPos = function () {
    return jQuery("span[player]").attr("id");
};