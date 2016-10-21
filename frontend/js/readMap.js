/**
 * Created by JanJJ on 18.10.2016.
 */

var maze = {};

maze.config = {
    selectorMap: '.js-map',
    SelectorLoadingIcon: '.js-map-loading-icon ',
    length: 17,
    width: 17,
    chars: {
        0: '&nbsp;',
        1: '#',
        2: '&copy;'
    },

    splitChar: "-"

};

maze.validatePosition = function(x,y, char) {
    var element = jQuery("#" + x+maze.config.splitChar+y);
    if (element.text() == char) {
        return true;
    }
    return false;
}
maze.isWall = function (x, y) {
    return maze.validatePosition(x, y, maze.config.chars[1]);
}
maze.isCandy = function (x, y) {
    var element = jQuery("#" + x+maze.config.splitChar+y);
    if (element.hasClass("candy"))
        return true;
    return false;
}
maze.isOnExit = function (x, y) {
    if (x == (maze.config.width-1) && y == (maze.config.length-1))
        return true;
    return false;
}

maze.isLoaded = false;

maze.loadMap = function (map) {
    if (!maze.isLoaded) {
        $.each(map, function (index, value) {
            var singleLine = "";
            singleLine += maze.createStructure('', index, 'start');

            for (var i = 0; i < value.length; i++) {
                singleLine += maze.createStructure(maze.config.chars[value[i]], index, i);
            }

            singleLine += maze.createStructure('', 'map', index, 'end');
            $(maze.config.selectorMap).append(singleLine);
        });
    }
};

maze.createStructure = function (character, x, y) {
    var env;
    var candyclass = "";
    if (character == "&copy;")
        candyclass = "class='candy'";
    if (y === "start") {
        env = '<div ' + candyclass + ' id="' + x + '">' + character;
    } else if (y === "end") {
        env = character + '</div>';
    } else {
        env = '<span ' + candyclass + ' id="' + x + maze.config.splitChar + y + '">' + character + '</span>';
    }
    return env;
};


function loadJson() {
    var url = location.protocol
                + '//' 
                + location.host 
                + location.pathname 
                + 'api/maze?x='
                + maze.config.width
                +'&y='
                + maze.config.length;
    $(maze.config.SelectorLoadingIcon).show();
    $(maze.config.selectorMap).html('');
    $.get(url, function (response) {
        $(maze.config.SelectorLoadingIcon).hide();
        //console.log(response);
        maze.loadMap(response);
    });
}

function saveScore(name, points, timeInSeconds) {
    var url = location.protocol + '//' + location.host + location.pathname + 'api/highscore';
    $.ajax({
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

$(function () {
    if($(maze.config.selectorMap).length)
    loadJson();
});