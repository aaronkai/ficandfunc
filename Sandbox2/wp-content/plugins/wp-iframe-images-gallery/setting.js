/**
 *     iFrame Images Gallery
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


function iframe_submit()
{
	if(document.iframe_form.iframe_path.value=="")
	{
		alert("Please enter the image path.")
		document.iframe_form.iframe_path.focus();
		return false;
	}
	if((document.iframe_form.iframe_order.value!="") && isNaN(document.iframe_form.iframe_order.value))
	{
		alert("Please enter the display order, only number.")
		document.iframe_form.iframe_order.focus();
		return false;
	}
	if(document.iframe_form.iframe_type.value=="")
	{
		alert("Please select the gallery group.")
		document.iframe_form.iframe_type.focus();
		return false;
	}
}

function iframe_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_iframe_display.action="options-general.php?page=wp-iframe-images-gallery/wp-iframe-images-gallery.php&AC=DEL&DID="+id;
		document.frm_iframe_display.submit();
	}
}	

function iframe_redirect()
{
	window.location = "options-general.php?page=wp-iframe-images-gallery/wp-iframe-images-gallery.php";
}

function iframe_help()
{
	window.open("http://www.gopiplus.com/work/2011/07/24/wordpress-plugin-wp-iframe-images-gallery/");
}
