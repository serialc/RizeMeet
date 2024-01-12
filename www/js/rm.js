
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
    let sections = ['sessions', 'admin', 'images', 'page', 'locations', 'style', 'backup'];

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

    // show the hash location panel
    let hash = window.location.hash.slice(1);
    if (hash !== "") {
        document.getElementById(hash + '_content').style.display = "";
    }
}();

