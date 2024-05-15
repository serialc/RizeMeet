
RM = {};

RM.copyToClipboard = function(val)
{
    navigator.clipboard.writeText(val);
};

RM.toggle = function(tid)
{
    let el = document.getElementById(tid);
    if ( el.style.display === "none" ) {
        el.style.display = "";
    } else {
        el.style.display = "none";
    }
};

RM.init = function()
{
    let s;
    let sections = ['regular_event', 'sessions', 'admin', 'images', 'page', 'locations', 'style', 'backup'];

    for(s in sections) {
        // define section with let in iteration to prevent lexical scoping
        let section = sections[s];
        let el = document.getElementById('manage_' + section + '_content');

        if (el) {
            el.style.display = "none";
            document.getElementById('icon_manage_' + section)
                .addEventListener('click', function(){
                    RM.toggle('manage_' + section + '_content');
                }
            );
        }
    }

    // get the hash value without '#'
    let hash = window.location.hash.slice(1);
    // show the location panel with the id of the hash value (plus extension '_content' if it exists)
    if (hash !== "" && document.getElementById(hash + '_content') ) {
        document.getElementById(hash + '_content').style.display = "";
    }
}();

