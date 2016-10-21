jQuery(document).ready(function() {
    jQuery('input#input_text').characterCounter();
    if(jQuery(maze.config.selectorMap).length)
    	loadJson();
});

function validate() {
	if (jQuery("#first_name").val() == "") {
		jQuery("#first_name").toggleClass("invalid");
	} else {
		game.startGame();
	}
}

function loadJson() {
    var url = location.protocol
                + '//' 
                + location.host 
                + location.pathname 
                + 'api/maze?x='
                + maze.config.width
                + '&y='
                + maze.config.length
                + '&candyCount='
                + maze.config.candyCount;
    jQuery(maze.config.SelectorLoadingIcon).show();
    jQuery(maze.config.selectorMap).html('');
    jQuery.get(url, function (response) {
        jQuery(maze.config.SelectorLoadingIcon).hide();
        //console.log(response);
        maze.loadMap(response);
    });
}