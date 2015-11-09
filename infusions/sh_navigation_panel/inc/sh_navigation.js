/*
 * Slider Navigation
 * Description: Navigation used in theme Slider from Counterjumper
 * Version: 1.0.2
 * Author: Karmadude
 * Author URI: http://counterjumper.com/
 *
 * Slider 1.0.2
 *
 * This navigation was designed and built by Karmadude
 *
 *
 */

jQuery.noConflict();

var accordion = true;

var sidebar =
{
    init: function()
    {
        jQuery("#navigation div[@id$=Content]").each(function(i){
            jQuery(this).addClass("sliderContent");

            var id = this.id.replace(/Content/g, "");
            sidebar.createClickEvent(id);
            sidebar.initFromCookies(id);
        });
    },

    initFromCookies: function(id)
    {
        if( accordion )
        {
            var prevID = jQuery.cookie('SliderAccordionID');
            if( id + 'Content' == prevID )
                this.handleClick(id);

        }
        else
        {
            var st = jQuery.cookie(id + 'ContentState');

            if( st == "block" )
                this.handleClick(id);
        }
    },

    createClickEvent: function(id)
    {
        jQuery("#" + id + "Link").click(function() {
            sidebar.handleClick(id);
         });
    },

    handleClick: function(id)
    {
        id += "Content";

        if( accordion )
        {
            var prevID = jQuery.cookie('SliderAccordionID');
            if( id != prevID && jQuery("#" + prevID).css("display") == 'block' )
                jQuery("#" + prevID).slideToggle("fast");
        }

        var st = getToggledState(jQuery("#" + id).css("display"));
        jQuery("#" + id).slideToggle("fast");

        if( accordion )
            jQuery.cookie("SliderAccordionID", id, {expires: 30, path: '/'});
        else
            jQuery.cookie(id + "State", st, {expires: 30, path: '/'});


    }
};

function getToggledState(state)
{
    if( state == "block" )
        return "none";
    else
        return "block";
}

jQuery(document).ready(function()
{
    sidebar.init();
});