
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
    let el;

    el = document.getElementById('form_manage_admin');
    if (el) {
        el.style.display = "none";
        document.getElementById('icon_manage_admin').addEventListener('click', function(){
            RM.toggle('form_manage_admin');
        });
    }

    // show the hash location panel
    let hash = window.location.hash.slice(1);
    if (hash !== "") {
        document.getElementById(hash).style.display = "";
    }
}();

