/*
 * bugspray
 * Copyright 2009 a2h - http://a2h.uni.cc/
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * http://a2h.github.com/bugspray/
 *
 */

function changestatus(id,status,assigns)
{
	// assigns list
	var a;
	for (var i in assigns)
	{
		a += '<option value="'+assigns[i][0]+'">'+assigns[i][1]+'</option>';
	}
	
	// show it	
	$.amwnd({
		title:'Change status',
		content:'Hello! You can change the status of this issue here; just select an option.<br /><br />\
		<form id="st" method="post" action="manage_issue.php?id='+id+'&status">\
			<input type="radio" name="st" value="0" id="st0" /> <label for="st0">Open</label> <br />\
			<input type="radio" name="st" value="1" id="st1" /> <label for="st1">Assigned to</label> <select id="st1a">'+a+'</select> (doesn\'t work right now)<br />\
			<input type="radio" name="st" value="2" id="st2" /> <label for="st2">Resolved</label> <br />\
			<input type="radio" name="st" value="3" id="st3" /> <label for="st3">Duplicate of</label> <input type="text" id="st3a" /> (doesn\'t work right now) <br />\
			<input type="radio" name="st" value="4" id="st4" /> <label for="st4">By design</label> <br />\
			<input type="radio" name="st" value="5" id="st5" /> <label for="st5">Declined</label> <br />\
			<input type="radio" name="st" value="6" id="st6" /> <label for="st6">Non-issue</label> <br />\
			<input type="radio" name="st" value="7" id="st7" /> <label for="st7">Spam</label> <br />\
			<br />\
			<div class="ibox_generic">\
				<b>You may enter some additional notes here. These will be posted in the comments. If you do not wish to write any, leave the box blank.</b> (doesn\'t work right now)\
				<br /><br />\
				<textarea cols="60" rows="2" class="mono" id="notes"></textarea>\
			</div>\
		</form>',
		buttons:['ok','cancel'],
		closer:'cancel'
	});
	
	// which status is current?
	$("#st"+status).attr({'checked':'checked'});
	
	// and when you click ok...
	$("#amwnd_ok").bind('click',function() {
		$("#st").submit();
	});
}

function confirmurl(title,url,permanent)
{
	var a = '';
	if (permanent)
	{
		a = '<br /><br /><div class="ibox_alert"><img src="img/alert/exclaim.png" alt="" /> <b>This cannot be undone!</b></div>';
	}
	
	$("#amwnd_yes").bind('click',function() {
		location.href = url;
	});
	
	$.amwnd({
		title:title,
		content:'Are you sure you want to do this?'+a,
		buttons:['yes','no'],
		closer:'no'
	});
}

function stringform(title,url)
{
	var a = '';
	if (url)
	{
		a = ' action="'+url+'"';
	}
	
	$.amwnd({
		title:title,
		content:'<form id="st" method="post"'+a+'>Enter the value: <input type="text" name="str" /><input type="hidden" name="sub" /></form>',
		buttons:['ok','cancel'],
		closer:'cancel'
	});
	$("#amwnd_ok").bind('click',function() {
		$("#st").submit();
	});
}