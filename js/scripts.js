// scripts.js //
var lat;
var lon;
var rm;
var text;
var t_out;
var interval = 7000;
var cnt = 1000;
var settimer;
var timer_interval = 1000;
var clock;
var clock_clicked = false;
var clock_state = "stopped";
var numrows;
var num_rows = 0;
var secs;
var addmodal;
var addmodalcheckpoint = false;
var haskey = false;
var keypass = false;

// DOC READY START JQUERY FUNCTIONS ////
jQuery(document).ready(function () {

    rm = getParam("rm");
    //console.log(rm);
    if (rm === "") {
        init_geoFindMe();
    } else {
        checkPrivate();
    }

    jQuery("#letter_b, #letter_c").delay(5000).fadeOut(5000, function () {
        jQuery("#subheader").fadeOut(1000);
        jQuery("#letter_b").fadeIn(2000).html("B.");
        jQuery("#letter_c").fadeIn(3000).html("C.");
    });

    jQuery(document).on('click', '.flip-clock-wrapper', function (e) {
        clock_clicked = true;
        if (clock_state === "stopped") {
            clock_state = "started";
            jQuery.ajax({
                method: 'post',
                url: "stclk.php?rm=" + rm,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    //console.log("msg: " + obj.msgitems[0].msg);
                }
            });
            clock.start();
        }
        /*else {
        	clock_state = "stopped";
        	clock.stop();
        }
        */
    });

    CKEDITOR.replace("text-block");
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].on('change', function () {
            CKEDITOR.instances[i].updateElement();
        });
    }
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].on('blur', function () {
            CKEDITOR.instances[i].updateElement();
        });
    }

    jQuery(document).on('click', '#key', function (e) {
        //console.log("clicked key");
        $('#myModal').modal();
    });
    jQuery(document).on('click', '.isimage', function (e) {
        var imagepath = jQuery(this).data("href");
        //console.log("clicked isimage: " + imagepath);
        jQuery(".passed_image").attr("src", imagepath);
        $('.myModal4').modal();
    });

    jQuery(document).on('click', '#checkrmkey', function (e) {
        //console.log("clicked check key button");
        var rmkey = jQuery("#rmkey").val();
        //console.log(rmkey);
        jQuery.ajax({
            method: 'post',
            url: "check_rm.php?rm=" + rm + "&rmkey=" + rmkey,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                //console.log("msg: " + obj.msgitems[0].rmkey);
                if (obj.msgitems[0].rmkey == "Pass") {
                    keypass = true;
                    getData();
                    $('#myModal2').modal('hide');
                }
            }
        });
        return false;
    });

    //    jQuery(document).on('click', '#trash-all-links', function (e) {
    //        trashLinks();
    //    });

    jQuery(document).on('click', '#trash-all-text', function (e) {
        $('#myModal3').modal();
    });
    jQuery(document).on('click', '#del-ok', function (e) {
        trashText();
    });

    jQuery(document).on('click', '.linkblockbutton', function (e) {
        var lnk = jQuery("#link-block").val();
        jQuery.ajax({
            method: 'post',
            url: "pss_chg.php?rm=" + rm + "&data=" + lnk + "&type=link",
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                jQuery("#link-block").val("");
                jQuery('.btn-primary').prop('disabled', 'disabled');
                geoFindMe();
            }
        });
    });
    jQuery("#link-block").keyup(function (event) {
        if (event.keyCode == 13) {
            var lnk = jQuery("#link-block").val();
            jQuery.ajax({
                method: 'post',
                url: "pss_chg.php?rm=" + rm + "&data=" + lnk + "&type=link",
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    jQuery("#link-block").val("");
                    jQuery('.btn-primary').prop('disabled', 'disabled');
                    geoFindMe();
                }
            });
        }
    });

    jQuery(document).on('click', '.textblockbutton', function (e) {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        }
        var text = jQuery("textarea#text-block").val();
        //alert(text);
        jQuery.ajax({
            method: 'post',
            url: "pss_chg.php?rm=" + rm + "&data=" + encodeURIComponent(text) + "&type=text",
            success: function (data) {
                //alert(data);
                var obj = jQuery.parseJSON(data);
                jQuery("textarea#text-block").val("");
                jQuery('.btn-primary').prop('disabled', 'disabled');
                var theeditor = "text-block";
                CKEDITOR.instances['text-block'].setData('');
                geoFindMe();
            }
        });
    });
    /*jQuery("#text-block").keyup(function(event){
    	if(event.keyCode == 13){
    		var text = jQuery("textarea#text-block").val();
    		jQuery.ajax({
    			method: 'post',
    			url: "pss_chg.php?rm="+rm+"&data="+text+"&type=text",
    			success: function(data) {
    					var obj = jQuery.parseJSON(data);		
    					//console.log("msg: "+obj.msgitems[0].msg);
    					jQuery("textarea#text-block").val("");
    					jQuery('.btn-primary').prop('disabled', 'disabled');
    					geoFindMe();
    			  }
    		});
    	}
    });*/

    jQuery(document).on('click', '.fileblockbutton', function (e) {
        // var path = jQuery("#path-block").val();

        var form = document.getElementById('uploadfile');
        var formData = new FormData(form);

        for (var [key, value] of formData.entries()) {
            //console.log(key, value);
        }

        jQuery.ajax({
            method: 'post',
            url: "upld.php",
            // Form data
            data: formData,
            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //console.log(data);
                var obj = jQuery.parseJSON(data);
                //console.log("msg: " + obj.msgitems[0].msg);
                jQuery('.btn-primary').prop('disabled', 'disabled');
                jQuery("#file").val("");
                getData();
            }
        });

        return false;
    });

    /*jQuery("#path-block").keyup(function(event){
    	if(event.keyCode == 13){
    		var path = jQuery("#path-block").val();
    		jQuery.ajax({
    			method: 'post',
    			url: "pss_chg.php?rm="+rm+"&data="+path+"&type=path",
    			success: function(data) {
    					var obj = jQuery.parseJSON(data);
    					//console.log("msg: "+obj.msgitems[0].msg);	
    					jQuery('.btn-primary').prop('disabled', 'disabled');
    					geoFindMe();
    			  }
    		});
    	}
    });*/

});

function init_geoFindMe() {

    var out = jQuery("#out");
    var urlout = jQuery("#urlout");
    var tb = jQuery("#text-block");
    var ib = jQuery("#img-block");
    var pb = jQuery(".path-block");

    if (!navigator.geolocation) {
        //console.log("Geolocation is not supported by your browser");
        return;
    }

    function success(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        lat = latitude;
        lon = longitude;

        jQuery.getJSON("pss_lat_lon.php?lat=" + lat + "&lon=" + lon + "&rm=" + getParam("rm"), function (data) {
            //console.log(data.msgitems);

            jQuery("#textblock_output").html("");
            jQuery("#linkblock_output").html("");
            jQuery("#pathblock_output").html("");
            if (data.msgitems != null) {
                jQuery.each(data.msgitems, function (index, value) {

                    //console.log("data: " + value.data);
                    //console.log("type: " + value.type);

                    rm = value.rm;
                    urlout.attr("href", "https://www.brushcontact.com/?rm=" + rm);
                    urlout.html(rm);
                    jQuery("#rm").val(rm);
                    if (haskey == false) {
                        out.html(lat + " " + lon);
                    }
                    window.history.replaceState({}, '/', '/?rm=' + rm);

                    jQuery('textarea[name="text-block"]').prop('disabled', false);
                    jQuery('input[name="link-block"]').prop('disabled', false);
                    jQuery('input[id="file"]').prop('disabled', false);
                    jQuery('.btn-primary').prop('disabled', false);

                    if (value.type == "text") {
                        jQuery('textarea[name="text-block"]').html("");
                        jQuery('#textblock_output').append("<div class='txtblock'>" + value.data + "</div>");
                    }
                    //                    if (value.type == "link") {
                    //                        jQuery('input[name="link-block"]').html("");
                    //                        jQuery('#linkblock_output').prepend("<div class='lnkblock'><a href=" + value.data + " target='_blank'>" + value.data + "</a></div>");
                    //                    }
                    if (value.type == "path") {
                        var extension = value.data.split('.').pop();
                        //console.log(extension);
                        if (extension == "png" || extension == "jpg" || extension == "gif" || extension == "jpeg") {
                            jQuery('#pathblock_output').append("<div class='pathblock'><span class='isimage' data-href=" + value.data + " target='_blank'>" + value.data + "</span></div>");
                        } else {
                            jQuery('#pathblock_output').append("<div class='pathblock'><a href=" + value.data + " target='_blank'>" + value.data + "</a></div>");
                        }
                    }

                });
            }
            getCountDown();
            t_out = setTimeout(function () {
                geoFindMe();
            }, interval);
        });
    };

    function error() {
        //console.log("Unable to retrieve your location");
    };

    navigator.geolocation.getCurrentPosition(success, error);
}

function geoFindMe() {
    clearInterval(t_out);

    if (getParam("rm")) {
        //console.log(getParam("rm"));
        getData();
    } else {
        init_geoFindMe();
    }

    t_out = setTimeout(function () {
        geoFindMe();
    }, interval);
}

function getData(state) {

    var urlout = jQuery("#urlout");

    jQuery.getJSON("pss_lat_lon.php?rm=" + getParam("rm"), function (data) {
        //console.log("msgitems: "+data.msgitems);

        if (data.msgitems != null) {
            jQuery.each(data.msgitems, function (index, value) {

                //console.log("data: " + value.data);
                //console.log("type: " + value.type);
                //console.log("index: " + index);

                //console.log("value.num_rows: " + value.num_rows);
                //console.log("numrows: " + numrows);
                numrows = value.num_rows;

                rm = getParam("rm");
                urlout.attr("href", "https://www.brushcontact.com/?rm=" + rm);
                urlout.html(rm);

                if (numrows > num_rows || state == "del") {
                    if (index == 0) {
                        jQuery("#textblock_output").html("");
                        jQuery("#linkblock_output").html("");
                        jQuery("#pathblock_output").html("");
                    }
                    if (value.type == "text") {
                        jQuery('textarea[name="text-block"]').html("");
                        jQuery('#textblock_output').append("<div class='txtblock'>" + value.data + "</div>");
                    }
                    //                    if (value.type == "link") {
                    //                        jQuery('input[name="link-block"]').html("");
                    //                        jQuery('#linkblock_output').prepend("<div class='lnkblock'><a href=" + value.data + " target='_blank'>" + value.data + "</a></div>");
                    //                    }
                    if (value.type == "path") {
                        var extension = value.data.split('.').pop();
                        if (extension == "png" || extension == "jpg" || extension == "gif" || extension == "jpeg") {
                            jQuery('#pathblock_output').append("<div class='pathblock'><span class='isimage' data-href=" + value.data + " target='_blank'>" + value.data + "</span></div>");
                        } else {
                            jQuery('#pathblock_output').append("<div class='pathblock'><a href=" + value.data + " target='_blank'>" + value.data + "</a></div>");
                        }
                    }
                }
            });
        }
        getCountDown();
        jQuery('textarea[name="text-block"]').prop('disabled', false);
        jQuery('input[name="link-block"]').prop('disabled', false);
        jQuery('input[id="file"]').prop('disabled', false);
        jQuery('.btn-primary').prop('disabled', false);
        jQuery("#textblock_output").animate({
            scrollTop: $('#textblock_output').prop("scrollHeight")
        }, 1000);
        num_rows = numrows;
    });
}

function getCountDown() {
    jQuery.getJSON("gtclk.php?rm=" + getParam("rm"), function (data) {
        //console.log("msgitems: "+data.msgitems);

        if (data.msgitems != null) {
            jQuery.each(data.msgitems, function (index, value) {
                var countdown = value.cd;
                //console.log("cd: "+countdown);

                var d = new Date(Date.parse(countdown));
                //console.log(d);
                var tm = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                //console.log(tm);

                var dt = new Date();
                //console.log(dt);
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                //console.log(time);

                var newtimer = new Date(dt - d);
                //console.log(newtimer.getSeconds());

                var _initial = countdown;
                var fromTime = new Date(_initial);
                var toTime = new Date();

                var differenceTravel = toTime.getTime() - fromTime.getTime();
                var seconds = Math.floor((differenceTravel) / (1000));
                //console.log("secs: "+seconds);

                var newsecs = 600 - seconds;
                if (newsecs >= 0 && newsecs <= 600) {
                    jQuery("#burnit-header").html("Time 'til Burn");
                    clock_state = "started";
                    clock_clicked = false;
                    setClockCountdown(600 - seconds);
                    clock.start();
                } else {
                    setClockCountdown(600);
                    if (countdown != "0000-00-00 00:00:00") {
                        trashAll();
                    }
                }
            });
        }
    });
}

function getParam(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function trashAll() {
    if (rm) {
        rm = rm;
    } else {
        rm = getParam("rm");
    }
    trashLinks(rm);
    trashText(rm);
    setClockCountdown(600);
}

function trashLinks(rm) {
    if (rm) {
        rm = rm;
    } else {
        rm = getParam("rm");
    }
    jQuery.ajax({
        method: 'post',
        url: "rmv.php?rm=" + rm + "&type=link",
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            //console.log("msg: "+obj.msgitems[0].msg);	
            jQuery("#link-block").val("");
            jQuery('.btn-primary').prop('disabled', 'disabled');
            getData("del");
        }
    });
}

function trashText(rm) {
    if (rm) {
        rm = rm;
    } else {
        rm = getParam("rm");
    }
    window.history.replaceState({}, '/', '/');
    jQuery("#pathblock_output, #textblock_output").html("");
    jQuery.ajax({
        method: 'post',
        url: "rmv.php?rm=" + rm + "&type=text",
        success: function (data) {
            //console.log(data);
            var obj = jQuery.parseJSON(data);
            //console.log("msg: "+obj.msgitems[0].msg);	
            jQuery("#text-block").val("");
            jQuery('.btn-primary').prop('disabled', 'disabled');
            getData("del");
        }
    });
}

function setClockCountdown(seconds) {
    //3600 = 60 min
    //  600 = 10 min
    if (seconds != "") {
        secs = seconds;
    } else {
        secs = 600;
    }
    //console.log(secs);
    clock = $('#timer-output').FlipClock(secs, {
        clockFace: 'MinuteCounter',
        autoStart: false,
        countdown: true,
        callbacks: {
            start: function () {
                if (clock_clicked === true) {
                    clock_clicked = false;
                }
            },
            stop: function () {
                if (clock_clicked === false) {
                    trashAll();
                    clock_state = "started";
                } else {
                    clock_clicked = false;
                }
            }
        }
    });
}

function checkPrivate() {
    jQuery.getJSON("check_private.php?rm=" + getParam("rm"), function (data) {
        // console.log(data.msgitems);

        if (data.msgitems != null) {
            jQuery.each(data.msgitems, function (index, value) {
                //console.log("data: " + value.data);
                //console.log("rmkey: " + value.rmkey);

                if (value.rmkey == "has") {
                    haskey = true;
                    $('#myModal2').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                //console.log("haskey: " + haskey + " keypass: " + keypass);
                if (haskey == true) {
                    if (keypass == true) {
                        getData();
                    }
                } else {
                    init_geoFindMe();
                }

            });
        }
    });
}