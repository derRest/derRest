function formSubmit(event) {
    event.preventDefault();

    var $name = $("#nameInput");
    if ($name.val() === "") {
        $name.toggleClass("invalid");
    } else {
        loadJson($name.val());
    }

    return false;
}

function loadJson(name) {
    $(maze.config.SelectorLoadingIcon).show();

    var url = location.protocol + '//' + location.host + location.pathname
        + 'api/maze?x=' + maze.config.width
        + '&y=' + maze.config.height
        + '&candyCount=' + maze.config.candyCount;
    $(maze.config.selectorMap).html('');
    $.get(url, function (response) {
        //console.log(response);
        maze.load(response);
        $(maze.config.SelectorLoadingIcon).hide();
        game.start(name);
    });
}

$('input#nameInput').characterCounter();//Was macht das?
