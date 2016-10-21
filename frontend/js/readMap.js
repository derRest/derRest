/**
 * Created by JanJJ on 18.10.2016.
 */

var maze = {};

maze.config = {
    selectorMap: '.js-map',
    SelectorLoadingIcon: '.js-map-loading-icon ',

    chars: {
        0: '__',
        1: '##',
        2: '&#127852;'
    },

    splitChar: "-"

};


maze.loadMap = function (map) {
    $.each(map, function (index, value) {
        var singleLine = "";
        singleLine += maze.createStructure('', index, 'start');

        for (var i = 0; i < value.length; i++) {
            singleLine += maze.createStructure(maze.config.chars[value[i]], index, i);
        }

        singleLine += maze.createStructure('', 'map', index, 'end');
        $(maze.config.selectorMap).append(singleLine);
    })
};

maze.createStructure = function (character, x, y) {
    var env;
    if (y === "start") {
        env = '<div id="' + x + '">' + character;
    } else if (y === "end") {
        env = character + '</div>';
    } else {
        env = '<span id="' + x + maze.config.splitChar + y + '">' + character + '</span>';
    }
    return env;
};


function loadJson() {
    var url = location.protocol + '//' + location.host + location.pathname + 'api/maze?x=11&y=15';
    $(maze.config.SelectorLoadingIcon).show();
    $(maze.config.selectorMap).html('');
    $.get(url, function (response) {
        $(maze.config.SelectorLoadingIcon).hide();
        console.log(response);
        maze.loadMap(response);
    });
}
$(function () {
    loadJson();
});