function GE(id) {
 return document.getElementById(id);
}

function setvis(id) {
   if (GE(id)) GE(id).style.display='block';
}

function setHTML(id,what) {
  if (GE(id)) GE(id).innerHTML=what;
}

function setValue(id,what) {
  if (GE(id)) GE(id).value=what;
}

function setBackgroundImage(id,what) {
    if (GE(id)) {
        GE(id).style.backgroundImage=what;
    }
}

function setshow(pic,price,elite,myShip) {
  var swf = pic.search(/swf.+/);
  if (swf != -1) previewswf(pic,price,elite,myShip);
  else previewpng(pic);
}

function setshow_new(name,descr,price,dit_id,elite,eventItem,lang,myShip, item_prefix, inuse, in_use_plain, teaser_plain, callBackFunction) {
  previewswf_new(name, descr, price, dit_id, elite,eventItem,lang,myShip, item_prefix, inuse, in_use_plain, teaser_plain, callBackFunction);
}


function sethide(id) {
  if (GE(id)) GE(id).style.display='none';
}

function previewpng(filename) {
 GE('preview').innerHTML='<img src="'+CDN+''+filename+'" width="320" height="240">';
}

var cvObj = {'background_cv': "",
             'item_cv': "",
             'elite_icon_cv' : "",
             'booster_icon_cv' : "",
             'limited_icon_cv' : "",
             'limited_std_icon_cv' : "",
             'shopdetails_cv' : ""
}

function setCV(key, val) {
    cvObj[key] = val;
}

function getCV(key) {
    return cvObj[key];
}


function previewswf_new(name, descr, price, dit_id, elite, eventItem, lang, myShip, item_prefix, inuse, in_use_plain, teaser_plain,callBackFunction) {
/*
  swfparam='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="253" height="206">'+
  '<param name="movie" value="' + CDN + 'swf_global/shopdetails.swf">'+
  '<param name="quality" value="high">'+
  '<param name="allowScriptAccess" value="always">'+
  '<param name="allowNetworking" value="true">'+
  '<param name="FlashVars" value="cdn=' + CDN + '&item_name='+name+'&item_caption='+descr+'&price_plain='+price+'&item_id='+dit_id+'&item_prefix=' + item_prefix + '&elite='+elite+'&lang='+lang+'&myShip='+myShip+'&inuse='+inuse+'&in_use_plain='+in_use_plain+'&teaser_plain='+teaser_plain+'&js_fn='+callBackFunction+'" />'+
  '<embed src="' + CDN + 'swf_global/shopdetails.swf" wmode="transparent" FlashVars="cdn=' + CDN + '&item_name='+name+'&item_caption='+descr+'&price_plain='+price+'&item_id='+dit_id+'&item_prefix=' + item_prefix + '&elite='+elite+'&lang='+lang+'&myShip='+myShip+'&inuse='+inuse+'&in_use_plain='+in_use_plain+'&teaser_plain='+teaser_plain+'&js_fn='+callBackFunction+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="253" height="206"></embed>'+
  '</object>';

  var agent = navigator.userAgent.toLowerCase();
  if (agent.indexOf('msie 6'.toLowerCase())==-1) {
    swfparam = '<embed src="' + CDN + 'swf_global/shopdetails.swf" wmode="transparent" FlashVars="allowScriptAccess=always&allowNetworking=true&cdn=' + CDN + '&item_name='+name+'&item_caption='+descr+'&price_plain='+price+'&item_id='+dit_id+'&item_prefix=' + item_prefix + '&elite='+elite+'&lang='+lang+'&myShip='+myShip+'&inuse='+inuse+'&in_use_plain='+in_use_plain+'&teaser_plain='+teaser_plain+'&js_fn='+callBackFunction+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="253" height="206"></embed>';
  }
  */
 swfparam = '<embed allowScriptAccess="always" allowNetworking="true" src="' + CDN + 'swf_global/shopdetails.swf?__cv='+getCV('shopdetails_cv')+'" name="shopdetails" wmode="transparent" FlashVars="allowScriptAccess=always&allowNetworking=true&cdn=' + CDN + '&item_name='+name+'&item_caption='+descr+'&price_plain='+price+'&item_id='+dit_id+'&item_prefix=' + item_prefix + '&item_cv='+getCV('item_cv')+'&elite_icon_cv='+getCV('elite_icon_cv')+'&background_cv='+getCV('background_cv')+'&booster_icon_cv='+getCV('booster_icon_cv')+'&limited_icon_cv='+getCV('limited_icon_cv')+'&limited_std_icon_cv='+getCV('limited_std_icon_cv')+'&elite='+elite+'&event_item_enabled='+eventItem+'&lang='+lang+'&myShip='+myShip+'&inuse='+inuse+'&in_use_plain='+in_use_plain+'&teaser_plain='+teaser_plain+'&js_fn='+callBackFunction+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="253" height="206"></embed>';
    GE('previewMovie').innerHTML=swfparam;
//preview.innerHTML=swfparam;
}

function previewswf(filename,price,elite,myShip) {
  swfparam='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="253" height="206">'+
  '<param name="movie" value="' + CDN + filename+'">'+
  '<param name="quality" value="high">'+
  '<param name="wmode" value="transparent">'+
  '<param name="FlashVars" value="price='+price+'&elite='+elite+'&myShip='+myShip+'" />'+
  '<embed src="'+filename+'" FlashVars="price='+price+'&elite='+elite+'&myShip='+myShip+'" wmode="transparent" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="253" height="206"></embed>'+
  '</object>';
  GE('previewMovie').innerHTML=swfparam;
  //preview.innerHTML=swfparam;
}
