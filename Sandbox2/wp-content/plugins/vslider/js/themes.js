var $jq=jQuery.noConflict();$jq(document).ready(function(){var csvURL='https://spreadsheets2.google.com/spreadsheet/pub?hl=en_US&hl=en_US&key=0ArSajYZ8A9I8dElHQUNESEdEYzVCWXZ3ZXBVakR6NUE&output=csv';var yqlURL="http://query.yahooapis.com/v1/public/yql?q="+"select%20*%20from%20csv%20where%20url%3D'"+encodeURIComponent(csvURL)+"'%20and%20columns%3D'vslidertitle%2Cvslidertut'&format=json&callback=?";$jq.getJSON(yqlURL,function(msg){var dl=$jq('<dl>');$jq.each(msg.query.results.row,function(){var vslidertut=this.vslidertut.replace(/""/g,'"').replace(/^"|"$/g,'');var vslidertitle=this.vslidertitle.replace(/""/g,'"').replace(/^"|"$/g,'');dl.append('<div class="theme"><dt>'+vslidertitle+'</dt><dd>'+vslidertut+'</dd></div>')});$jq('#themes').append(dl);$jq('dt').live('click',function(){var dd=$jq(this).next();if(!dd.is(':animated')){dd.slideToggle();$jq(this).toggleClass('opened')}});$jq('a.button').click(function(){if($jq(this).hasClass('collapse')){$jq('dt.opened').click()}else $jq('dt:not(.opened)').click();$jq(this).toggleClass('expand collapse');return false})})});