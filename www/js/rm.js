
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

    el = document.getElementById('manage_page_content');
    if (el) {
        el.style.display = "none";
        document.getElementById('icon_manage_page').addEventListener('click', function(){
            RM.toggle('manage_page_content');
        });
    }

    el = document.getElementById('manage_images_content');
    if (el) {
        el.style.display = "none";
        document.getElementById('icon_manage_images').addEventListener('click', function(){
            RM.toggle('manage_images_content');
        });
    }

    el = document.getElementById('manage_admin_content');
    if (el) {
        el.style.display = "none";
        document.getElementById('icon_manage_admin').addEventListener('click', function(){
            RM.toggle('manage_admin_content');
        });
    }

    el = document.getElementById('manage_sessions_content');
    if (el) {
        el.style.display = "none";
        document.getElementById('icon_manage_session').addEventListener('click', function(){
            RM.toggle('manage_sessions_content');
        });
    }


    // show the hash location panel
    let hash = window.location.hash.slice(1);
    if (hash !== "") {
        document.getElementById(hash + '_content').style.display = "";
    }
}();

