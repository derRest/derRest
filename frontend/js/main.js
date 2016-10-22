function formSubmit(event) {
    event.preventDefault();

    var $name = $("#nameInput");
    if ($name.val() == "") {
        $name.toggleClass("invalid");
    } else {
        game.startGame($name.val());
    }

    return false;
}

function loadJson() {
    var url = location.protocol + '//' + location.host + location.pathname
        + 'api/maze?x=' + maze.config.width
        + '&y=' + maze.config.height
        + '&candyCount=' + maze.config.candyCount;

    $(maze.config.SelectorLoadingIcon).show();
    $(maze.config.selectorMap).html('');
    $.get(url, function (response) {
        $(maze.config.SelectorLoadingIcon).hide();
        //console.log(response);
        maze.load(response);
    });
}

$(function () {
    $('input#nameInput').characterCounter();//Was macht das?

    if ($(maze.config.selectorMap).length) {
        loadJson();
    }
});
