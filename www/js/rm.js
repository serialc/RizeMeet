
RM = {};

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
    document.getElementById('form_manage_admin').style.display = "none";
    document.getElementById('icon_manage_admin').addEventListener('click', function(){
        RM.toggle('form_manage_admin');
    });

    document.getElementById('form_regular_schedule').style.display = "none";
    document.getElementById('icon_regular_schedule').addEventListener('click', function(){
        RM.toggle('form_regular_schedule');
    });
}();

