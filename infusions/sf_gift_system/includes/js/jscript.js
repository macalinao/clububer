/*Combo Box Image Selector:
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free JavaScript here!
*/

function showimage() {
	if (!document.images)
	return
	document.images.giftimage.src=
	document.giftform.gift_image.options[document.giftform.gift_image.selectedIndex].value
}