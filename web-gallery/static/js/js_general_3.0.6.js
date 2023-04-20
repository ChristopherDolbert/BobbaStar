/* HABBOTIMES FINAL V6 3.0.X | MADE FOR FANS */

window.addEvent('domready', function()
{		
	// TAG CLOUD
	try{ TagCanvas.textColour = '#0891c4'; TagCanvas.outlineColour = '#cccccc'; TagCanvas.depth = 0.8; TagCanvas.weight = 1; TagCanvas.reverse = 1; TagCanvas.Start('cloud'); } catch(e) { }
	
	// FACEBOOK SOCIAL PLUGIN	
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script'));
		
	// HT
	if($('ht')){ alive(1); }
	
	// LOGIN
	if($('acceptTerms')){ $('acceptTerms').set('checked',false); $('vReg1').set('value',''); $('vReg2').set('value',''); $('vReg3').set('value',''); }

	// ARTICLE
	prepareAList();
	if($('articlesearchinput')){ $('articlesearchinput').addEvent('keydown', function(e){ if(e.key == "enter"){ articleSearch(); }}); }

	// STREAM
	streamStart();
	var sqy = Math.floor(window.innerHeight*0.8); if(sqy < 200){ sqy = 200; }
	SqueezeBox.initialize({size: {x: 425, y: sqy}});
	if($('streamcnt')){ $('streamcnt').value = 5; }
	if($('streamcntw')){ $('streamcntw').value = 5; }
	if($('streamcntn')){ $('streamcntn').value = 3; }
	if($('reportsforum')){ $('reportsforum').setStyle('opacity',0); getReportsCount(); }
	
	// LOADING
	if($('loading')){ visuellLoading(); }
	
	// NEW ALERT
	// if($('nav')){ $('nav').getElements('.newalert').each(function(e){ setNewAlert(e); }); }
	
	// NAV CLICK
	if($('nav')){ $('nav').getElements('a').each(function(e){ e.addEvent('mousedown', function(t){ e.setStyle('opacity',0.75); }); }); }
	
	// SHOW OPTIONS
	if($('lang')){ $('lang').addEvent('click', function(e){ try{ e.setStyle('height','auto');}catch(e){ return; } } ); }
	if($('articleskat')){ $('articleskat').addEvent('click', function(e){ e.setStyle('height','auto');} ); }
	
	// TOOLTIP
	var tooltips = new Tips('.tooltip', {className: 'tooltip', text: false});
	tooltips.addEvent('show', function(tip, el){ tip.setStyle('opacity',0.9); });
	var tooltips2 = new Tips('.tooltip2', {className: 'tooltip', text: false});
});

window.addEvent('load', function()
{
	ReMooz.assign('#gallery a', {
		origin: 'img'
	});
});

// ANIMATE HT
function alive(i)
{
	switch(i){
		case 1: $('ht').setStyle('background-position','right bottom'); setTimeout('alive(2)',200); break;
		case 2: $('ht').setStyle('background-position','left bottom' ); setTimeout('alive(1)',(Math.random()*5000+1000)); break;
	}
}

// SET LANG
function setL(v)
{
	Cookie.write('HTLang', v, {duration: 7});
	location.reload();
}

// FADE
var fcnt = 0;
function fadeC(v){ var e = $(v); if(e){ e.setStyle('opacity',0); setTimeout('fadeI(\''+v+'\')', (1000+(fcnt*250))); fcnt++; } }
function fadeI(v){ var e = $(v); if(e){ e.fade(1); }}

// LOGIN
var opnl = false;
function opnLogin()
{
	if(opnl == false)
	{
		$('login2').setStyle('opacity',0); 
		if($('logo')){ $('logo').fade(0); } if($('logode')){ $('logode').fade(0); }
		if($('headinner')){ $('headinner').fade(0); }
		$('login2').morph({'margin-top':10,'opacity':1}); opnl = true;
	}else{ closeLogin(); }
}

function closeLogin()
{
	if($('logo')){ $('logo').fade(1); } if($('logode')){ $('logode').fade(1); }
	if($('headinner')){ $('headinner').fade(1); }
	$('login2').morph({'margin-top':-500,'opacity':0}); opnl = false;
}

function switchRegLog(v)
{ 
	$('logininner').tween('margin-left',v); 
	if(v == 0 && $('acceptTerms')){ acceptT = true; acceptTerms(); $('acceptTerms').set('checked',false); }
}

var acceptT = false; function acceptTerms(){ if(acceptT == false){ acceptT = true; $('loginterms').tween('height',60); }else{ acceptT = false; $('loginterms').tween('height',90); } checkReg1(); }
var enterC  = false; function enterConfirm(){ if($('confirm_copy').value.length > 3){ enterC = true; }else{ enterC = false; } $('confirm_copy').value == $('confirm_code').value; checkReg1(); }

function checkReg1()
{
	if(acceptT == true && enterC == true){
		if($('logintermsnext').getStyle('display') == 'none'){ $('logintermsnext').setStyles({'display':'block','opacity':0}); $('logintermsnext').fade(1); }
	}else{
		$('logintermsnext').setStyles({'display':'none','opacity':0});
	}
}

var validateR = false;
function validateReg()
{
	if(acceptT == true)
	{
		if($('vReg1').value.length > 3 && $('vReg2').value.length > 5 && $('vReg3').value.length > 5 && validateMail($('vReg2').value))
		{
			if(validateR == false)
			{
				$('loginregwarn').setStyle('display','none'); validateR = true;
				$('logindatanext').setStyles({'display':'block','opacity':0}); $('logindatanext').fade(1);
			}
		}else{
			if(validateR == true)
			{
				$('loginregwarn').setStyles({'display':'block','opacity':0}); $('loginregwarn').fade(1);
				$('logindatanext').setStyles({'display':'none','opacity':0}); validateR = false;
			}
		}
	}
}

function validateMail(v)
{
	re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(re.test(v)){ return true; }else{ return false; }
}

// VERIFY
var validateV = false;
function validateVer(){	if($('vVer1').value.length > 3){ if(validateV == false){ $('loginverifynext').setStyles({'display':'block','opacity':0}); $('loginverifynext').fade(1); validateV = true; } }else{ $('loginverifynext').fade(0); validateV = false; } }

function verifyHabbo()
{
	$('verifyinner').setStyle('opacity',0);
	
	var n = $('vVer1').value;
	var v = $('vVer2').value;
	
	if(n != '' && v != '')
	{
		var req = new Request({
			url: './site/ajax.php?s=verify2',
			method: 'post',
			onSuccess: function(r){ verifyHabbo2(r); }				
		});
		req.send("a=cvd&v="+v+"&n="+n);	
	}
}

function verifyHabbo2(r)
{
	$('verifywarn').setStyle('display','none');
	$('verifyok').setStyle('display','none');
	
	switch(r)
	{ 
		case '1': $('verifyok').setStyle('display','block'); $('verifywarn').setStyle('display','none'); break;
		default: $('verifywarn').setStyle('display','block'); $('verifyinner').fade(1); break;
	}
}

// ARTICLE
var articlecnt = 0; var articlekat = '';
function getMoreArticle(r,k,t)
{
	articlecnt = articlecnt + 3;
	if(r == 1){	$('articlelist').set('html',''); articlecnt = 0; articlekat = k; $('articleskatselect').set('html',t); }
	var th = 1; var to = 0; var td = 'none'; if(k == 0 || k == ''){ th = 175; to = 1; td = 'inherit'; }
	if($('topnews')){ $('topnews').morph({'height':th,'opacity':to}); $('topnews2').setStyle('display',td); }
	var t = $('articlesmore').get('html'); $('articlesmore').set('html','&nbsp;'); $('articlesmore').addClass('loading');
	var req = new Request.HTML({
		url: '/site/ajax.php?s=articles', method: 'post', data: { 'c': 'gmh', 's': articlecnt, 'k': articlekat }, 
		onSuccess: function(e){ $('articlesmore').removeClass('loading'); $('articlesmore').set('html',t); prepareAList(); 
		$$('#gallery a').each(function(e){ if(!e.hasClass('remooz-element')){ new ReMooz(e); }}); },
		append: $('articlelist')
	});
	req.send();
}

function prepareAList()
{
	if($('articles'))
	{
		$('articles').getElements('.articlemore').each(function(e){
			e.setStyle('opacity',0.01);
			e.addEvent('mouseenter', function(){ e.fade(1.0); })
			e.addEvent('mouseleave', function(){ e.fade(0.01); })
		});
	}
}

var articlels = "";
function articleSearch()
{
	var v = $('articlesearchinput').value;
	if(v != '' && v != articlels)
	{
		if($('topnews')){ $('topnews').morph({'height':1,'opacity':0}); $('topnews2').setStyle('display','none'); }
		articlels = v; $('articlelist').set('html','');
		var req = new Request.HTML({
			url: '/site/ajax.php?s=articles', method: 'post', data: { 'c': 'fmh', 'f': v }, 
			append: $('articlelist')
		});
		req.send();
	}
}

// STREAM
function sendFR(u)
{
	$('sendFR').morph({'opacity':0,'height':0,'padding':0}); setTimeout(function(){ $('sendFR').destroy(); },1000);
	var req = new Request({url: './site/ajax.php?s=stream'});
	req.send("a=afr&u="+u);	
}

function handleFR(i,s)
{
	$('fno'+i).fade(0); $('fok'+i).fade(0); 
	var req = new Request({url: './site/ajax.php?s=stream'});
	req.send("a=hfr&i="+i+"&s="+s);	
}

function deleteF(f)
{
	$('friend'+f).morph({'height':0,'opacity':0});
	var req = new Request({url: './site/ajax.php?s=stream'});
	req.send("a=def&f="+f);	
}

function opnStream(i)
{
	if($('streamadd')){ streamHideAdd('streamadd'); $('streamadd').set('html',''); }
	SqueezeBox.open('/site/ajax.php?s=stream&a=gsb&i='+i);
}

function streamStart()
{
	if($('sendinput'))
	{
		$('sendinput').addEvent('keyup', function(){ checkSendInput(); })
		$('sendinput').value = ''; $('sendmsg').setStyle('opacity',0.2);
		if(slc == 0){ $('sendinput').removeProperty('disabled'); }
	}
}

function streamShowAdd(v)
{
	var d = 'streamsend';
	if(v == 1){	d = 'streamadd'; if($(d).get('html') == ''){ var req = new Request.HTML({url: '/site/ajax.php?s=stream', data: {'a': 'gab'}, append: $('streamadd'), onSuccess: function(e){ streamStart(); }}); req.send(); }}

	if($(d))
	{
		if($(d).getStyle('height') == '1px'){
			$(d).setStyles({'height':1,'opacity':0,'display':'block'});
			$(d).morph({'height':135,'opacity':1});
		}else{
			streamHideAdd(d);
		}
	}
}

function streamHideAdd(d)
{
	setTimeout(function(){ $(d).setStyle('display','none'); }, 500);
	$(d).morph({'height':1,'opacity':0});	
}

function checkSendInput()
{
	$('sendinput').value = $('sendinput').value.replace(/[^a-zA-Z 0-9_äüöÄÜÖ\(\)\:\.\*\?\=\!\&\[\]\+\~\ß\,\/\-\_\#\♥\Á\á\ç\É\é\Í\í\Ñ\ñ\Ó\ó\Ú\ú\¿\À\� \Â\â\Æ\æ\Ç\ç\È\è\Ê\ê\Ë\ë\Î\î\Ï\ï\Ô\ô\Œ\œ\Ù\ù\Û\û\Ÿ\ÿ^\%\$\^\°\@]/g,'');
	
	var c = 200-$('sendinput').value.length;
	$('sendcnt').set('html',c);
	if(c < 15){ $('sendcnt').addClass('sendcntred'); }else{ $('sendcnt').removeClass('sendcntred'); }
	
	if(c <= 190)
	{ 
		$('sendmsg').removeProperty('disabled'); 
		$('sendmsg').setStyle('cursor','pointer'); 
		$('sendmsg').setStyle('opacity',1); 
	}else{ 
		$('sendmsg').setProperty('disabled','disabled');
		$('sendmsg').setStyle('cursor','auto'); 
		$('sendmsg').setStyle('opacity',0.2);  
	}
}

var slc = 0;
function sendLock(m)
{
	if(m != 0)
	{ 
		slc = m; 
		$('sendinput').value = '';
		$('sendinput').setProperty('disabled','disabled');
		$('sendmsg').setProperty('disabled','disabled');
		$('sendcnt').removeClass('sendcntred');		
	}
	
	if(slc != 0)
	{
		$('sendcnt').set('html','Wait '+slc+' seconds');
		slc--;
		setTimeout('sendLock(0)', 1000);
	}else{
		$('sendcnt').set('html','200');
		$('sendinput').removeProperty('disabled');
	}
}


function sendMSG(r,v)
{
	var c = 200-$('sendinput').value.length;
	if(c <= 190)
	{
		var m = $('sendinput').value;
		$('sendinput').setProperty('disabled','disabled');
		$('sendmsg').setProperty('disabled','disabled');
		
		var req = new Request({
			url: '/site/ajax.php?s=stream', data: { 'a': 'stm', 'v':m, 'r':r }, 
		    onSuccess: function(e){	sendLock(e); $('streamcnt'+v).value = 0; streammores = false; $('streaminner'+v).set('html',''); getStreamMore(v,r); },
			onFailure: function(e){	sendLock(120); }
		});
		req.send();	
	}
}

function deleteMsg(i,r)
{
	var req = new Request({url: '/site/ajax.php?s=stream', data: { 'a': 'dsm', 'i': i, 'r': r }}); req.send();
	for(var c = 0;c<1;){ if($('tu'+i)){ $('tu'+i).destroy(); }else{ c = 1; }}
}

function reportMsg(i)
{
	var req = new Request({
		url: '/site/ajax.php?s=stream', data: { 'a': 'rsm', 'i': i }, 
		onSuccess: function(e){	$('tu'+i).morph({'opacity':0,'height':0,'padding':0}); setTimeout(function(){ $('tu'+i).destroy(); },1000); },
	});
	req.send();				
}

var streammores = false;
function getStreamMore(v,r)
{
	if(streammores == false)
	{
		streammores = true;
		var t = $('streammore'+v).get('html'); $('streammore'+v).set('html','&nbsp;'); $('streammore'+v).addClass('loading');
		setTimeout('streamMoreD(\''+t+'\',\''+v+'\',\''+r+'\')',1000);
	}
}

function streamMoreD(t,v,r)
{
	var s = $('streamcnt'+v).value;;
	var req = new Request.HTML({
		url: '/site/ajax.php?s=stream', data: { 'a': 'gmm', 'r': r, 's': s, 'v': v }, 
		onSuccess: function(e)
		{ 
			$('streammore'+v).set('html',t);  
			$('streammore'+v).removeClass('loading');
			var c = 5; if(v == 'n'){ c = 3; }
			$('streamcnt'+v).value = (parseInt(s) + parseInt(c)); 
			streammores = false;
		},
		append: $('streaminner'+v)
	});
	req.send();
}

function openReports(i,l)
{
	SqueezeBox.open('/site/ajax.php?s=stream&a=grl&i='+i+'&l='+l);	
}

function modReport(v,i,r)
{
	var req = new Request({
		url: '/site/ajax.php?s=stream', data: { 'a': 'mre', 'v': v, 'i': i, 'r': r }, 
		onSuccess: function(e){	$('ro'+v+'-'+i).fade(0); setTimeout(function(){ $('ro'+v+'-'+i).destroy(); },1000); },
	});
	req.send();	
}

function getReportsCount()
{
	var req = new Request({
		url: '/site/ajax.php?s=stream', data: { 'a': 'grb' }, 
		onSuccess: function(e){	$('reportsforum').set('html',e); $('reportsforum').fade(1); },
	});
	req.send();		
}

function openAStream()
{
	SqueezeBox.open('/site/ajax.php?s=stream&a=gsn');	
}

// LOADING

vLv = 0;
function visuellLoading()
{
	obj = $('loading').getElement('div');
	obj.setStyle('background-position',vLv+'px center');	
	vLv = vLv+2; setTimeout('visuellLoading()',60);
}

// ALERTS
function setNewAlert(e)
{
	var nae = new Fx.Tween(e, {duration: 800});			
	var f = function(){ nae.start('opacity',0.5).chain(function(){ nae.start('opacity',1); }); return f; };
	f().periodical(1700);
}

function setMsgAlert()
{
	if($('openmp')){ 
		$('openmp').getElements('span').each(function(e){ 
			e.setStyle('opacity',0); e.setStyle('display','block'); setTimeout(function(){ e.fade(1); },1000);
		});
	}	
}

// POLL
function sendPollVote(a)
{	
	var v = false;
	for(var i=0;i<3;i++){ if (document.poll.pollanswer[i].checked){ v = document.poll.pollanswer[i].value; }}
	if(v != false)
	{
		$('poll').fade(0); 
		setTimeout('showPoll('+a+','+v+');',1000);
	}
}

function showPoll(a,v)
{
	var req = new Request({
			url: './site/ajax.php?s=articles',
			method: 'post',
			async: true,
			data: { 'c':'spv','a':a,'v':v },
			onSuccess: function(r){ $('poll').set('html', r); setTimeout(function(){ $('poll').fade(1); },1000); }
	});
	req.send();	
}
