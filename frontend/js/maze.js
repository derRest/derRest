var maze = {};

maze.config = {
    selectorMap: '.js-map',
    SelectorLoadingIcon: '.js-map-loading-icon ',
    height: 17,
    width: 17,
    splitChar: "-",
    candyCount: 10,
    markingWallhits: true,
    chars: {
        0: '&nbsp;',
        1: '#',
        2: '&copy;'
    }
};

maze.validatePosition = function (x, y, char) {
    var element = $("#" + x + maze.config.splitChar + y);
    return element.text() === char;
};
maze.isWall = function (x, y) {
    var isWall = maze.validatePosition(x, y, maze.config.chars[1]);
    return isWall;
};
maze.isCandy = function (x, y) {
    var element = $("#" + x + maze.config.splitChar + y);
    return element.hasClass("candy");

};
maze.isOnExit = function (x, y) {
    //x ^= height;
    var exitPositions = [
        (maze.config.height - 1) + '#' + (maze.config.width),
        (maze.config.height - 2) + '#' + (maze.config.width),
        (maze.config.height) + '#' + (maze.config.width - 1),
        (maze.config.height) + '#' + (maze.config.width - 2)
    ];
    return exitPositions.indexOf(x + '#' + y) !== -1;

};

maze.isLoaded = false;

maze.load = function (map) {
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

maze.unload = function () {
    $(maze.config.selectorMap).html('');
};

maze.createStructure = function (character, x, y) {
    var env;
    var candyclass = "";
    if (character === maze.config.chars[2]) //candy
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

maze.printResult = function (points, time) {
    var result = "<h3><b>SUCCESS!</b> you earned " + points + " Points</h3>";
    result += "<p>It took you " + time + "s to succeed</p>";
    result += "<p>You collected " + game.player.collectedCandies + " of " + maze.config.candyCount + "</p>";
    result += "<p>You hit " + game.player.keyCountWall + " Walls</p>";
    $(maze.config.selectorMap).html(result);
};

