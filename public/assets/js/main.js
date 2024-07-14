var errNotif, doneNotif, loadNotif;
var log = console.log;

$(function () {
    window._token = $('meta[name="csrf-token"]').attr('content');
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function notif(type,icon,title,message,notifType){
    let option = {
        icon: icon,
        title: title,
        message: message,
    }
    let settings = {
        type: type,
        z_index: 1051,
        delay: 9000,
        timer: 1000,
        mouse_over: "pause",
        animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp"
        },
    }
    if(notifType == "error"){
        if(errNotif) errNotif.close();
        errNotif = $.notify(option,settings);
    } else {
        if(doneNotif) doneNotif.close();
        doneNotif = $.notify(option,settings);
    }
}

function notifLoading(message){
    if(loadNotif) loadNotif.close();
    loadNotif = $.notify({
        icon: "fas fa-info",
        title: "Memproses Data",
        message: message,
    },{
        type: "info",
        allow_dismiss: false,
        delay: 900000,
        timer: 1000,
        animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp"
        },
    });
}

function formLoading(form,obj,state,all = false){
    if(state){
        $disable = "input,textarea,select";
        if(all) $disable += ",button";
        $(form).find($disable).prop("disabled",true);
        $(obj).addClass("is-loading is-loading-lg");
    } else {
        $disable = "input,textarea,select,button";
        $(form).find($disable).prop("disabled",false);
        $(obj).removeClass("is-loading is-loading-lg");
    }
}

function pwGenerate(length){
    let password = "";
    for(i = 0; i < length; i++){
        password += "*";
    }
    return password;
}

function slugGenerate(Text) {
    return Text.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
  }